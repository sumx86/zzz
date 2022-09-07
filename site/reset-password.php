<?php
    require_once "server.php";
    require_once "config/lang.php";
    require_once "cookie.php";
    require_once "helpers/string.php";
    require_once "helpers/array.php";
    require_once "http/response.php";
    
    if( Server::is_active_session('user') ) {
        Response::include_header("Location", "/");
    }
    $lang  = Server::get_request_cookie('lang', ['en', 'bg'], 'en');
    $theme = Server::get_request_cookie('theme', ['halloween', 'none'], 'none');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8">
    <!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0" />

    <title>ps-classics.com/reset-password</title>

    <link rel="icon" href="\ps-classics\img\logo\Asset A.png" type="image/x-icon" id='site-ico' />

    <link rel="stylesheet" href="\ps-classics\css\font-awesome.min.css">

    <link rel="stylesheet" href="\ps-classics\css\main-stylesheet-v1.css">

    <meta name="title" content="ps-classics.com/reset-password" />
    <meta property="og:url" content="https://www.ps-classics.com/reset-password/" />
    <meta property="og:site_name" content="ps-classics.com/reset-password">
    <meta property="og:locale" content="bg_BG" />
    <meta property="og:locale:alternate" content="en_US" />

    <meta property="og:title" content="ps-classics" />
    <meta property="og:type" content="website" />

    <meta name="author" content="sumx86" />
    <!-- <meta name="description" content="" />
    <meta property="og:description" content="" />
    <link rel="canonical" href="https://" />
    <meta property="og:url" content="https://" /> />-->
    <meta name="locale" content="bg_BG">

    <script type="text/javascript" src="\ps-classics\js\jquery-3.6.0.min.js" ></script>
    <script type="text/javascript" src="\ps-classics\js\app-96f77c7a4023688288d96c0ec78c5ba8.js"></script>
    <script type="text/javascript" src="\ps-classics\js\cookie-util.js"></script>
    <script type="text/javascript" src="\ps-classics\js\ui.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#moon-img').css({'top': '10px'});
        });
    </script>
</head>
<body id="bodyy">
    <div id='main-container'>
        <?php
            if($theme == 'halloween') {
                echo "<div id='moon-img'>
                        <img src='\ps-classics\img\clipart457867.png'>
                    </div>";
            }
        ?>
        <div id='navbar'>
            <a href='/' id='site-name'>
                <div id='logo'>
                    <img src='\ps-classics\img\logo\pngegg.png'>
                </div>
                <span id='name-text' data-theme data-fontsize='3em' data-mgtop='20%'>ps-classics</span>
            </a>
            <div id='login-button'>
                <span class='multilang'><?php echo $language_config[$lang]['sign-in'] ?></span>
            </div>
        </div>

        <div id='reset-password-main-container'>
            <div id='top'>
                <span id='text' data-theme data-fontsize='3em' data-mgtop='0%'><?php echo $language_config[$lang]['recover-password']; ?></span>
            </div>
            <div id='mid'>
                    <div id='inner'>
                        <span id='text' data-theme data-fontsize='1.5em' data-mgtop='20%'><?php echo $language_config[$lang]['email-hint']; ?></span>
                    </div>
                </div>
            <div id='form-container'>
                <form id='reset-pass-form' action='' method='' data-action='reset-pass'>
                    <input  class='input-field' type='text' name='reset-pass-field' id='reset-pass-field' placeholder='<?php echo $language_config[$lang]['email']; ?>'>
                    <button class='multilang' name='submit-reset-pass' id='submit-reset-pass'><?php echo $language_config[$lang]['submit']; ?></button>
                </form>
            </div>
            <i class='fa fa-spinner fa-spin' id='spinner' style='position: absolute; display: none; top: 38%; left: 4%; font-size: 1.4em; color: white;'></i>
        </div>

        <div id='lang-container'>
            <div id='inner'>
                <div id='en' class='lang-img-container' data-lang='en'>
                    <img src='\ps-classics\img\enz.png'>
                </div>
                <div id='bg' class='lang-img-container' data-lang='bg'>
                    <img src='\ps-classics\img\bgz.png'>
                </div>
            </div>
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
    </div>
</body>
<script type='text/javascript'>
    $(document).ready(function(){
        $('.multilang').each(function(i, e) {
            var element = $(e);
            var text = element.text();
            if( (/[\u0400-\u04FF]+/).test(text) ){element.css('font-weight', 'bold');}
        });
    });
</script>
<footer>
    <div id='footer-inner'>
        <span>© 2022 ps-classics.com. All rights reserved.</span>
    </div>
</footer>
</html>