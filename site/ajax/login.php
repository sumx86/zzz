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

    if( !assert_fields($config['login-fields']) ) {
        Response::throw_json_string(
            ["input-error" => $assertionErrors]
        );
    } else {
        $db = new DB(false);
        UserCP::setDB($db);
        if(!UserCP::validate($_POST, $config['login-fields'])) {
            Response::throw_json_string(
                ["input-error" => UserCP::$errors]
            );
        } else {
            UserCP::create_session(true);
            Response::throw_json_string(["success" => '']);
        }
        $db->close();
    }

    /*
     * Assertion function for empty fields
     */
    function assert_fields($fields) {
        global $language_config;
        global $lang;
        global $assertionErrors;

        $user = trim($_POST[$fields['user']]);
        $pass = trim($_POST[$fields['pass']]);

        if( Str::is_empty($user) ) {
            $assertionErrors[$fields['user']] = $language_config[$lang]['login-errors']['empty'];
        }
        if( Str::is_empty($pass) ) {
            $assertionErrors[$fields['pass']] = $language_config[$lang]['login-errors']['empty'];
        }
        return _Array::size($assertionErrors) > 0
            ? false : true;
    }
?>