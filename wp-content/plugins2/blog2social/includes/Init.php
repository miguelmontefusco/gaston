<?php

class B2S_Init {

    public $blogUserData;
    public $lastVersion;

    public function __construct() {
        
    }

    public function init() {
        require_once(B2S_PLUGIN_DIR . 'includes/MetaBox.php');
        require_once(B2S_PLUGIN_DIR . 'includes/Notice.php');
        require_once(B2S_PLUGIN_DIR . 'includes/Tools.php');
        require_once(B2S_PLUGIN_DIR . 'includes/PRG/Api/Post.php');
        require_once(B2S_PLUGIN_DIR . 'includes/PRG/Api/Get.php');
        require_once(B2S_PLUGIN_DIR . 'includes/B2S/Api/Post.php');
        require_once(B2S_PLUGIN_DIR . 'includes/Ajax/Post.php');
        require_once(B2S_PLUGIN_DIR . 'includes/Ajax/Get.php');
        require_once(B2S_PLUGIN_DIR . 'includes/Util.php');
        require_once(B2S_PLUGIN_DIR . 'includes/AutoShare.php');
        require_once(B2S_PLUGIN_DIR . 'includes/B2S/Heartbeat.php');

        $this->lastVersion = get_option('b2s_plugin_version');
        if ($this->lastVersion == false || (int) $this->lastVersion < B2S_PLUGIN_VERSION) {
            $this->activatePlugin();
            update_option('b2s_plugin_version', B2S_PLUGIN_VERSION);
        }

        define('B2S_PLUGIN_POSTPERPAGE', '15');
        define('B2S_PLUGIN_API_ENDPOINT', 'https://developer.blog2social.com/wp/v3/');
        define('B2S_PLUGIN_API_ENDPOINT_AUTH', 'https://developer.blog2social.com/wp/v3/network/auth.php');
        define('B2S_PLUGIN_PRG_API_ENDPOINT', 'http://developer.pr-gateway.de/wp/v3/');
        define('B2S_PLUGIN_SERVER_URL', 'https://developer.blog2social.com');
        define('B2S_PLUGIN_VERSION_TYPE', serialize(array(0 => 'Free', 1 => 'PRO', 2 => 'Business', 3 => 'Premium', 7 => 'PRO', 8 => 'PRO', 9 => 'Business', 10 => 'Premium', 11 => 'Smart')));
        define('B2S_PLUGIN_NETWORK', serialize(array(1 => 'Facebook', 2 => 'Twitter', 3 => 'Linkedin', 4 => 'Tumblr', 5 => 'Storify', 6 => 'Pinterest', 7 => 'Flickr', 8 => 'Xing', 9 => 'Diigo', 10 => 'Google+', 11 => 'Medium', 12 => 'Instagram', 13 => 'Delicious', 14 => 'Torial')));
        define('B2S_PLUGIN_SCHED_DEFAULT_TIMES', serialize(array(1 => array(18, 22), 2 => array(8, 10), 3 => array(8, 10), 4 => array(16, 22), 5 => array(), 6 => array(19, 22), 7 => array(7, 9), 8 => array(7, 10), 9 => array(16, 19), 10 => array(7, 10), 11 => array(16, 19), 12 => array(19, 22), 13 => array(11, 13), 14 => array(18, 22))));
        define('B2S_PLUGIN_SCHED_DEFAULT_TIMES_INFO', serialize(array(1 => array(0 => array(13, 16), 1 => array(18, 22)), 2 => array(0 => array(8, 10), 1 => array(11, 13), 2 => array(16, 19)), 3 => array(0 => array(8, 10), 1 => array(16, 18)), 4 => array(), 5 => array(), 6 => array(0 => array(12, 14), 1 => array(19, 22)), 7 => array(0 => array(7, 9), 1 => array(17, 19)), 8 => array(0 => array(7, 10), 1 => array(17, 18)), 9 => array(0 => array(8, 10), 1 => array(11, 13), 2 => array(16, 19)), 10 => array(0 => array(7, 10), 1 => array(14, 15)), 11 => array(), 12 => array(0 => array(12, 14), 1 => array(19, 22)), 13 => array(0 => array(8, 10), 1 => array(11, 13), 2 => array(16, 19)), 14 => array())));
        define('B2S_PLUGIN_NETWORK_ALLOW_PROFILE', serialize(array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14)));
        define('B2S_PLUGIN_NETWORK_ALLOW_PAGE', serialize(array(1, 3, 8, 10)));
        define('B2S_PLUGIN_NETWORK_ALLOW_GROUP', serialize(array(8, 10)));
        define('B2S_PLUGIN_NETWORK_OAUTH', serialize(array(1, 2, 3, 4, 7, 8, 11)));
        define('B2S_PLUGIN_BLOG_USER_ID', get_current_user_id());
        define('B2S_PLUGIN_ADMIN', current_user_can('administrator'));
        $this->blogUserData = get_userdata(B2S_PLUGIN_BLOG_USER_ID);

        add_action('admin_init', array($this, 'registerAssets'));
        add_action('admin_enqueue_scripts', array($this, 'addBootAssets'));
        add_action('admin_menu', array($this, 'createMenu'));
        add_filter('heartbeat_received', array(B2S_Heartbeat::getInstance(), 'init'), 10, 2);
        add_action('admin_notices', array('B2S_Notice', 'getProVersionNotice'));
        add_action('admin_notices', array($this, 'b2s_save_post_alert_meta_box'));
        add_filter('plugin_action_links_' . B2S_PLUGIN_BASENAME, array($this, 'plugin_activate_sublink'));
        add_action('add_meta_boxes', array($this, 'b2s_init_meta_box'));
        add_action('save_post', array($this, 'b2s_save_meta_box'));

