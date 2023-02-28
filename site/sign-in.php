<?php
    require_once "server.php";
    require_once "config/lang.php";
    require_once "config/db.php";
    require_once "cookie.php";
    require_once "helpers/string.php";
    require_once "helpers/array.php";
    require_once "db/db.php";
    
    $lang    = Server::get_request_cookie('lang', ['en', 'bg'], 'bg');
    $theme   = Server::get_request_cookie('theme', ['halloween', 'none'], 'none');
    $isLogin = Server::is_active_session('user');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8">
    <!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0" />

    <title>ps-classics.com</title>

    <link rel="icon" href="\ps-classics\img\logo\Asset A.png" type="image/x-icon" id='site-ico' />

    <link rel="stylesheet" href="\ps-classics\css\font-awesome.min.css">

    <link rel="stylesheet" href="\ps-classics\css\main-stylesheet-v1.css">

    <meta name="title" content="ps-classics.com" />
    <meta property="og:url" content="https://www.ps-classics.com/" />
    <meta property="og:site_name" content="ps-classics.com">
    <meta property="og:locale" content="bg_BG" />
    <meta property="og:locale:alternate" content="en_US" />

    <meta property="og:title" content="ps-classics" />
    <meta property="og:type" content="website" />

    <meta name="author" content="Antonio Drandarov - sumx86" />
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

            $._on('.input-field', null, {
                'focus' : function(e) {
                    var field = $(e.target);
                    field.css('border-color', '#00cd89');
                },
                'blur' : function(e) {
                    var field = $(e.target);
                    var error = $('#' + field.attr('name') + '-error');
                    if(error.css('display') == 'block') {
                        field.css('border-color', 'rgb(161, 20, 67)');
                    } else {
                        field.css('border-color', '#738399'); 
                    }
                }
            }, null);
        });
    </script>
</head>
<body id="bodyy">
    <div id='main-container'>
        <?php
            if($theme == 'halloween') {
                echo "<div id='moon-img'>
                        <img src='\ps-classics\img\NicePng_halloween-png_46141.png'>
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
                <span class='multilang'><?php echo $language_config[$lang]['sign-in']; ?></span>
            </div>
        </div>
        <?php
            if(!$isLogin) {
                echo "<div id='sign-in-main-container'>
                <div id='top'>
                    <span id='text' data-theme data-fontsize='3em' data-mgtop='-2%'>".$language_config[$lang]['sign-in']."</span>
                </div>
                <div id='form-container'>
                    <form id='login-form' action='' method='' data-action='login'>
                        <input  class='input-field' type='text' name='login-username-field' id='login-username-field' placeholder='".$language_config[$lang]['user-or-email']."'>
                        <input  class='input-field' type='password' name='login-password-field' id='login-password-field' placeholder='".$language_config[$lang]['pass']."'>
                        <button class='multilang' name='submit-login-data' id='submit-login-data'>".$language_config[$lang]['submit']."</button>
                    </form>
                </div>
                <div id='bottom-container'>
                    <a href='/reset-password' id='reset-password-link'>".$language_config[$lang]['account-access-problem']."</a>
                </div>
                <i class='fa fa-spinner fa-spin' id='spinner' style='position: absolute; display: none; top: 40%; left: 4%; font-size: 1.4em; color: white;'></i>
            </div>";
            }
        ?>
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