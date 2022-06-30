<?php
    require_once "../server.php";
    require_once "../http/response.php";

    if( Server::request_method() == 'get' ) {
        Response::throw_json_string(Server::retrieve_session('user'));
    }
?>