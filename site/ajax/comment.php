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
    $actionTypes = ['load','post'];
    $action      = trim($_POST['action']);
    $data        = json_decode($_POST['data']);

    if(!Str::is_in($action, $actionTypes) || !isProperData($data)) {
        echo "what";
        return;
    }
    var_dump($data);
    //////////////////////////////////////////////////////////////////////////////////////


    // INITIALIZE DB, QUERY AND SUCCESS DATA
    //////////////////////////////////////////////////////////////////////////////////////
    $lang = Server::get_request_cookie('lang', ['en', 'bg'], 'en');
    // initialize database object
    $db = new DB(false);
    //////////////////////////////////////////////////////////////////////////////////////

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