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
    require_once "usercp.php";

    $lang    = Server::get_request_cookie('lang',  ['en', 'bg'], 'bg');
    $theme   = Server::get_request_cookie('theme', ['halloween', 'none'], 'none');
    $isLogin = Server::is_active_session('user');

    $platform = Str::getstr(Server::get_param('platform'), ['ps1', 'ps2', 'ps3'], 'ps2');
    $search   = Str::replace_all_quotes(Server::get_param('search-game'));
    $pageID   = intval(Server::get_param('page'));

    $db         = new DB(false);
    $pagination = new Pagination([
        'max-page-links' => 5,
        'max-page-items' => 27,
        'current-page' => $pageID,
        'table' => 'games',
        'platform' => $platform,
        'db' => $db
    ]);
    //UserCP::setDB($db);
    //UserCP::move_game('Tomb Raider 2013');
    //echo Util::transform_links("Here is a link [link]https://example1.com[/link], \nand one more [link]https://example2.com[/link] is the next");
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
            window._login = <?php echo $isLogin ? 'true' : 'false' ; ?>;
            window.lang  = '<?php echo $lang; ?>'
            window.text  = {
                'comment-removal': {
                    'bg' : '<?php echo transliterator_transliterate('Any-Hex/Java', 'Сигурен/а ли си че искаш да изтриеш този коментар?'); ?>',
                    'en' : 'Are you sure you want to delete the comment?'
                },
                'yes' : {
                    'bg' : '<?php echo transliterator_transliterate('Any-Hex/Java', 'Да'); ?>',
                    'en' : 'Yes'
                },
                'no' : {
                    'bg' : '<?php echo transliterator_transliterate('Any-Hex/Java', 'Не'); ?>',
                    'en' : 'No'
                },
                'edit' : {
                    'bg' : '<?php echo transliterator_transliterate('Any-Hex/Java', 'Редактиране'); ?>',
                    'en' : 'Edit comment'
                }
            }
            $('.file-upload-icon').click(function() {
                if(!window._login) {
                    $('#upload-login-warn').css('display', 'flex').delay(1500).hide('fast');
                } else {
                    $('#game-cover-file').click();
                }
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
        <section id='top-section' class='sections'>
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
                    $userData  = $db->setFetchMode(FetchModes::$modes['assoc'])->rawQuery("select image from users where id = ?", [intval(Server::retrieve_session('user', 'id'))], true, DB::ALL_ROWS);
                    $userImage = Str::htmlEnt($userData[0]['image']);
                    
                    $username  = Str::truncate(Str::replace_all_quotes(Server::retrieve_session('user', 'username'), true), 9);
                    echo "<div id='login-success-container'>
                        <div id='account-info' data-uid='".intval(Server::retrieve_session('user', 'id'))."' data-acc>
                            <div id='image'>
                                <img src='".$userImage."'>
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
            <div id='halloween-theme'>
                <img src='\ps-classics\img\halloween-u.png'>
            </div>
        
            <div id='search-game-container'>
                <div id='top'>
                    <span data-theme data-fontsize='3em' data-mgtop='-3.5%'><?php echo $language_config[$lang]['find-game']; ?></span>
                </div>
                <form id='search-form' action='' method='get'>
                    <input id='search-game' type='text' name='search-game' placeholder='<?php echo $language_config[$lang]['search']; ?>' autocomplete='off'>
                    <input type='hidden' name='platform' value='<?php echo $platform; ?>'>
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

            <div id='game-filters-container' data-gr class='modal-active'></div>

            <div id='upload-game-container'>
                <form id='upload-game-form'>
                    <div id='inner'>
                        <i class='fa fa-upload file-upload-icon'></i>
                    </div>
                    <input type='file' id='game-cover-file' name='game-cover-file' style='visibility: hidden;'>
                </form>
            </div>

            <div id='filter-games-trigger'>
                <span><?php echo $language_config[$lang]['filter-genre']; ?> <span> <i class='fa fa-caret-down'></i></span></span>
            </div>

            <div id='upload-login-warn'>
                <span><?php echo $language_config[$lang]['account-first']; ?></span>
            </div>

            <div class='collection-container'>
                <div id='collection'>
                <?php
                    if(Str::is_empty($search)) {
                        $offset = ($pageID - 1) * 27;
                        // Query games data from database based on CURRENT PAGE NUMBER and PLATFORM
                        $arrayResult = $db->setFetchMode(FetchModes::$modes['assoc'])->rawQuery("select * from games where platform = ? limit 27 offset $offset", [$platform], true, DB::ALL_ROWS);
                        if(_Array::size($arrayResult) > 0) {
                            foreach($arrayResult as $item) {

                                $gameMetadata = json_encode([
                                    'genres'        => $item['genres'],
                                    'developers'    => $item['developers'],
                                    'publishers'    => $item['publishers'],
                                    'release-dates' => $item['release_dates'],
                                    'platforms'     => $item['platforms'],
                                    'iso'           => $item['link']
                                ]);

                                $uploaderImage = Str::htmlEnt(Str::replace_all_quotes($item['uploader_image'], true));

                                echo "<div class='collection-item ".intval($item['id'])."' data-name='".Str::htmlEnt(Str::replace_all_quotes($item['name'], true))."' data-uploader='".Str::htmlEnt($item['uploader'])."' data-uploaderid=".$item['uploader_id']." data-uploader-image='".$uploaderImage."' data-metadata='".$gameMetadata."'>
                                    <div class='cover ".$platform."-cover'>
                                        <img src='\\ps-classics\\img\\collection\\".$platform."\\".htmlentities($item['cover'], ENT_QUOTES, 'UTF-8')."'>
                                    </div>
                                    <div class='collection-item-slider'>
                                        <div class='game-name'>
                                            <span>".htmlentities(Str::truncate($item['name'], 19), ENT_QUOTES, 'UTF-8')."</span>
                                        </div>
                                        <div class='uploader-name'>
                                            <span>".Str::truncate("By: ".htmlentities($item['uploader'], ENT_QUOTES, 'UTF-8')."", 19)."</span>
                                        </div>
                                        <div class='likes' data-count='".intval($item['likes'])."'>
                                            <span><i class='fa fa-thumbs-up' style='color: #df0f55; font-size: 1.2em;'></i> <span>".intval($item['likes'])."</span></span>
                                        </div>
                                        <div class='favourited' data-count='".intval($item['favourited'])."'>
                                            <span><i class='fa fa-heart' style='color: #df0f55; font-size: 1.2em;'></i> <span>".intval($item['favourited'])."</span></span>
                                        </div>
                                        <div class='comments' data-count='".intval($item['comments'])."'>
                                            <span><i class='fa fa-comments' style='color: #df0f55; font-size: 1.2em;'></i> ".intval($item['comments'])."</span>
                                        </div>
                                        <div class='views' data-count='".intval($item['views'])."'>
                                            <span><i class='fa fa-eye' style='color: #df0f55; font-size: 1.2em;'></i> <span>".intval($item['views'])."</span></span>
                                        </div>
                                    </div>
                                </div>";
                            }
                        }
                    } else {
                        $offset = ($pageID - 1) * 27;
                        $arrayResult = $db->setFetchMode(FetchModes::$modes['assoc'])->rawQuery("select * from games where platform = ? and lower( games.name ) like '%".$search."%' limit 27", [$platform], true, DB::ALL_ROWS);
                        if(_Array::size($arrayResult) > 0) {
                            foreach($arrayResult as $item) {

                                $gameMetadata = json_encode([
                                    'genres'        => $item['genres'],
                                    'developers'    => $item['developers'],
                                    'publishers'    => $item['publishers'],
                                    'release-dates' => $item['release_dates'],
                                    'platforms'     => $item['platforms']
                                ]);

                                $uploaderImage = Str::htmlEnt(Str::replace_all_quotes($item['uploader_image'], true));

                                echo "<div class='collection-item ".intval($item['id'])."' data-name='".Str::htmlEnt(Str::replace_all_quotes($item['name'], true))."' data-uploader='".htmlentities($item['uploader'], ENT_QUOTES, 'UTF-8')."' data-uploaderid=".$item['uploader_id']." data-uploader-image='".$uploaderImage."' data-metadata='".$gameMetadata."'>
                                    <div class='cover ".$platform."'>
                                        <img src='\\ps-classics\\img\\collection\\".$platform."\\".htmlentities($item['cover'], ENT_QUOTES, 'UTF-8')."'>
                                    </div>
                                    <div class='collection-item-slider'>
                                        <div class='game-name'>
                                            <span>".htmlentities(Str::truncate($item['name'], 19), ENT_QUOTES, 'UTF-8')."</span>
                                        </div>
                                        <div class='uploader-name'>
                                            <span>".Str::truncate("By: ".htmlentities($item['uploader'], ENT_QUOTES, 'UTF-8')."", 19)."</span>
                                        </div>
                                        <div class='likes' data-count='".intval($item['likes'])."'>
                                            <span><i class='fa fa-thumbs-up' style='color: #df0f55; font-size: 1.2em;'></i> <span>".intval($item['likes'])."</span></span>
                                        </div>
                                        <div class='favourited' data-count='".intval($item['favourited'])."'>
                                            <span><i class='fa fa-heart' style='color: #df0f55; font-size: 1.2em;'></i> <span>".intval($item['favourited'])."</span></span>
                                        </div>
                                        <div class='comments' data-count='".intval($item['comments'])."'>
                                            <span><i class='fa fa-comments' style='color: #df0f55; font-size: 1.2em;'></i> ".intval($item['comments'])."</span>
                                        </div>
                                        <div class='views' data-count='".intval($item['views'])."'>
                                            <span><i class='fa fa-eye' style='color: #df0f55; font-size: 1.2em;'></i> <span>".intval($item['views'])."</span></span>
                                        </div>
                                    </div>
                                </div>";
                            }
                        }
                    }
                ?>
                </div>
                <div class='pagination-container' data-action='collection' data-platform='<?php echo $platform; ?>'>
                    <div id='inner'>
                        <?php
                            $pagination->generate_links();
                        ?>
                        <!-- <div class='page-item'><span data-theme>1</span></div>
                        <div class='page-item'><span data-theme>2</span></div>
                        <div class='page-item'><span data-theme>3</span></div>
                        <div class='page-item no-redirect'><span data-theme>...</span></div>
                        <div class='page-item'><span data-theme>5</span></div> -->
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
                            <span data-theme data-fontsize='3em'></span>
                        </div>
                    </div>
                    <div id='game-cover'>
                        <img src=''>
                    </div>
                    <div id='item-actions'>
                        <div id='likes' class='action-button' data-action='like'>
                            <span><i class='fa fa-thumbs-up'></i> &nbsp;<span>100</span></span>
                        </div>
                        <div id='favourited' class='action-button' data-action='favourite'>
                            <span><i class='fa fa-heart'></i> &nbsp;<span>100</span></span>
                        </div>
                        <div id='comments' class='action-button no-action'>
                            <span><i class='fa fa-comments'></i> &nbsp;<span>100</span></span>
                        </div>
                        <div id='views' class='action-button no-action'>
                            <span><i class='fa fa-eye'></i> &nbsp;<span>100</span></span>
                        </div>
                    </div>
                    <div id='account-login-first'>
                        <span class=''><?php echo $language_config[$lang]['account-first']; ?></span>
                    </div>
                    <div id='item-information'>
                        <div id='inner'>
                            <div id='uploader'>
                                <div id='image' class='uploader-data' data-uid='1' data-acc>
                                    <img src='\ps-classics\img\halloween-u.png'>
                                </div>
                                <div id='display-name' class='uploader-data' data-uid='1' data-acc>
                                    <span></span>
                                </div>
                            </div>
                            <div id='game-info'>
                                <div id='release-date' class='game-info-text'>
                                    <span style='color: #fc5603;'>&bull; </span>
                                    <span><?php echo $language_config[$lang]['game-date']; ?>: <span></span></span>
                                </div>
                                <div id='genre' class='game-info-text'>
                                    <span style='color: #fc5603;'>&bull; </span>
                                    <span><?php echo $language_config[$lang]['game-genre']; ?>: <span></span></span>
                                </div>
                                <div id='platforms' class='game-info-text'>
                                    <span style='color: #fc5603;'>&bull; </span>
                                    <span><?php echo $language_config[$lang]['game-pltf']; ?>: <span></span></span>
                                </div>
                                <div id='developers' class='game-info-text'>
                                    <span style='color: #fc5603;'>&bull; </span>
                                    <span><?php echo $language_config[$lang]['game-devs']; ?>: <span></span></span>
                                </div>
                                <div id='publishers' class='game-info-text'>
                                    <span style='color: #fc5603;'>&bull; </span>
                                    <span><?php echo $language_config[$lang]['game-publ']; ?>: <span></span></span>
                                </div>
                                <div id='iso' class='game-info-text'>
                                    <span style='color: #fc5603;'>&bull; </span>
                                    <span id='iso-span'>Iso: </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id='write-comment'>
                        <?php
                            if($isLogin) {
                                echo "<div id='emoji-smiley' data-gr>
                                        <span data-gr>🙂</span>
                                    </div>
                                    <div id='add-link'>
                                        <span>".$language_config[$lang]['add-link']."</span>
                                    </div>";

                                echo "
                                    <div id='top'>
                                        <span>".$language_config[$lang]['write-comment']."</span>
                                    </div>
                                    <form id='comment-form' action='' method='' data-action='comment'>
                                        <textarea name='comment-input-field' id='collection-item-comment-input-field' autocomplete='off'></textarea>
                                        <div id='comment-submit'>
                                            <i class='fa fa-check'></i>
                                        </div>
                                    </form>";
                            } else {
                                echo "<div id='top'>
                                        <span data-theme data-fontsize='1.8em'>".$language_config[$lang]['login-to-comment']."</span>
                                    </div>";
                            }
                        ?>
                    </div>
                    <div id='comment-rate-warning'>
                        <span><?php echo $language_config[$lang]['account-first']; ?></span>
                    </div>
                    <div id='emoji-container' data-gr>
                        <div id='top' data-gr>
                            <span data-gr><?php echo $language_config[$lang]['emojis']; ?></span>
                        </div>
                        <div id='mid' data-gr>
                            <div id='inner' data-gr>
                                <div id='smiley' class='icons-container' data-gr>
                                    <?php
                                        foreach(explode(" ", "😀 😃 😄 😁 😆 😅 😂 🤣 😊 😇 🙂 🙃 😉 😌 😍 🥰 😘 😗
                                                😙 😚 😋 😛 😝 😜 🤪 🤨 🧐 🤓 😎 🤩 🥳 😏 😒 😞 😔 😟 😕
                                                🙁 ☹️ 😣 😖 😫 😩 🥺 😢 😭 😤 😠 😡 🤬 🤯 😳 🥵 🥶 😱 😨
                                                😰 😥 😓 🤗 🤔 🤭 🤫 🤥 😶 😐 😑 😬 🙄 😯 😦 😧 😮 😲 🥱 😴
                                                🤤 😪 😵 🤐 🥴 🤢 🤮 🤧 😷 🤒 🤕 🤑 🤠 😈 👿 👹 👺 🤡 💩 👻
                                                💀 ☠️ 👽 👾 🤖 🎃 😺 😸 😹 😻 😼 😽 🙀 😿 😾") as $icon) {
                                
                                                $_icon = Str::substring(Util::emoji_to_unicode($icon), 2);
                                                // valid emojis have length of 5
                                                if(Str::length($_icon) == 5) {
                                                    echo "<span class='comment-icon' data-gr data-code='$_icon'>&#x$_icon;</span>";
                                                }
                                        }
                                        echo "\n";
                                    ?>
                                </div>
                                <div id='animals-nature' class='icons-container' data-gr>
                                    <?php
                                        foreach(explode(" ", "🐶 🐱 🐭 🐹 🐰 🦊 🐻 🐼 🐻‍❄️ 🐨 🐯 🦁 🐮 🐷 🐽 🐸 🐵 🙈 🙉 🙊
                                                🐒 🐔 🐧 🐦 🐤 🐣 🐥 🦆 🦅 🦉 🦇 🐺 🐗 🐴 🦄 🐝 🪱 🐛 🦋 🐌 🐞 🐜 🦟 🦗 🕷
                                                🕸 🦂 🐢 🐍 🦎 🦖 🦕 🐙 🦑 🦐 🦞 🦀 🐡 🐠 🐟 🐬 🐳 🐋 🦈 🐊 🐅 🐆 🦓 🦍 🦧 🐘
                                                🦛 🦏 🐪 🐫 🦒 🦘 🐃 🐂 🐄 🐎 🐖 🐏 🐑 🦙 🐐 🦌 🐕 🐩 🦮 🐕‍🦺 🐈 🐈‍⬛ 🐓 🦃 🦚
                                                🦜 🦢 🦩 🕊 🐇 🦝 🦨 🦡 🦦 🦥 🐁 🐀 🐿 🦔 🐾 🐉 🐲 🌵 🎄 🌲 🌳 🌴 🌱 🌿 ☘️ 🍀 🎍
                                                🎋 🍃 🍂 🍁 🍄 🐚 🌾 💐 🌷 🌹 🥀 🌺 🌸 🌼 🌻 🌞 🌝 🌛 🌜 🌚 🌕 🌖 🌗 🌘 🌑 🌒 🌓 🌔
                                                🌙 🌎 🌍 🌏 🪐 💫 ⭐️ 🌟 ✨ ⚡️ ☄️ 💥 🔥 🌪 🌈 ☀️ ⛅️ ☁️ ❄️ ☃️ ⛄️
                                                💨 💧 💦 ☔️ ☂️ 🌊") as $icon) {
                                
                                                $_icon = Str::substring(Util::emoji_to_unicode($icon), 2);
                                                // valid emojis have length of 5
                                                if(Str::length($_icon) == 5) {
                                                    echo "<span class='comment-icon' data-gr data-code='$_icon'>&#x$_icon;</span>";
                                                }
                                        }
                                        echo "\n";
                                    ?>
                                </div>
                                <div id='symbols' class='icons-container' data-gr>
                                    <?php
                                        foreach(explode(" ", "❤️ 🧡 💛 💚 💙 💜 🖤 🤍 🤎 💔 ❣️ 💕 💞 💓 💗 💖 💘 💝
                                                💟 🉑 ☢️ ☣️ 📴 📳 🈶 🈚️ 🈸 🈺 🈷️ ✴️
                                                🆚 💮 🉐 ㊙️ ㊗️ 🈴 🈵 🈹 🈲 🅰️ 🅱️ 🆎 🆑 🅾️ 🆘 ❌ ⭕️ 🛑 ⛔️
                                                📛 🚫 💯 💢 ♨️ 🚷 🚯 🚳 🚱 🔞 📵 🚭 ❗️ ❕ ❓ ❔ 🔅 🔆 〽️
                                                ⚠️ 🚸 🔱 ⚜️ 🔰 ♻️ ✅ 🈯️ 💹 ❇️ ✳️ ❎ 🌐 💠 Ⓜ️ 🌀 💤 🏧 🚾 ♿️ 🅿️ 🛗 🈳 🈂️
                                                🎦 📶 🈁 🔣 ℹ️ 🔤 🔡 🔠 🆖 🆗 🆙 🆒 🆕 🆓
                                                🔢 #️⃣ *️⃣ ⏏️ ▶️ ⏸ ⏯ ⏹ ⏺ ⏭ ⏮ ⏩ ⏪ ⏫ ⏬
                                                ◀️ 🔼 🔽 ➡️ ⬅️ ⬆️ ⬇️ ↖️ ↪️ ↩️ ⤴️ ⤵️ 🔀 🔁 🔂 🔄 🔃 🎵 🎶
                                                ➗ ✖️ ♾ 💲 💱 〰️ ➰ ➿ ✔️ 🔘 🔴 🟠 🟡 🟢 🔵 🟣 ⚫️ ⚪️
                                                🔇 🔉 🔊 🔔 🔕 📣 📢 👁‍🗨 💬 💭") as $icon) {
                                
                                                $_icon = Str::substring(Util::emoji_to_unicode($icon), 2);
                                                // valid emojis have length of 5
                                                if(Str::length($_icon) == 5) {
                                                    echo "<span class='comment-icon' data-gr data-code='$_icon'>&#x$_icon;</span>";
                                                }
                                        }
                                        echo "\n";
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id='game-upload-container'>
                <div id='top'>
                    <div id='exit-preview'>
                        <i class='fa fa-times'></i>
                    </div>
                </div>
                <div id='inner'>
                    <div id='game-upload-cover'>
                        
                    </div>
                    <div id='header'>
                        <div id='text'>
                            <span><?php echo $language_config[$lang]['info']; ?></span>
                        </div>
                        <div id='header-line'>
                            <div id='underline'></div>
                        </div>
                    </div>
                    <div id='game-metadata'>
                        <form id='metadata-form' action='' method=''>
                            <input class='game-upload-field' type='text' name='game-name'  id='game-name'  placeholder='<?php echo $language_config[$lang]['game-name'];  ?> ...' autocomplete='off'>
                            <input class='game-upload-field' type='text' name='game-genre' id='game-genre' placeholder='<?php echo $language_config[$lang]['game-genre']; ?> ...' autocomplete='off'>
                                <i class="fa fa-info-circle game-upload-tooltip-trigger" data-target='game-genre'></i>

                            <input class='game-upload-field' type='text' name='game-pltf'  id='game-pltf'  placeholder='<?php echo $language_config[$lang]['game-pltf']; ?> ...' autocomplete='off'>
                                <i class="fa fa-info-circle game-upload-tooltip-trigger" data-target='game-pltf'></i>

                            <input class='game-upload-field' type='text' name='game-devs'  id='game-devs'  placeholder='<?php echo $language_config[$lang]['game-devs']; ?> ...' autocomplete='off'>
                                <i class="fa fa-info-circle game-upload-tooltip-trigger" data-target='game-devs'></i>

                            <input class='game-upload-field' type='text' name='game-publ'  id='game-publ'  placeholder='<?php echo $language_config[$lang]['game-publ']; ?> ...' autocomplete='off'>
                                <i class="fa fa-info-circle game-upload-tooltip-trigger" data-target='game-publ'></i>

                            <input class='game-upload-field' type='text' name='game-date'  id='game-date'  placeholder='<?php echo $language_config[$lang]['game-date']; ?> ...' autocomplete='off'>
                                <i class="fa fa-info-circle game-upload-tooltip-trigger" data-target='game-date'></i>

                            <input class='game-upload-field' type='text' name='game-iso'   id='game-iso'   placeholder='<?php echo $language_config[$lang]['game-iso']; ?> - https://example.com' autocomplete='off'>
                            

                            <div id='checkbox-ps1-container' class='checkbox-container'>
                                <div class='box'>
                                    <span>ps1</span>
                                </div>
                                <div class='box'>
                                    <input type="radio" id="ps1-radio" name="platform" value="ps1">
                                </div>
                            </div>

                            <div id='checkbox-ps2-container' class='checkbox-container'>
                                <div class='box'>
                                    <span>ps2</span>
                                </div>
                                <div class='box'>
                                    <input type="radio" id="ps2-radio" name="platform" value="ps2">
                                </div>
                            </div>

                            <div id='checkbox-ps3-container' class='checkbox-container'>
                                <div class='box'>
                                    <span>ps3</span>
                                </div>
                                <div class='box'>
                                    <input type="radio" id="ps3-radio" name="platform" value="ps3">
                                </div>
                            </div>


                            <div id='submit-game-upload'>
                                <span class='multilang'><?php echo $language_config[$lang]['confirm-upload']; ?></span>
                            </div>
                        </form>
                        <div id='upload-spinner'>
                            <i class='fa fa-spinner fa-spin'></i>
                        </div>
                    </div>
                    <div id='game-genre-tooltip' class='game-upload-field-info-tooltip'>
                        <div class='top'>
                            <div class='inner'>
                                <span><?php echo $language_config[$lang]['examples']; ?></span>
                            </div>
                        </div>
                        <div class='mid'>
                            <span>&bull; Action</span></br>
                            <span>&bull; Action, Horror, Adventure</span>
                        </div>
                    </div>
                    <div id='game-pltf-tooltip' class='game-upload-field-info-tooltip'>
                        <div class='top'>
                            <div class='inner'>
                                <span><?php echo $language_config[$lang]['examples']; ?></span>
                            </div>
                        </div>
                        <div class='mid'>
                            <span>&bull; PlayStation 2</span></br>
                            <span>&bull; PlayStation 2, macOS, PlayStation 3</span>
                        </div>
                    </div>
                    <div id='game-devs-tooltip' class='game-upload-field-info-tooltip'>
                        <div class='top'>
                            <div class='inner'>
                                <span><?php echo $language_config[$lang]['examples']; ?></span>
                            </div>
                        </div>
                        <div class='mid'>
                            <span>&bull; Electronic Arts</span></br>
                            <span>&bull; Electronic Arts, Overkill</span>
                        </div>
                    </div>
                    <div id='game-publ-tooltip' class='game-upload-field-info-tooltip'>
                        <div class='top'>
                            <div class='inner'>
                                <span><?php echo $language_config[$lang]['examples']; ?></span>
                            </div>
                        </div>
                        <div class='mid'>
                            <span>&bull; Rockstar Games</span></br>
                            <span>&bull; Rockstar Games, Starbreeze</span>
                        </div>
                    </div>
                    <div id='game-date-tooltip' class='game-upload-field-info-tooltip'>
                        <div class='top'>
                            <div class='inner'>
                                <span><?php echo $language_config[$lang]['examples']; ?></span>
                            </div>
                        </div>
                        <div class='mid'>
                            <span>&bull; October 31 1998</span></br>
                            <span>&bull; October 31 1998, July 10 2004</span>
                        </div>
                    </div>
                    <div id='game-iso-tooltip' class='game-upload-field-info-tooltip'>
                        <div class='top'>
                            <div class='inner'>
                                <span><?php echo $language_config[$lang]['examples']; ?></span>
                            </div>
                        </div>
                        <div class='mid'>
                            <span>&bull; October 31 1998</span></br>
                            <span>&bull; October 31 1998, July 10 2004</span>
                        </div>
                    </div>
                </div>
                <div id='upload-error'>
                    <span></span>
                </div>
            </div>
        </section>
        <section id='comment-section'>
            <div id='inner'>
                <div id='spinner'>
                    <i class='fa fa-spinner fa-spin' style='position: relative; top: 75%; left: 49%; font-size: 1.9em; color: white;'></i>
                </div>
                <div id='no-comments'>
                    <div id='inner'>
                        <span><?php echo $language_config[$lang]['no-comments']; ?></span>
                    </div>
                </div>
            </div>
        </section>
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
        $('#search-game-icon').click(function() {
            $('#search-form').submit();
        });
        $(document).on('preview-comments-loaded', function() {
            $('#scrolltop-caret').click(function() {
                $("html, body").animate({scrollTop: 0}, "fast");
            });
        });
    });
</script>
</html>