<?php

class B2S_AutoShare {

    private $title;
    private $contentHtml;
    private $content;
    private $url;
    private $imageUrl;
    private $keywords;
    private $blogPostData = array();
    private $myTimeSettings = array();
    private $current_user_date;
    private $setPreFillText;

    function __construct($blogPostData = array(), $current_user_date = '0000-00-00 00:00:00', $myTimeSettings = false, $title = '', $content = '', $url = '', $imageUrl = '', $keywords = '') {
        $this->blogPostData = $blogPostData;
        $this->current_user_date = $current_user_date;
        $this->myTimeSettings = $myTimeSettings;
        $this->title = $title;
        $this->content = B2S_Util::prepareContent($content, false);
        $this->contentHtml = B2S_Util::prepareContent($content, '<p><h1><h2><br><i><b><a><img>');
        $this->url = $url;
        $this->imageUrl = $imageUrl;
        $this->keywords = $keywords;
        $this->setPreFillText = array(0 => array(1 => 239, 2 => 116, 3 => 239, 6 => 300, 8 => 239, 10 => 442, 12 => 240, 9 => 200), 1 => array(1 => 239, 3 => 239, 8 => 1200, 10 => 442), 2 => array(8 => 239, 10 => 442));
    }

    public function prepareShareData($networkAuthId = 0, $networkId = 0, $networkType = 0) {
        if ((int) $networkId > 0 && (int) $networkAuthId > 0) {
            $postData = array('content' => '', 'custom_title' => '', 'tags' => array(), 'publish_image' => (($this->imageUrl !== false) ? true : false), 'network_auth_id' => (int) $networkAuthId);

            //Special
            if ($networkId == 1 || $networkId == 3) {
                $postData['content'] = (isset($this->setPreFillText[$networkType][$networkId])) ? B2S_Util::getExcerpt($this->content, (int) $this->setPreFillText[$networkType][$networkId]) : $this->content;
            }
            if ($networkId == 2) {
                $postData['content'] = (isset($this->setPreFillText[$networkType][$networkId])) ? B2S_Util::getExcerpt(strip_tags($this->title), (int) $this->setPreFillText[$networkType][$networkId]) : strip_tags($this->title);
            }
            if ($networkId == 4) {
                $postData['custom_title'] = strip_tags($this->title);
                $postData['content'] = $this->contentHtml;
                if (is_array($this->keywords) && !empty($this->keywords)) {
                    foreach ($this->keywords as $tag) {
                        $postData['tags'][] = $tag->name;
                    }
                }
            }

            if ($networkId == 6 || $networkId == 12) {
                if ($this->imageUrl !== false) {
                    $postData['content'] = (isset($this->setPreFillText[$networkType][$networkId])) ? B2S_Util::getExcerpt($this->content, (int) $this->setPreFillText[$networkType][$networkId]) : $this->content;
                    $postData['content'] .= $this->getHashTagsString();
                } else {
                    return false;
                }
            }

            if ($networkId == 7) {
                if ($this->imageUrl !== false) {
                    $postData['custom_title'] = strip_tags($this->title);
                } else {
                    return false;
                }
            }
            if ($networkId == 8) {
                $postData['content'] = (isset($this->setPreFillText[$networkType][$networkId])) ? B2S_Util::getExcerpt($this->content, (int) $this->setPreFillText[$networkType][$networkId]) : $this->content;
                if ($networkType != 0) {
                    $postData['custom_title'] = strip_tags($this->title);
                }
            }
            if ($networkId == 9) {
                $postData['custom_title'] = $this->title;
                $postData['content'] = (isset($this->setPreFillText[$networkType][$networkId])) ? B2S_Util::getExcerpt($this->content, (int) $this->setPreFillText[$networkType][$networkId]) : $this->content;
                if (is_array($this->keywords) && !empty($this->keywords)) {
                    foreach ($this->keywords as $tag) {
                        $postData['tags'][] = $tag->name;
                    }
                }
            }

            if ($networkId == 10) {
                $postData['content'] = (isset($this->setPreFillText[$networkType][$networkId])) ? B2S_Util::getExcerpt($this->content, (int) $this->setPreFillText[$networkType][$networkId]) : $this->content;
                $postData['content'] .= $this->getHashTagsString();
            }

            if ($networkId == 11 || $networkId == 14) {
                $postData['custom_title'] = strip_tags($this->title);
                $postData['content'] = $this->contentHtml;
            }

            if ($networkId == 13) {
                $postData['content'] = strip_tags($this->title);
            }
            return $postData;
        }
        return false;
    }

