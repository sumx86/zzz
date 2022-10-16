<?php
    //require_once "../crypt.php";
    require_once "../server.php";
    require_once "../config/lang.php";
    
    $lang  = Server::get_request_cookie("lang", ["en", "bg"], "en");
    $theme = Server::get_request_cookie('theme', ['halloween', 'none'], 'none');
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

        #halloween-theme {
            position: absolute;
            width: 60px;
            height: 60px;
            top: 55%;
            left: 0.4%;
            border-radius: 100%;
            background-color: transparent;
            cursor: pointer;
            z-index: 5;
        }

        #halloween-theme > img {
            position: absolute;
            width: 100%;
            height: 100%;
            top: -1px;
        }
    </style>
    <head>
        <script type="text/javascript" src="\ps-classics\js\jquery-3.6.0.min.js" ></script>
        <script type="text/javascript" src="\ps-classics\js\app-96f77c7a4023688288d96c0ec78c5ba8.js"></script>
        <script type="text/javascript" src="\ps-classics\js\cookie-util.js"></script>
    </head>
    <body>
        <div id="img-cover">
            <h1><?php echo $language_config[$lang]['page-forbidden']; ?><h1>
        </div>
        <div id='halloween-theme'>
            <img src='\ps-classics\img\halloween-u.png'>
        </div>
        <?php
            if($theme == 'halloween') {
                echo "<span id='halloween-web-left'>W</span>
                      <span id='halloween-web-right'>W</span>";
            }
        ?>
    </body>
    <script type='text/javascript'>
        var theme = cookieUtil.get('theme');
        if(theme == 'halloween') {
            $('#img-cover').css('background-image', 'url("/ps-classics/img/halloween/happy-halloween-wallpaper.jpg")');
            $('#img-cover').css('background-repeat', 'no-repeat');
            $('#img-cover').css('background-position', 'center');
            $('#img-cover > h1').css('color', 'black');
        }
    </script>
</html>