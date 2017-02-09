<?php

class PRG_Ship_Item {

    private $postData;
    private $userData;
    private $postUrl;

    public function __construct($postId) {
        $this->postData = get_post($postId);
        $this->postUrl = (get_permalink($this->postData->ID) !== false ? get_permalink($this->postData->ID) : $this->postData->guid);
    }

    public function getPostData() {
        return $this->postData;
    }

    public function getMandant() {
        global $wpdb;
        $sqlUserData = $wpdb->prepare("SELECT * FROM `b2s_user_contact` WHERE `blog_user_id` = %d", B2S_PLUGIN_BLOG_USER_ID);
        $this->userData = $wpdb->get_row($sqlUserData);
        return $this->userData;
    }

    public function getCountryHtml() {
        $countries = simplexml_load_string(PRG_Api_Get::get(B2S_PLUGIN_PRG_API_ENDPOINT . 'get.php?action=getCountry'));
        $prgKeyName = 'titel_' . substr(B2S_LANGUAGE, 0, 2);
        $content = '';
        foreach ($countries as $val) {
            $content .= '<option value="' . $val->tag . '"';
            if (isset($this->userData->land_presse) && !empty($this->userData->land_presse)) {
                if ($val->tag == $this->userData->land_presse) {
                    $content .= ' selected="selected"';
                }
            } else {
                //default
                if ($val->tag == "US") {
                    $content .= ' selected="selected"';
                }
            }
            $content .= '>' . $val->$prgKeyName . '</option>' . PHP_EOL;
        }
        return $content;
    }

    public function getCategoryHtml() {
        $cats = simplexml_load_string(PRG_Api_Get::get(B2S_PLUGIN_PRG_API_ENDPOINT . 'get.php?action=getCategory'));
        $prgKeyName = 'titel_' . substr(B2S_LANGUAGE, 0, 2);
        $content = '';
        foreach ($cats as $val) {
            $content .= '<option value="' . $val->id . '">' . $val->$prgKeyName . '</option>' . PHP_EOL;
        }
        return $content;
    }

}