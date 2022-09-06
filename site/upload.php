<?php
    final class FileUploadEngine {

        // The last error
        private $error = '';

        // Array containing the allowed file types
        private $allowedTypes = [];

        // Maximum file size allowed
        private $maxSize = 0;

        // Default file size
        private $defaultSize = 100000;

        //
        private $files = null;

        // Upload destination
        private static $destination = '';

        public function __construct($files, $dbInstance) {
            $this->files = $files;
            echo $this->files['file']['tmp_name'];
        }

        /*
         * Process the file
         */
        public function process() {
            // check if file is an image
            // check its size
            // check its dimensions (must have more height than width)
        }

        /*
         * Upload the file
         */
        public function upload() {
            global $language_config;
            global $lang;

            if(!move_uploaded_file($this->files['file']['tmp_name'], self::$destination)) {
                $this->error = $language_config[$lang]['upload-error'];
                return false;
            }
            return true;
        }

        /*
         * Set the maximum file size
         */
        public function set_max_size($bytes) {
            if($bytes > 0) {
                $this->maxSize = $bytes;
            } else {
                $this->maxSize = $this->defaultSize;
            }
        }

        /*
         * Set the upload destination
         */
        public function set_destination($destination) {
            self::$destination = $destination;
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
            return !Str::is_empty($this->error);
        }

        /*
         * Get the last error
         */
        public function get_last_error() {
            return $this->error;
        }
    }
?>