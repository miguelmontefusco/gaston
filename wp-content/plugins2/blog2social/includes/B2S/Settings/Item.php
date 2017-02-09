<?php

class B2S_Settings_Item {

    private $userSchedTimeData = array();
    private $networkData = array();
    private $settings = array();
    private $lang;
    private $allowPage;
    private $allowGroup;
    private $timeInfo;

    public function __construct() {
        $this->getSettings();
        $this->getSchedDataByUser();
        $this->lang = substr(B2S_LANGUAGE, 0, 2);
        $this->allowPage = unserialize(B2S_PLUGIN_NETWORK_ALLOW_PAGE);
        $this->allowGroup = unserialize(B2S_PLUGIN_NETWORK_ALLOW_GROUP);
        $this->timeInfo = unserialize(B2S_PLUGIN_SCHED_DEFAULT_TIMES_INFO);
    }

    private function getSettings() {
        $result = json_decode(B2S_Api_Post::post(B2S_PLUGIN_API_ENDPOINT, array('action' => 'getSettings', 'token' => B2S_PLUGIN_TOKEN)));
        if (is_object($result) && isset($result->result) && (int) $result->result == 1 && isset($result->portale) && is_array($result->portale)) {
            $this->networkData = $result->portale;
            if (isset($result->settings) && is_object($result->settings)) {
                $this->settings = $result->settings;
            }
        }
    }

    public function getSchedDataByUser() {
        global $wpdb;
        $saveSchedData = $wpdb->get_results($wpdb->prepare("SELECT network_id, network_type, sched_time FROM b2s_post_sched_settings WHERE blog_user_id= %d", B2S_PLUGIN_BLOG_USER_ID));
        if (!empty($saveSchedData)) {
            $this->userSchedTimeData = $saveSchedData;
        }
    }

    private function selectSchedTime($network_id = 0, $network_type = 0) {
        if (!empty($this->userSchedTimeData) && is_array($this->userSchedTimeData)) {
            foreach ($this->userSchedTimeData as $k => $v) {
                if ((int) $network_id == (int) $v->network_id && (int) $network_type == (int) $v->network_type) {
                    $slug = ($this->lang == 'en') ? 'h:i A' : 'H:i';
                    return date($slug, strtotime(date('Y-m-d ' . $v->sched_time . ':00')));
                }
            }
        }
        return null;
    }

    public function getGeneralSettingsHtml() {
        $isChecked = (isset($this->settings->short_url) && (int) $this->settings->short_url == 0) ? 1 : 0;
        $content = '<input type="checkbox" value="' . $isChecked . '" id="b2s-user-network-settings-short-url" ' . (($isChecked == 0) ? 'checked="checked"' : '') . ' /><label for="b2s-user-network-settings-short-url">' . __('use b2s.pm Link Shortner', 'blog2social') . ' <a href="#" data-toggle="modal" data-target="#b2sInfoLinkModal" class="btn btn-link btn-lg del-padding-left"><span class="glyphicon glyphicon-info-sign glyphicon-success"></span></a></label>';
        $content .= '<br>';

        $isCheckedAutoShare = (get_option('B2S_PLUGIN_USER_AUTO_SHARE_' . B2S_PLUGIN_BLOG_USER_ID) !== false && B2S_PLUGIN_USER_VERSION > 0) ? 1 : 0;
        $content .= '<input type="checkbox" data-user-version="' . B2S_PLUGIN_USER_VERSION . '" value="' . $isCheckedAutoShare . '" id="b2s-user-network-settings-auto-share" ' . (($isCheckedAutoShare == 1) ? 'checked="checked"' : '') . ' /><label for="b2s-user-network-settings-auto-share">' . __('save as default Auto-Posting', 'blog2social') . ' <a href="#" data-toggle="modal" data-target="#b2sInfoAutoShareModal" class="btn btn-link btn-lg del-padding-left"><span class="glyphicon glyphicon-info-sign glyphicon-success"></span></a></label>';
        return $content;
    }

    public function getNetworkSettingsHtml() {

        $content = '<h4>' . __('Facebook - Specify the publication format', 'blog2social') . ' <a href="#" data-toggle="modal" data-target="#b2sInfoFBFormatModal" class="btn btn-link btn-lg del-padding-left"><span class="glyphicon glyphicon-info-sign glyphicon-success"></span></a></h4>';
        $content .='<div class="b2s-user-network-settings-post-format-area col-md-12">';
        $content .='<div class="col-md-4 col-xs-12">';
        $content .= '<b>1) '.__('Share with a focus on the link','blog2social').'</b><br><br>';
        $content .= '<label><input type="radio" ' . (((isset($this->settings->network_post_format_1) && (int) $this->settings->network_post_format_1 == 0) || !isset($this->settings->network_post_format_1)) ? 'checked' : '') . ' name="b2s-user-network-settings-post-format-1" class="b2s-user-network-settings-post-format" data-network-id="1" value="0"/><img class="img-responsive b2s-display-inline" src="' . plugins_url('/assets/images/settings/b2s-post-format-1-1-' . (($this->lang == 'de') ? $this->lang : 'en') . '.png', B2S_PLUGIN_FILE) . '">';
        $content .='</label>';
        $content .='</div>';
        $content .='<div class="col-md-4 col-xs-12">';
        $content .= '<b>2) '.__('Share with a focus on the image','blog2social').'</b><br><br>';
        $content .= '<label><input type="radio" ' . ((isset($this->settings->network_post_format_1) && (int) $this->settings->network_post_format_1 == 1) ? 'checked' : '') . ' name="b2s-user-network-settings-post-format-1" class="b2s-user-network-settings-post-format" data-network-id="1" value="1" /><img class="img-responsive b2s-display-inline" src="' . plugins_url('/assets/images/settings/b2s-post-format-1-2-' . (($this->lang == 'de') ? $this->lang : 'en') . '.png', B2S_PLUGIN_FILE) . '">';
        $content .='</label>';
        $content .='</div>';
        $content .='</div>';
        return $content;
    }

