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
    }
?>