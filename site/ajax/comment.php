<?php
    require_once "../config/lang.php";
    require_once "../config/db.php";
    require_once "../helpers/string.php";
    require_once "../helpers/array.php";
    require_once "../helpers/util.php";
    require_once "../server.php";
    require_once "../http/response.php";
    require_once "../usercp.php";
    require_once "../db/db.php";

    // request method is not POST
    if( Server::request_method() != "post" ) {
        Response::throw_json_string(["error" => "Request method is not acceptable!"]);
        return;
    }

    // PREPARE AND VALIDATE DATA
    ///////////////////////////////////////////////////////////////////////////////////////
    $actionTypes = ['load', 'post', 'reply', 'edit', 'delete'];
    $action      = trim($_POST['action']);
    $data        = json_decode($_POST['data']);
    if(!Str::is_in($action, $actionTypes) || !is_proper_data($data)) {
        return;
    }

    // If we're trying to post a comment or reply and we're not logged in throw error
    if((Str::equal($action, 'post') || Str::equal($action, 'reply')) && !Server::is_active_session('user')) {
        Response::throw_json_string(["error" => "login"]);
        return;
    }
    //////////////////////////////////////////////////////////////////////////////////////

    // INITIALIZE DB, QUERY AND SUCCESS DATA
    //////////////////////////////////////////////////////////////////////////////////////
    $lang = Server::get_request_cookie('lang', ['en', 'bg'], 'en');
    // initialize database object
    $db = new DB(false);
    UserCP::setDB($db);
    $commentsGroupResult = [];
    //////////////////////////////////////////////////////////////////////////////////////
    

    // LOAD COMMENTS
    //////////////////////////////////////////////////////////////////////////////////////
    if(Str::equal($action, 'load')) {
        $itemID = intval($data->item);
        $commentsDBResult = $db->setFetchMode(FetchModes::$modes['assoc'])->rawQuery("select * from comments where item_id=? order by comment_id", [$itemID], true, DB::ALL_ROWS);
        if(_Array::size($commentsDBResult) > 0) {
            $commentsGroupResult = get_comments_group_result($commentsDBResult);
        }
        Response::throw_json_string(
            ["success" => $commentsGroupResult]
        );
        return;
    }
    //////////////////////////////////////////////////////////////////////////////////////


    // POST COMMENT
    //////////////////////////////////////////////////////////////////////////////////////
    if(Str::equal($action, 'post')) {
        if(property_exists($data, 'item') && property_exists($data, 'text')) {
            $gameID = intval($data->item);

            if(item_exists($gameID, 'game', $db)) {
                $comment = utf8_encode($data->text);

                if(!Str::is_empty($comment)) {
                    $result = $db->setFetchMode(FetchModes::$modes['assoc'])->rawQuery("select max(comment_id) as last_comment_id from comments", [], true, DB::ALL_ROWS);
                    $lastCommentID = intval($result[0]['last_comment_id']);
                    $newCommentID  = $lastCommentID + 1;
                    $comment       = Str::splitfixed(Str::replace_all_quotes($comment), 200);

                    $displayName = Server::retrieve_session('user', 'display_name');
                    $userID      = intval(Server::retrieve_session('user', 'id'));

                    UserCP::post_comment($comment, $newCommentID, $gameID, $displayName, $userID, Util::get_current_date_and_time(false));
                    UserCP::increment_comments($gameID);
                    Response::throw_json_string(["success" => '']);
                }
            }
        }
        return;
    }
    //////////////////////////////////////////////////////////////////////////////////////


    // REPLY TO COMMENT
    //////////////////////////////////////////////////////////////////////////////////////
    if(Str::equal($action, 'reply')) {
        // same requirements as the comment
        if(property_exists($data, 'item') && property_exists($data, 'text')) {
            $commentID = intval($data->item);
            
            if(item_exists($commentID, 'comment', $db)) {
                $comment = $data->text;
                echo 'reply -- ' . $itemID . " -- " . "yeaah" . " -- " . $comment;
            }
        }
        return;
    }
    //////////////////////////////////////////////////////////////////////////////////////


    // DELETE COMMENT
    //////////////////////////////////////////////////////////////////////////////////////
    if(Str::equal($action, 'delete')) {
        if(property_exists($data, 'item') && property_exists($data, 'game_id')) {
            $commentID = intval($data->item);
            $gameID    = intval($data->game_id);
            $userID    = intval(Server::retrieve_session('user', 'id'));

            if(item_exists($commentID, 'comment', $db) && item_belongs_to_user($commentID, 'comment', $userID, $db)) {
                UserCP::delete_comment($commentID, $userID);
                UserCP::decrement_comments($gameID);
                Response::throw_json_string(["success" => '']);
            }
        }
        return;
    }
    //////////////////////////////////////////////////////////////////////////////////////

    
    // EDIT COMMENT
    //////////////////////////////////////////////////////////////////////////////////////
    if(Str::equal($action, 'edit')) {
        if(property_exists($data, 'item') && property_exists($data, 'text')) {
            $commentID = intval($data->item);
            $userID    = intval(Server::retrieve_session('user', 'id'));

            if(item_exists($commentID, 'comment', $db) && item_belongs_to_user($commentID, 'comment', $userID, $db)) {
                $comment = utf8_encode($data->text);

                if(!Str::is_empty($comment)) {
                    $comment = Str::splitfixed(Str::replace_all_quotes($comment), 200);
                    UserCP::update_comment($comment, $commentID, intval(Server::retrieve_session('user', 'id')), Util::get_current_date_and_time(false));
                    Response::throw_json_string(
                        ["success" => [
                            "text" => utf8_decode(Str::replace_all_quotes(Str::reassemble($comment), true)),
                            'item' => $commentID]
                        ]
                    );
                }
            }
        }
        return;
    }
    //////////////////////////////////////////////////////////////////////////////////////
    

    function get_comments_group_result($commentsDBResult) {
        global $language_config;
        global $lang;
        $result = [];
        // push the blueprint to $result (that makes a whole comment)
        $commentBluePrint = [
            'comment'  => [
                'text' => '',
                'username'   => '',
                'user_id'    => 0,
                'likes'      => '',
                'date'       => '',
                'item_id'    => 0,
                'comment_id' => 0,
                'image'      => '',
                'reply-meta' => $language_config[$lang]['reply'],
                'delete' => false,
                'edit'   => false
            ]
        ];

        $commentIDList = [];
        foreach($commentsDBResult as $comment) {
            $commentID = $comment['comment_id'];
            $commentUsername = $comment['comment_by'];
            $userID          = $comment['comment_by_id'];
            $commentDate     = $comment['comment_date'];
            $commentLikes    = $comment['comment_likes'];
            $commentItemID   = $comment['item_id'];
            $image           = $comment['image'];

            // Store the $commendID in the $commentIDList to now in the future that it was already processed
            if(!in_array($commentID, $commentIDList)) {

                array_push($commentIDList, $commentID);

                foreach($commentsDBResult as $_comment) {
                    if($_comment['comment_id'] == $commentID) {
                        $commentBluePrint['comment']['text'] .= $_comment['comment'];
                        $commentBluePrint['comment']['username']   = Str::htmlEnt(Str::replace_all_quotes($commentUsername, true));
                        $commentBluePrint['comment']['likes']      = intval($commentLikes);
                        $commentBluePrint['comment']['item_id']    = intval($commentItemID);
                        $commentBluePrint['comment']['comment_id'] = intval($commentID);
                        $commentBluePrint['comment']['user_id']    = intval($userID);
                        $commentBluePrint['comment']['date']       = Str::htmlEnt($commentDate);
                        $commentBluePrint['comment']['image']      = Str::htmlEnt(Str::replace_all_quotes($image));

                        if(Server::is_active_session('user')) {
                            if(Server::retrieve_session('user', 'id') == $userID) {
                                $commentBluePrint['comment']['delete'] = true;
                                $commentBluePrint['comment']['edit']   = true;
                            }
                        }
                    }
                }
                $commentBluePrint['comment']['text'] = Util::transform_links(Str::htmlEnt(Str::replace_all_quotes(utf8_decode($commentBluePrint['comment']['text']), true)));
                array_push($result, $commentBluePrint);
                
                $commentBluePrint['comment']['text']   = '';
                $commentBluePrint['comment']['delete'] = false;
                $commentBluePrint['comment']['edit']   = false;
            }
        }
        return $result;
    }

    /*
     * check if the item exists
     */
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

    /*
     * check if the item was created by user with id $userID
     */
    function item_belongs_to_user($itemID, $itemType, $userID, $db) {
        $query  = '';
        $result = [];
        switch($itemType) {
            case "game":
                //$query = "select * from games where id = ?";
                break;
            case "comment":
                $query = "select * from comments where comment_id = ? and comment_by_id = ?";
                break;
        }
        $result = $db->setFetchMode(FetchModes::$modes['assoc'])->rawQuery($query, [$itemID, $userID], true, DB::ALL_ROWS, false);
        return _Array::size($result) > 0;
    }

    function is_proper_data($data) {
        if(!is_object($data)) {
            return false;
        }
        if(!property_exists($data, 'item')) {
            return false;
        }
        return true;
    }
?>