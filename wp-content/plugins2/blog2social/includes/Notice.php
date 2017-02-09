<?php

class B2S_Notice {

    public static function getProVersionNotice() {

        global $hook_suffix;
        if (in_array($hook_suffix, array('index.php', 'plugins.php'))) {
            if (B2S_PLUGIN_USER_VERSION == 0) {
                global $wpdb;
                $userResult = $wpdb->get_row($wpdb->prepare('SELECT feature,register_date FROM b2s_user WHERE blog_user_id =%d', B2S_PLUGIN_BLOG_USER_ID));
                if ($userResult->register_date == '0000-00-00 00:00:00') {
                    $wpdb->update('b2s_user', array('register_date' => date('Y-m-d H:i:s')), array('blog_user_id' => B2S_PLUGIN_BLOG_USER_ID), array('%s'), array('%d'));
                } else if ($userResult->feature == 0 && strtotime($userResult->register_date) < strtotime('-6 days')) {
                    wp_enqueue_style('B2SNOTICECSS');
                    wp_enqueue_script('B2SNOTICEJS');
                    echo '<div class="updated b2s-notice-rate">
                            <p>' . __('<strong>Rate it!</strong> If you like Blog2Social, please give us a 5 star rating. I there is anything that does not work for you, please contact us!', 'blog2social') . ' 
                                    <b><a href="https://wordpress.org/plugins/blog2social/" target="_bank">' . __('RATE BLOG2SOCIAL', 'blog2social') . '</a></b> 
                                    <small><a href="#" class="b2s-hide-notice-area" data-area-class="b2s-notice-rate">(' . __('hide', 'blog2social') . ')</a></small>  
                            </p>  
                         </div>';
                    echo '<div class="notice b2s-notice-premium">
                            <button class="b2s-hide-notice-area close_icon notice-dismiss" data-area-class="b2s-notice-premium" title="close notice"></button>
                            <div class="b2s-icon">
                                 <img class="b2s-img" src="' . plugins_url('/assets/images/b2s/premium.png', B2S_PLUGIN_FILE) . '" alt="b2s premium"> 
                            </div>
                            <div class="b2s-text">
                            <h2>' . __('Upgrade to Blog2Social Premium', 'blog2social') . '</h2>
                                <span>- ' . __('Social Media Auto-Posting', 'blog2social') . '</span>
                                <br><span>- ' . __('Post on pages and groups', 'blog2social') . '</span>
                                <br><span>- ' . __('Share on multiple accounts per network', 'blog2social') . '</span>
                                <br><span>- ' . __('Best Time Scheduler: Schedule once, multiple times or recurringly.', 'blog2social') . '</span>
                                <br><span>- ' . __('Reporting with links to all published social media posts', 'blog2social') . '</span>
                            </div>
                            <div><a class="b2s-btn-premium" target="_blank" href="https://www.blog2social.com">' . __('Upgrade to Blog2Social Premium', 'blog2social') . '</a></div>
                         </div>';
                }
            }
        }
    }

    public static function getBlogEntries($lang = 'en') {
        return json_decode(B2S_Api_Post::post(B2S_PLUGIN_API_ENDPOINT, array('action' => 'getBlogEntries', 'lang' => $lang, 'token' => B2S_PLUGIN_TOKEN)));
    }

    public static function getFaqEntriesHtml($items = '') {
        $content = '';
        if (!empty($items)) {
            $content.='<h5 class="b2s-dashboard-h4">' . __('Top 5 FAQ', 'blog2social') . '</h5>';
            $content.='<ul>';
            $content.=$items;
            $content.='</ul>';
        }
        return $content;
    }

    public static function sytemNotice() {
        $b2sSytem = new B2S_System();
        $b2sCheck = $b2sSytem->check();
        if (is_array($b2sCheck) && !empty($b2sCheck)) {
            $output = '<div id="message" class="notice inline notice-warning notice-alt"><p>';
            $output .= $b2sSytem->getErrorMessage($b2sCheck, true);
            $output .= '</p></div>';
            echo $output;
        }
    }

}