        Ajax_Get::getInstance();
        Ajax_Post::getInstance();
        if ((int) B2S_PLUGIN_BLOG_USER_ID > 0) {
            $this->getToken();
            $this->getUserDetails();
        }
        $this->plugin_init_language();
    }

    public function b2s_init_meta_box() {
        $post_types = get_post_types(array('public' => true));
        if (is_array($post_types) && !empty($post_types)) {
            foreach ($post_types as $post_type) {
                add_meta_box('b2s-post-meta-box', '<span style="padding: 10px 0 10px 25px; background: url(\'' . plugins_url('/assets/images/b2s_icon.png', B2S_PLUGIN_FILE) . '\') no-repeat left center;"></span>' . __('Share on Social Media', 'blog2social'), array($this, 'b2s_view_meta_box'), $post_type, 'side', 'high');
            }
        }
    }

    public function b2s_view_meta_box() {
        wp_enqueue_style('B2SAIRDATEPICKERCSS');
        wp_enqueue_style('B2SMETABOXCSS');
        wp_enqueue_script('B2SAIRDATEPICKERJS');
        wp_enqueue_script('B2SAIRDATEPICKERDEJS');
        wp_enqueue_script('B2SAIRDATEPICKERENJS');
        wp_enqueue_script('B2SMETABOXJS');

        wp_nonce_field("b2s-meta-box-nonce-post-area", "b2s-meta-box-nonce");
        $postId = (isset($_GET['post']) && (int) $_GET['post'] > 0) ? (int) $_GET['post'] : 0;
        $postStatus = ($postId != 0) ? get_post_status($postId) : '';
        $metaBox = new B2S_MetaBox();
        echo $metaBox->getMetaBoxLoadHtml($postId, $postStatus);
    }

    public function b2s_save_meta_box() {
        if (isset($_POST['post_ID']) && isset($_POST['user_ID']) && (int) $_POST['post_ID'] > 0 && (int) $_POST['user_ID'] > 0 && !defined("B2S_SAVE_META_BOX_AUTO_SHARE") && !wp_is_post_autosave($_POST['post_ID']) && isset($_POST['b2s-meta-box-nonce']) && wp_verify_nonce($_POST['b2s-meta-box-nonce'], 'b2s-meta-box-nonce-post-area') && isset($_POST['post_status']) && isset($_POST['b2s-post-meta-box-time-dropdown'])) {
            if (strtolower($_POST['b2s-post-meta-box-time-dropdown']) == 'publish') {
                if (strtolower($_POST['post_status']) == "publish" && isset($_POST['b2s-post-meta-box-profil-dropdown'])) {
                    $profilId = (int) $_POST['b2s-post-meta-box-profil-dropdown'];
                    if (isset($_POST['b2s-post-meta-box-profil-data-' . $profilId]) && !empty($_POST['b2s-post-meta-box-profil-data-' . $profilId])) {
                        $networkData = unserialize(stripslashes($_POST['b2s-post-meta-box-profil-data-' . $profilId]));
                        if ($networkData !== false && is_array($networkData) && !empty($networkData)) {
                            $user_timezone = isset($_POST['b2s-user-timezone']) ? $_POST['b2s-user-timezone'] : 0;
                            $current_user_date = (isset($_POST['b2s-user-publish-date']) && strtotime($_POST['b2s-user-publish-date']) !== false) ? date('Y-m-d H:i:s', strtotime($_POST['b2s-user-publish-date'])) : date('Y-m-d H:i:s', current_time('timestamp'));

                            //WP User Sched Post
                            $post_date = '';
                            if (isset($_POST['post_date']) && !empty($_POST['post_date'])) {
                                $post_date = date('Y-m-d H:i:s', strtotime($_POST['post_date']));
                            }

                            //ShareNow
                            $sched_type = 3;
                            $sched_date = $current_user_date;
                            $sched_date_utc = date('Y-m-d H:i:s', strtotime("-30 seconds", strtotime(B2S_Util::getUTCForDate($sched_date, $user_timezone * (-1)))));
                            $myTimeSettings = false;

                            //allow for User Post Date (Schedule)
                            if (!empty($post_date) && $current_user_date <= $post_date) {
                                $sched_type = 2;

                                if (date('i', strtotime($post_date)) <= 30) {
                                    $sched_date = date('Y-m-d H:30:00', strtotime($post_date));
                                } else {
                                    $sched_date = date('Y-m-d H:00:00', strtotime('+1 hours', strtotime($post_date)));
                                }
                                $sched_date_utc = date('Y-m-d H:i:s', strtotime(B2S_Util::getUTCForDate($sched_date, $user_timezone * (-1))));
                            }

                            //Schedule post once 
                            if (isset($_POST['b2s-post-meta-box-sched-select']) && $_POST['b2s-post-meta-box-sched-select'] == 1) {
                                $user_sched_date = (isset($_POST['b2s-post-meta-box-sched-date']) && strtotime($_POST['b2s-post-meta-box-sched-date']) !== false) ? date('Y-m-d H:i:s', strtotime($_POST['b2s-post-meta-box-sched-date'])) : date('Y-m-d H:i:00', current_time('timestamp'));
                                //Check User Schedule Date in past!
                                if ($user_sched_date >= $sched_date) {
                                    $sched_type = 2;
                                    $sched_date = $user_sched_date;
                                    $sched_date_utc = date('Y-m-d H:i:s', strtotime(B2S_Util::getUTCForDate($sched_date, $user_timezone * (-1))));
                                }
                                //allow for my Time Settings
                                if (isset($_POST['b2s-post-meta-box-best-time-settings'])) {
                                    $myTimeSettings = unserialize(stripslashes($_POST['b2s-post-meta-box-best-time-settings']));
                                    if ($myTimeSettings !== false && is_array($myTimeSettings) && isset($myTimeSettings['times'])) {
                                        $myTimeSettings = $myTimeSettings;
                                    }
                                }
                            }

                            $image_url = wp_get_attachment_url(get_post_thumbnail_id((int) $_POST['post_ID']));
                            $keywords = get_the_tags((int) $_POST['post_ID']);
                            $url = get_permalink($_POST['post_ID']);
                            $title = isset($_POST['post_title']) ? trim(addslashes(strip_tags($_POST['post_title']))) : '';
                            $content = (isset($_POST['content']) && !empty($_POST['content'])) ? trim($_POST['content']) : '';
                            $defaultPostData = array('default_titel' => strip_tags($title),
                                'image_url' => ($image_url !== false) ? trim($image_url) : '',
                                'lang' => trim(strtolower(substr(B2S_LANGUAGE, 0, 2))),
                                'board' => '', 'group' => '', 'url' => $url, 'user_timezone' => $user_timezone); // 'publish_date' => $sched_date, OLD FOR Share Now?

                            $defaultBlogPostData = array('post_id' => (int) $_POST['post_ID'], 'blog_user_id' => (int) $_POST['user_ID'], 'user_timezone' => $user_timezone, 'sched_type' => $sched_type, 'sched_date' => $sched_date, 'sched_date_utc' => $sched_date_utc);
                            $autoShare = new B2S_AutoShare($defaultBlogPostData, $current_user_date, $myTimeSettings, $title, $content, $url, $image_url, $keywords);
                            define('B2S_SAVE_META_BOX_AUTO_SHARE', $_POST['post_ID']);
                            if (isset($_POST['b2s-user-last-selected-profile-id']) && (int) $_POST['b2s-user-last-selected-profile-id'] != (int) $_POST['b2s-post-meta-box-profil-dropdown'] && (int) $_POST['b2s-post-meta-box-profil-dropdown'] != 0) {
                                update_option('B2S_PLUGIN_SAVE_META_BOX_AUTO_SHARE_PROFILE_USER_' . $_POST['user_ID'], (int) $_POST['b2s-post-meta-box-profil-dropdown']);
                            }

                            foreach ($networkData as $k => $value) {
                                if (isset($value->networkAuthId) && (int) $value->networkAuthId > 0 && isset($value->networkId) && (int) $value->networkId > 0 && isset($value->networkType)) {
                                    $res = $autoShare->prepareShareData($value->networkAuthId, $value->networkId, $value->networkType);
                                    if ($res !== false && is_array($res)) {
                                        $res = array_merge($res, $defaultPostData);
                                        $autoShare->saveShareData($res, $value->networkId, $value->networkType, $value->networkAuthId, strip_tags($value->networkUserName));
                                    }
                                }
                            }
                            if ($sched_type != 3) {
                                if (isset($_POST['b2s-user-lang']) && !empty($_POST['b2s-user-lang'])) {
                                    $dateFormat = ($_POST['b2s-user-lang'] == 'de') ? 'd.m.Y' : 'Y-m-d';
                                    $_POST['b2s_update_publish_date'] = date($dateFormat, strtotime($sched_date));
                                }
                            }
                            add_filter('redirect_post_location', array($this, 'b2s_add_param_auto_share_meta_box'));
                        }
                    } else {
                        add_filter('redirect_post_location', array($this, 'b2s_add_param_auto_share_error_data_meta_box'));
                    }
                } else {
                    add_filter('redirect_post_location', array($this, 'b2s_add_param_auto_share_error_meta_box'));
                }
            }
        }
    }

    public function b2s_add_param_auto_share_meta_box($location) {
        remove_filter('redirect_post_location', array($this, 'b2s_add_param_auto_share_meta_box'));
        if (isset($_POST['b2s_update_publish_date'])) {
            return add_query_arg(array('b2s_action' => 1, 'b2s_update_publish_date' => $_POST['b2s_update_publish_date']), $location);
        }
        return add_query_arg(array('b2s_action' => 1), $location);
    }

    public function b2s_add_param_auto_share_error_meta_box($location) {
        remove_filter('redirect_post_location', array($this, 'b2s_add_param_auto_share_error_meta_box'));
        return add_query_arg(array('b2s_action' => 2), $location);
    }

    public function b2s_add_param_auto_share_error_data_meta_box($location) {
        remove_filter('redirect_post_location', array($this, 'b2s_add_param_auto_share_error_data_meta_box'));
        return add_query_arg(array('b2s_action' => 3), $location);
    }

    public function b2s_save_post_alert_meta_box() {
        if (isset($_GET['b2s_action'])) {
            $b2sAction = $_GET['b2s_action'];
            if ((int) $b2sAction == 1) {
                if (isset($_GET['b2s_update_publish_date']) && !empty($_GET['b2s_update_publish_date'])) {
                    echo '<div class="updated"><p>' . __('Now, your post will be shared on social media since', 'blog2social') . ' ' . $_GET['b2s_update_publish_date'] . '</p></div>';
                } else {
                    echo '<div class="updated"><p>' . __('Now, your post will be shared on social media in 2-3 minutes!', 'blog2social') . '</p></div>';
                }
            }
            if ((int) $b2sAction == 2) {
                echo '<div class="error"><p>' . __('Please, make sure that your post are publish on this blog on this moment. Then you can auto post your post with Blog2social.', 'blog2social') . '</p></div>';
            }
            if ((int) $b2sAction == 3) {
                echo '<div class="error"><p>' . __('There are no authorizations for your selected profile. Please, authorize with a social network or select a other profile.', 'blog2social') . '</p></div>';
            }
        }
    }

    public function plugin_init_language() {
        load_plugin_textdomain('blog2social', false, B2S_PLUGIN_LANGUAGE_PATH);
        $this->defineText();
    }

    public function plugin_activate_sublink($links) {
        $added_link = array('<a target="_blank" style="color: rgba(10, 154, 62, 1); font-weight: bold; font-size: 13px;" href="' . __('https://www.blog2social.com/en/pricing/', 'blog2social') . '">' . __('Upgrade to Premium', 'blog2social') . '</a>');
        return array_merge($added_link, $links);
    }

    public function defineText() {
        define('B2S_PLUGIN_NETWORK_TYPE', serialize(array(__('Profile', 'blog2social'), __('Page', 'blog2social'), __('Group', 'blog2social'))));
        define('B2S_PLUGIN_NETWORK_ERROR', serialize(array('DEFAULT' => __('Your post could not be posted.', 'blog2social'),
            'TOKEN' => __('Your authorization has expired. Please check your authorization.', 'blog2social'),
            'CONTENT' => __('The network has marked the post as spam or abusive.', 'blog2social'),
            'RIGHT' => __('We don\'t have the permission to publish your post. Please check your authorization.', 'blog2social'),
            'LOGIN' => __('Your authorization is interrupted. Please check your authorization. Please see <a target="_blank" href="https://www.blog2social.com/en/faq/category/9/troubleshooting-for-error-messages.html">FAQ</a>.', 'blog2social'),
            'LIMIT' => __('Your limit is reached for today.', 'blog2social'),
            'IMAGE' => __('Your post could not be posted, because your image is not available.', 'blog2social'),
            'PROTECT' => __('The network has blocked your account. Please see <a target="_blank" href="https://www.blog2social.com/en/faq/category/9/troubleshooting-for-error-messages.html">FAQ</a>.', 'blog2social'),
            'IMAGE_LIMIT' => __('The number of images is reached. Please see <a target="_blank" href="https://www.blog2social.com/en/faq/category/9/troubleshooting-for-error-messages.html">FAQ</a>.', 'blog2social'))));
    }

    public function getToken() {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT token FROM `b2s_user` WHERE `blog_user_id` = %d", $this->blogUserData->ID);
        $userExist = $wpdb->get_row($sql);
        if (empty($userExist) || !isset($userExist->token)) {
            $postData = array('action' => 'getToken', 'blog_user_id' => $this->blogUserData->ID, 'blog_url' => get_option('home'), 'email' => $this->blogUserData->user_email);
            $result = json_decode(B2S_Tools::getToken($postData));
            if (isset($result->result) && (int) $result->result == 1 && isset($result->token)) {
                $state_url = (isset($result->state_url)) ? (int) $result->state_url : 0;
                $sqlInsertToken = $wpdb->prepare("INSERT INTO `b2s_user` (`token`, `blog_user_id`,`register_date`,`state_url`) VALUES (%s,%d,%s,%d);", $result->token, (int) $this->blogUserData->ID, date('Y-m-d H:i:s'), $state_url);
                $wpdb->query($sqlInsertToken);
                define('B2S_PLUGIN_TOKEN', $result->token);
            } else {
                define('B2S_PLUGIN_ERROR', '1');
            }
        } else {
            define('B2S_PLUGIN_TOKEN', $userExist->token);
        }
    }

    public function getUserDetails() {
        $tokenInfo = get_option('B2S_PLUGIN_USER_VERSION_' . B2S_PLUGIN_BLOG_USER_ID);
        if ($tokenInfo == false || !isset($tokenInfo['B2S_PLUGIN_USER_VERSION']) || $tokenInfo['B2S_PLUGIN_USER_VERSION_NEXT_REQUEST'] < time() || (isset($tokenInfo['B2S_PLUGIN_TRAIL_END']) && strtotime($tokenInfo['B2S_PLUGIN_TRAIL_END']) < strtotime(gmdate('Y-m-d H:i:s')))) {
            B2S_Tools::setUserDetails();
//Cache
            $this->checkUpdate();
        } else {
            define('B2S_PLUGIN_UPATE', '0');
            define('B2S_PLUGIN_USER_VERSION', $tokenInfo['B2S_PLUGIN_USER_VERSION']);
            if (isset($tokenInfo['B2S_PLUGIN_TRAIL_END'])) {
                define('B2S_PLUGIN_TRAIL_END', $tokenInfo['B2S_PLUGIN_TRAIL_END']);
            }
        }
    }

    private function checkUpdate() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, B2S_PLUGIN_API_ENDPOINT . 'update.txt');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 8);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_CAINFO, B2S_PLUGIN_DIR . "/includes/cacert.pem");
        $currentVersion = explode('#', curl_exec($ch));
        $b2sUpdate = (isset($currentVersion[0]) && (int) $currentVersion[0] > (int) B2S_PLUGIN_VERSION) ? 1 : 0;  //1=InfoUpdate
        define('B2S_PLUGIN_UPATE', $b2sUpdate);
    }

    public function createMenu() {
        $subPages = array();
//pageTitle,menutitle,$capability, $menu_slug, $function, $icon_url, $position
        add_menu_page('Blog2Social', 'Blog2Social', 'read', 'blog2social', null, plugins_url('/assets/images/b2s_icon.png', B2S_PLUGIN_FILE));
//$parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function
        $subPages[] = add_submenu_page('blog2social', 'blog2social', __('Dashboard', 'blog2social'), 'read', 'blog2social', array($this, 'b2sstart'));
        $subPages[] = add_submenu_page('blog2social', __('Posts & Sharing', 'blog2social'), __('Posts & Sharing', 'blog2social'), 'read', 'blog2social-post', array($this, 'b2sPost'));
        $subPages[] = add_submenu_page('blog2social', __('Networks', 'blog2social'), __('Networks', 'blog2social'), 'read', 'blog2social-network', array($this, 'b2sNetwork'));
        $subPages[] = add_submenu_page('blog2social', __('Settings', 'blog2social'), __('Settings', 'blog2social'), 'read', 'blog2social-settings', array($this, 'b2sSettings'));
        $subPages[] = add_submenu_page('blog2social', __('PR-Service', 'blog2social'), __('PR-Service', 'blog2social'), 'read', 'prg-post', array($this, 'prgPost'));
        $subPages[] = add_submenu_page(null, 'B2S Post Sched', 'B2S Post Sched', 'read', 'blog2social-sched', array($this, 'b2sPostSched'));
        $subPages[] = add_submenu_page(null, 'B2S Post Publish', 'B2S Post Publish', 'read', 'blog2social-publish', array($this, 'b2sPostPublish'));
        $subPages[] = add_submenu_page(null, 'B2S Ship', 'B2S Ship', 'read', 'blog2social-ship', array($this, 'b2sShip'));
        $subPages[] = add_submenu_page(null, 'PRG Login', 'PRG Login', 'read', 'prg-login', array($this, 'prgLogin'));
        $subPages[] = add_submenu_page(null, 'PRG Ship', 'PRG Ship', 'read', 'prg-ship', array($this, 'prgShip'));
        foreach ($subPages as $var) {
            add_action($var, array($this, 'addAssets'));
        }
    }

