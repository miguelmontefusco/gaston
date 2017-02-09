<?php

/*
 * Plugin Name:Blog2Social: Social Media Schedule&Auto-Post
 * Plugin URI: http://www.blog2social.com
 * Description:Auto-post, crosspost, schedule & share blogposts to profiles, pages and groups on social media: Facebook, Twitter, LinkedIn, Instagram, Pinterest etc.
 * Author: Blog2Social, Adenion
 * Text Domain: blog2social
 * Domain Path: /languages
 * Version: 3.1.3
 * Author URI: http://www.blog2social.com
 * License: GPL2+
 */

//B2SDefine
define('B2S_PLUGIN_VERSION', '313');
define('B2S_PLUGIN_LANGUAGE', serialize(array('de_DE', 'en_US')));
define('B2S_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('B2S_PLUGIN_URL', plugin_dir_url(__FILE__));
define('B2S_PLUGIN_HOOK', basename(dirname(__FILE__)) . '/' . basename(__FILE__));
define('B2S_PLUGIN_FILE', __FILE__);
define('B2S_PLUGIN_LANGUAGE_PATH', dirname(plugin_basename(__FILE__)) . '/languages/');
$language = (!in_array(get_locale(), unserialize(B2S_PLUGIN_LANGUAGE))) ? 'en_US' : get_locale();
define('B2S_LANGUAGE', $language);
define('B2S_PLUGIN_BASENAME', plugin_basename(__FILE__));

//B2SLoad
require_once(B2S_PLUGIN_DIR . 'includes/Init.php');
$b2sInit = new B2S_Init();
register_activation_hook(B2S_PLUGIN_FILE, array($b2sInit, 'activatePlugin'));
register_deactivation_hook(B2S_PLUGIN_FILE, array($b2sInit, 'deactivatePlugin'));
register_uninstall_hook(B2S_PLUGIN_FILE, 'uninstallPlugin');

require_once (B2S_PLUGIN_DIR . 'includes/System.php');
$b2sCheck = new B2S_System();
if ($b2sCheck->check() === true) {
    add_action('init', array($b2sInit, 'init'));
} else {
    require_once(B2S_PLUGIN_DIR . 'includes/Notice.php');
    add_action('admin_notices', array('B2S_Notice', 'sytemNotice'));
}

function uninstallPlugin() {
    require_once (plugin_dir_path(__FILE__) . 'includes/System.php');
    $b2sCheck = new B2S_System();
    if ($b2sCheck->check() === true) {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT token,blog_user_id FROM `b2s_user`");
        $data = $wpdb->get_results($sql, ARRAY_A);
        if (!empty($data) && is_array($data)) {
            require_once (plugin_dir_path(__FILE__) . 'includes/B2S/Api/Post.php');
            B2S_Api_Post::post('https://developer.blog2social.com/wp/v3/', array('action' => 'uninstallPlugin', 'blog_url' => get_option('home'), 'data' => serialize($data)));
        }
    }
    //global $wpdb;
    //update_option('b2s_plugin_version', '0');
    //$wpdb->query('DROP TABLE IF EXISTS `b2s_posts`');
    //$wpdb->query('DROP TABLE IF EXISTS `b2s_user`');
    //$wpdb->query('DROP TABLE IF EXISTS `b2s_filter`');
    //$wpdb->query('DROP TABLE IF EXISTS `b2s_posts_network_details`');
    //$wpdb->query('DROP TABLE IF EXISTS `b2s_posts_sched_details`');
    //$wpdb->query('DROP TABLE IF EXISTS `b2s_user_network_settings`');
    //$wpdb->query('DROP TABLE IF EXISTS `b2s_user_contact`');
}
