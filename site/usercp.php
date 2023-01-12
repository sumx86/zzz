<?php
    class UserCP {
        
        public static $errors = [];

        /*
         * User session data like username, display name, etc...
         */
        public static $sessionData = [];

        /*
         * Use debug mode
         */
        public static $debug = false;

        /*
         * The database handle
         */
        public static $dbInstance = null;

        /*
         * Set the database handle
         */
        public static function setDB($dbInstance) {
            if( is_object($dbInstance) ) {
                self::$dbInstance = $dbInstance;
            }
        }

        /*
         * Validate a user based on provided username and password
         */
        public static function validate($req, $data) {
            $userField = $data['user'];
            $passField = $data['pass'];
            global $language_config;
            global $lang;
            
            $username = Str::replace_all_quotes($req[$userField]);
            $result = self::$dbInstance->setFetchMode(PDO::FETCH_ASSOC)->rawQuery("select * from users where username = ?", [$username], true, DB::ALL_ROWS);
            if( _Array::size($result) > 0 ) {
                if(password_verify($req[$passField], $result[0]['password'])) {
                    self::set_session_data($result[0]);
                    //var_dump(self::$sessionData);
                    return true;
                }
            }
            self::$errors[$userField] = $language_config[$lang]['login-errors']['wrong-u-p'];
            self::$errors[$passField] = '';
            return false;
        }

        /*
         * Validate that the user with id $userID has password $password
         */
        public static function validate_password($password, $userID) {
            global $language_config;
            global $lang;
            $result = self::$dbInstance->setFetchMode(PDO::FETCH_ASSOC)->rawQuery("select password from users where id = ?", [$userID], true, DB::ALL_ROWS);
            if( _Array::size($result) > 0 ) {
                if(password_verify($password, $result[0]['password'])) {
                    return true;
                }
            }
            self::$errors['password'] = $language_config[$lang]['login-errors']['wrong-p'];
            return false;
        }

        /*
         * Determine if the provided email exists
         */
        public static function validate_email($req, $data) {
            $emailField = $data['email'];
            global $language_config;
            global $lang;
            
            $email  = Str::replace_all_quotes($req[$emailField]);
            $result = self::$dbInstance->setFetchMode(PDO::FETCH_ASSOC)->rawQuery("select id from users where email = ?", [$email], true, DB::ALL_ROWS);
            if( _Array::size($result) <= 0 ) {
                self::$errors[$emailField] = $language_config[$lang]['reset-pass-errors']['wrong-e'];
                return false;
            }
            return true;
        }

        /*
         * Prepare the $sessionData variable
         */
        public static function set_session_data($data) {
            foreach($data as $fieldName => $fieldValue) {
                if( $fieldName != 'password' && $fieldName != 'email' ) {
                    self::$sessionData[$fieldName] = $fieldValue;
                }
            }
        }

        /*
         * Create a user session with data $sessionData
         */
        public static function create_session($debug = false) {
            foreach(self::$sessionData as $dataName => $dataValue) {
                if( !Server::set_session_data('user', $dataName, $dataValue) ) {
                    return false;
                }
            } return true;
        }

        /*
         * Add a new user to the database with data $data
         */
        public static function add($req, $data) {
            $userField  = $data['user'];
            $emailField = $data['email'];
            $passField  = $data['pass'];
            $passcField = $data['pass-confirm'];
            global $language_config;
            global $config;
            global $lang;

            $username = Str::replace_all_quotes($req[$userField]);
            $usermail = Str::replace_all_quotes($req[$emailField]);

            if(!self::assert_username($username)) {
                self::$errors[$userField] = $language_config[$lang]['register-errors']['username-format'];
                return false;
            }
            if( self::user_exists($username) ) {
                self::$errors[$userField] = $language_config[$lang]['register-errors']['existing-user'];
                return false;
            }
            if( self::email_exists($usermail) ) {
                self::$errors[$emailField] = $language_config[$lang]['register-errors']['existing-email'];
                return false;
            }
            // no error thrown here because the password strength indicator tells what's wrong with the password
            if( !self::assert_password($req[$passField], $passField) ) {
                return false;
            }
            if( !Str::equal($req[$passField], $req[$passcField]) ) {
                self::$errors[$passField] = $language_config[$lang]['register-errors']['passwords-match'];
                // just enough to mark the password confirmation field
                self::$errors[$passcField] = '';
                return false;
            }
            self::$dbInstance->rawQuery("insert into users (username, email, password, image, user_rank, display_name, registration_date) values (?, ?, ?, ?, ?, ?, ?)", [$username, $usermail, password_hash($req[$passField], PASSWORD_BCRYPT), $config['default-image'], 2, Util::random_number(10), Util::get_current_date_and_time(false)], false);
            return true;
        }

        /*
         * Check if a given username already exists in the database
         */
        public static function user_exists($user) {
            $query = '';
            switch(gettype($user)) {
                case "string":
                    $query = 'select id from users where username = ?';
                    break;
                case "integer":
                    $query = 'select username from users where id = ?';
                    break;
            }
            $result = self::$dbInstance->setFetchMode(PDO::FETCH_ASSOC)->rawQuery($query, [$user], true, DB::ALL_ROWS);
            return _Array::size($result) > 0;
        }

        /*
         * Check if a given email already exists in the database
         */
        public static function email_exists($email) {
            $result = self::$dbInstance->setFetchMode(PDO::FETCH_ASSOC)->rawQuery("select id from users where email = ?", [$email], true, DB::ALL_ROWS);
            return _Array::size($result) > 0;
        }

        /*
         * Check if a given email already exists in the database
         */
        public static function email_exists2($email) {
            $result = self::$dbInstance->setFetchMode(PDO::FETCH_ASSOC)->rawQuery("select id from users where email = ?", [$email], true, DB::ALL_ROWS);
            if(_Array::size($result) > 0) {
                if(intval($result[0]['id']) == Server::retrieve_session('user', 'id')) {
                    return false;
                } else {
                    return true;
                }
            }
            return false;
        }

        /*
         * Check if $username is valid
         */
        public static function assert_username($username) {
            return Str::in_range($username, [3, 30]);
        }

        /*
         * Check if $password is valid
         */
        public static function assert_password($password, $passField) {
            global $language_config;
            global $lang;
            if( !Str::in_range($password, [15, 50]) ) {
                self::$errors[$passField] = $language_config[$lang]['register-errors']['password-length'];
                return false;
            }
            if( !Str::contains_upper($password) ) {
                self::$errors[$passField] = $language_config[$lang]['register-errors']['password-upper'];
                return false;
            }
            if( !Str::contains_digit($password) ) {
                self::$errors[$passField] = $language_config[$lang]['register-errors']['password-digit'];
                return false;
            }
            return true;
        }




        



        // GAME RATING
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        /*
         * Check if a $userId has rated (liked or favourited) a $gameID
         */
        public static function has_rated_game($userId, $gameID, $type) {
            switch($type) {
                case 'like':
                    $query = "select id from rated_games where liked_by_user_id=? and game_id=?";
                    break;
                case 'favourite':
                    $query = "select id from rated_games where favourited_by_user_id=? and game_id=?";
                    break;
            }
            $result = self::$dbInstance->setFetchMode(PDO::FETCH_ASSOC)->rawQuery($query, [$userId, $gameID], true, DB::ALL_ROWS);
            return _Array::size($result) > 0;
        }

        /*
         * Like / Favourite a game
         */
        public static function rate_game($userId, $gameID, $type) {
            switch($type) {
                case 'like':
                    $query = "update games set likes=likes+1 where id=?; insert into rated_games (game_id, liked_by_user_id) values (?, ?)";
                    break;
                case 'favourite':
                    $query = "update games set favourited=favourited+1 where id=?; insert into rated_games (game_id, favourited_by_user_id) values (?, ?)";
                    break;
            }
            self::$dbInstance->rawQuery($query, [$gameID, $gameID, $userId], false, false, true);
        }

        /*
         * Remove a like / favourite for a game
         */
        public static function unrate_game($userId, $gameID, $type) {
            switch($type) {
                case 'like':
                    $query = "update games set likes=likes-1 where id=? and likes > 0; delete from rated_games where game_id=? and liked_by_user_id=?";
                    break;
                case 'favourite':
                    $query = "update games set favourited=favourited-1 where id=? and favourited > 0; delete from rated_games where game_id=? and favourited_by_user_id=?";
                    break;
            }
            self::$dbInstance->rawQuery($query, [$gameID, $gameID, $userId], false, false, true);
        }
        // GAME RATING
        /////////////////////////////////////////////////////////////////////////////////////////////////////









        // INCREMENT / DECREMENT LIKES AND FOLLOWINGS
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        /*
         * Increment the game likes or the user with id $userID
         */
        public static function increment_likes($userID) {
            self::$dbInstance->rawQuery("update users set likes=likes+1 where id=?", [$userID], false, false, true);
        }

        /*
         * Decrement the game likes or the user with id $userID
         */
        public static function decrement_likes($userID) {
            self::$dbInstance->rawQuery("update users set likes=likes-1 where id=?", [$userID], false, false, true);
        }

        /*
         * Increment the followings of user $userID
         */
        public static function increment_followings($userID) {
            self::$dbInstance->rawQuery("update users set following=following+1 where id=?", [$userID], false, false, true);
        }

        /*
         * Decrement the followings of user $userID
         */
        public static function decrement_followings($userID) {
            self::$dbInstance->rawQuery("update users set following=following-1 where id=?", [$userID], false, false, true);
        }

        /*
         * Increment the followers of user $userID
         */
        public static function increment_followers($userID) {
            self::$dbInstance->rawQuery("update users set followers=followers+1 where id=?", [$userID], false, false, true);
        }

        /*
         * Decrement the followers of user $userID
         */
        public static function decrement_followers($userID) {
            self::$dbInstance->rawQuery("update users set followers=followers-1 where id=?", [$userID], false, false, true);
        }
        // INCREMENT / DECREMENT LIKES AND FOLLOWINGS
        /////////////////////////////////////////////////////////////////////////////////////////////////////



        




        /*
         * Check if a $userId has liked a $commentID
         */
        public static function has_rated_comment($userId, $commentID) {
            $query = "select id from rated_comments where liked_by_user_id=? and comment_id=?";
            $result = self::$dbInstance->setFetchMode(PDO::FETCH_ASSOC)->rawQuery($query, [$userId, $commentID], true, DB::ALL_ROWS);
            return _Array::size($result) > 0;
        }

        /*
         * Give like to a comment
         */
        public static function rate_comment($userId, $commentID) {
            self::$dbInstance->rawQuery("update comments set comment_likes=comment_likes+1 where comment_id=?; insert into rated_comments (comment_id, liked_by_user_id) values (?, ?)", [$commentID, $commentID, $userId], false, false, true);
        }

        /*
         * Remove a like / favourite for a game
         */
        public static function unrate_comment($userId, $commentID) {
            self::$dbInstance->rawQuery("update comments set comment_likes=comment_likes-1 where comment_id=?; delete from rated_comments where comment_id=? and liked_by_user_id=?", [$commentID, $commentID, $userId], false, false, true);
        }

        /*
         * Post a comment
         */
        public static function post_comment($comment, $commentID, $gameID, $username, $userID, $userImage, $date) {
            // $comment is an array of strings
            foreach($comment as $commentText) {
                self::$dbInstance->rawQuery("insert into comments (comment, item_id, comment_by, comment_by_id, comment_date, comment_id, image) values (?, ?, ?, ?, ?, ?, ?)", [$commentText, $gameID, $username, $userID, $date, $commentID, $userImage], false, false, true);
            }
        }

        /*
         * Increment the comments count in games table
         */
        public static function increment_comments($gameID) {
            self::$dbInstance->rawQuery("update games set comments=comments+1 where id=?", [$gameID], false, false, true);
        }

        /*
         * 
         */
        public static function delete_comment($commentID, $userID) {
            self::$dbInstance->rawQuery("delete from comments where comment_id = ? and comment_by_id = ?; delete from rated_comments where comment_id = ?", [$commentID, $userID, $commentID], false, false, true);
        }

        /*
         * Decrement the comments count in games table
         */
        public static function decrement_comments($gameID) {
            self::$dbInstance->rawQuery("update games set comments = comments-1 where id = ?", [$gameID], false, false, true);
        }

        /*
         * Update the comment
         */
        public static function update_comment($comment, $commentID, $userID, $date) {
            foreach($comment as $commentText) {
                self::$dbInstance->rawQuery("update comments set comment = ?, comment_by_id = ?, comment_date = ? where comment_id = ?", [$commentText, $userID, $date, $commentID], false, false, true);
            }
        }


        



        /*
         * Increment the views count for a $gameID
         */
        public static function update_views($userID, $gameID) {
            self::$dbInstance->rawQuery("update games set views=views+1 where id = ?; insert into viewed_games (game_id, viewed_by_user_id) values (?, ?)", [$gameID, $gameID, $userID], false, false, true);
        }

        /*
         * Check if the user has already viewed the game
         */
        public static function has_viewed_game($userID, $gameID) {
            $query = "select id from viewed_games where viewed_by_user_id=? and game_id=?";
            $result = self::$dbInstance->setFetchMode(PDO::FETCH_ASSOC)->rawQuery($query, [$userID, $gameID], true, DB::ALL_ROWS);
            return _Array::size($result) > 0;
        }



        /*
         * Add the information about the pending upload
         */
        public static function add_pending_upload($filename, $metadata) {
            $name          = utf8_encode(Str::replace_all_quotes($metadata['game-name']));
            $genres        = utf8_encode(Str::replace_all_quotes($metadata['game-genre']));
            $platforms     = utf8_encode(Str::replace_all_quotes($metadata['game-pltf']));
            $developers    = utf8_encode(Str::replace_all_quotes($metadata['game-devs']));
            $publishers    = utf8_encode(Str::replace_all_quotes($metadata['game-publ']));
            $release_dates = utf8_encode(Str::replace_all_quotes($metadata['game-date']));
            $link          = utf8_encode(Str::replace_all_quotes($metadata['game-iso']));
            $platform      = Str::replace_all_quotes($metadata['platform']);

            $cover         = $filename;
            $uploader      = Str::replace_all_quotes(Server::retrieve_session('user', 'display_name'));
            $uploaderID    = intval(Server::retrieve_session('user', 'id'));
            $uploaderImage = Str::replace_all_quotes(Server::retrieve_session('user', 'image'));
            $date          = Util::get_current_date_and_time(true);

            self::$dbInstance->rawQuery("insert into pending_uploads
                                        (name, platform, cover, uploader, uploader_id, link, genres, developers, publishers, release_dates, platforms, date, uploader_image) values
                                        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
                                        [$name, $platform, $cover, $uploader, $uploaderID, $link, $genres, $developers, $publishers, $release_dates, $platforms, $date, $uploaderImage],
                                        false, false, false);
        }

        /*
         * 
         */
        public static function get_last_upload_date($username) {
            $date = self::$dbInstance->setFetchMode(PDO::FETCH_ASSOC)->rawQuery("select max(date) as date from pending_uploads where uploader = ?", [$username], true, DB::ALL_ROWS);
            return $date;
        }

        /*
         * Check if 24 hours have passed since last upload by $username
         */
        public static function expired_upload_time($username) {
            $uploadDate = self::get_last_upload_date($username)[0]['date'];
            return (!is_null($uploadDate) && $uploadDate > 0) ? strtotime(Util::get_current_date_and_time(true)) - strtotime($uploadDate) >= 86400 : true;
        }

        public static function move_game($gameName) {
            self::$dbInstance->setFetchMode(PDO::FETCH_ASSOC)->rawQuery("insert into games (name, platform, cover, uploader, uploader_id, link, genres, developers, publishers, platforms, release_dates, uploader_image) select name, platform, cover, uploader, uploader_id, link, genres, developers, publishers, platforms, release_dates, uploader_image from pending_uploads where name like '".$gameName."%'", false, false, false);
        }

        /*
         * 
         */
        public static function get_most_liked_games() {
            $likes = self::$dbInstance->setFetchMode(PDO::FETCH_ASSOC)->rawQuery("select * from games order by likes desc limit 3", false, true, DB::ALL_ROWS);
            return $likes;
        }





        // DELETION STUFF
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        public static function delete_account($userID) {
            self::$dbInstance->setFetchMode(PDO::FETCH_ASSOC)->rawQuery("delete from users where id = ?", [$userID], false, false);
        }

        public static function delete_uploads($userID) {
            self::$dbInstance->setFetchMode(PDO::FETCH_ASSOC)->rawQuery("delete from games where uploader_id = ?", [$userID], false, false);
        }

        public static function delete_followings($userID) {
            //self::$dbInstance->setFetchMode(PDO::FETCH_ASSOC)->rawQuery("delete from followings where followed_by_id = ?", [$userID], false, false);
        }

        public static function delete_comments($userID) {
            self::$dbInstance->setFetchMode(PDO::FETCH_ASSOC)->rawQuery("delete from comments where comment_by_id = ?", [$userID], false, false);
        }

        public static function delete_rated_games($userID) {
            self::$dbInstance->setFetchMode(PDO::FETCH_ASSOC)->rawQuery("delete from rated_games where liked_by_user_id = ? or favourited_by_user_id = ?", [$userID, $userID], false, false);
        }

        public static function delete_rated_comments($userID) {
            self::$dbInstance->setFetchMode(PDO::FETCH_ASSOC)->rawQuery("delete from rated_comments where liked_by_user_id = ? or favourited_by_user_id = ?", [$userID, $userID], false, false);
        }
        /////////////////////////////////////////////////////////////////////////////////////////////////////






        // DELETION STUFF
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        public static function is_followed_by_user($followedUserID, $followerID) {
            $isFollowed = self::$dbInstance->setFetchMode(PDO::FETCH_ASSOC)->rawQuery("select * from followings where followed_user_id = ? and followed_by_user_id = ?", [$followedUserID, $followerID], true, DB::ALL_ROWS);
            return $isFollowed;
        }

        public static function follow_user($data) {
            self::$dbInstance->setFetchMode(PDO::FETCH_ASSOC)->rawQuery("insert into followings (followed_user_id, followed_username, followed_by_user_id, followed_by_username, follower_image) values (?, ?, ?, ?, ?)", [$data['followed_user_id'], $data['followed_username'], $data['followed_by_user_id'], $data['followed_by_username'], $data['follower_image']], false, false, false);
        }

        public static function unfollow_user($followedUserID, $followerID) {
            self::$dbInstance->setFetchMode(PDO::FETCH_ASSOC)->rawQuery("delete from followings where followed_user_id = ? and followed_by_user_id = ?", [$followedUserID, $followerID], true, DB::ALL_ROWS);
        }

        public static function get_username_by_id($userID) {
            $data = self::$dbInstance->setFetchMode(PDO::FETCH_ASSOC)->rawQuery("select username from users where id = ?", [$userID], true, DB::ALL_ROWS);
            return $data[0]['username'];
        }
        /////////////////////////////////////////////////////////////////////////////////////////////////////

        public static function update_image($newImage, $userID) {
            self::$dbInstance->setFetchMode(PDO::FETCH_ASSOC)->rawQuery("update users set image = ? where id = ?", [$newImage, $userID], false, false, false);
        }
    }
?>