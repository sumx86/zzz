<?php
    final class Util {
        /*
         * Check if the day is a valid one
         */
        public static function is_valid_day($day) {
            $day = intval($day);
            return $day >= 1 && $day <= 31;
        }

        /*
         * Check if the year is a valid one
         */
        public static function is_valid_year($year) {
            $year = intval($year);
            return $year > 1980 && $year <= intval(date("Y"));
        }

        /*
        * Check if the year is a valid one
        */
        public static function is_valid_month($month) {
            return in_array($month, ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']);
        }

        /*
         * Check if the date string is a valid one
         */
        public static function is_valid_date($string) {
            $array = @explode(' ', $string);
            if(_Array::size($array) != 3) {
                return false;
            }
            $month = $array[0];
            $day   = $array[1];
            $year  = $array[2];
            if(!self::is_valid_month($month)) {
                return false;
            }
            if(!self::is_valid_day($day)) {
                return false;
            }
            if(!self::is_valid_year($year)) {
                return false;
            }
            return true;
        }

        public static function get_current_date_and_time($includeTime) {
            date_default_timezone_set('Europe/Sofia');
            $date = $includeTime ? 'm/d/Y H:i:s' : 'm/d/Y';
            return date($date);
        }

        /*
         * Taken from stackoverflow
         */
        public static function emoji_to_unicode($emoji) {
            $emoji   = mb_convert_encoding($emoji, 'UTF-32', 'UTF-8');
            $unicode = strtolower(preg_replace("/^[0]+/", "U+", bin2hex($emoji)));
            return $unicode;
        }
    }
?>