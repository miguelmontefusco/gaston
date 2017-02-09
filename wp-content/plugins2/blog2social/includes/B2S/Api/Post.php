<?php

class B2S_Api_Post {

    public static function post($url = '', $post = array(), $timeout = false) {
        if (empty($url) || empty($post)) {
            return false;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url . 'post.php');
        curl_setopt($ch, CURLOPT_POST, true);
        if ($timeout) {
            curl_setopt($ch, CURLOPT_TIMEOUT, 12);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_CAINFO, B2S_PLUGIN_DIR . "/includes/cacert.pem");
        $result = curl_exec($ch);
        return $result;
    }

}
