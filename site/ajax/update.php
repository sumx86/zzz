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
    //if(!Server::is_active_session('user')) {
    //    return;
    //}

    ///////////////////////////////////////////////////////////////////////////////////////
    $actionTypes = [
        'like',
        'favourite',
        'user'       // update information about a user
    ];
    $action = trim($_POST['action']);
    $data   = json_decode($_POST['data']);
    if(!Str::is_in($action, $actionTypes) || !isProperData($data)) {
        return;
    }
    //////////////////////////////////////////////////////////////////////////////////////
    $lang = Server::get_request_cookie('lang', ['en', 'bg'], 'en');
    $assertionErrors = [];

    // initialize database object
    $db = new DB(false);
    UserCP::setDB($db);
    // run queries
    $queryData = ['query' => '','params' => []];
    $successData = [
        'item' => '',
        'item_type' => '',
        'action' => '',
        'result' => ''
    ];
    // LIKE GAME or COMMENT
    ////////////////////////////////////////////////////////////////////////////////////////
    if(Str::equal($action, 'like')) {
        switch($data->item_type) {
            case "game":
                $userID = intval(Server::retrieve_session('user', 'id'));
                $gameID = intval($data->item);
                if(!UserCP::hasRatedGame(1, $gameID, 'like')) {
                    UserCP::rateGame($userID, $gameID, 'like');
                    $successData['item_type'] = 'game';
                }
                break;
            case "comment":
                /*$userID  = intval(Server::retrieve_session('user', 'id'));
                $commentID = intval($data->item);
                if(!UserCP::hasRatedComment(1, $commentID)) {
                    UserCP::rateComment($userID, $commentID);
                    $successData['item_type'] = 'comment';
                }*/
                break;
        }
        $successData['action'] = 'like';
        $successData['item'] = $data->item;
        Response::throw_json_string(["success" => $successData]);
        return;
    }
    ////////////////////////////////////////////////////////////////////////////////////////

    // FAVOURITE GAME
    ////////////////////////////////////////////////////////////////////////////////////////
    if(Str::equal($action, 'favourite')) {
        if($data->item_type == 'game') {
            $userID = intval(Server::retrieve_session('user', 'id'));
            $gameID = intval($data->item);
            if(!UserCP::hasRatedGame(1, $gameID, 'favourite')) {
                UserCP::rateGame($userID, $gameID, 'favourite');
                $successData['item_type'] = 'game';
            }
        }
        $successData['action'] = 'favourite';
        $successData['item'] = $data->item;
        Response::throw_json_string(["success" => $successData]);
        return;
    }
    ////////////////////////////////////////////////////////////////////////////////////////

    // UPDATE USER INFORMATION
    ////////////////////////////////////////////////////////////////////////////////////////
    if(Str::equal($action, 'user')) {
        return;
    }
    ////////////////////////////////////////////////////////////////////////////////////////

    function isProperData($data) {
        if(!is_object($data)) {
            return false;
        }
        if(!property_exists($data, 'item') || !property_exists($data, 'item_type')) {
            return false;
        }
        return true;
    }
?>