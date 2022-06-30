<?php
    require_once "config/config.php";
    require_once "crypt.php";
    //require_once "../../chan/site/util.php";
    
    final class Server {

        /*
         * Session lifetime in minutes
         */
        private const session_lifetime = 1;

        /*
         * Get the current url (https or http)
         */
        public static function GetURL(){
            $scheme = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https://' : 'http://' ;
            $url    = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            return $scheme . $url;
        }
        
        /*
         * include_file
         */
        public static function include_file(string $path) {
            $path = self::get_root() . $path;
            if( is_file($path) ) {
                require_once $path;
            }
        }

        /*
         * Set the session data
         * @param string $session_name The name of the session
         * @param string $session_key
         * @param string $value
         */
        public static function set_session_data(string $session_name, $session_key = '', $value = '') {
            if( !$session_name || ctype_space($session_name) ) {
                return false;
            }
            if( !self::session_started() ) {
                @session_start();
            }
            if( !$session_key ) {
                $_SESSION[$session_name] = $value;
            } else {
                $_SESSION[$session_name][$session_key] = $value;
            }
            self::init_with_timestamp($session_name);
            return true;
        }

        /*
         * Set the session creation time
         * @param string $session_name The name of the session
         */
        public static function init_with_timestamp($session_name) {
            if( !self::session_has_key($session_name, 'time') ) {
                $_SESSION[$session_name]['time'] = time();
            }
        }

        /*
         * Check if a session has expired
         * @param string $session_name The name of the session
         */
        public static function is_session_expired($session_name) {
            $session  = self::retrieve_session($session_name);
            $sesstime = $session['time'];
            return time() - $sesstime > (60 * self::session_lifetime);
        }

        /*
         * Retrieve session data
         * @param string $session_name The name of the session
         * @param string $session_key
         */
        public static function retrieve_session(string $session_name, string $session_key = '') {
            if ( !$session_name ) {
                return $_SESSION;
            }
            if ( !self::session_started() ) {
                @session_start();
            }
            return ($session_key) ? $_SESSION[$session_name][$session_key] : $_SESSION[$session_name];
        }

        /*
	     * Destroy the session
	     * @param string $session_name The name of the session to destroy
         */ 
        public static function destroy_session(string $session_name = '') {
            if( !$session_name ) {
                return False;
            }
            if( !self::session_started() ) {
                @session_start();
            }
            if( self::is_active_session($session_name) ) {
                // forces the creation of a new session file
                setcookie(session_name(), "", time() - 3600, session_get_cookie_params()['path']);
                unset($session);
                // destroys the current session file
                @session_destroy();
            }
        }

        /*
	     * Check if a session exists
	     * @param string $session_name The name of the session
         */ 
        public static function is_active_session(string $session_name = '') {
            if( !$session_name ) {
                return False;
            }
            if( !self::session_started() ) {
                @session_start();
            }
            return isset($_SESSION[$session_name]);
        }

        /*
         * Check if a session already exists
         */
        public static function session_started() {
            $cmp = (defined(PHP_VERSION)) ? PHP_VERSION : phpversion();
        
            // values returned by `session_status()`
            $disabled = (defined(PHP_SESSION_DISABLED)) ? PHP_SESSION_DISABLED : 0x00 ;
            $none     = (defined(PHP_SESSION_NONE))     ? PHP_SESSION_NONE     : 0x01 ;
            $active   = (defined(PHP_SESSION_ACTIVE))   ? PHP_SESSION_ACTIVE   : 0x02 ;
            
            if ( version_compare($cmp, '5.4.0') >= 1 ) {
                $status = @session_status();
            } else {
                $status = @session_id();
            }

            switch( gettype($status) ) {
                // session_status()
                case 'string':
                    if( $status == '' ) {
                        return false;
                    }
                    break;
                // session_id()
                case 'integer':
                    if( $status != $active ) {
                        return false;
                    }
                    break;
            }
            return true;
        }

        /*
         * Check if a session has a given key
         */
        public static function session_has_key($session_name, $key) {
            return isset($_SESSION[$session_name][$key]);
        }
        /*
         * Managing sessions [end]
         */
        
        public static function get_request_cookie(string $name, $cmp_values = [], $default_value = null) {
            if( isset($_COOKIE[$name]) ) {
                $cookie = $_COOKIE[$name];
                if( empty($cmp_values) || !$default_value ) {
                    return $cookie;
                }
                foreach( $cmp_values as $val ) {
                    if( trim($_COOKIE[$name]) == $val ) {
                        return $val;
                    }
                }
            }
            return $default_value;
        }

        /*
         * Download a file through http
         */
        public static function download_file(string $path, string $name, string $location) {
            if( file_exists($path) ) {
                header("Cache-Control: public");
                header("Content-Description: File Transfer");
                header("Content-Disposition: attachment; filename=" . $name);
                header("Content-Type: application/zip");
                header("Content-Transfer-Encoding: binary");

                readfile($path);
                header("Location: " . $location);
            }
        }

        public static function request_method(){
            return strtolower($_SERVER['REQUEST_METHOD']);
        }

        public static function protocol(){
            return strtolower($_SERVER['SERVER_PROTOCOL']);
        }

        public static function get_root() {
            return $_SERVER['DOCUMENT_ROOT'];
        }
    }
?>