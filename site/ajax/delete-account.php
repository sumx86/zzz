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

    // check if user is logged in
    if(!Server::is_active_session('user')) {
        return;
    }

    $ajaxUID = intval($_POST['id']);
    // check if the user id in the request matches the on in the session
    if(intval(Server::retrieve_session('user', 'id')) != $ajaxUID) {
        return;
    }

    // INITIALIZE DB, QUERY AND SUCCESS DATA
    //////////////////////////////////////////////////////////////////////////////////////
    $lang = Server::get_request_cookie('lang', ['en', 'bg'], 'en');
    // initialize database object
    $db = new DB(false);

    $userData = UserCP::get_user_data_by_id($ajaxUID);
    if(_Array::size($userData) > 0) {
        UserCP::setDB($db);
        UserCP::delete_account($ajaxUID);
        UserCP::delete_uploads($ajaxUID);
        UserCP::delete_followings($ajaxUID);
        UserCP::delete_comments($ajaxUID);
        UserCP::delete_rated_games($ajaxUID);
        UserCP::delete_rated_comments($ajaxUID);
        UserCP::delete_blocked_users($ajaxUID);

        Server::destroy_session('user');
        Response::throw_json_string(["success" => ""]);
    }
    //////////////////////////////////////////////////////////////////////////////////////
?>