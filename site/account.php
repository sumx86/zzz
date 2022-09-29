<?php
    require_once "helpers/string.php";
    require_once "helpers/array.php";
    require_once "helpers/util.php";
    require_once "server.php";
    require_once "config/lang.php";
    require_once "config/db.php";
    require_once "cookie.php";
    require_once "db/db.php";
    require_once "pagination.php";

    $lang    = Server::get_request_cookie('lang', ['en', 'bg'], 'bg');
    $theme   = Server::get_request_cookie('theme', ['halloween', 'none'], 'none');
    $isLogin = Server::is_active_session('user');
    $userID  = intval(Server::get_param('uid'));
    $db      = new DB(false);
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
        $(document).ready(function() {
            $('#moon-img').css({'top': '-120px'});
            $('#user-image').click(function() {
                //$(this).find('img:first').attr('src');
                //console.log($(this).find('img:first').attr('src'));
            });
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
        <?php
            if($isLogin) {
                echo "<div id='logout-confirmation-modal'>
                          <div id='inner'>
                              <span id='message'>".$language_config[$lang]['quit-account-confirm']."</span>
                              <div id='confirmation-buttons'>
                                  <div id='yes' class='button'>
                                       <span>".$language_config[$lang]['yes']."</span>
                                  </div>
                                  <div id='no' class='button'>
                                       <span>".$language_config[$lang]['no']."</span>
                                  </div>
                              </div>
                          </div>
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
            <?php
                if(!$isLogin) {
                    echo "<div id='login-button'>
                    <span class='multilang' data-theme data-fontsize='1.5em' data-mgtop='-7%'>".$language_config[$lang]['sign-in']."</span>
                </div>";
                } else {
                    $username = Str::truncate(Str::replace_all_quotes(Server::retrieve_session('user', 'username'), true), 9);
                    echo "<div id='login-success-container'>
                        <div id='account-info' data-uid='".intval(Server::retrieve_session('user', 'id'))."' data-acc>
                            <div id='image'>
                                <img src='\\ps-classics\\img\\—Pngtree—halloween pumpkin sticker_6787055.png'>
                            </div>
                            <div id='username'>
                                <span>".Str::htmlEnt($username, ENT_QUOTES, 'UTF-8')."</span>
                            </div>
                        </div>
                    </div>";

                    echo "<div id='sign-out'>
                            <i class='fa fa-power-off'></i>
                        </div>";
                }
            ?>
        </div>

        <section id='user-section'>
            <div id='page-under-development'>
                <span><?php echo $language_config[$lang]['under-development']; ?></span>
            </div>

            <?php
                $userData  = $db->setFetchMode(FetchModes::$modes['assoc'])->rawQuery("select username, email, image, display_name, followers, following, user_rank from users where id = ?", [$userID], true, DB::ALL_ROWS);

                $username  = Str::htmlEnt(Str::replace_all_quotes($userData[0]['username'], true));
                $userRank  = Util::get_rank($userData[0]['user_rank']);
                $userImage = Str::htmlEnt($userData[0]['image']);
                
                $followers = intval($userData[0]['followers']);
                $following = intval($userData[0]['following']);
            ?>

            <div id='inner'>
                <div id='cover'>
                    <div id='centered-container'>
                        <div id='user-image'>
                            <img src='<?php echo $userImage; ?>'>
                        </div>
                        <div id='user-info'>
                            <div id='username'>
                                <span><?php echo $username; ?></span>
                            </div>
                            <div id='rank'>
                                <span><?php echo $userRank; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div id='bottom-navbar'>
                    <?php
                        if($isLogin) {
                            if($userID != Server::retrieve_session('user', 'id')) {
                                echo "<div id='follow-button'>
                                          <span><i class='fa fa-user'></i> Follow</span>
                                      </div>";
                            }
                        } else {
                            echo "<div id='follow-button'>
                                      <span><i class='fa fa-user'></i> Follow</span>
                                  </div>";
                        }
                    ?>
                </div>
            </div>
            <div id='user-image-preview-container'></div>
        </section>

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
    </div>
</body>
<script type='text/javascript'>
    $(document).ready(function() {
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