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
    require_once "http/response.php";
    require_once "usercp.php";

    $lang    = Server::get_request_cookie('lang', ['en', 'bg'], 'bg');
    $theme   = Server::get_request_cookie('theme', ['halloween', 'none'], 'none');
    $isLogin = Server::is_active_session('user');
    $userID  = intval(Server::get_param('uid'));
    $blockedUID = intval(Server::get_param('blocked_uid'));

    $db = new DB(false);
    UserCP::setDB($db);
    
    // First check if user with id $userID exists
    if(!UserCP::user_exists($userID)) {
        Response::throw_http_error(404);
    }
    
    if(Server::is_active_session('user')) {
        $ourID = intval(Server::retrieve_session('user', 'id'));
        // Then, if we've previously blocked the user we're going to redirect to our account page but with some message to tell us
        // that we've already blocked the user
        if(UserCP::is_user_blocked($userID, $ourID)) {
            Response::include_header('Location', '/account/uid/' . $ourID . '/blocked_uid/' . $userID);
        }
    }
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="\ps-classics\css\main-stylesheet-v1.css">
    <link rel="stylesheet" href="\ps-classics\css\croppie.css">
    
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

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
    <script type="text/javascript" src="\ps-classics\js\croppie.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#moon-img').css({'top': '-120px'});
            //======================================================================================
            $('#user-image').click(function() {
                var src   = $(this).find('img:first').attr('src');
                var image = $('#user-image-preview-container > #inner > #image-preview > img');
                image.attr('src', src);
                $('#user-image-preview-container > #inner').css('top', '14%');
                $('#user-image-preview-container').css('display', 'block');
                Util.rescaleImage(image);
            });
            //======================================================================================
            $('#exit-profile-pic').click(function() {
                Util.userImageHidePreview();
            });
            $(document).click(function(e) {
                if($(e.target).attr('data-gr') == undefined) {
                    Util.userImageHidePreview();
                }
            });
            $(document).keydown(function(event) {
                if( event.key.toLowerCase() == "escape" ) {
                    $('#exit-profile-pic').click();
                }
            });
            $('#account-settings').click(function() {
                $('#settings-container-section').show();
                $('#profile-picture > img').attr('src', $('#user-image > img:first').attr('src'));
            });
            $('#exit-section').click(function() {
                Util.clearFields('.social-media-input-field');
                $('#settings-container-section').hide();
            });
            window._uid   = <?php echo $userID; ?>;
            <?php
                if($isLogin) {
                    echo "window._ourID = " . $ourID . ";\n";
                }
            ?>
            window._lang  = '<?php echo $lang; ?>';
            window._isLogin = <?php echo $isLogin ? 1 : 0; ?>;

            if(!window._ourID) {
                $('#bottom-navbar > .follow-button').css('left', '93%');
            }

            var followersInner = $('#followers > #inner');
            if(followersInner.find('#no-followers').length > 0) {
                followersInner.css('height', '100px');
                $('#main-info-panel > #followers').css('height', '170px');
            }
        });
    </script>