//PageFunktion
    public function b2sstart() {
        if (B2S_Tools::showErrorPage() == false) {
            wp_enqueue_style('B2SSTARTCSS');
            wp_enqueue_script('B2SSTARTJS');
            require_once( B2S_PLUGIN_DIR . 'views/b2s/dashboard.php');
        } else {
            require_once( B2S_PLUGIN_DIR . 'views/b2s/error.php');
        }
    }

//PageFunktion
    public function b2sPost() {
        if (B2S_Tools::showErrorPage() == false) {
            wp_enqueue_style('B2SPOSTCSS');
            wp_enqueue_script('B2SPOSTJS');
            require_once( B2S_PLUGIN_DIR . 'views/b2s/post.php');
        } else {
            require_once( B2S_PLUGIN_DIR . 'views/b2s/error.php');
        }
    }

//PageFunktion
    public function b2sNetwork() {
        if (B2S_Tools::showErrorPage() == false) {
            wp_enqueue_style('B2SNETWORKCSS');
            wp_enqueue_script('B2SNETWORKJS');
            require_once( B2S_PLUGIN_DIR . 'views/b2s/network.php');
        } else {
            require_once( B2S_PLUGIN_DIR . 'views/b2s/error.php');
        }
    }

//PageFunktion
    public function b2sSettings() {
        if (B2S_Tools::showErrorPage() == false) {
            wp_enqueue_style('B2SSETTINGSCSS');
            wp_enqueue_script('B2SSETTINGSJS');
            wp_enqueue_style('B2STIMEPICKERCSS');
            wp_enqueue_script('B2STIMEPICKERJS');
            require_once( B2S_PLUGIN_DIR . 'views/b2s/settings.php');
        } else {
            require_once( B2S_PLUGIN_DIR . 'views/b2s/error.php');
        }
    }