    //        $content .="<br>1)Share as Link";

    public function getSchedSettingsHtml() {
        if (!empty($this->networkData)) {
            $content = '<form id = "b2sSaveUserSettingsSchedTime" method = "post">
        <ul class = "list-group b2s-settings-sched-details-container-list">';
            foreach ($this->networkData as $k => $v) {
                $content .= '<li class = "list-group-item">
        <div class = "media">
        <img class = "pull-left hidden-xs b2s-img-network" src = "' . plugins_url('/assets/images/portale/' . $v->id . '_flat.png', B2S_PLUGIN_FILE) . '" alt = "' . $v->name . '">
        <div class = "media-body network">
        <h4><span class = "pull-left">' . ucfirst($v->name) . '</span>
        <div class = "b2s-box-sched-time-area">';

                $content .= '<div class = "col-xs-12">
        <div class = "form-group col-xs-2">
        <label class = "b2s-box-sched-time-area-label">' . __('Profile', 'blog2social') . '</label>
        <input class = "form-control b2s-box-sched-time-input b2s-settings-sched-item-input-time form-control valid" type = "text" value = "' . $this->selectSchedTime($v->id, 0) . '" readonly = "" data-network-id = "' . $v->id . '" data-network-type = "0" name = "b2s[user-sched-time][' . $v->id . '][0]">';
                if (in_array($v->id, $this->allowPage)) {
                    $content .= '<label class = "b2s-box-sched-time-area-label">' . __('Page', 'blog2social') . '</label>
        <input class = "form-control b2s-box-sched-time-input b2s-settings-sched-item-input-time form-control valid" type = "text" value = "' . $this->selectSchedTime($v->id, 1) . '" readonly = "" data-network-id = "' . $v->id . '" data-network-type = "1" name = "b2s[user-sched-time][' . $v->id . '][1]">';
                }
                if (in_array($v->id, $this->allowGroup)) {
                    $content .= '<label class = "b2s-box-sched-time-area-label">' . __('Group', 'blog2social') . '</label>
        <input class = "form-control b2s-box-sched-time-input b2s-settings-sched-item-input-time form-control valid" type = "text" value = "' . $this->selectSchedTime($v->id, 2) . '" readonly = "" data-network-id = "' . $v->id . '" data-network-type = "2" name = "b2s[user-sched-time][' . $v->id . '][2]">';
                }
                $content .= '</div>';

                if (isset($this->timeInfo[$v->id]) && !empty($this->timeInfo[$v->id]) && is_array($this->timeInfo[$v->id])) {
                    $time = '';
                    $slug = ($this->lang == 'de') ? __('Uhr', 'blog2social') : '';
                    foreach ($this->timeInfo[$v->id] as $k => $v) {
                        $time .= B2S_Util::getTimeByLang($v[0], $this->lang) . '-' . B2S_Util::getTimeByLang($v[1], $this->lang) . $slug . ', ';
                    }
                    $content .= '<div class = "form-group col-xs-10 hidden-xs hidden-sm"><div class = "b2s-settings-sched-time-info">' . __('Best times to post', 'blog2social') . ': ' . substr($time, 0, -2) . '</div></div>';
                }
                $content .= '</div>
        </div>
        </h4>
        </div>
        </div>
        </li>';
            }
            $content .= '</ul><div class = "pull-right">';
            if (B2S_PLUGIN_USER_VERSION > 0) {
                $content .= '<button class = "btn btn-success" type = "submit">';
            } else {
                $content .= '<button class = "btn btn-success b2s-save-settings-pro-info" data-title = "' . __('You want to schedule your posts and use the Best Time Scheduler?', 'blog2social') . '" data-toggle = "modal" data-target = "#b2sProFeatureModal">';
            }
            $content .= __('save', 'blog2social') . '</button>';
            $content .= '</div>';
            $content .= '<input id = "action" type = "hidden" value = "b2s_save_user_settings_sched_time" name = "action">';
            $content .= '</form>';
        } else {
            $content = '<div class = "alert alert-info">' . __('Sorry, we can not load your data at the moment...', 'blog2social') . '</div>';
        }
        return $content;
    }

}
