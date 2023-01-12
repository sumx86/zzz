<?php
    final class FileUploadEngine {

        // The last error
        private $error = '';

        // Array containing the allowed file types
        private $allowedTypes = [];

        // Array containing the allowed file extensions
        private $allowedExtensions = [];

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

        private static $filename = '';

        public function __construct($file, $dbInstance) {
            $this->file = $file;
        }

        /*
         * Process the file
         */
        public function process() {
            global $language_config;
            global $lang;
            
            $filenameData = @explode(".", $this->file['name']);
            self::$fileExtension = end($filenameData);

            if(count($filenameData) != 2 || !Str::is_in(self::$fileExtension, $this->allowedExtensions)) {
                $this->error = $language_config[$lang]['file-name-error'];
                return;
            }
            if(!$this->is_allowed_type()) {
                $this->error = $language_config[$lang]['file-type-error'];
                return;
            }
            if(filesize($this->file['tmp_name']) > $this->maxSize) {
                $this->error = sprintf($language_config[$lang]['file-size-error'], $this->maxSize);
                return;
            }
            // check its dimensions (must have more height than width)
        }

        /*
         * Upload the file
         */
        public function upload() {
            global $language_config;
            global $lang;

            if(move_uploaded_file($this->file['tmp_name'], $this->generate_new_filename(20))) {
                return true;
            }
            $this->error = $language_config[$lang]['upload-error'];
            return false;
        }

        /*
         * Check if file is allowed type
         */
        public function is_allowed_type() {
            foreach($this->allowedTypes as $type) {
                if(Str::equal($this->file['type'], $type) && $this->is_type($this->file, $type)) {
                    return true;
                }
            } return false;
        }

        /*
         * Check if the file type is same as in $type
         */
        public function is_type($file, $type) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime  = finfo_file($finfo, $file['tmp_name']);

            $is_type = false;
            if(Str::equal($mime, $type)) {
                $is_type = true;
            }
            finfo_close($finfo);
            return $is_type;
        }

        /*
         * Generate the new file name
         */
        public static function generate_new_filename($length) {
            self::$filename = self::$destination . Crypt::generate_nonce(true, $length) . "." . self::$fileExtension;
            return self::$filename;
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
            foreach($allowedTypes as $type) {
                array_push($this->allowedExtensions, @explode("/", $type)[1]);
            }
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
        
        /*
         * Get the name of the uploaded file
         */
        public function get_uploaded_filename() {
            return self::$filename;
        }
    }
?>