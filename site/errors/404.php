<?php
    require_once "../crypt.php";
    require_once "../server.php";
    require_once "../config/lang.php";
    
    $lang = Server::get_request_cookie("lang", ["en", "bg"], "en");
    //$nonce = Crypt::generate_nonce();
    //header("Content-Security-Policy: default-src 'self'; font-src *; img-src * data:; style-src 'self' 'nonce-".$nonce."';", True);
?>
<!DOCTYPE html>
<html>
    <style type="text/css">
        html, body, #header {
            margin: 0 !important;
            padding: 0 !important;
        }
        body{
            margin:0;
            padding: 0;
            background: #13181a;
        }
        #img {
            position: absolute;
            top: 10%;
        }
        #img-cover{
            width: 100%;
            height: 100%;
            position: absolute;
            z-index: 1;
            text-align: center;
            vertical-align: middle;
            display: flex;
            justify-content: center;
            background-image: url("/ps-classics/img/cropped-5120-2880-247803.jpg");
            background-size: cover;
            background-position: center;
        }
        #img-cover > h1 {
            position: absolute;
            color: #686561;
            font-size: 6em;
            -webkit-user-select: none; /* Safari */
            -khtml-user-select: none; /* Konqueror HTML */
            -moz-user-select: none; /* Old versions of Firefox */
            -ms-user-select: none; /* Internet Explorer/Edge */
            user-select: none;
            font-family: monospace;
        }
    </style>
    <head>
        <script type="text/javascript" src="\ps-classics\js\cookie-util.js"></script>
    </head>
    <body>
        <div id="img-cover">
            <h1><?php echo $language_config[$lang]['page-not-found']; ?><h1>
        </div>
    </body>
</html>