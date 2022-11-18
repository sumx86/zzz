<?php
    require_once "../config/lang.php";
    require_once "../config/db.php";
    require_once "../helpers/string.php";
    require_once "../helpers/array.php";
    require_once "../server.php";
    require_once "../http/response.php";
    require_once "../usercp.php";
    require_once "../db/db.php";

    // request method is not POST
    if( Server::request_method() != "post" ) {
        Response::throw_json_string(["error" => "Request method is not acceptable!"]);
        return;
    }

    // check if user is logged in
    if(!Server::is_active_session('user')) {
        Response::throw_json_string(["error" => "login"]);
        return;
    }

    // PREPARE AND VALIDATE DATA
    ///////////////////////////////////////////////////////////////////////////////////////
    $actionTypes = [
        'like',
        'favourite',
        'view',
        'user'       // update information about a user
    ];
    $action = trim($_POST['action']);
    $data   = json_decode($_POST['data']);
    if(!Str::is_in($action, $actionTypes) || !is_proper_data($data, $action)) {
        return;
    }
    //////////////////////////////////////////////////////////////////////////////////////


    // INITIALIZE DB, QUERY AND SUCCESS DATA
    //////////////////////////////////////////////////////////////////////////////////////
    $lang = Server::get_request_cookie('lang', ['en', 'bg'], 'en');
    // initialize database object
    $db = new DB(false);
    
    // Check if the given item exists only if we're not updating user information
    if(!Str::equal($action, 'user')) {
        if(!item_exists($data->item, $data->item_type, $db)) {
            return;
        }
    }

    UserCP::setDB($db);
    $successData = [
        'item' => '',
        'item_type' => '',
        'action' => '',
        'result' => ''
    ];
    //////////////////////////////////////////////////////////////////////////////////////


    // LIKE GAME or COMMENT
    ////////////////////////////////////////////////////////////////////////////////////////
    if(Str::equal($action, 'like')) {
        switch($data->item_type) {
            case "game":
                $userID = intval(Server::retrieve_session('user', 'id'));
                $gameID = intval($data->item);
                if(!UserCP::hasRatedGame($userID, $gameID, 'like')) {
                    UserCP::rateGame($userID, $gameID, 'like');
                } else {
                    UserCP::unrateGame($userID, $gameID, 'like');
                }
                $successData['item_type'] = 'game';
                $successData['result'] = $db->setFetchMode(FetchModes::$modes['assoc'])->rawQuery("select likes from games where id = ?", [$gameID], true, DB::ALL_ROWS, true);
                $successData['action'] = 'like';
                $successData['item']   = intval($data->item);
                Response::throw_json_string(["success" => $successData]);
                break;

            case "comment":
                $userID    = intval(Server::retrieve_session('user', 'id'));
                $commentID = intval($data->item);
                if(!UserCP::hasRatedComment($userID, $commentID)) {
                    UserCP::rateComment($userID, $commentID);
                } else {
                    UserCP::unrateComment($userID, $commentID);
                }
                $successData['item_type'] = 'comment';
                $successData['result'] = $db->setFetchMode(FetchModes::$modes['assoc'])->rawQuery("select comment_likes from comments where comment_id = ? limit 1", [$commentID], true, DB::ALL_ROWS, true);
                $successData['action'] = 'like';
                $successData['item']   = intval($data->item);
                Response::throw_json_string(["success" => $successData]);
                break;
        }
        return;
    }
    ////////////////////////////////////////////////////////////////////////////////////////


    // FAVOURITE GAME
    ////////////////////////////////////////////////////////////////////////////////////////
    if(Str::equal($action, 'favourite')) {
        if($data->item_type == 'game') {
            $userID = intval(Server::retrieve_session('user', 'id'));
            $gameID = intval($data->item);
            if(!UserCP::hasRatedGame($userID, $gameID, 'favourite')) {
                UserCP::rateGame($userID, $gameID, 'favourite');
            } else {
                UserCP::unrateGame($userID, $gameID, 'favourite');
            }
            $successData['item_type'] = 'game';
            $successData['result'] = $db->setFetchMode(FetchModes::$modes['assoc'])->rawQuery("select favourited from games where id = ?", [$gameID], true, DB::ALL_ROWS, true);
            $successData['action'] = 'favourite';
            $successData['item']   = intval($data->item);
            Response::throw_json_string(["success" => $successData]);
        }
        return;
    }
    ////////////////////////////////////////////////////////////////////////////////////////
    

    // UPDATE GAME VIEW
    ////////////////////////////////////////////////////////////////////////////////////////
    if(Str::equal($action, 'view')) {
        if($data->item_type == 'game') {
            $userID = intval(Server::retrieve_session('user', 'id'));
            $gameID = intval($data->item);

            if(!UserCP::hasViewedGame($userID, $gameID)) {
                UserCP::updateViews($userID, $gameID);
                $successData['item_type'] = 'game';
                $successData['result'] = $db->setFetchMode(FetchModes::$modes['assoc'])->rawQuery("select views from games where id = ?", [$gameID], true, DB::ALL_ROWS, true);
                $successData['action'] = 'view';
                $successData['item']   = $gameID;
                Response::throw_json_string(["success" => $successData]);
            }
        }
        return;
    }
    ////////////////////////////////////////////////////////////////////////////////////////


    // UPDATE USER INFORMATION
    ////////////////////////////////////////////////////////////////////////////////////////
    if(Str::equal($action, 'user')) {
        if(!isset($_POST['id'])) {
            return;
        }
        
        $query  = '';
        $userID = intval(Server::retrieve_session('user', 'id'));
        if(intval($_POST['id']) != $userID) {
            return;
        }

        if(property_exists($data, 'display_name')) {
            $query = 'update users set display_name = ? where id = ?';
            $db->rawQuery($query, [Str::replace_all_quotes($data->display_name), $userID], false);
        }

        if(property_exists($data, 'emaill')) {
            $email = Str::replace_all_quotes($data->emaill);
            if(UserCP::email_exists2($email)) {
                Response::throw_json_string(["error" => ['email' => $language_config[$lang]['register-errors']['existing-email']]]);
                return;
            }
            $query = 'update users set email = ? where id = ?';
            $db->rawQuery($query, [$email, $userID], false);
        }

        if(property_exists($data, 'location')) {
            $query = 'update users set location = ? where id = ?';
            $db->rawQuery($query, [Str::replace_all_quotes($data->location), $userID], false);
        }

        if(property_exists($data, 'current_password') && property_exists($data, 'new_password_update') && property_exists($data, 'confirm_password_update') ) {
            if(UserCP::validatePassword($data->current_password, $userID)) {
                $newPassword1 = $data->new_password_update;
                $newPassword2 = $data->confirm_password_update;

                if(Str::equal($newPassword1, $newPassword2)) {
                    $query = 'update users set password = ? where id = ?';
                    $db->rawQuery($query, [password_hash($newPassword1, PASSWORD_BCRYPT), $userID], false);
                } else {
                    Response::throw_json_string(["error" => ['password' => $language_config[$lang]['register-errors']['passwords-match']]]);
                }
                return;
            }
            Response::throw_json_string(["error" => UserCP::$errors]);
        }
        return;
    }
    ////////////////////////////////////////////////////////////////////////////////////////

    function item_exists($itemID, $itemType, $db) {
        $query  = '';
        $result = [];
        switch($itemType) {
            case "game":
                $query = "select * from games where id = ?";
                break;
            case "comment":
                $query = "select * from comments where comment_id = ?";
                break;
        }
        $result = $db->setFetchMode(FetchModes::$modes['assoc'])->rawQuery($query, [$itemID], true, DB::ALL_ROWS, false);
        return _Array::size($result) > 0;
    }


    function is_proper_data($data, $action) {
        if(!is_object($data)) {
            return false;
        }
        if(Str::equal($action, 'user')) {
            return true;
        }
        if(!property_exists($data, 'item') || !property_exists($data, 'item_type')) {
            return false;
        }
        return true;
    }


    function is_not_id($id) {
        
    }
?>