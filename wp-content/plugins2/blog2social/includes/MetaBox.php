<?php

class B2S_MetaBox {

    private $b2sSiteUrl;

    public function __construct() {
        $this->b2sSiteUrl = get_option('siteurl') . ((substr(get_option('siteurl'), -1, 1) == '/') ? '' : '/');
    }

    public function getMetaBoxLoadHtml($postId = 0, $postStatus = '') {

        $isChecked = "";
        $lastPost = "";
        if (B2S_PLUGIN_USER_VERSION > 0) {
            if ($postId > 0) {
                global $wpdb;
                $lastAutopost = $wpdb->get_results($wpdb->prepare("SELECT sched_date, publish_date FROM b2s_posts WHERE post_id= %d AND blog_user_id= %d AND sched_type = 3 GROUP BY post_id ORDER BY publish_date DESC", $postId, B2S_PLUGIN_BLOG_USER_ID));
                if (!empty($lastAutopost) && isset($lastAutopost[0]) && !empty($lastAutopost[0]->publish_date)) {
                    $date = $lastAutopost[0]->publish_date == '0000-00-00 00:00:00' ? $lastAutopost[0]->sched_date : $lastAutopost[0]->publish_date;
                    $lastPost = '<b>' . __('last auto-post:', 'blog2social') . '</b> ' . B2S_Util::getCustomDateFormat($date, substr(B2S_LANGUAGE, 0, 2)) . '<br>';
                }
            }
            if (get_option('B2S_PLUGIN_USER_AUTO_SHARE_' . B2S_PLUGIN_BLOG_USER_ID) !== false && B2S_PLUGIN_USER_VERSION > 0 && empty($lastPost)) {
                $isChecked = 'checked';
            }
        }

        $selectedProfileID = get_option('B2S_PLUGIN_SAVE_META_BOX_AUTO_SHARE_PROFILE_USER_' . B2S_PLUGIN_BLOG_USER_ID);
        $content = '<div class="b2s-post-meta-box">
                      <input type="hidden" id="b2s-user-last-selected-profile-id" name="b2s-user-last-selected-profile-id" value="' . ($selectedProfileID !== false ? (int) $selectedProfileID : 0) . '" />
                      <input type="hidden" id="b2s-home-url" name="b2s-home-url" value="' . get_option('home') . '"/>
                      <input type="hidden" id="b2sLang" name="b2s-user-lang" value="' . substr(B2S_LANGUAGE, 0, 2) . '">    
                      <input type="hidden" id="b2s-user-timezone" name="b2s-user-timezone" value=""/>
                      <input type="hidden" id="b2s-post-status" name="b2s-post-status" value="' . trim(strtolower($postStatus)) . '"/>
                      <input type="hidden" id="b2s-user-publish-date" name="b2s-user-publish-date" value=""/>
                      <input type="hidden" id="b2s-redirect-url-custom-share" name="b2s-redirect-url-custom-share" value="' . $this->b2sSiteUrl . 'wp-admin/admin.php?page=blog2social-ship&postId=' . $postId . '"/>
                      <div id="b2s-server-connection-fail" class="b2s-info-error"><button class="b2s-btn-close-meta-box b2s-close-icon" data-area-id="b2s-server-connection-fail" title="close notice"></button>' . __('The connection to the server failed. Try again!', 'blog2social') . '</div> 
                      <div id="b2s-heartbeat-fail" class="b2s-info-error"><button class="b2s-btn-close-meta-box b2s-close-icon" data-area-id="b2s-heartbeat-fail" title="close notice"></button>' . __('WordPress uses heartbeats by default, Blog2Social as well. Please enable heartbeats for using Blog2Social!', 'blog2social') . '</div>
                      <div id="b2s-post-meta-box-state-no-auth" class="b2s-info-error"><button class="b2s-btn-close-meta-box b2s-close-icon" data-area-id="b2s-post-meta-box-state-no-auth" title="close notice"></button>' . __('There are no authorizations for your selected profile. Please, authorize with a social network or select a other profile.', 'blog2social') . '<a href="' . $this->b2sSiteUrl . 'wp-admin/admin.php?page=blog2social-network' . '" target="_bank">' . __('Network settings', 'blog2social') . '</a></div>
                      <div id="b2s-post-meta-box-state-no-publish-future" class="b2s-info-error"><button class="b2s-btn-close-meta-box b2s-close-icon" data-area-id="b2s-post-meta-box-state-no-publish-future" title="close notice"></button>' . __('Please, make sure that your post are publish or futured on this blog. Then you can schedule and custom share your post with Blog2social', 'blog2social') . '</div>
                      <div id="b2s-url-valid-warning" class="b2s-info-warning"><button class="b2s-btn-close-meta-box b2s-close-icon" data-area-id="b2s-url-valid-warning" title="close notice"></button>' . __('Notice: Please make sure, that your website address is reachable. The Social Networks do not allow postings from local installations.', 'blog2social') . '</div> 
                      <div id="b2s-post-meta-box-note-trial" class="b2s-info-success"><button class="b2s-btn-close-meta-box b2s-close-icon" data-area-id="b2s-post-meta-box-note-trial" title="close notice"></button><b>' . __('You want to auto post your blog post?', 'blog2social') . '</b><br> <a class="" target="_blank" href="https://service.blog2social.com/">' . __('Upgrade to PREMIUM', 'blog2social') . '</a></div>
                      <h3 class="b2s-meta-box-headline">' . __('Custom Sharing & Scheduling', 'blog2social') . ' <a class="b2s-info-btn" href="#b2sInfoMetaBoxModalSched">' . __('Info', 'blog2social') . '</a></h3>
                      <a id="b2s-meta-box-btn-custom-share" class="b2s-btn b2s-btn-success b2s-btn-sm b2s-center-block b2s-btn-margin-bottom-15" href="#">' . __('Customize & Schedule Social Media Posts', 'blog2social') . '</a>
                      <hr>
                      <input type="hidden" name="b2s-post-meta-box-version" id="b2s-post-meta-box-version" value="' . B2S_PLUGIN_USER_VERSION . '"/>
                      <h3 class="b2s-meta-box-headline">' . __('Social Media Auto-Posting', 'blog2social') . '<span class="b2s-color-green">' . __('(NEW)', 'blog2social') . '</span> <a id="b2s-info-btn-meta-box-modal-auto-post" class="b2s-info-btn" href="#b2sInfoMetaBoxModalAutoPost">' . __('Info', 'blog2social') . '</a></h3>
                      ' . $lastPost . ' 
                      <input id="b2s-post-meta-box-time-dropdown-publish" class="post-format" name="b2s-post-meta-box-time-dropdown" value="publish" type="checkbox" ' . $isChecked . '>
                      <label for="b2s-post-meta-box-time-dropdown-publish" class="post-format-icon">' . __('enable Auto-Posting', 'blog2social') . '</label>
                        
                    <div class="b2s-loading-area" style="display:none">
                        <br>
                        <div class="b2s-loader-impulse b2s-loader-impulse-md"></div>
                        <div class="clearfix"></div>
                        <small>' . __('Loading...', 'blog2social') . '</small>
                       </div>
                    </div>';

        $content .= '<div class="b2s-meta-box-modal" id="b2sInfoMetaBoxModalAutoPost" aria-hidden="true">
                        <div class="b2s-meta-box-modal-dialog">
                            <div class="b2s-meta-box-modal-header">
                                  <a href="#b2s-meta-box-close" class="b2s-meta-box-modal-btn-close" aria-hidden="true">×</a>
                              <h4 class="b2s-meta-box-modal-title">' . __('Blog2Social: Social Media Auto-Posting', 'blog2social') . ' <span class="b2s-color-green">' . __('(NEW)', 'blog2social') . '</span></h4>
                            </div>
                            <div class="b2s-meta-box-modal-body">
                              <p>' . __('Blog2Social automatically shares your blog post on your selected social media networks when your post is published. Your selection will be saved and run automatically until changed.', 'blog2social');
        if (B2S_PLUGIN_USER_VERSION == 0) {
            $content .= '<hr>               
                            <h4 class="b2s-meta-box-modal-h4">' . __('You want to auto-post your blog post?', 'blog2social') . '</h4>
                            ' . __('Upgrade to Blog2Social Premium', 'blog2social') . '
                                <br>
                                <br>
                                - ' . __('Social Media Auto-Posting', 'blog2social') . '<br>
                                - ' . __('Post on pages and groups', 'blog2social') . '<br>
                                - ' . __('Share on multiple accounts per network', 'blog2social') . '<br>
                                - ' . __('Best Time Scheduler: Schedule once, multiple times or recurringly.', 'blog2social') . '<br>
                                - ' . __('Reporting with links to all published social media posts', 'blog2social') . '<br>  
                                <br>
                                <a target="_blank" href="http://service.blog2social.com/" class="b2s-btn b2s-btn-success b2s-center-block b2s-btn-none-underline">' . __('Upgrade to PREMIUM', 'blog2social') . '</a>
                                <br>
                                <center>' . __('or <a href="http://service.blog2social.com/trial" target="_blank">start with free 30-days-trial of Blog2Social Premium</a> (no payment information needed)', 'blog2social') . '</center>';
        }
        $content .= '</p>
                            </div>
                        </div>
                      </div>
                    
                    <div class="b2s-meta-box-modal" id="b2sInfoMetaBoxModalSched" aria-hidden="true">
                        <div class="b2s-meta-box-modal-dialog">
                            <div class="b2s-meta-box-modal-header">
                                  <a href="#b2s-meta-box-close" class="b2s-meta-box-modal-btn-close" aria-hidden="true">×</a>
                              <h4 class="b2s-meta-box-modal-title">' . __('Blog2Social: Custom Sharing & Scheduling', 'blog2social') . '</h4>
                            </div>
                            <div class="b2s-meta-box-modal-body">
                              <p>' . __('Customize and schedule your social media posts on the one page preview for all your selected networks: tailor your posts with individual comments, #hashtags or @handles and schedule your posts for the best times to post, for multiple times or re-share recurrently for more visibility and engagement with your community.', 'blog2social') . '</p>
                            </div>
                        </div>
                    </div>';

        return $content;
    }

