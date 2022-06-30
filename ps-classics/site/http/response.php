<?php
    final class Response {

        // 
        public static $codes = [
            '200' => 'OK',
            '301' => 'Moved Permanently',
            '302' => 'Moved Temporarily',
            '400' => 'Bad Request',
            '403' => 'Forbidden',
            '404' => 'Not Found',
            '500' => 'Internal Server Error'
        ];

        /*
         * Send a header
         */
        public static function include_header($headerName = '', $headerValue = '', $replace = false) {
            $headerString = '';
            if( $headerName ) {
                $headerString .= trim($headerName);
                if( $headerValue ) {
                    $headerString .= ': ';
                }
            }
            $headerString .= $headerValue;
            header($headerString, $replace);
        }
        
        /***/
        public static function throw_json_string($array) {
            echo json_encode($array);
        }

        /*
         * Throw a custom http error
         */
        public static function throw_http_error($code) {
            global $config;
            $version_check = version_compare((defined( PHP_VERSION )) ? PHP_VERSION : phpversion(), '5.4.0') >= 1;
            switch( $version_check ) {
                case True:
                    http_response_code($code);
                    Server::include_file($config['error-doc'][(string) $code]);
                    die();
                    break;
                default:
                    self::include_header( Server::protocol() . ' ' . $code . ' ' . self::$codes[(string) $code]);
                    Server::include_file($config['error-doc'][(string)$code]);
                    die();
                    break;
            }
        }
    }
?>