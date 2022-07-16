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

    // LOAD COMMENT
    //////////////////////////////////////////////////////////////////////////////////////
    if(Str::equal($action, 'load')) {
        $itemID = intval($data->item);
        $commentsDBResult = $db->setFetchMode(FetchModes::$modes['assoc'])->rawQuery("select * from comments where item_id=?", [$itemID], true, DB::ALL_ROWS);
        if(_Array::size($commentsDBResult) > 0) {
            $comments = GroupComments($commentsDBResult);
        }
        Response::throw_json_string(
            ["success" => [
                'comment' => [
                    'text' => 'This comment is fucking awesome yo! pff hahaaah',
                    'username' => 'SomeUser98',
                    'likes' => '1000',
                    'date'  => '20/10/2022',
                    'reply-meta' => $language_config[$lang]['reply']
                ]
            ]]
        );
        return;
    }
    //////////////////////////////////////////////////////////////////////////////////////

    // POST COMMENT
    //////////////////////////////////////////////////////////////////////////////////////
    if(Str::equal($action, 'post')) {
        // split comment if it exceeds 200 characters
        // generate unique id for the group of strings
    }
    //////////////////////////////////////////////////////////////////////////////////////

    function GroupComments($commentsDBResult) {
        foreach($commentsDBResult as $comment) {
            ;
        }
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