<?php
    require_once "server.php";
    require_once "config/lang.php";
    require_once "config/db.php";
    require_once "cookie.php";
    require_once "helpers/string.php";
    require_once "helpers/array.php";
    require_once "db/db.php";
    require_once "http/response.php";
    
    $lang = Server::get_request_cookie('lang', ['en', 'bg'], 'bg');
    $isLogin = Server::is_active_session('user');
    /*if($isLogin) {
        Server::destroy_session('user');
        Response::include_header("Location", "/");
    }*/
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
        $(document).ready(function() {
            $._on('#collection-redirect-container', null, {
                'mouseenter' : function() {
                    $(this).removeClass('inactive-circle');
                    $(this).addClass('active-circle');
                },
                'mouseleave' : function() {
                    $(this).removeClass('active-circle');
                    $(this).addClass('inactive-circle');
                }
            }, null);

            $._on('.register-input', null, {
                'focus' : function(e) {
                    var field = $(e.target);
                    if(field.attr('id') == 'password-field') {
                        $('#password-requirements-tooltip').show('fast');
                    }
                },
                'blur' : function(e) {
                    var field = $(e.target);
                    if(field.attr('id') == 'password-field') {
                        $('#password-requirements-tooltip').hide('fast');
                    }
                }
            }, null);
        });
    </script>
</head>
<body id="bodyy">
    <div id='main-container'>
        <div id='navbar'>
            <a href='/' id='site-name'>
                <div id='logo'>
                    <img src='\ps-classics\img\logo\pngegg.png'>
                </div>
                <span id='name-text'>ps-classics</span>
            </a>
            <?php
                if(!$isLogin) {
                    echo "<div id='login-button'>
                    <span class='multilang'>".$language_config[$lang]['sign-in']."</span>
                </div>";
                } else {
                    echo "<div id='login-success-container'>
                        <div id='account-info' data-uid='".intval(Server::retrieve_session('user', 'id'))."' data-acc>
                            <div id='image'>
                                <img src='\ps-classics\img\oth\pngegg.png'>
                            </div>
                            <div id='username'>
                                <span>".htmlentities(Str::truncate(Server::retrieve_session('user', 'username'), 9), ENT_QUOTES, 'UTF-8')."</span>
                            </div>
                        </div>
                        <div id='dropdown-menu-switch'>
                            <i class='fa fa-bars'></i>
                        </div>
                    </div>";
                }
            ?>
        </div>
        <?php
            if(!$isLogin) {
                echo "<div id='sign-up-main-container'>
                <div id='top'>
                    <span id='text'>".$language_config[$lang]['sign-up']."</span>
                </div>
                <div id='mid'>
                    <div id='inner'>
                        <span id='text'>".$language_config[$lang]['username-requirement']."</span>
                    </div>
                </div>
                <div id='form-container'>
                    <form id='registration-form' action='' method='' data-action='register'>
                        <input class='register-input input-field' type='text'  name='register-username-field' id='username-field' placeholder='".$language_config[$lang]['user']."' autocomplete='off'>
                        <input class='register-input input-field' type='text' name='register-email-field' id='email-field' placeholder='".$language_config[$lang]['email']."' autocomplete='off'>
                        <input class='register-input input-field' type='password' name='register-password-field' id='password-field' placeholder='".$language_config[$lang]['pass']."' autocomplete='off'>
                        <input class='register-input input-field' type='password' name='register-password-confirmation-field' id='password-confirmation-field' placeholder='".$language_config[$lang]['pass-rep']."' autocomplete='off'>
                        <button class='multilang' name='submit-registration-data' id='submit-registration-data'>".$language_config[$lang]['submit']."</button>
                    </form>
                </div>
                <div id='password-requirements-tooltip'>
                    <div id='top'>
                        <div id='inner'>
                            <span>".$language_config[$lang]['pass']."</span>
                        </div>
                    </div>
                    <div id='mid'>
                        <span>&bull; ".$language_config[$lang]['pass-length']."</span><br>
                        <span>&bull; ".$language_config[$lang]['pass-char']."</span><br>
                        <span>&bull; ".$language_config[$lang]['pass-digit']."</span><br>
                    </div>
                </div>
                <i class='fa fa-spinner fa-spin' id='spinner' style='position: absolute; display: none; top: 79%; left: 4%; font-size: 1.4em; color: white;'></i>
            </div>";
            echo "<div id='sign-up-errors-container'>
                <div class='error' id='register-username-field-error'></div>
                <div class='error' id='register-email-field-error'></div>
                <div class='error' id='register-password-field-error'></div>
                <div class='error' id='register-password-confirmation-field-error'></div>
            </div>";
            } else {
                echo "<div id='statistics-showcase-container'></div>";
            }
        ?>
        <div id='search-game-index-container'>
            <div id='top'>
                <span><?php echo $language_config[$lang]['find-favgame']; ?></span>
            </div>
            <form id='search-form' action='' method=''>
                <input id='search-game' type='text' name='search-game' placeholder='<?php echo $language_config[$lang]['search']; ?>' autocomplete='off'>
            </form>
            <div id='mid'>
                <span id='collection-redirect-text'><?php echo $language_config[$lang]['visit-collection']; ?></span>
            </div>
            <div id='bottom'>
                <i class='fa fa-arrow-down'></i>
            </div>
            <div id='search-game-icon'>
                <i class='fa fa-search'></i>
            </div>
        </div>
        <div id='collection-redirect-container' class='inactive-circle'>
            <img src='\ps-classics\img\oth\pngegg.png'>
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
    </div>
</body>
<script type='text/javascript'>
    $(document).ready(function(){
        $('#collection-redirect-container').on('click', function(e) {
            $.redirect('/collection?page=1&platform=ps2');
        });
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