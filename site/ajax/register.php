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

    $lang = Server::get_request_cookie('lang', ['en', 'bg'], 'en');
    $assertionErrors = [];

    if( !assert_fields($config['register-fields']) ) {
        Response::throw_json_string(
            ["input-error" => $assertionErrors]
        );
    } else {
        $db = new DB(false);
        UserCP::setDB($db);
        if(!UserCP::add($_POST, $config['register-fields'])) {
            Response::throw_json_string(
                ["input-error" => UserCP::$errors]
            );
        } else {
            Response::throw_json_string(["success" => '']);
        }
        $db->close();
    }

    function assert_fields($fields) {
        global $language_config;
        global $lang;
        global $assertionErrors;

        $user  = trim($_POST[$fields['user']]);
        $email = trim($_POST[$fields['email']]);
        $pass  = trim($_POST[$fields['pass']]);
        $passc = trim($_POST[$fields['pass-confirm']]);

        if( Str::is_empty($user) ) {
            $assertionErrors[$fields['user']] = $language_config[$lang]['register-errors']['empty-username'];
        }
        if( Str::is_empty($email) ) {
            $assertionErrors[$fields['email']] = $language_config[$lang]['register-errors']['empty-email'];
        }
        if( Str::is_empty($pass) ) {
            $assertionErrors[$fields['pass']] = $language_config[$lang]['register-errors']['empty-password'];
        }
        if( Str::is_empty($passc) ) {
            $assertionErrors[$fields['pass-confirm']] = $language_config[$lang]['register-errors']['empty-password-conf'];
        }
        return _Array::size($assertionErrors) > 0
            ? false : true;
    }
?>