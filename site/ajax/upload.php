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
    // Check if 24 hours have passed since the last upload by this user
    if(!UserCP::expired_upload_time(Server::retrieve_session('user', 'username'))) {
        Response::throw_json_string(["error" => $language_config[$lang]['upload-time']]);
        return;
    }

    $assertionError = '';
    $metadata = null;
    parse_str($_POST['metadata'], $metadata);
    if(!assert_metadata($metadata)) {
        Response::throw_json_string(["error" => Str::is_empty($assertionError) ? $language_config[$lang]['empty-fields'] : $assertionError]);
        return;
    }

    // PROCEED UPLOADING
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    $engine = new FileUploadEngine($_FILES['file'], $db);

    $engine->set_max_size(5000000);

    $engine->set_destination("/ps-classics/img/pending/");
    
    $engine->set_allowed_types([
        'image/jpeg',
        'image/jpg',
        'image/png'
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
    // only one upload every 24 hours
    UserCP::add_pending_upload(basename($engine->get_uploaded_filename()), $metadata);
    Response::throw_json_string(['success' => $language_config[$lang]['upload-success']]);
    /////////////////////////////////////////////////////////////////////////////////////////////////////////


    
    /*
     * Make sure all metadata fields are filled
     */
    function assert_metadata($metadata) {
        global $assertionError;
        global $language_config;
        global $lang;
        
        if(Str::is_empty($metadata['game-name']) || Str::is_empty($metadata['game-genre']) || Str::is_empty($metadata['game-pltf']) || 
           Str::is_empty($metadata['game-devs']) || Str::is_empty($metadata['game-publ'])  || Str::is_empty($metadata['game-date']) || 
           Str::is_empty($metadata['game-iso'])) {
            return false;
        }
        if(!array_key_exists('platform', $metadata)) {
            $assertionError = $language_config[$lang]['platform-not-specified'];
            return false;
        }
        if(!Str::is_in($metadata['platform'], ['ps1', 'ps2', 'ps3'])) {
            $assertionError = $language_config[$lang]['platform-not-specified'];
            return false;
        }
        return true;
    }
?>