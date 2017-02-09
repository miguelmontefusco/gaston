<?php

class B2S_Migration {

    public static function filter() {
        global $wpdb;

        if ($wpdb->get_var("SHOW TABLES LIKE 'b2s_filter'") == 'b2s_filter') {
            $result = $wpdb->get_results('SELECT * FROM b2s_filter');
            $networkTypeData = array('profil' => 0, 'page' => 1, 'group' => 2);
            $networkTypeAllow = array('profil', 'page', 'group');
            $networkNameData = array('facebook' => 1, 'twitter' => 2, 'linkedin' => 3, 'tumblr' => 4, 'storify' => 5, 'pinterest' => 6, 'flickr' => 7, 'xing' => 8, 'diigo' => 9, 'google+' => 10, 'medium' => 11, 'instagram' => 12, 'delicious' => 13, 'torial' => 14);
            $networkNameAllow = array('facebook', 'twitter', 'linkedin', 'tumblr', 'storify', 'pinterest', 'flickr', 'xing', 'diigo', 'google', 'medium', 'instagram', 'delicious', 'torial');


            foreach ($result as $k => $value) {
                $publishData = unserialize(stripslashes($value->publishData));

                if ($publishData != false && is_array($publishData)) {
                    //Publish
                    if ($value->sched_network_date == '0000-00-00 00:00:00' && $value->last_network_publish_date != '0000-00-00 00:00:00') {
                        $whereData = array($value->post_id,
                            $value->blog_user_id,
                            $value->id);
                        $existSql = $wpdb->prepare('SELECT id FROM b2s_posts WHERE post_id = %d AND blog_user_id = %d AND v2_id=%d', $whereData);
                        if ((int) $wpdb->get_var($existSql) == 0) {
                            foreach ($publishData as $k => $v) {
                                $networkDetailsId = 0;
                                $schedDetailsId = 0;
                                if (isset($v['portal_id']) && !empty($v['portal_id']) && isset($v['type']) && in_array($v['type'], $networkTypeAllow)) {
                                    $networkDetails = array(
                                        'network_id' => $v['portal_id'],
                                        'network_type' => $networkTypeData[$v['type']],
                                        'network_auth_id' => 0,
                                        'network_display_name' => ''
                                    );
                                    $wpdb->insert('b2s_posts_network_details', $networkDetails, array('%d', '%d', '%d', '%s'));
                                    $networkDetailsId = $wpdb->insert_id;
                                    $timezone = get_option('gmt_offset');
                                    $b2sPost = array(
                                        'post_id' => $value->post_id,
                                        'blog_user_id' => $value->blog_user_id,
                                        'user_timezone' => $timezone,
                                        'sched_details_id' => $schedDetailsId,
                                        'sched_type' => '0',
                                        'sched_date' => '0000-00-00 00:00:00',
                                        'sched_date_utc' => '0000-00-00 00:00:00',
                                        'publish_date' => $value->last_network_publish_date,
                                        'publish_link' => isset($v['publishUrl']) ? stripslashes($v['publishUrl']) : '',
                                        'publish_error_code' => (!isset($v['error']) || (int) $v['error'] == 0) ? '' : 'DEFAULT',
                                        'network_details_id' => $networkDetailsId,
                                        'hook_action' => '0',
                                        'hide' => '0',
                                        'v2_id' => $value->id);
                                    $wpdb->insert('b2s_posts', $b2sPost, array('%d', '%d', '%d', '%d', '%d', '%s', '%s', '%s', '%s', '%s', '%d', '%d', '%d', '%d'));
                                }
                            }
                        }
                    }

                    //Sched
                    if ($value->sched_network_date != '0000-00-00 00:00:00' && $value->last_network_publish_date == '0000-00-00 00:00:00') {
                        $whereData = array($value->post_id,
                            $value->blog_user_id,
                            $value->id);
                        $existSql = $wpdb->prepare('SELECT id FROM b2s_posts WHERE post_id = %d AND blog_user_id = %d AND v2_id=%d', $whereData);
                        if ((int) $wpdb->get_var($existSql) == 0) {
                            foreach ($publishData as $k => $v) {
                                foreach ($v as $vc => $details) {
                                    foreach ($details as $networkType => $networkName) {
                                        $networkDetailsId = 0;
                                        $schedDetailsId = 0;
                                        $nN = trim(strtolower($networkName));
                                        $nT = trim(strtolower($networkType));
                                        if (in_array($nN, $networkNameAllow) && in_array($nT, $networkTypeAllow)) {
                                            $networkDetails = array(
                                                'network_id' => $networkNameData[$networkName],
                                                'network_type' => $networkTypeData[$networkType],
                                                'network_auth_id' => 0,
                                                'network_display_name' => ''
                                            );
                                            $wpdb->insert('b2s_posts_network_details', $networkDetails, array('%d', '%d', '%d', '%s'));
                                            $networkDetailsId = $wpdb->insert_id;
                                            $timezone = get_option('gmt_offset');

                                            $schedDetails = array('sched_data' => '', 'image_url' => '');
                                            $wpdb->insert('b2s_posts_sched_details', $schedDetails, array('%s', '%s'));
                                            $schedDetailsId = $wpdb->insert_id;

                                            $timeZoneCal = $timezone * (-1);

                                            $b2sPost = array(
                                                'post_id' => $value->post_id,
                                                'blog_user_id' => $value->blog_user_id,
                                                'user_timezone' => $timezone,
                                                'sched_details_id' => $schedDetailsId,
                                                'sched_type' => '1',
                                                'sched_date' => $value->sched_network_date,
                                                'sched_date_utc' => $value->sched_network_date != '0000-00-00 00:00:00' ? B2S_Util::getUTCForDate($value->sched_network_date, $timeZoneCal) : $value->sched_network_date,
                                                'publish_date' => '0000-00-00 00:00:00',
                                                'publish_link' => '',
                                                'publish_error_code' => '',
                                                'network_details_id' => $networkDetailsId,
                                                'hook_action' => '0',
                                                'hide' => '0',
                                                'v2_id' => $value->id);
                                            $wpdb->insert('b2s_posts', $b2sPost, array('%d', '%d', '%d', '%d', '%d', '%s', '%s', '%s', '%s', '%s', '%d', '%d', '%d', '%d'));
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

}
