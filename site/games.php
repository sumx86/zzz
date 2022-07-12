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
        <section id='top-section' class='sections'>
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
        </section>

        <section id='mid-section' class='sections'>
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
                                echo "<div class='collection-item ".intval($item['id'])."' data-name='".htmlentities($item['name'], ENT_QUOTES, 'UTF-8')."'>
                                <div class='cover'>
                                    <img src='\\ps-classics\\img\\collection\\ps2\\".htmlentities($item['cover'], ENT_QUOTES, 'UTF-8')."'>
                                </div>
                                <div class='collection-item-slider'>
                                    <div class='game-name'>
                                        <span>".htmlentities(Str::truncate($item['name'], 19), ENT_QUOTES, 'UTF-8')."</span>
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
                <div class='pagination-container' data-action='collection' data-platform='<?php echo $platform; ?>'>
                    <div id='inner'>
                        <div class='page-item'><span>1</span></div>
                        <div class='page-item'><span>2</span></div>
                        <div class='page-item'><span>3</span></div>
                        <div class='page-item no-redirect'><span>...</span></div>
                        <div class='page-item'><span>5</span></div>
                    </div>
                </div>
            </div>
            <div id='game-preview-container'>
                <div id='top'>
                    <div id='exit-preview'>
                        <i class='fa fa-times'></i>
                    </div>
                </div>
                <!-- #preview expands the #game-preview-container which expands #mid-section -->
                <div id='preview'>
                    <div id='top'>
                        <div id='inner'>
                            <span></span>
                        </div>
                    </div>
                    <div id='game-cover'>
                        <img src=''>
                    </div>
                    <div id='item-actions'>
                        <div id='likes' class='action-button' data-action='like'>
                            <span><i class='fa fa-thumbs-up'></i> &nbsp;100</span>
                        </div>
                        <div id='favourited' class='action-button' data-action='favourite'>
                            <span><i class='fa fa-heart'></i> &nbsp;100</span>
                        </div>
                        <div id='comments' class='action-button no-action'>
                            <span><i class='fa fa-comments'></i> &nbsp;100</span>
                        </div>
                        <div id='views' class='action-button no-action'>
                            <span><i class='fa fa-eye'></i> &nbsp;100</span>
                        </div>
                    </div>
                    <div id='item-information'>
                        <div id='inner'>
                            <div id='uploader'>
                                <div id='image' class='uploader-data' data-uid='1' data-acc>
                                    <img src='\ps-classics\img\artworks-000616474873-i3mr2m-t500x500.jpg'>
                                </div>
                                <div id='display-name' class='uploader-data' data-uid='1' data-acc>
                                    <span>RobertoRicardo2000</span>
                                </div>
                            </div>
                            <div id='game-info'>
                                <div id='release-date' class='game-info-text'><span style='color: #fc5603;'>&bull; </span><span>Release dates: October 30, 2006</span></div>
                                <div id='genre' class='game-info-text'><span style='color: #fc5603;'>&bull; </span><span>Genres: Action, Adventure</span></div>
                                <div id='platforms' class='game-info-text'><span style='color: #fc5603;'>&bull; </span><span>Platforms: Playstation 2, Xbox 360</span></div>
                                <div id='developers' class='game-info-text'><span style='color: #fc5603;'>&bull; </span><span>Developers: HappyCitizens</span></div>
                                <div id='publishers' class='game-info-text'><span style='color: #fc5603;'>&bull; </span><span>Publishers: HappyCitizens</span></div>
                                <div id='iso' class='game-info-text'><span style='color: #fc5603;'>&bull; </span><span>Iso: <a href='https://cdromance.com/ps2-iso/need-for-speed-carbon-usa/' target="_blank">link</a></span></div>
                            </div>
                        </div>
                    </div>
                    <div id='write-comment'>
                        <div id='top'>
                            <span><?php echo $language_config[$lang]['write-comment']; ?></span>
                        </div>
                        <form id='comment-form' action='' method='' data-action='comment'>
                            <textarea name='comment-input-field' id='collection-item-comment-input-field' autocomplete='off'></textarea>
                            <div id='comment-submit'>
                                <i class='fa fa-check'></i>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <?php
            if($isLogin) {
                echo "<section id='comment-section'>
                        <div id='inner'>
                            <div class='comment-box'>
                                <div class='inner'>
                                    <div class='user-pic'>
                                        <img src='\ps-classics\img\93401019.jfif'>
                                    </div>
                                    <div class='comment-info-top'>
                                        <div class='username info'>
                                            <span>what is that maaaaan?</span>
                                        </div>
                                        <div class='comment-date info'>
                                            <span>20/15/2022</span>
                                        </div>
                                        <div class='comment-actions info'>
                                            <div class='like'>
                                                <span><i class='fa fa-thumbs-up clickable'></i> 10000</span>
                                            </div>
                                            <div class='reply'>
                                                <span class='clickable'>".$language_config[$lang]['reply']."</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='comment'>
                                        <div class='inner'>
                                            <span>Curious why you allowed jokers that do shoot bullets, but banned turrets and AI? While people are bringing up flamethrowers, Grenade launchers and bows I understand why you'd ban them despite not firing bullets as it would defeat the point of the challenge and make it trivial.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='comment-box'>
                                <div class='inner'>
                                    <div class='user-pic'>
                                        <img src='\ps-classics\img\93401019.jfif'>
                                    </div>
                                    <div class='comment-info-top'>
                                        <div class='username info'>
                                            <span>what is that maaaaan?</span>
                                        </div>
                                        <div class='comment-date info'>
                                            <span>20/15/2022</span>
                                        </div>
                                        <div class='comment-actions info'>
                                            <div class='like'>
                                                <span><i class='fa fa-thumbs-up clickable'></i> 10000</span>
                                            </div>
                                            <div class='reply'>
                                                <span class='clickable'>".$language_config[$lang]['reply']."</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='comment'>
                                        <div class='inner'>
                                            <span>Curious why you allowed jokers that do shoot bullets, but banned turrets and AI? While people are bringing up flamethrowers, Grenade launchers and bows I understand why you'd ban them despite not firing bullets as it would defeat the point of the challenge and make it trivial.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='comment-box'>
                                <div class='inner'>
                                    <div class='user-pic'>
                                        <img src='\ps-classics\img\93401019.jfif'>
                                    </div>
                                    <div class='comment-info-top'>
                                        <div class='username info'>
                                            <span>what is that maaaaan?</span>
                                        </div>
                                        <div class='comment-date info'>
                                            <span>20/15/2022</span>
                                        </div>
                                        <div class='comment-actions info'>
                                            <div class='like'>
                                                <span><i class='fa fa-thumbs-up clickable'></i> 10000</span>
                                            </div>
                                            <div class='reply'>
                                                <span class='clickable'>".$language_config[$lang]['reply']."</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='comment'>
                                        <div class='inner'>
                                            <span>Curious why you allowed jokers that do shoot bullets, but banned turrets and AI? While people are bringing up flamethrowers, Grenade launchers and bows I understand why you'd ban them despite not firing bullets as it would defeat the point of the challenge and make it trivial.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>";
            }
        ?>
        <footer class='sections'>
            <div id='footer-inner'>
                <span>© 2022 ps-classics.com. All rights reserved.</span>
            </div>
        </footer>
    </div>
</body>
<script type='text/javascript'>
    $(document).ready(function() {
        $('.multilang').each(function(i, e) {
            var element = $(e);
            var text = element.text();
            if( (/[\u0400-\u04FF]+/).test(text) ) {element.css('font-weight', 'bold');}
        });
    });
</script>
</html>