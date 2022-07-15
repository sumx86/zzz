<?php
    require_once "../http/response.php";
    require_once "../server.php";

    if( Server::is_active_session('user') ) {  
        Server::destroy_session('user');
    }
    Response::include_header("Location", "/");
?>