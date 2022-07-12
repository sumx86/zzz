<?php
    require_once "../config/lang.php";
    require_once "../config/db.php";
    require_once "../helpers/string.php";
    require_once "../helpers/array.php";
    require_once "../server.php";
    require_once "../http/response.php";
    require_once "../usercp.php";
    require_once "../db/db.php";

    if( Server::request_method() != "post" ) {
        Response::throw_json_string(["error" => "Request method is not acceptable!"]);
        return;
    }
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
    // run queries
    $queryData = ['query' => '','params' => []];
    $successData = [
        'item' => '',
        'item_type' => '',
        'action' => '',
        'result' => ''
    ];
    // LIKE
    ////////////////////////////////////////////////////////////////////////////////////////
    if(Str::equal($action, 'like')) {
        switch($data->item_type) {
            case "game":
                $queryData['query']  = "update games set likes=likes+1 where id=?";
                $queryData['params'] = [intval($data->item)];
                $successData['item_type'] = 'game';
                break;
            case "comment":
                $queryData['query']  = "update comments set comment_likes=comment_likes+1 where comment_id=?";
                $queryData['params'] = [intval($data->item)];
                $successData['item_type'] = 'comment';
                break;
        }
        $db->rawQuery($queryData['query'], $queryData['params'], false, false);
        $successData['action'] = 'like';
        $successData['item'] = $data->item;
        Response::throw_json_string(
            ["success" => $successData]
        );
        return;
    }
    ////////////////////////////////////////////////////////////////////////////////////////

    // FAVOURITE
    ////////////////////////////////////////////////////////////////////////////////////////
    if(Str::equal($action, 'favourite')) {
        if($data->item_type == 'game') {
            $queryData['query']  = "update games set favourited=favourited+1 where id=?";
            $queryData['params'] = [intval($data->item)];
        }
        $db->rawQuery($queryData['query'], $queryData['params'], false, false);
        $successData['action'] = 'favourite';
        $successData['item'] = $data->item;
        Response::throw_json_string(
            ["success" => $successData]
        );
        return;
    }
    ////////////////////////////////////////////////////////////////////////////////////////

    // USER
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