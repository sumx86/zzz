<?php
    require_once "server.php";
    require_once "config/lang.php";
    require_once "config/db.php";
    require_once "cookie.php";
    require_once "helpers/string.php";
    require_once "helpers/array.php";
    require_once "db/db.php";
    
    $lang = Server::get_request_cookie('lang', ['en', 'bg'], 'bg');
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
    </script>
</head>
<body id="bodyy">
    <div id='main-container'>
        <div id='navbar'>
            <a href='/' id='site-name'>
                <div id='logo'>
                    <img src='\ps-classics\img\logo\Asset A.png'>
                </div>
                <span id='name-text'>ps-classics</span>
            </a>
        </div>
        <?php
            if(!$isLogin) {
                echo "<div id='sign-in-main-container'>
                <div id='top'>
                    <span id='text'>".$language_config[$lang]['sign-up']."</span>
                </div>
                <div id='mid'>
                    <div id='inner'>
                        <span id='text'>".$language_config[$lang]['username-requirement']."</span>
                    </div>
                </div>
                <div id='form-container'>
                    <form id='registration-form' action='' method=''>
                        <input class='register-input' type='text'  name='username-field' id='username-field' placeholder='".$language_config[$lang]['user']."'>
                        <input class='register-input' type='email' name='email-field' id='email-field' placeholder='".$language_config[$lang]['email']."'>
                        <input class='register-input' type='password' name='password-field' id='password-field' placeholder='".$language_config[$lang]['pass']."'>
                        <input class='register-input' type='password' name='password-confirmation-field' id='password-confirmation-field' placeholder='".$language_config[$lang]['pass-rep']."'>
                        <input type='submit' name='submit-registration-data' id='submit-registration-data' value='".$language_config[$lang]['submit']."'>
                    </form>
                </div>
            </div>";
            }
        ?>
    </div>
</body>
<script type='text/javascript'>
    $(document).ready(function(){});
</script>
<footer>
    <div id='footer-inner'>
        <span>© 2022 ps-classics.com. All rights reserved.</span>
    </div>
</footer>
</html>