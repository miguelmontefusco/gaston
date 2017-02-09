<?php

class B2S_System {

    public function __construct() {
        
    }

    public function check() {
        $result = array();
        if (!$this->checkCurl()) {
            $result['curl'] = false;
        }
        return empty($result) ? true : $result;
    }

    private function checkCurl() {
        return function_exists('curl_version');
    }

    public function getErrorMessage($errors, $removeBreakline = false) {
        $output = '';
        if (is_array($errors) && !empty($errors)) {
            foreach ($errors as $error => $status) {
                if ($error == 'curl' && $status == false) {
                    $output .= __('Blog2Social used cURL. cURL is not installed in your PHP installation on your server. Install cURL and activate Blog2Social again.', 'blog2social');
                    $output .= (!$removeBreakline) ? '<br>' : ' ';
                }
            }
            $output .= (!$removeBreakline) ? '<br>' : ' ';
            $output .= __('Please see <a href="https://www.blog2social.com/en/faq/" target="_bank">FAQ</a>', 'blog2social') . '</a>';
        }

        return $output;
    }

    public function deactivatePlugin() {
        deactivate_plugins(B2S_PLUGIN_BASENAME);
    }

}
