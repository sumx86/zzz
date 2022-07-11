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

    $actionTypes = [
        'like',
        'favourite',
        'user'
    ];
    $action = trim($_POST['action']);
    $data   = $_POST['data'];

    if(!Str::is_in($action, $actionTypes)) {
        return;
    }

    $lang = Server::get_request_cookie('lang', ['en', 'bg'], 'en');
    $assertionErrors = [];

    $db = new DB(false);
    UserCP::setDB($db);
    echo $action . " -- " . $data;
?>