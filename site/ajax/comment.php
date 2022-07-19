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

    // PREPARE AND VALIDATE DATA
    ///////////////////////////////////////////////////////////////////////////////////////
    $actionTypes = ['load', 'post'];
    $action      = trim($_POST['action']);
    $data        = json_decode($_POST['data']);

    if(!Str::is_in($action, $actionTypes) || !isProperData($data)) {
        echo "what";
        return;
    }
    //////////////////////////////////////////////////////////////////////////////////////

    // INITIALIZE DB, QUERY AND SUCCESS DATA
    //////////////////////////////////////////////////////////////////////////////////////
    $lang = Server::get_request_cookie('lang', ['en', 'bg'], 'en');
    // initialize database object
    $db = new DB(false);
    $commentsGroupResult = [];
    // LOAD COMMENT
    //////////////////////////////////////////////////////////////////////////////////////
    if(Str::equal($action, 'load')) {
        $itemID = intval($data->item);
        $commentsDBResult = $db->setFetchMode(FetchModes::$modes['assoc'])->rawQuery("select * from comments where item_id=?", [$itemID], true, DB::ALL_ROWS);
        if(_Array::size($commentsDBResult) > 0) {
            $commentsGroupResult = GetCommentsGroupResult($commentsDBResult);
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
        // split comment if it exceeds 200 characters
        // generate unique id for the group of strings
        // replace newline character with <br>
        if(property_exists($data, 'item') && property_exists($data, 'text')) {
            $itemID  = intval($data->item);
            $comment = $data->text;
            echo $itemID . " -- " . "yeaah" . " -- " . $comment;
        }
    }
    //////////////////////////////////////////////////////////////////////////////////////
    
    function GetCommentsGroupResult($commentsDBResult) {
        global $language_config;
        global $lang;
        $result = [];
        // push the blueprint to $result (that makes a whole comment)
        $commentBluePrint = [
            'comment' => [
                'text' => '',
                'username' => '',
                'likes' => '',
                'date'  => '',
                'item_id' => 0,
                'comment_id' => 0,
                'reply-meta' => $language_config[$lang]['reply']
            ]
        ];

        $commentIDList = [];
        foreach($commentsDBResult as $comment) {
            $commentID = $comment['comment_id'];
            $commentUsername = $comment['comment_by'];
            $commentDate   = $comment['comment_date'];
            $commentLikes  = $comment['comment_likes'];
            $commentItemID = $comment['item_id'];

            // Store the $commendID in the $commentIDList to now in the future that it was already processed
            if(!in_array($commentID, $commentIDList)) {

                array_push($commentIDList, $commentID);

                foreach($commentsDBResult as $_comment) {
                    if($_comment['comment_id'] == $commentID) {
                        $commentBluePrint['comment']['text'] .= $_comment['comment'];
                        $commentBluePrint['comment']['username']   = htmlentities($commentUsername, ENT_QUOTES, 'UTF-8');
                        $commentBluePrint['comment']['likes']      = intval($commentLikes);
                        $commentBluePrint['comment']['item_id']    = intval($commentItemID);
                        $commentBluePrint['comment']['comment_id'] = intval($commentID);
                        $commentBluePrint['comment']['date'] = htmlentities($commentDate, ENT_QUOTES, 'UTF-8');
                    }
                }
                array_push($result, $commentBluePrint);
                $commentBluePrint['comment']['text'] = '';
            }
        }
        return $result;
    }

    function isProperData($data) {
        if(!is_object($data)) {
            return false;
        }
        if(!property_exists($data, 'item')) {
            return false;
        }
        return true;
    }
?>