    public function getMetaBoxHtml($mandant = array(), $auth = array()) {
        $authContent = '';
        $content = '<br><div class="b2s-meta-box-auto-post-area"><label for="b2s-post-meta-box-profil-dropdown">' . __('Select profile:', 'blog2social') . ' <div style="float:right;"><a href="' . $this->b2sSiteUrl . 'wp-admin/admin.php?page=blog2social-network' . '" target="_blank">' . __('Network settings', 'blog2social') . '</a></div></label>
            <select style="width:100%;" id="b2s-post-meta-box-profil-dropdown" name="b2s-post-meta-box-profil-dropdown">';
        foreach ($mandant as $k => $m) {
            $content .= '<option value="' . $m->id . '">' . $m->name . '</option>';
            $profilData = (isset($auth->{$m->id}) && isset($auth->{$m->id}[0]) && !empty($auth->{$m->id}[0])) ? serialize($auth->{$m->id}) : '';
            $authContent .= "<input type='hidden' id='b2s-post-meta-box-profil-data-" . $m->id . "' name='b2s-post-meta-box-profil-data-" . $m->id . "' value='" . $profilData . "'/>";
        }
        $content .= '</select></div>';
        $content .= $authContent;

        //Opt: Get Best Time Settings
        global $wpdb;
        $bestTimeSettings = '';
        $myBestTimeSettings = $wpdb->get_results($wpdb->prepare("SELECT network_id, network_type, sched_time FROM b2s_post_sched_settings WHERE blog_user_id= %d", B2S_PLUGIN_BLOG_USER_ID));

        $content .='<label>' . __('Schedule your post:', 'blog2social') . '</label>';
        $content .= '<div class="b2s-post-meta-box-sched-area">';

        $content .='<select class="b2s-post-meta-box-sched-select" style="width:100%;" name="b2s-post-meta-box-sched-select">
                        <option value="0">' . __('Share Now', 'blog2social') . '</option>
                        <option value="1">' . __('Schedule post once', 'blog2social') . '</option>
                        </select>';

        $content .='<div class="b2s-post-meta-box-sched-once" style="display:none;">';
        //Opt: CustomDatePicker
        $dateFormat = (substr(B2S_LANGUAGE, 0, 2) == 'de') ? 'dd.mm.yyyy' : 'yyyy-mm-dd';
        $timeFormat = (substr(B2S_LANGUAGE, 0, 2) == 'de') ? 'hh:ii' : 'hh:ii aa';
        $content .='<label class="b2s-font-bold">' . __('Select date:', 'blog2social') . '</label><br><input style="width:100%;" id="b2s-post-meta-box-sched-date-picker" name="b2s-post-meta-box-sched-date" value="" readonly data-timepicker="true" data-language="' . substr(B2S_LANGUAGE, 0, 2) . '" data-time-format="' . $timeFormat . '" data-date-format="' . $dateFormat . '" type="text"><br>';

        //Opt: Best Time Settings
        if (!empty($myBestTimeSettings) && is_array($myBestTimeSettings)) {
            $bestTimeSettings = array('my_times' => 1, 'times' => $myBestTimeSettings);
            $content .="<input id='b2s-post-meta-box-best-time-settings' class='post-format' name='b2s-post-meta-box-best-time-settings' value='" . serialize($bestTimeSettings) . "' type='checkbox'> ";
            $content .="<label class='post-format-icon' for='b2s-post-meta-box-best-time-settings'>" . __('allow for', 'blog2social');
            $content .=' <a href="' . $this->b2sSiteUrl . 'wp-admin/admin.php?page=blog2social-settings' . '" target="_blank">' . __('My Time Settings', 'blog2social') . '</a></label>';
        }
        $content .="</div>";

        $content .='</div>';
        return $content;
    }

}
