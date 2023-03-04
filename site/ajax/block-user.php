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

// The user id passed via AJAX
$blockedID = json_decode($_POST['data'])->id;
// Our userID (from the session)
$blockerID = intval(Server::retrieve_session('user', 'id'));

// PERFORM BLOCKING ACTIONS
//////////////////////////////////////////////////////////////////////////////////////

// if user id is not valid integer simply stop
if(!is_numeric($blockedID)) {
    return;
}

$blockedUserData = UserCP::get_user_data_by_id($blockedID);
if(_Array::size($blockedUserData) > 0) {
    if(UserCP::is_user_blocked($blockedID, $blockerID)) {
        UserCP::unblock_user($blockedID, $blockerID);
        Response::throw_json_string(["success-unblock" => $language_config[$lang]['unblock-user-success'] . Str::htmlEnt(Str::replace_all_quotes($blockedUserData[0]['display_name'], true)) . "."]);
        return;
    } else {
        UserCP::block_user($blockedID, $blockedUserData, $blockerID);
        Response::throw_json_string(["success-block" => $language_config[$lang]['block-user-success'] . Str::htmlEnt(Str::replace_all_quotes($blockedUserData[0]['display_name'], true)) . "."]);
        return;
    } 
}

?>