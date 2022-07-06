<?php
    final class Crypt {
        public static function generate_nonce($base64 = false) {
            $bytes = bin2hex(random_bytes(16));
            return $base64 ? base64_encode($bytes) : $bytes ;
        }
    }
?>