    private function getHashTagsString($add = "\n\n") {
        $hashTags = '';
        if (is_array($this->keywords) && !empty($this->keywords)) {
            foreach ($this->keywords as $tag) {
                $hashTags .= ' #' . trim($tag->name);
            }
        }
        return (!empty($hashTags) ? (!empty($add) ? $add . $hashTags : $hashTags) : '');
    }

    public function saveShareData($shareData = array(), $network_id = 0, $network_type = 0, $network_auth_id = 0, $network_display_name = '') {

        $sched_type = $this->blogPostData['sched_type'];
        $sched_date = $this->blogPostData['sched_date'];
        $sched_date_utc = $this->blogPostData['sched_date_utc'];

        //Scheduling post once with user times 
        if ($sched_type == 2 && $this->myTimeSettings !== false && is_array($this->myTimeSettings) && isset($this->myTimeSettings['times'])) {
            //Check My Time Setting in Past
            foreach ($this->myTimeSettings['times'] as $k => $v) {
                if ($v->network_id == $network_id && $v->network_type == $network_type) {
                    if (isset($v->sched_time) && !empty($v->sched_time)) {
                        $tempSchedDate = date('Y-m-d', strtotime($sched_date));
                        $networkSchedDate = date('Y-m-d H:i:00', strtotime($tempSchedDate . ' ' . $v->sched_time));
                        if ($networkSchedDate >= $this->current_user_date) {
                            //Scheduling
                            $sched_date = $networkSchedDate;
                            $sched_date_utc = date('Y-m-d H:i:s', strtotime(B2S_Util::getUTCForDate($sched_date, $this->blogPostData['user_timezone'] * (-1))));
                        } else {
                            //Scheduling on next Day by Past
                            $sched_date = date('Y-m-d H:i:s', strtotime('+1 days', strtotime($networkSchedDate)));
                            $sched_date_utc = date('Y-m-d H:i:s', strtotime(B2S_Util::getUTCForDate($sched_date, $this->blogPostData['user_timezone'] * (-1))));
                        }
                    }
                }
            }
        }

        global $wpdb;
        $networkDetailsId = 0;
        $schedDetailsId = 0;
        $networkDetailsIdSelect = $wpdb->get_col($wpdb->prepare("SELECT postNetworkDetails.id FROM b2s_posts_network_details AS postNetworkDetails WHERE postNetworkDetails.network_auth_id = %s", $network_auth_id));
        if (isset($networkDetailsIdSelect[0])) {
            $networkDetailsId = (int) $networkDetailsIdSelect[0];
        } else {
            $wpdb->insert('b2s_posts_network_details', array(
                'network_id' => (int) $network_id,
                'network_type' => (int) $network_type,
                'network_auth_id' => (int) $network_auth_id,
                'network_display_name' => $network_display_name), array('%d', '%d', '%d', '%s'));
            $networkDetailsId = $wpdb->insert_id;
        }
        if ($networkDetailsId > 0) {
            $wpdb->insert('b2s_posts_sched_details', array('sched_data' => serialize($shareData), 'image_url' => (isset($shareData['image_url']) ? $shareData['image_url'] : '')), array('%s', '%s'));
            $schedDetailsId = $wpdb->insert_id;
            $wpdb->insert('b2s_posts', array(
                'post_id' => $this->blogPostData['post_id'],
                'blog_user_id' => $this->blogPostData['blog_user_id'],
                'user_timezone' => $this->blogPostData['user_timezone'],
                'publish_date' => "0000-00-00 00:00:00",
                'sched_details_id' => $schedDetailsId,
                'sched_type' => $sched_type,
                'sched_date' => $sched_date,
                'sched_date_utc' => $sched_date_utc,
                'network_details_id' => $networkDetailsId,
                'hook_action' => 1), array('%d', '%d', '%s', '%s', '%d', '%d', '%s', '%s', '%d', '%d'));
        }
    }

}
