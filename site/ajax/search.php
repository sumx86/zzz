<?php
    require_once "../server.php";
    require_once "../http/response.php";

    if( Server::request_method() != "post" ) {
        Response::throw_json(
            ["response_error" => "Request method is not acceptable!"]
        );
        //Response::throw_http_error(404);
        return;
    }
?>