//PageFunktion
    public function b2sShip() {
        if (B2S_Tools::showErrorPage() == false) {
            wp_enqueue_style('B2SSHIPCSS');
            wp_enqueue_style('B2SDATEPICKERCSS');
            wp_enqueue_style('B2STIMEPICKERCSS');
            wp_enqueue_style('B2SWYSIWYGCSS');

            wp_enqueue_script('B2SWYSIWYGJS');
            if (substr(B2S_LANGUAGE, 0, 2) == 'de') {
                wp_enqueue_script('B2SWYSIWYGLANGDEJS');
            } else {
                wp_enqueue_script('B2SWYSIWYGLANGENJS');
            }
            wp_enqueue_script('B2SDATEPICKERJS');
            wp_enqueue_script('B2SDATEPICKERDEJS');
            wp_enqueue_script('B2SDATEPICKERENJS');
            wp_enqueue_script('B2STIMEPICKERJS');
            wp_enqueue_script('B2SSHIPJS');
            require_once( B2S_PLUGIN_DIR . 'views/b2s/ship.php');
        } else {
            require_once( B2S_PLUGIN_DIR . 'views/b2s/error.php');
        }
    }

//PageFunktion
    public function prgLogin() {
        if (B2S_Tools::showErrorPage() == false) {
            $prgInfo = get_option('B2S_PLUGIN_PRG_' . B2S_PLUGIN_BLOG_USER_ID);
            if ($prgInfo != false && isset($prgInfo['B2S_PRG_ID']) && (int) $prgInfo['B2S_PRG_ID'] > 0 && isset($prgInfo['B2S_PRG_TOKEN']) && !empty($prgInfo['B2S_PRG_TOKEN'])) {
                $postId = (int) $_GET['postId'];
                echo'<script> window.location="' . admin_url('/admin.php?page=prg-ship&postId=' . $postId, 'http') . '"; </script> ';
//wp_redirect(admin_url('/admin.php?page=prg-ship&postId=' . $postId, 'http'), 301);
                wp_die();
            } else {
                wp_enqueue_style('PRGLOGINCSS');
                wp_enqueue_script('PRGLOGINJS');
                require_once( B2S_PLUGIN_DIR . 'views/prg/login.php');
            }
        } else {
            require_once( B2S_PLUGIN_DIR . 'views/b2s/error.php');
        }
    }

