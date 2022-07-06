<?php
    require_once "../helpers/string.php";
    require_once "../server.php";
    require_once "../http/request.php";
    require_once "../http/response.php";

    if( Server::request_method() != "post" ) {
        Response::throw_json_string(
            ["error" => "Request method is not acceptable!"]
        );
        return;
    }

    $request = new Request();
    $role = $request->get('role');
    $login_user = $request->get('login-user-name');
    $login_pass = $request->get('login-user-password');

    Response::throw_json_string(
        ["success" => [
            "login-user-name" => "Това поле е задължително!",
            "user-reset-email" => "Това поле е задължително!",
            ]
        ]
    );
?>