<?php
    namespace z_chan;
    
    final class User {
        
        // user data like id, username, etc...
        private $data = [];

        /*
         * Initialize user with data
         */
        public function __construct($data) {
            if( gettype($data) == 'array' ) {
                foreach( $data as $dataName => $dataValue ) {
                    $this->set($dataName, $dataValue);
                }
            }
        }

        /*
         * Getter
         */
        public function get($data = '') {
            return $data ? $this->data[$data] : $this->data;
        }

        /*
         * Setter
         */
        public function set($data, $value) {
            $this->data[$data] = $value;
        }
    }
?>