<?php
    require_once "../config/lang.php";
    require_once "../config/db.php";
    require_once "../helpers/string.php";
    require_once "../helpers/array.php";
    require_once "../server.php";
    require_once "../http/response.php";
    require_once "../usercp.php";
    require_once "../db/db.php";
    require_once "../mail/mail.php";

    if( Server::request_method() != "post" ) {
        Response::throw_json_string(["error" => "Request method is not acceptable!"]);
        return;
    }

    $lang = Server::get_request_cookie('lang', ['en', 'bg'], 'en');
    $assertionErrors = [];

    if( !assertFields($config['reset-pass-fields']) ) {
        Response::throw_json_string(
            ["input-error" => $assertionErrors]
        );
    } else {
        $db = new DB(false);
        UserCP::setDB($db);
        if( !UserCP::validate_email($_POST, $config['reset-pass-fields']) ) {
            Response::throw_json_string(
                ['input-error' => UserCP::$errors]
            );
        } else {
            // send email
        }
        $db->close();
    }
    
    /*
     * Assertion function for empty fields
     */
    function assertFields($fields) {
        global $language_config;
        global $lang;
        global $assertionErrors;

        $email = trim($_POST[$fields['email']]);

        if( Str::is_empty($email) ) {
            $assertionErrors[$fields['email']] = $language_config[$lang]['reset-pass-errors']['empty'];
        }
        return _Array::size($assertionErrors) > 0
            ? false : true;
    }
?>