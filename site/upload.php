<?php
    final class FileUploadEngine {
        
        // The last error
        private static $error = '';

        // Array containing the allowed file types
        private $allowedTypes = [];

        public function __construct($files, $dbInstance) {
            var_dump($files);
        }

        /*
         * Process the file
         */
        public function process() {
            
        }

        /*
         * Upload the file
         */
        public function upload() {
            return true;
        }

        /*
         * Set the allowed file types
         */
        public function set_allowed_types($allowedTypes) {
            $this->allowedTypes = $allowedTypes;
        }

        /*
         * Check if an error occurred
         */
        public function has_error() {
            return !Str::is_empty(self::$error);
        }

        /*
         * Get the last error
         */
        public function get_last_error() {
            return self::$error;
        }
    }
?>