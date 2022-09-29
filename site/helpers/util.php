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

        /*
         * Transform the link to a clickable link
         */
        public static function transform_links($string) {
            $output    = [];
            $newstring = '';
            $links     = [];

            if(preg_match_all('/(\[link\])(\S+)(\[\/link\])/', $string, $output)) {
                foreach($output[2] as $link) {
                    $key = "[link]".$link."[/link]";
                    $links[$key] = "<a href='".$link."' target='_blank' style='color: white;'>link</a>";
                    $newstring   = str_replace(array_keys($links), array_values($links), $string);
                }
                return $newstring;
            }
            return $string;
        }

        /*
         * 
         */
        public static function has_path($link) {
            
        }

        public static function get_rank($rank) {
            global $language_config;
            global $lang;

            $rank = intval($rank);
            switch($rank) {
                case 0:
                    return 'VIP';
                case 1:
                    return $language_config[$lang]['rank-moderator'];
                case 2:
                    return $language_config[$lang]['rank-member'];
            }
        }
    }
?>