//PageFunktion
    public function prgShip() {
        if (B2S_Tools::showErrorPage() == false) {
            wp_enqueue_style('PRGSHIPCSS');
            wp_enqueue_script('PRGSHIPJS');
            wp_enqueue_script('PRGGENERALJS');
            require_once( B2S_PLUGIN_DIR . 'views/prg/ship.php');
        } else {
            require_once( B2S_PLUGIN_DIR . 'views/b2s/error.php');
        }
    }

//PageFunktion
    public function b2sPostSched() {
        if (B2S_Tools::showErrorPage() == false) {
            wp_enqueue_style('B2SPOSTSCHEDCSS');
            wp_enqueue_style('B2SDATEPICKERCSS');
            wp_enqueue_style('B2STIMEPICKERCSS');
            wp_enqueue_script('B2SDATEPICKERJS');
            wp_enqueue_script('B2SDATEPICKERDEJS');
            wp_enqueue_script('B2SDATEPICKERENJS');
            wp_enqueue_script('B2STIMEPICKERJS');
            wp_enqueue_script('B2SPOSTJS');
            require_once( B2S_PLUGIN_DIR . 'views/b2s/post.sched.php');
        } else {
            require_once( B2S_PLUGIN_DIR . 'views/b2s/error.php');
        }
    }

