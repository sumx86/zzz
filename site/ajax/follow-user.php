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

    // INITIALIZE DB, QUERY AND SUCCESS DATA
    //////////////////////////////////////////////////////////////////////////////////////
    $lang = Server::get_request_cookie('lang', ['en', 'bg'], 'en');
    // initialize database object
    $db = new DB(false);
    UserCP::setDB($db);
    $data = json_decode($_POST['data']);

    
    if(property_exists($data, 'id')) {
        $ajaxID    = intval($data->id);
        $userID    = intval(Server::retrieve_session('user', 'id'));
        $userName  = Str::replace_all_quotes(Server::retrieve_session('user', 'display_name'));
        $userImage = Str::replace_all_quotes(Server::retrieve_session('user', 'image'));

        if($ajaxID == $userID) {
            return;
        }

        if(UserCP::user_exists($ajaxID)) {
            if(UserCP::is_followed_by_user($ajaxID, $userID)) {
                UserCP::unfollow_user($ajaxID, $userID);
                UserCP::decrement_followings($userID);
                UserCP::decrement_followers($ajaxID);
                Response::throw_json_string(["success" => ""]);
            } else {
                UserCP::follow_user([
                    'followed_user_id'     => $ajaxID,
                    'followed_username'    => UserCP::get_username_by_id($ajaxID),
                    'followed_by_user_id'  => $userID,
                    'followed_by_username' => $userName,
                    'follower_image'       => $userImage
                ]);
                UserCP::increment_followings($userID);
                UserCP::increment_followers($ajaxID);
                Response::throw_json_string(["success" => ""]);
            }
        }
    }
    //////////////////////////////////////////////////////////////////////////////////////
?>