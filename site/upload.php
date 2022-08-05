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
         * Upload the file
         */
        public function upload() {
            return true;
        }

        /*
         * Set the allowed file types
         */
        public function setAllowedTypes($allowedTypes) {
            $this->allowedTypes = $allowedTypes;
        }

        /*
         * Check if an error occurred
         */
        public function hasErrors() {
            return !Str::is_empty(self::$error);
        }

        /*
         * Get the last error
         */
        public function getLastError() {
            return self::$error;
        }
    }
?>