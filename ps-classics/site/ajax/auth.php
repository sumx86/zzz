<?php 
    require_once "../server.php";

    if( Server::request_method() != "post" ) {
        return;
    }
?>