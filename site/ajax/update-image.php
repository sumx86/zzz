<?php
    require_once "../config/lang.php";
    require_once "../config/db.php";
    require_once "../crypt.php";
    require_once "../helpers/string.php";
    require_once "../helpers/array.php";
    require_once "../helpers/util.php";
    require_once "../server.php";
    require_once "../http/response.php";
    require_once "../usercp.php";
    require_once "../db/db.php";
    require_once "../upload.php";

    // request method is not POST
    if( Server::request_method() != "post" ) {
        Response::throw_json_string(["error" => "Request method is not acceptable!"]);
        return;
    }

    $lang = Server::get_request_cookie('lang', ['en', 'bg'], 'en');
    // check if user is logged in
    if(!Server::is_active_session('user')) {
        Response::throw_json_string(["error" => $language_config[$lang]['account-first']]);
        return;
    }

    $db = new DB(false);
    UserCP::setDB($db);
    $data = $_POST['data'];
    if(isset($data)) {
        $data  = explode(";", $_POST['data']);
        $text  = base64_decode(explode(",", explode(";", $_POST['data'])[1])[1]);
        $fname = "../../img/" . Crypt::generate_nonce(15) . '.jpg';

        if(file_put_contents($fname, $text)) {
            echo "<img src='".$fname."'>";
        }
    }

    // 1) put content in image file
    // 2) check if file is image
    // 3) check file size
    // 4) upload
    // 5) return file path to browser
?>