<?php
    require_once "server.php";
    require_once "config/lang.php";
    require_once "config/db.php";
    require_once "cookie.php";
    require_once "helpers/string.php";
    require_once "helpers/array.php";
    require_once "db/db.php";
    require_once "pagination.php";

    $lang    = Server::get_request_cookie('lang', ['en', 'bg'], 'bg');
    $theme   = Server::get_request_cookie('theme', ['halloween', 'none'], 'none');
    $isLogin = Server::is_active_session('user');
    $search  = Str::replace_all_quotes(Server::get_param('search-member'));

    $db         = new DB(false);
    $pagination = new Pagination([
        'max-page-links' => 5,
        'max-page-items' => 27,
        'current-page' => intval(Server::get_param('page')),
        'table' => 'users',
        'db' => $db
    ]);

    if($pagination->last() > 1) {
        $offset = $pagination->get_current_page() * 27;
    } else {
        $offset = 0;
    }
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
        $(document).ready(function() {
            $('#login-success-container,.member-listing-item').click(function(e) {
                $.redirect('/account/uid/' + $(this).attr('data-uid'));
            });
            $('#moon-img').css({'top': '-120px'});
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
                    echo "<div id='login-success-container' data-uid='".intval(Server::retrieve_session('user', 'id'))."'>
                        <div id='account-info'>
                            <div id='image'>
                                <img src='\\ps-classics\\img\\—Pngtree—halloween pumpkin sticker_6787055.png'>
                            </div>
                            <div id='username'>
                                <span>".Str::htmlEnt($username)."</span>
                            </div>
                        </div>
                    </div>";

                    echo "<div id='sign-out'>
                            <i class='fa fa-power-off'></i>
                        </div>";
                }
            ?>
        </div>
        <div id='search-users-container'>
            <div id='top'>
                <span data-theme data-fontsize='3em' data-mgtop='-3.5%'><?php echo $language_config[$lang]['search-members']; ?></span>
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
                <?php
                    if(Str::is_empty($search)) {
                        $usersList = $db->setFetchMode(FetchModes::$modes['assoc'])->rawQuery("select * from users limit 27 offset " . $offset, [], true, DB::ALL_ROWS);
                        if(_Array::size($usersList) > 0) {
                            foreach($usersList as $user) {

                                $username = Str::truncate(Str::replace_all_quotes($user['username'], true), 9);
                                if($theme == 'halloween') {
                                    $image = '\\ps-classics\\img\\—Pngtree—halloween pumpkin sticker_6787055.png';
                                } else {
                                    $image = Str::htmlEnt($user['image']);
                                }
                                echo "<div class='member-listing-item' data-uid='".intval($user['id'])."'>
                                    <div class='member-picture'>
                                        <img src='".$image."'>
                                    </div>
                                    <div class='member-info'>
                                        <div class='username'>
                                            <span class='multilang'>".Str::htmlEnt($username)."</span>
                                        </div>
                                        <div class='following'>
                                            <span>".$language_config[$lang]['following'].": ".intval($user['following'])."</span>
                                        </div>
                                    </div>
                                </div>";
                            }
                        }
                    } else {
                        $usersList = $db->setFetchMode(FetchModes::$modes['assoc'])->rawQuery("select * from users where lower( users.username ) like '%".$search."%' limit 27 offset " . $offset, [], true, DB::ALL_ROWS);
                        if(_Array::size($usersList) > 0) {
                            foreach($usersList as $user) {

                                $username = Str::truncate(Str::replace_all_quotes($user['username'], true), 9);
                                if($theme == 'halloween') {
                                    $image = '\\ps-classics\\img\\—Pngtree—halloween pumpkin sticker_6787055.png';
                                } else {
                                    $image = Str::htmlEnt($user['image']);
                                }
                                echo "<div class='member-listing-item' data-uid='".intval($user['id'])."'>
                                    <div class='member-picture'>
                                        <img src='".$image."'>
                                    </div>
                                    <div class='member-info'>
                                        <div class='username'>
                                            <span class='multilang'>".Str::htmlEnt($username)."</span>
                                        </div>
                                        <div class='following'>
                                            <span>".$language_config[$lang]['following'].": ".intval($user['following'])."</span>
                                        </div>
                                    </div>
                                </div>";
                            }
                        }
                    }
                ?>
            </div>
            <div class='pagination-container' data-action='members'>
                <div id='inner'>
                    <?php
                        $maxPageLinks = $pagination->get_max_page_links();
                        $lastPage     = $pagination->last();
                        $count        = $lastPage >= $maxPageLinks ? $maxPageLinks : $lastPage;

                        for($i = 0; $i < $count; $i++) {
                            if($i == 3) {
                                echo "<div class='page-item no-redirect'><span>...</span></div>";
                            } else {
                                echo "<div class='page-item'><span data-theme>".$pagination->next()."</span></div>";
                            }
                        }
                    ?>
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
        <div id='halloween-theme'>
            <img src='\ps-classics\img\halloween-u.png'>
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
        $('#search-member-icon').click(function() {
            $('#search-form').submit();
        });
    });
</script>
<footer>
    <div id='footer-inner'>
        <span>© 2022 ps-classics.com. All rights reserved.</span>
    </div>
</footer>
</html>