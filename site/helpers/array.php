<?php
    final class _Array {

        /*
         * A flag for the sizeof($arr, $flag) function
         */
        public const ARRAY_ASSOC = 1;

        /*
         * Return the size of an $array (associative|non-associative)
         */
        public static function size($array) {
            return sizeof($array, self::ARRAY_ASSOC);
        }
        
        /*
         * Initialize an associative array $dest with keys - the keys from the $src array
         * but with empty string values
         */
        public static function init_assoc($src, &$dest) {
            if( sizeof($src, self::ARRAY_ASSOC) > 0 ) {
                foreach( array_values($src) as $value ) {
                    $dest[$value] = '';
                }
            }
        }

        /***/
        public static function assoc_loop() {

        }
    }
?>