</head>
<body id="bodyy">
    <div id='main-container'>
        <?php
            if($blockedUID > 0) {
                $data = UserCP::get_user_data_by_id($blockedUID);
                $displayName = Str::htmlEnt(Str::replace_all_quotes($data[0]['display_name'], true));
                $userImage   = Str::replace_all_quotes($data[0]['image'], true);
                echo "<div id='blocked-user-preview-container'>
                        <div id='inner' data-gr>
                            <div id='top' data-gr>
                                <div id='exit-blocked-user-preview'>
                                    <i class='fa fa-times'></i>
                                </div>
                            </div>
                            <div id='blocked-user-preview' data-gr>
                                <div id='user-info'>
                                    <div id='image'>
                                        <img src='".$userImage."'>
                                    </div>
                                    <div id='display-name'>
                                        <span>".$displayName."</span>
                                    </div>
                                </div>
                                <div id='success-blocked-message'>
                                    <span class='multilang'>".$language_config[$lang]['block-success']."</span>
                                </div>
                            </div>
                        </div>
                      </div>";
            }
        ?>
        <?php
            if($theme == 'halloween') {
                echo "<div id='moon-img'>
                        <img src='\ps-classics\img\NicePng_halloween-png_46141.png'>
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
                    $userData  = $db->setFetchMode(FetchModes::$modes['assoc'])->rawQuery("select image from users where id = ?", [$ourID], true, DB::ALL_ROWS);
                    $userImage = Str::htmlEnt($userData[0]['image']);

                    $username  = Str::truncate(Str::replace_all_quotes(Server::retrieve_session('user', 'username'), true), 9);
                    echo "<div id='login-success-container'>
                        <div id='account-info' data-uid='".$ourID."' data-acc>
                            <div id='image'>
                                <img src='".$userImage."'>
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
                if($theme == 'halloween') {
                    echo "<div id='ghost-1' class='ghost-img' style='position: absolute; width: 100px; height: 100px; top: 3%; left: 3%;'>
                            <img src='\ps-classics\img\adb\Asset 1.png' style='position: absolute; width: 100%; height: 100%;'>
                        </div>
                        
                        <div id='ghost-2' class='ghost-img' style='position: absolute; width: 100px; height: 100px; top: 3%; left: 92%;transform: scaleX(-1);'>
                            <img src='\ps-classics\img\adb\Asset 1.png' style='position: absolute; width: 100%; height: 100%;'>
                        </div>";
                }
            ?>
            <?php
                $userData    = $db->setFetchMode(FetchModes::$modes['assoc'])->rawQuery("select username, email, image, display_name, followers, following, user_rank, location from users where id = ?", [$userID], true, DB::ALL_ROWS);
                $username    = Str::htmlEnt(Str::replace_all_quotes($userData[0]['username'], true));
                $displayName = Str::htmlEnt(Str::replace_all_quotes($userData[0]['display_name'], true));
                $location    = Str::htmlEnt(Str::replace_all_quotes($userData[0]['location'], true));
                $email       = Str::htmlEnt(Str::replace_all_quotes($userData[0]['email'], true));
                $userRank    = Util::get_rank($userData[0]['user_rank']);
                $userImage   = Str::htmlEnt($userData[0]['image']);
                
                $followers = intval($userData[0]['followers']);
                $following = intval($userData[0]['following']);
            ?>

            <div id='inner'>
                <div id='cover'>
                    <div id='centered-container'>
                        <div id='user-image' data-gr>
                            <img src='<?php echo $userImage; ?>' data-gr>
                        </div>
                        <!--<div id='user-info'>
                            <div id='username'>
                                <span><?php echo $displayName; ?></span>
                            </div>
                            <div id='rank'>
                                <span><?php echo $userRank; ?></span>
                            </div>
                        </div> -->
                    </div>
                    <input type="color" id="color" name="color" value="#e66465" style='position: absolute; visibility: hidden; left: 11%; top: 20%;'>
                    <label for="color" style='position: absolute; width: 30px; height: 30px; cursor: pointer; border-radius: 100px; left: 9.5%; top: 25%;'><i class="material-icons" style='color: white;'>palette</i></label>
                </div>
                <div id='bottom-navbar'>
                    <?php
                        if($isLogin) {
                            if($userID != $ourID) {
                                if(UserCP::is_followed_by_user($userID, $ourID)) {
                                    echo "<div class='unfollow cx-x-".$userID."'>
                                              <span class='multilang'><i class='fa fa-user'></i> ".$language_config[$lang]['unfollow']."</span>
                                          </div>";
                                } else {
                                    echo "<div class='follow-button cx-x-".$userID."'>
                                            <span class='multilang'><i class='fa fa-user'></i> ".$language_config[$lang]['follow']."</span>
                                        </div>";
                                }

                                if(!UserCP::is_user_blocked($userID, $ourID)) {
                                    echo "<div class='block-button x-c-".$userID."'>
                                              <span class='multilang'><i class='fa fa-times'></i> ".$language_config[$lang]['block-user']."</span>
                                          </div>";
                                }
                                      
                            } else {
                                echo "<div id='inbox-button'>
                                        <span><i class='fa fa-envelope-o'></i> Inbox</span>
                                    </div>";
                                
                                echo "<div id='account-settings'>
                                          <i class='fa fa-cog'></i>
                                      </div>";
                            }
                        } else {
                            echo "<div class='follow-button cx-x-".$userID."'>
                                      <span class='multilang'><i class='fa fa-user'></i> ".$language_config[$lang]['follow']."</span>
                                  </div>";
                        }
                    ?>
                    <?php
                        $data    = $db->setFetchMode(FetchModes::$modes['assoc'])->rawQuery("select followers, following, likes, registration_date from users where id = ?", [$userID], true, DB::ALL_ROWS);
                        $uploads = $db->setFetchMode(FetchModes::$modes['assoc'])->rawQuery("select count(*) as count from games where uploader_id = ?", [$userID], true, DB::ALL_ROWS);
                    ?>
                    <div id='stats'>
                        <div class='stat' id='followings' data-section='#followings-section'>
                            <div class='top'>
                                <span><?php echo $language_config[$lang]['following']; ?></span>
                            </div>
                            <div class='bottom'>
                                <span><?php echo $data[0]['following']; ?></span>
                                <div class='line'></div>
                            </div>
                        </div>
                        <div class='stat' id='followers' data-section='#followers-section'>
                            <div class='top'>
                                <span><?php echo $language_config[$lang]['followers']; ?></span>
                            </div>
                            <div class='bottom'>
                                <span><?php echo $data[0]['followers']; ?></span>
                                <div class='line'></div>
                            </div>
                        </div>
                        <div class='stat' id='likes' data-section='#likes-section'>
                            <div class='top'>
                                <span><?php echo $language_config[$lang]['likes']; ?></span>
                            </div>
                            <div class='bottom'>
                                <span><?php echo $data[0]['likes']; ?></span>
                                <div class='line'></div>
                            </div>
                        </div>
                        <div class='stat' id='uploads' data-section='#uploads-section'>
                            <div class='top'>
                                <span><?php echo $language_config[$lang]['uploads']; ?></span>
                            </div>
                            <div class='bottom'>
                                <span><?php echo $uploads[0]['count']; ?></span>
                                <div class='line'></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id='main-info-panel'>
                    <div id='side-info-panel'>
                        <div id='top'>
                            <div id='inner'>
                                <span id='display-name'><?php echo $displayName; ?></span>
                                <span id='joined-date'><?php echo $language_config[$lang]['joined']; ?>: <?php echo $data[0]['registration_date']; ?></span>
                            </div>
                        </div>
                        <div id='mid'>
                            <div id='inner'>
                                <span id='bio'>Aside from being awesome, I'm super mega awesome hahahahaahahahah!</span>
                            </div>
                        </div>
                        <div id='bottom'>
                            <div id='inner'>
                                <span id='location'>Varna, Bulgaria</span>
                                <span id='email'>somemail@gmail.com</span>
                            </div>
                        </div>
                    </div>
                    <div id='followers'>
                        <div id='top'>
                            <div id='inner'>
                                <span><?php echo $language_config[$lang]['followers']; ?> <span style="font-family: 'Roboto-Regular', 'prototype', 'Jura-Bold', sans-serif;">( <?php echo $followers; ?> )</span></span>
                            </div>
                        </div>
                        <div id='inner'>
                            <?php
                                $followers = $db->setFetchMode(FetchModes::$modes['assoc'])->rawQuery("select * from followings where followed_user_id = ? limit 3", [$userID], true, DB::ALL_ROWS);
                                if(_Array::size($followers) > 0) {
                                    foreach($followers as $follower) {
                                        $followerImage = Str::htmlEnt(Str::replace_all_quotes($follower['follower_image'], true));
                                        $followerName  = Str::htmlEnt(Str::replace_all_quotes($follower['followed_by_username'], true));
                                        $followerID    = intval($follower['followed_by_user_id'], true);

                                        $text = $language_config[$lang]['follow'];
                                        if($isLogin) {
                                            if(UserCP::is_followed_by_user($followerID, $ourID)) {
                                                $text = $language_config[$lang]['unfollow'];
                                            } else {
                                                $text = $language_config[$lang]['follow'];
                                            }
                                        }
                                        
                                        echo "<div class='follower' data-uid='".$followerID."'>
                                                <div class='inner image'>
                                                    <img src='".$followerImage."'>
                                                </div>
                                                <div class='inner username'>
                                                    <div class='inner'>
                                                        <span>".$followerName."</span>
                                                    </div>
                                                </div>
                                                <div class='inner check'>
                                                    <div class='inner'>
                                                        <div class='follow-button cx-x-".$followerID."'>
                                                            <span><i class='fa fa-user'></i> ".$text."</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>";
                                    }
                                } else {
                                    echo "<div id='no-followers'><span>".$language_config[$lang]['no-followers']."</span></div>";
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <div id='user-image-preview-container'>
                <div id='inner' data-gr>
                    <div id='top' data-gr>
                        <div id='exit-profile-pic'>
                            <i class='fa fa-times'></i>
                        </div>
                    </div>
                    <div id='image-preview' data-gr>
                        <img src='' data-gr>
                    </div>
                </div>
            </div>

            <?php
                if($isLogin) {
                    if($userID == $ourID) {
                        echo "<div id='settings-container-section' data-gr>
                            <div id='exit-section'>
                                <i class='fa fa-times'></i>
                            </div>
                            <div id='inner'>
                                <div id='top'>
                                    <span>".$language_config[$lang]['account-settings']."</span>
                                </div>
                                <div id='main-info'>
                                    <div id='picture-section'>
                                        <div id='top'>
                                            <span>".$language_config[$lang]['profile-picture']."</span>
                                        </div>
                                        <div id='profile-picture'>
                                            <img src=''>
                                        </div>
                                        <div id='edit'>
                                            <i class='fa fa-edit'></i>
                                        </div>
                                    </div>

                                    <i class='fa fa-spinner fa-spin' id='spinner' style='position: absolute; display: none; top: 70%; left: 10%; font-size: 3.5em; color: white;'></i>
                                    <button id='confirm-changes'>".$language_config[$lang]['save-details']."</button>
            
                                    <div id='user-data'>
                                        <div id='basic-info'>
                                            <div id='top'>
                                                <span>".$language_config[$lang]['overall-info']."</span>
                                            </div>
                                            <div id='display-name-info-section' class='basic-info-section' data-slide-px='180px' data-initial-px='65px'>
                                                <div class='icon'>
                                                    <i class='fa fa-file-text'></i>
                                                </div>
                                                <div class='heading'>
                                                    <span>".$language_config[$lang]['display-name']."</span>
                                                </div>
                                                <div class='subtext'>
                                                    <span>".$language_config[$lang]['display-name-info']."</span>
                                                </div>
                                                <div id='display-name-field-container' class='cnt'>
                                                    <span>".$language_config[$lang]['new-display-name']."</span>
                                                    <input type='text' name='display_name' id='display-name-field' class='overall-info-field' value='".$displayName."'>
                                                </div>
                                            </div>
                                            <div id='password-update' class='basic-info-section' data-slide-px='360px' data-initial-px='65px'>
                                                <div class='icon'>
                                                    <i class='fa fa-key'></i>
                                                </div>
                                                <div class='heading'>
                                                    <span>".$language_config[$lang]['password-change']."</span>
                                                </div>
                                                <div class='subtext'>
                                                    <span>".$language_config[$lang]['password-info']."</span>
                                                </div>
                                                <div id='password-update-field-container' class='cnt'>
                                                    <span id='current-password-text'>".$language_config[$lang]['current-password']."</span>
                                                    <input type='password' name='current_password' id='password-update-field' class='overall-info-field'>
            
                                                    <span id='new-password-text'>".$language_config[$lang]['new-password']."</span>
                                                    <input type='password' name='new_password_update' id='new-password-update-field' class='overall-info-field'>
            
                                                    <span id='new-password-confirm-text'>".$language_config[$lang]['confirm-new-password']."</span>
                                                    <input type='password' name='confirm_password_update' id='confirm-password-update-field' class='overall-info-field'>
                                                </div>
                                                <div id='password-error'>
                                                    <span>Паролите не съвпадат!</span>
                                                </div>
                                            </div>
                                            <div id='email-update' class='basic-info-section' data-slide-px='230px' data-initial-px='65px'>
                                                <div class='icon'>
                                                    <i class='fa fa-envelope'></i>
                                                </div>
                                                <div class='heading'>
                                                    <span>".$language_config[$lang]['email-change']."</span>
                                                </div>
                                                <div class='subtext'>
                                                    <span>".$language_config[$lang]['email-info']."</span>
                                                </div>
                                                <div id='email-field-container' class='cnt'>
                                                    <span>".$language_config[$lang]['new-email']."</span>
                                                    <input type='text' name='emaill' id='emaill-field' class='overall-info-field' placeholder='email@mail.com' value='".$email."'>
                                                </div>
                                                <div id='email-error'>
                                                    <span>Вече съществува такъв имейл!</span>
                                                </div>
                                            </div>
                                            <div id='location-update' class='basic-info-section' data-slide-px='180px' data-initial-px='65px'>
                                                <div class='icon'>
                                                    <i class='fa fa-map-marker'></i>
                                                </div>
                                                <div class='heading'>
                                                    <span>".$language_config[$lang]['location']."</span>
                                                </div>
                                                <div class='subtext'>
                                                    <span>".$language_config[$lang]['location-info']."</span>
                                                </div>
                                                <div id='location-field-container' class='cnt'>
                                                    <span>".$language_config[$lang]['location']."</span>
                                                    <input type='text' name='location' id='location-field' class='overall-info-field' placeholder='Sofia, Bulgaria' value='".$location."'>
                                                </div>
                                            </div>
                                        </div>
                                        <div id='location-login-info'>
                                            <div id='top'>
                                                <span>".$language_config[$lang]['login-location']."</span>
                                            </div>
                                            <div class='location-info'>
                                                <div class='icon'>
                                                    <i class='fa fa-desktop'></i>
                                                </div>
                                                <div class='heading'>
                                                    <span>Настолен компютър с Windows · Troyan, Bulgaria</span>
                                                </div>
                                                <div class='subtext'>
                                                    <span>Chrome · На линия в момента</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div id='social-media'>
                                            <div id='top'>
                                                <span>".$language_config[$lang]['social-media']."</span>
                                            </div>
                                            <form action='' method='post'>
                                                <div id='facebook'>
                                                    <div class='icon'>
                                                        <i class='fa fa-facebook'></i>
                                                    </div>
                                                    <span>Facebook</span>
                                                    <input type='text' name='facebook'  id='facebook' class='social-media-input-field' placeholder='".$language_config[$lang]['facebook-info']."'>
                                                </div>
            
                                                <div id='instagram'>
                                                    <div class='icon'>
                                                        <i class='fa fa-instagram'></i>
                                                    </div>
                                                    <span>Instagram</span>
                                                    <input type='text' name='instagram' id='instagram' class='social-media-input-field' placeholder='".$language_config[$lang]['instagram-info']."'>
                                                </div>
            
                                                <div id='twitter'>
                                                    <div class='icon'>
                                                        <i class='fa fa-twitter'></i>
                                                    </div>
                                                    <span>Twitter</span>
                                                    <input type='text' name='twitter'   id='twitter'   class='social-media-input-field' placeholder='".$language_config[$lang]['twitter-info']."'>
                                                </div>

                                                <div id='twitch'>
                                                    <div class='icon'>
                                                        <i class='fa fa-twitch'></i>
                                                    </div>
                                                    <span>Twitch</span>
                                                    <input type='text' name='twitch'  id='twitch' class='social-media-input-field' placeholder='".$language_config[$lang]['facebook-info']."'>
                                                </div>

                                                <div id='steam'>
                                                    <div class='icon'>
                                                        <i class='fa fa-steam'></i>
                                                    </div>
                                                    <span>Steam</span>
                                                    <input type='text' name='steam'  id='steam' class='social-media-input-field' placeholder='".$language_config[$lang]['facebook-info']."'>
                                                </div>
                                                
            
                                                <div id='youtube'>
                                                    <div class='icon'>
                                                        <i class='fa fa-youtube'></i>
                                                    </div>
                                                    <span>YouTube</span>
                                                    <input type='text' name='youtube'   id='youtube'   class='social-media-input-field' placeholder='".$language_config[$lang]['youtube-info']."'>
                                                </div>
            
                                                <div id='skype'>
                                                    <div class='icon'>
                                                        <i class='fa fa-skype'></i>
                                                    </div>
                                                    <span>Skype</span>
                                                    <input type='text' name='skype'   id='skype'   class='social-media-input-field' placeholder='".$language_config[$lang]['skype-info']."'>
                                                </div>
                                            </form>
                                        </div>


                                        <div id='blocked-users'>
                                            <div id='top'>
                                                <span>".$language_config[$lang]['blocked-users']."</span>
                                            </div>";
                                            
                                            $blockedUsers = $db->setFetchMode(FetchModes::$modes['assoc'])->rawQuery("select * from blocked_users where blocked_by_user_id = ?", [$userID], true, DB::ALL_ROWS);
                                            if(_Array::size($blockedUsers) > 0) {
                                                foreach($blockedUsers as $blockedUser) {
                                                    $blockedUserID          = intval($blockedUser['blocked_user_id']);
                                                    $blockedUserImage       = Str::htmlEnt(Str::replace_all_quotes($blockedUser['blocked_user_image'], true));
                                                    $blockedUserDisplayName = Str::htmlEnt(Str::replace_all_quotes($blockedUser['blocked_user_displayname'], true));
                                                    
                                                    echo "<div class='blocked-user ".$blockedUserID."'>
                                                            <div class='image'>
                                                                <img src='".$blockedUserImage."'>
                                                            </div>
                                                            <div class='display-name'>
                                                                <span>".$blockedUserDisplayName."</span>
                                                            </div>
                                                            <button class='unblock unblock-button x-c-$blockedUserID'>".$language_config[$lang]['unblock-user']."</button>
                                                        </div>";
                                                }
                                            } else {
                                                echo "<div id='no-blocked-users'>
                                                          <div id='inner'>
                                                              <span>".$language_config[$lang]['no-blocked-users-found']."</span>
                                                          </div>
                                                      </div>";
                                            }

                                   echo "</div>";


                                            if($isLogin) {
                                                if($ourID == $userID) {
                                                    echo "<div id='delete-account'>
                                                            <div id='top'>
                                                                <span>".$language_config[$lang]['delete-account']."</span>
                                                            </div>
                                                            <span>&bull; ".$language_config[$lang]['account-deletion']."</span>
                                                            <button id='submit-deletion'>".$language_config[$lang]['delete-account']."</button>
                                                            
                                                            <div id='confirm-deletion'>
                                                                <span id='message'>".$language_config[$lang]['delete-account-confirmation']."</span>
                                                                <div id='buttons'>
                                                                    <div id='yes'>
                                                                        <span>".$language_config[$lang]['yes']."</span>
                                                                    </div>
                                                                    <div id='no'>
                                                                        <span>".$language_config[$lang]['no']."</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>";
                                                }
                                            }
                                            
                                    echo "
                                    </div>
                                    <div id='image-cropper-container'>
                                        <button id='crop-result'>".$language_config[$lang]['crop']."</button>
                                    </div>
                                </div>
                            </div>
                            <form id='upload-image-form'>
                                <input type='file' id='image-file' name='image-file' style='visibility: hidden;'>
                            </form>
                        </div>";
                    }
                }
            ?>
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


    /* ==== PROFILE PICTURE BORDER COLOR HANDLING ==== */
    var picBorderColor = cookieUtil.get('pic-border-color');
    if(picBorderColor) {
        $('#user-image').css('border', '3px solid ' + picBorderColor);
    } else {
        $('#user-image').css('border', '3px solid #0af0ca');
    }
    $('input[type="color"]').on('change', function() {
        $('#user-image').css('border', '3px solid ' + $(this).val());
        cookieUtil.create({
                name: 'pic-border-color',
                value: $(this).val(),
                path: '/',
                days: 365
            }
        );
    });
    /* ==== PROFILE PICTURE BORDER COLOR HANDLING ==== */



    $('#bottom-navbar > #stats > .stat').click(function(e) {
        var self = $(this);
        $('#bottom-navbar > #stats > .stat').each(function(index, element) {
            var id = $(element).attr('id');
            if(self.attr('id') != id) {
                $(element).find('.bottom > .line').fadeOut('fast');
                $($(element).attr('data-section')).hide();
            }
        });
        self.find('.bottom > .line').fadeIn('fast');
    });
</script>
<script type='text/javascript'>
    $(document).ready(function() {
        var lang = cookieUtil.get('lang');
        if(lang != 'en') {
            $('#bottom-navbar > #stats > .stat').css('width', '150px');
        }
        $('.follower').each(function(i, e) {
            var follower = $(e);
            follower.find('.username > .inner > span, .image').click(function() {
                $.redirect('/account/uid/' + follower.attr('data-uid'));
            });
        });
    });
</script>
<footer>
    <div id='footer-inner'>
        <span>© 2022 ps-classics.com. All rights reserved.</span>
    </div>
</footer>
</html>