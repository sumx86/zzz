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
        private $file = null;

        // The extension of the file
        private static $fileExtension = '';

        // Upload destination
        private static $destination = '';

        public function __construct($file, $dbInstance) {
            $this->file = $file;
            echo $this->file['name'];
        }

        /*
         * Process the file
         */
        public function process() {
            // check if filename is ok
            // check if file is an image
            // check its size
            // check its dimensions (must have more height than width)
            if(!$this->assert_file_data()) {
                return;
            }
        }

        /*
         * Upload the file
         */
        public function upload() {
            global $language_config;
            global $lang;

            if(move_uploaded_file($this->file['tmp_name'], self::$destination . Crypt::generate_nonce(true, 20) . "." . self::$fileExtension)) {
                //$uploader = Server::retrieve_session('user', 'name');
                $this->db->setFetchMode(FetchModes::$modes['assoc'])
                    ->rawQuery("insert into pending_uploads
                                    (name, platform, cover, uploader, link, genres, developers, publishers, release_dates, platforms) values
                                    (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [], false, false, false);
                return true;
            }
            $this->error = $language_config[$lang]['upload-error'];
            return false;
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
            self::$destination = Server::get_root() . $destination;
        }

        /*
         * Get the upload destination
         */
        public function get_destination() {
            return self::$destination;
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