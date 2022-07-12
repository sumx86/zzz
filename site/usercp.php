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
            
            $result = self::$dbInstance->setFetchMode(PDO::FETCH_ASSOC)->rawQuery("select * from users where username = ?", [$req[$userField]], true, DB::ALL_ROWS);
            if( _Array::size($result) > 0 ) {
                if(password_verify($req[$passField], $result[0]['password'])) {
                    self::setSessionData($result[0]);
                    //var_dump(self::$sessionData);
                    return true;
                }
            }
            self::$errors[$userField] = $language_config[$lang]['login-errors']['wrong-u-p'];
            self::$errors[$passField] = '';
            return false;
        }

        /*
         * Determine if the provided email exists
         */
        public static function validateEmail($req, $data) {
            $emailField = $data['email'];
            global $language_config;
            global $lang;
            
            $result = self::$dbInstance->setFetchMode(PDO::FETCH_ASSOC)->rawQuery("select id from users where email = ?", [$req[$emailField]], true, DB::ALL_ROWS);
            if( _Array::size($result) <= 0 ) {
                self::$errors[$emailField] = $language_config[$lang]['reset-pass-errors']['wrong-e'];
                return false;
            }
            return true;
        }

        /*
         * Prepare the $sessionData variable
         */
        public static function setSessionData($data) {
            foreach($data as $fieldName => $fieldValue) {
                if( $fieldName != 'password' && $fieldName != 'email' ) {
                    self::$sessionData[$fieldName] = $fieldValue;
                }
            }
        }

        /*
         * Create a user session with data $sessionData
         */
        public static function createSession($debug = false) {
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
            global $lang;

            if( self::userExists($req[$userField]) ) {
                self::$errors[$userField] = $language_config[$lang]['register-errors']['existing-user'];
                return false;
            }
            if( self::emailExists($req[$emailField]) ) {
                self::$errors[$emailField] = $language_config[$lang]['register-errors']['existing-email'];
                return false;
            }
            // no error thrown here because the password strength indicator tells what's wrong with the password
            if( !self::assertPassword($req[$passField], $passField) ) {
                return false;
            }
            if( !Str::equal($req[$passField], $req[$passcField]) ) {
                self::$errors[$passField] = $language_config[$lang]['register-errors']['passwords-match'];
                // just enough to mark the password confirmation field
                self::$errors[$passcField] = '';
                return false;
            }
            self::$dbInstance->rawQuery("insert into users (username, email, password) values (?, ?, ?)", [$req[$userField], $req[$emailField], password_hash($req[$passField], PASSWORD_BCRYPT)], false);
            return true;
        }

        /*
         * Check if a given username already exists in the database
         */
        public static function userExists($username) {
            $result = self::$dbInstance->setFetchMode(PDO::FETCH_ASSOC)->rawQuery("select id from users where username = ?", [$username], true, DB::ALL_ROWS);
            return _Array::size($result) > 0;
        }

        /*
         * Check if a given email already exists in the database
         */
        public static function emailExists($email) {
            $result = self::$dbInstance->setFetchMode(PDO::FETCH_ASSOC)->rawQuery("select id from users where email = ?", [$email], true, DB::ALL_ROWS);
            return _Array::size($result) > 0;
        }

        /*
         * Check if $password is valid
         */
        public static function assertPassword($password, $passField) {
            global $language_config;
            global $lang;
            if( !Str::in_range($password, [15, 50]) ) {
                self::$errors[$passField] = $language_config[$lang]['register-errors']['password-length'];
                return false;
            }
            if( !Str::containsUpper($password) ) {
                self::$errors[$passField] = $language_config[$lang]['register-errors']['password-upper'];
                return false;
            }
            if( !Str::containsDigit($password) ) {
                self::$errors[$passField] = $language_config[$lang]['register-errors']['password-digit'];
                return false;
            }
            return true;
        }

        /*
         * Check if a $userId has rated (liked or favourited) a $gameID
         */
        public static function hasRatedGame($userId, $gameID, $type) {
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
        public static function rateGame($userId, $gameID, $type) {
            switch($type) {
                case 'like':
                    $query = "update games set likes=likes+1 where id=?; insert into rated_games (game_id, liked_by_user_id) values (?, ?)";
                    break;
                case 'favourite':
                    $query = "update games set favourited=favourited+1 where id=?; insert into rated_games (game_id, favourited_by_user_id) values (?, ?)";
                    break;
            }
            self::$dbInstance->rawQuery($query, [$gameID, $gameID, $userId], false, false);
        }

        /*
         * Check if a $userId has liked a $commentID
         */
        public static function hasRatedComment($userId, $commentID) {
            $query = "select id from rated_comments where liked_by_user_id=? and comment_id=?";
            $result = self::$dbInstance->setFetchMode(PDO::FETCH_ASSOC)->rawQuery($query, [$userId, $commentID], true, DB::ALL_ROWS);
            return _Array::size($result) > 0;
        }

        /*
         * Give like to a comment
         */
        public static function rateComment($userId, $commentID) {
            self::$dbInstance->rawQuery("update comments set comment_likes=comment_likes+1 where comment_id=?; insert into rated_comments (comment_id, liked_by_user_id) values (?, ?)", [$commentID, $commentID, $userId], false, false);
        }
    }
?>