//PageFunktion
    public function b2sPostPublish() {
        if (B2S_Tools::showErrorPage() == false) {
            wp_enqueue_style('B2SPOSTPUBLISHCSS');
            wp_enqueue_script('B2SPOSTJS');
            wp_enqueue_script('PRGGENERALJS');
            require_once( B2S_PLUGIN_DIR . 'views/b2s/post.publish.php');
        } else {
            require_once( B2S_PLUGIN_DIR . 'views/b2s/error.php');
        }
    }

//PageFunktion
    public function prgPost() {
        if (B2S_Tools::showErrorPage() == false) {
            wp_enqueue_style('PRGPOSTCSS');
            wp_enqueue_script('PRGPOSTJS');
            wp_enqueue_script('PRGGENERALJS');
            require_once( B2S_PLUGIN_DIR . 'views/prg/post.php');
        } else {
            require_once( B2S_PLUGIN_DIR . 'views/b2s/error.php');
        }
    }

    public function addBootAssets() {
        wp_enqueue_script('B2SVALIDATEJS');
    }

    public function addAssets() {
        wp_enqueue_style('B2SBOOTCSS');
        wp_enqueue_script('B2SBOOTJS');
        wp_enqueue_script('B2SGENERALJS');
    }

    public function registerAssets() {
        wp_register_style('B2SBOOTCSS', plugins_url('assets/css/general.css', B2S_PLUGIN_FILE),array(),B2S_PLUGIN_VERSION);
        wp_register_style('B2SSTARTCSS', plugins_url('assets/css/b2s/start.css', B2S_PLUGIN_FILE),array(),B2S_PLUGIN_VERSION);
        wp_register_style('B2SPOSTCSS', plugins_url('assets/css/b2s/post.css', B2S_PLUGIN_FILE),array(),B2S_PLUGIN_VERSION);
        wp_register_style('B2SSHIPCSS', plugins_url('assets/css/b2s/ship.css', B2S_PLUGIN_FILE),array(),B2S_PLUGIN_VERSION);
        wp_register_style('B2SPOSTSCHEDCSS', plugins_url('assets/css/b2s/post.sched.css', B2S_PLUGIN_FILE),array(),B2S_PLUGIN_VERSION);
        wp_register_style('B2SPOSTPUBLISHCSS', plugins_url('assets/css/b2s/post.publish.css', B2S_PLUGIN_FILE),array(),B2S_PLUGIN_VERSION);
        wp_register_style('B2SNETWORKCSS', plugins_url('assets/css/b2s/network.css', B2S_PLUGIN_FILE),array(),B2S_PLUGIN_VERSION);
        wp_register_style('B2SSETTINGSCSS', plugins_url('assets/css/b2s/settings.css', B2S_PLUGIN_FILE),array(),B2S_PLUGIN_VERSION);
        wp_register_style('PRGSHIPCSS', plugins_url('assets/css/prg/ship.css', B2S_PLUGIN_FILE),array(),B2S_PLUGIN_VERSION);
        wp_register_style('PRGLOGINCSS', plugins_url('assets/css/prg/login.css', B2S_PLUGIN_FILE),array(),B2S_PLUGIN_VERSION);
        wp_register_style('B2SDATEPICKERCSS', plugins_url('assets/lib/datepicker/css/bootstrap-datepicker3.min.css', B2S_PLUGIN_FILE),array(),B2S_PLUGIN_VERSION);
        wp_register_style('B2SAIRDATEPICKERCSS', plugins_url('assets/lib/air-datepicker/css/datepicker.css', B2S_PLUGIN_FILE),array(),B2S_PLUGIN_VERSION);
        wp_register_style('B2STIMEPICKERCSS', plugins_url('assets/lib/timepicker/timepicker.css', B2S_PLUGIN_FILE),array(),B2S_PLUGIN_VERSION);
        wp_register_style('PRGPOSTCSS', plugins_url('assets/css/prg/post.css', B2S_PLUGIN_FILE),array(),B2S_PLUGIN_VERSION);
        wp_register_style('B2SWYSIWYGCSS', plugins_url('assets/lib/wysiwyg/square.min.css', B2S_PLUGIN_FILE),array(),B2S_PLUGIN_VERSION);
        wp_register_style('B2SMETABOXCSS', plugins_url('assets/css/b2s/wp/post-meta-box.css', B2S_PLUGIN_FILE),array(),B2S_PLUGIN_VERSION);
        wp_register_style('B2SNOTICECSS', plugins_url('assets/css/notice.css', B2S_PLUGIN_FILE),array(),B2S_PLUGIN_VERSION);

        wp_register_script('B2SNETWORKJS', plugins_url('assets/js/b2s/network.js', B2S_PLUGIN_FILE),array(),B2S_PLUGIN_VERSION);
        wp_register_script('B2SSETTINGSJS', plugins_url('assets/js/b2s/settings.js', B2S_PLUGIN_FILE),array(),B2S_PLUGIN_VERSION);
        wp_register_script('B2SSTARTJS', plugins_url('assets/js/b2s/start.js', B2S_PLUGIN_FILE),array(),B2S_PLUGIN_VERSION);
        wp_register_script('B2SPOSTJS', plugins_url('assets/js/b2s/post.js', B2S_PLUGIN_FILE),array(),B2S_PLUGIN_VERSION);
        wp_register_script('B2SSHIPJS', plugins_url('assets/js/b2s/ship.js', B2S_PLUGIN_FILE),array(),B2S_PLUGIN_VERSION);
        wp_register_script('PRGSHIPJS', plugins_url('assets/js/prg/ship.js', B2S_PLUGIN_FILE),array(),B2S_PLUGIN_VERSION);
        wp_register_script('PRGLOGINJS', plugins_url('assets/js/prg/login.js', B2S_PLUGIN_FILE),array(),B2S_PLUGIN_VERSION);
        wp_register_script('B2SBOOTJS', plugins_url('assets/js/general.js', B2S_PLUGIN_FILE),array(),B2S_PLUGIN_VERSION);
        wp_register_script('B2SVALIDATEJS', plugins_url('assets/js/validate.js', B2S_PLUGIN_FILE),array(),B2S_PLUGIN_VERSION);
        wp_register_script('B2SGENERALJS', plugins_url('assets/js/b2s/general.js', B2S_PLUGIN_FILE),array(),B2S_PLUGIN_VERSION);
        wp_register_script('B2SDATEPICKERJS', plugins_url('assets/lib/datepicker/js/bootstrap-datepicker.min.js', B2S_PLUGIN_FILE),array(),B2S_PLUGIN_VERSION);
        wp_register_script('B2SDATEPICKERDEJS', plugins_url('assets/lib/datepicker/locales/bootstrap-datepicker.de_DE.min.js', B2S_PLUGIN_FILE),array(),B2S_PLUGIN_VERSION);
        wp_register_script('B2SDATEPICKERENJS', plugins_url('assets/lib/datepicker/locales/bootstrap-datepicker.en_US.min.js', B2S_PLUGIN_FILE),array(),B2S_PLUGIN_VERSION);
        wp_register_script('B2SAIRDATEPICKERJS', plugins_url('assets/lib/air-datepicker/js/datepicker.js', B2S_PLUGIN_FILE),array(),B2S_PLUGIN_VERSION);
        wp_register_script('B2SAIRDATEPICKERDEJS', plugins_url('assets/lib/air-datepicker/js/locales/datepicker.de.js', B2S_PLUGIN_FILE),array(),B2S_PLUGIN_VERSION);
        wp_register_script('B2SAIRDATEPICKERENJS', plugins_url('assets/lib/air-datepicker/js/locales/datepicker.en.js', B2S_PLUGIN_FILE),array(),B2S_PLUGIN_VERSION);
        wp_register_script('B2STIMEPICKERJS', plugins_url('assets/lib/timepicker/timepicker.js', B2S_PLUGIN_FILE),array(),B2S_PLUGIN_VERSION);
        wp_register_script('B2SNOTICEJS', plugins_url('assets/js/notice.js', B2S_PLUGIN_FILE),array(),B2S_PLUGIN_VERSION);
        wp_register_script('PRGPOSTJS', plugins_url('assets/js/prg/post.js', B2S_PLUGIN_FILE),array(),B2S_PLUGIN_VERSION);
        wp_register_script('PRGGENERALJS', plugins_url('assets/js/prg/general.js', B2S_PLUGIN_FILE),array(),B2S_PLUGIN_VERSION);
        wp_register_script('B2SWYSIWYGJS', plugins_url('assets/lib/wysiwyg/jquery.sceditor.xhtml.min.js', B2S_PLUGIN_FILE),array(),B2S_PLUGIN_VERSION);
        wp_register_script('B2SWYSIWYGLANGDEJS', plugins_url('assets/lib/wysiwyg/languages/de.js', B2S_PLUGIN_FILE),array(),B2S_PLUGIN_VERSION);
        wp_register_script('B2SWYSIWYGLANGENJS', plugins_url('assets/lib/wysiwyg/languages/en.js', B2S_PLUGIN_FILE),array(),B2S_PLUGIN_VERSION);
        wp_register_script('B2SMETABOXJS', plugins_url('assets/js/b2s/wp/post-meta-box.js', B2S_PLUGIN_FILE),array(),B2S_PLUGIN_VERSION);
    }

    public function activatePlugin() {
        require_once (B2S_PLUGIN_DIR . 'includes/System.php');
        $b2sSystem = new B2S_System();
        $b2sCheck = $b2sSystem->check();
        if (is_array($b2sCheck)) {
            $b2sSystem->deactivatePlugin();
            wp_die($b2sSystem->getErrorMessage($b2sCheck) . ' ' . __('or', 'blog2social') . '  <a href="' . admin_url("/plugins.php", "http") . '/">' . __('back to install plugins', 'blog2social') . '</a>');
        }

        global $wpdb;
//Start Old Plugin
        $sqlDeleteFirst = 'DROP TABLE IF EXISTS `prg_connect_sent`';
        $wpdb->query($sqlDeleteFirst);
        $sqlDeleteSecond = 'DROP TABLE IF EXISTS `prg_connect_config`';
        $wpdb->query($sqlDeleteSecond);
//END Old Plugin
        $sqlCreateUser = "CREATE TABLE IF NOT EXISTS `b2s_user` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `token` varchar(255) NOT NULL,
          `blog_user_id` int(11) NOT NULL,
          `feature` TINYINT(2) NOT NULL,
          `state_url` TINYINT(2) NOT NULL,
          `register_date` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
          PRIMARY KEY (`id`), INDEX `blog_user_id` (`blog_user_id`), INDEX `token` (`token`), INDEX `feature` (`feature`)
          ) ENGINE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci AUTO_INCREMENT=1;";
        $wpdb->query($sqlCreateUser);

        $b2sUserCols = $wpdb->get_results('SHOW COLUMNS FROM b2s_user');
        if (is_array($b2sUserCols) && isset($b2sUserCols[0])) {
            $b2sUserColsData = array();
            foreach ($b2sUserCols as $key => $value) {
                if (isset($value->Field) && !empty($value->Field)) {
                    $b2sUserColsData[] = $value->Field;
                }
            }
            if (!in_array("register_date", $b2sUserColsData)) {
                $wpdb->query("ALTER TABLE b2s_user ADD register_date DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'");
            }
            if (!in_array("state_url", $b2sUserColsData)) {
                $wpdb->query(" ALTER TABLE b2s_user ADD state_url TINYINT(2) NOT NULL DEFAULT '1'");
            }
        }

