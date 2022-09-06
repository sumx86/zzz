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

    $lang = Server::get_request_cookie('lang', ['en', 'bg'], 'en');
    $db   = new DB(false);
    $metadata = null;
    parse_str($_POST['metadata'], $metadata);

    if(!assert_metadata($metadata)) {
        Response::throw_json_string(["error" => $language_config[$lang]['empty-fields']]);
        return;
    }


    // PROCEED UPLOADING
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    $engine = new FileUploadEngine($_FILES, $db);

    $engine->set_max_size(100000);
    
    $engine->set_allowed_types([
        'image/jpeg',
        'image/jpg'
    ]);
    $engine->process();
    
    if($engine->has_error()) {
        Response::throw_json_string(["error" => $engine->get_last_error()]);
        return;
    }
    if(!$engine->upload()) {
        Response::throw_json_string(["error" => $engine->get_last_error()]);
        return;
    }
    Response::throw_json_string(['success' => '']);
    /////////////////////////////////////////////////////////////////////////////////////////////////////////


    
    /*
     * Make sure all metadata fields are filled
     */
    function assert_metadata($metadata) {
        if(Str::is_empty($metadata['game-name']) || Str::is_empty($metadata['game-genre']) || Str::is_empty($metadata['game-pltf']) || 
           Str::is_empty($metadata['game-devs']) || Str::is_empty($metadata['game-publ'])  || Str::is_empty($metadata['game-date']) || 
           Str::is_empty($metadata['game-iso'])) {
            return false;
        }
        return true;
    }
?>