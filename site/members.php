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
        $(document).ready(function() {
            $('#login-success-container').click(function(){
                $.redirect('/account/uid/' + $(this).attr('data-uid'));
            });
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
                    echo "<div id='login-success-container' data-uid='".intval(Server::retrieve_session('user', 'id'))."'>
                        <div id='account-info'>
                            <div id='image'>
                                <img src='\ps-classics\img\oth\pngegg.png'>
                            </div>
                            <div id='username'>
                                <span>Roberto98</span>
                            </div>
                        </div>
                        <div id='dropdown-menu-switch'>
                            <i class='fa fa-bars'></i>
                        </div>
                    </div>";
                }
            ?>
        </div>
        <div id='search-users-container'>
            <div id='top'>
                <span><?php echo $language_config[$lang]['search-members']; ?></span>
            </div>
            <form id='search-form' action='' method='get'>
                <input id='search-member' type='text' name='search-member' placeholder='<?php echo $language_config[$lang]['search']; ?>' autocomplete='off'>
            </form>
            <div id='search-member-icon'>
                <i class='fa fa-search'></i>
            </div>
        </div>

        <div id='users-listing-container'>
            <div id='listing'>
                <div class='member-listing-item'>
                    <div class='member-picture'>
                        <img src='\ps-classics\img\oth\pngegg.png'>
                    </div>
                    <div class='member-info'>
                        <div class='username'>
                            <span class='multilang'>Roberto98</span>
                        </div>
                        <div class='following'>
                            <span class='multilang'>Following: 90</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class='pagination-container' data-action='members'>
                <div id='inner'>
                    <div class='page-item'><span>1</span></div>
                    <div class='page-item'><span>2</span></div>
                    <div class='page-item'><span>3</span></div>
                    <div class='page-item no-redirect'><span>...</span></div>
                    <div class='page-item'><span>5</span></div>
                </div>
            </div>
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
            $.redirect('/collection');
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