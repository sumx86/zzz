<?php
    final class Request {
        
        /*
         * The body of the request
         */
        private $body = null;

        /*
         * An associative array containing the request headers
         */
        private $headers;

        /*
         * An associative array containing the request cookies
         */
        private $cookies;

        public function __construct() {}

        /*
         * Get the body of the request
         */
        public function get_body() {
            if($this->isJson()) {
                $this->body = json_decode($_REQUEST, true);
            } else {
                $this->body = $_REQUEST;
            }
        }

        /*
         * Get a value from the body
         */
        public function get($key) {
            if( !$this->body ) {
                $this->get_body();
            }
            if( isset($this->body[$key]) ) {
                return $this->body[$key];
            }
        }

        /*
         * Parse the request headers into $this->headers
         */
        private function parse_headers() {
            $headers = getallheaders();
            foreach( $headers as $headerName => $headerValue ) {
                $this->headers[$headerName] = $headerValue;
            }
        }

        /*
         * Get the request headers
         */
        public function get_headers() {
            if( empty($this->headers) ) {
                $this->parse_headers();  
            }
            return $this->headers;
        }

        /*
         * Check if the body is json encoded
         */
        public function isJson() {
            if(empty($this->headers)) {
                $this->parse_headers();
            }
            return Str::contains($this->headers['Content-Type'], 'json'); #content-type: application/json
        }
    }
?>