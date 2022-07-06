<?php
    require_once "helpers/string.php";
    require_once "helpers/array.php";
    require_once "server.php";
    require_once "config/lang.php";
    require_once "config/db.php";
    require_once "cookie.php";
    require_once "db/db.php";
    require_once "pagination.php";

    $lang = Server::get_request_cookie('lang', ['en', 'bg'], 'bg');
    $isLogin = Server::is_active_session('user');

    $platform   = Str::getstr(Server::GetParam('platform'), ['ps1', 'ps2', 'ps3'], 'ps2');
    $pagination = new Pagination([
        'max-pages' => 5,
        'max-items' => 27,
        'current-page' => intval(Server::GetParam('page'))
    ]);
    $db = new DB(false);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8">
    <!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0" />

    <title>ps-classics.com/collection</title>

    <link rel="icon" href="\ps-classics\img\logo\Asset A.png" type="image/x-icon" id='site-ico' />

    <link rel="stylesheet" href="\ps-classics\css\font-awesome.min.css">

    <link rel="stylesheet" href="\ps-classics\css\main-stylesheet-v1.css">

    <meta name="title" content="ps-classics.com/collection" />
    <meta property="og:url" content="https://www.ps-classics.com/collection" />
    <meta property="og:site_name" content="ps-classics.com/collection">
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
                }
            ?>
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
        
        <div id='search-game-container'>
            <div id='top'>
                <span><?php echo $language_config[$lang]['find-game']; ?></span>
            </div>
            <form id='search-form' action='' method='get'>
                <input id='search-game' type='text' name='search-game' placeholder='<?php echo $language_config[$lang]['search']; ?>' autocomplete='off'>
            </form>
            <div id='search-game-icon'>
                <i class='fa fa-search'></i>
            </div>
        </div>
        
        <div id='game-platforms'>
            <div class='platform' id='ps1'><span>PS1</span></div>
            <div class='platform' id='ps2'><span>PS2</span></div>
            <div class='platform' id='ps3'><span>PS3</span></div>
        </div>
        <div class='collection-container'>
            <div id='collection'>
                <?php
                    // Query games data from database based on CURRENT PAGE NUMBER and PLATFORM
                    $arrayResult = $db->setFetchMode(FetchModes::$modes['assoc'])->rawQuery("select * from games where platform=?", [$platform], true, DB::ALL_ROWS);
                    if(_Array::size($arrayResult) > 0) {
                        foreach($arrayResult as $item) {
                            echo "<div class='collection-item'>
                            <div class='cover'>
                                <img src='\\ps-classics\\img\\collection\\ps2\\".htmlentities($item['cover'], ENT_QUOTES, 'UTF-8')."'>
                            </div>
                            <div class='collection-item-slider'>
                                <div class='game-name'>
                                    <span>".Str::truncate($item['name'], 19)."</span>
                                </div>
                                <div class='uploader-name'>
                                    <span>".Str::truncate("By: ".htmlentities($item['uploader'], ENT_QUOTES, 'UTF-8')."", 19)."</span>
                                </div>
                                <div class='likes'>
                                    <span><i class='fa fa-thumbs-up' style='color: #df0f55; font-size: 1.2em;'></i> ".intval($item['likes'])."</span>
                                </div>
                                <div class='favourited'>
                                    <span><i class='fa fa-heart' style='color: #df0f55; font-size: 1.2em;'></i> ".intval($item['favourited'])."</span>
                                </div>
                                <div class='comments'>
                                    <span><i class='fa fa-comments' style='color: #df0f55; font-size: 1.2em;'></i> ".intval($item['comments'])."</span>
                                </div>
                                <div class='views'>
                                    <span><i class='fa fa-eye' style='color: #df0f55; font-size: 1.2em;'></i> ".intval($item['views'])."</span>
                                </div>
                            </div>
                        </div>";
                        }
                    }
                ?>
            </div>
            <div class='pagination-container' data-platform='<?php echo $platform; ?>'>
                <div id='inner'>
                    <div class='page-item'><span>1</span></div>
                    <div class='page-item'><span>2</span></div>
                    <div class='page-item'><span>3</span></div>
                    <div class='page-item no-redirect'><span>...</span></div>
                    <div class='page-item'><span>5</span></div>
                </div>
            </div>
        </div>
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