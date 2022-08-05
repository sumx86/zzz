<?php
    require_once "../config/lang.php";
    require_once "../config/db.php";
    require_once "../helpers/string.php";
    require_once "../helpers/array.php";
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

    $db = new DB(false);
    $engine = new FileUploadEngine($_FILES, $db);
    $engine->setAllowedTypes([
        'image/jpeg',
        'image/jpg'
    ]);
    if($engine->hasErrors()) {
        //Response::throw_json_string(["error" => $engine->getLastError()]);
        return;
    }
    if(!$engine->upload()) {
        //Response::throw_json_string(["error" => $engine->getLastError()]);
        return;
    }
    Response::throw_json_string(['success' => '']);
?>