//feature auf 0 setzen
        $wpdb->query('UPDATE `b2s_user` SET `feature` = 0');

        $keys = $wpdb->get_results('SHOW INDEX FROM `b2s_user`');
        $allowIndexUser = array('PRIMARY', 'blog_user_id', 'token', 'feature');
        foreach ($keys as $k => $value) {
            if (!in_array($value->Key_name, $allowIndexUser)) {
                $wpdb->query('ALTER TABLE `b2s_user` DROP INDEX ' . $value->Key_name);
            }
        }

        $sqlCreateUserPosts = "CREATE TABLE IF NOT EXISTS `b2s_posts` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `post_id` int(11) NOT NULL,
          `blog_user_id` int(11) NOT NULL,
          `user_timezone` TINYINT NOT NULL DEFAULT '0',
          `sched_details_id` INT NOT NULL,
          `sched_type` TINYINT NOT NULL DEFAULT '0',
          `sched_date` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
          `sched_date_utc` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
          `publish_date` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
          `publish_link` varchar(255) NOT NULL,
          `publish_error_code` varchar(100) NOT NULL,
          `network_details_id` int(11) NOT NULL,
          `hook_action` TINYINT NOT NULL DEFAULT '0',
          `hide` TINYINT NOT NULL DEFAULT '0',
          `v2_id` int(11) NOT NULL DEFAULT '0',
            PRIMARY KEY (`id`), INDEX `post_id` (`post_id`), INDEX `blog_user_id` (`blog_user_id`) , INDEX `sched_details_id` (`sched_details_id`),
            INDEX `sched_date` (`sched_date`), INDEX `sched_date_utc` (`sched_date_utc`), INDEX `publish_date` (`publish_date`) ,
            INDEX `hook_action` (`hook_action`), INDEX `hide` (`hide`)
          ) ENGINE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci AUTO_INCREMENT=1 ;";
        $wpdb->query($sqlCreateUserPosts);

        $keys = $wpdb->get_results('SHOW INDEX FROM `b2s_posts`');
        $allowIndexPosts = array('PRIMARY', 'post_id', 'post_id', 'blog_user_id', 'sched_details_id', 'sched_date', 'sched_date_utc' . 'publish_date', 'hook_action', 'hide');
        foreach ($keys as $k => $value) {
            if (!in_array($value->Key_name, $allowIndexPosts)) {
                $wpdb->query('ALTER TABLE `b2s_posts` DROP INDEX ' . $value->Key_name);
            }
        }


        $sqlCreateUserSchedDetails = "CREATE TABLE IF NOT EXISTS `b2s_posts_sched_details` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `sched_data` text NOT NULL COMMENT 'JSON',
            `image_url` varchar(255) NOT NULL ,
            PRIMARY KEY (`id`)
            ) ENGINE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci AUTO_INCREMENT=1 ;";
        $wpdb->query($sqlCreateUserSchedDetails);

        $sqlCreateUserNetworkDetails = "CREATE TABLE IF NOT EXISTS `b2s_posts_network_details` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `network_id` TINYINT NOT NULL,
            `network_type` TINYINT NOT NULL,
            `network_auth_id` int(11) NOT NULL,
            `network_display_name` varchar(100) NOT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci AUTO_INCREMENT=1 ;";
        $wpdb->query($sqlCreateUserNetworkDetails);

        $sqlCreateUserContact = "CREATE TABLE IF NOT EXISTS `b2s_user_contact`(
          `id` int(5) NOT  NULL  AUTO_INCREMENT ,
          `blog_user_id` int(11)  NOT  NULL ,
          `name_mandant` varchar(100)  NOT  NULL ,
          `created` datetime NOT  NULL DEFAULT  '0000-00-00 00:00:00',
          `name_presse` varchar(100)  NOT  NULL ,
          `anrede_presse` enum('0','1','2')  NOT  NULL DEFAULT  '0' COMMENT  '0=Frau,1=Herr 2=keine Angabe',
          `vorname_presse` varchar(50)  NOT  NULL ,
          `nachname_presse` varchar(50)  NOT  NULL ,
          `strasse_presse` varchar(100)  NOT  NULL ,
          `nummer_presse` varchar(5)  NOT  NULL DEFAULT  '',
          `plz_presse` varchar(10)  NOT  NULL ,
          `ort_presse` varchar(75)  NOT  NULL ,
          `land_presse` varchar(3)  NOT  NULL DEFAULT  'DE',
          `email_presse` varchar(75)  NOT  NULL ,
          `telefon_presse` varchar(30)  NOT  NULL ,
          `fax_presse` varchar(30)  NOT  NULL ,
          `url_presse` varchar(150)  NOT  NULL ,
          PRIMARY  KEY (`id`) ,
          KEY `blog_user_id`(`blog_user_id`)) ENGINE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci AUTO_INCREMENT=1";
        $wpdb->query($sqlCreateUserContact);


        $sqlCreatePostSchedSettings = 'CREATE TABLE IF NOT EXISTS `b2s_post_sched_settings` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `blog_user_id` int(11) NOT NULL,
            `network_id` tinyint(4) NOT NULL,
            `network_type` TINYINT NOT NULL,
            `sched_time` varchar(10) NOT NULL,
            PRIMARY KEY (`id`),
            INDEX `blog_user_id` (`blog_user_id`), INDEX `network_id` (`network_id`)
          ) ENGINE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci AUTO_INCREMENT=1;';
        $wpdb->query($sqlCreatePostSchedSettings);


        $sqlCreateNetworkSettings = 'CREATE TABLE IF NOT EXISTS `b2s_user_network_settings` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `blog_user_id` int(11) NOT NULL,
            `mandant_id` int(11) NOT NULL,
            `network_auth_id` int(11) NOT NULL,
            PRIMARY KEY (`id`),
            INDEX `blog_user_id` (`blog_user_id`), INDEX `mandant_id` (`mandant_id`)
          ) ENGINE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci AUTO_INCREMENT=1;';
        $wpdb->query($sqlCreateNetworkSettings);

        if ($this->lastVersion == false || (int) $this->lastVersion < 300) {
            require_once(B2S_PLUGIN_DIR . 'includes/B2S/Migration.php');
            require_once(B2S_PLUGIN_DIR . 'includes/Util.php');
            B2S_Migration::filter();
        }
    }

    public function deactivatePlugin() {
//since V3.0.3
        global $wpdb;
        $sqlDelete = 'DROP TABLE IF EXISTS `b2s_filter`';
        $wpdb->query($sqlDelete);
    }

}
