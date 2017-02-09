<?php 
/*
Plugin Name: Add Social Share
Plugin URI:
Description: Add Social Share Icons on every Post, Page or on Home page with Style on your WordPress site
Author: SuperHero Plugins
Author URI: 
Copyright: 2016 SuperHero Plugins
Version: 3.0
License: GplV2
*/

function wpssi_add_social_icons_post($content) {
$ncontent ='';
 if (get_option('wpsocial-enable-post') == 1 && is_single()) {
   global $post;
   $url = get_permalink($post->ID);
   $url = esc_url($url);
   $ncontent .= '<input id="wpsocial-get-post-id" type="hidden" value="' .$url.'" />';
   $ncontent .= '<div id="wpsocial-social-icons-box" class="wpsocial-social-icons-box" data-selected-skin="'.get_option('wpsocial-skins') .'" style="display: block;width: 100%;background-color: ;" id="wpsocial-live-preview-options-settings"></div>';
   $ncontent .= '<input id="wpsocial-selected-social-network1" name="wpsocial-selcetion-network" type="hidden" value="'.get_option('wpsocial-facebook').'"></input>';
   $ncontent .= '<input id="wpsocial-selected-social-network2" name="wpsocial-selcetion-network" type="hidden" value="'.get_option('wpsocial-twitter').'"></input>';
   $ncontent .= '<input id="wpsocial-selected-social-network3" name="wpsocial-selcetion-network" type="hidden" value="'.get_option('wpsocial-google').'"></input>';
   $ncontent .= '<input id="wpsocial-selected-social-network4" name="wpsocial-selcetion-network" type="hidden" value="'.get_option('wpsocial-linkedin').'"></input>';
   $ncontent .= '<input id="wpsocial-selected-social-network5" name="wpsocial-selcetion-network" type="hidden" value="'.get_option('wpsocial-pinterest').'"></input>';
   $ncontent .= '<input id="wpsocial-selected-skin" type="hidden" value="'. get_option("wpsocial-skins") .'"/>';
   $ncontent .= '<input id="wpsocial-selected-positioning" type="hidden" value="'. get_option("wpsocial-positioning") .'"/>';
   $ncontent .= '<input id="wpsocial-selected-message" type="hidden" value="'. get_option("wpsocial-message-selection") .'"/>';
   $ncontent .= '<input id="wpsocial-selected-custom-message" type="hidden" value="'. get_option("wpsocial-custom-message") .'"/>';
   $ncontent .= '<input id="wpsocial-selected-alignment" type="hidden" value="'. get_option("wpsocial-alignment") .'"/>';
   $ncontent .= '<input id="wpsocial-selected-message-font" type="hidden" value="'. get_option("wpsocial-gfonts") .'"/>';

 }
 if(get_option('wpsocial-positioning') == 'afterpost'){
   return $content =$content . $ncontent;
 }

 if(get_option('wpsocial-positioning') == 'beforepost'){
   return $content = $ncontent .$content;
 }

 if(get_option('wpsocial-positioning') == 'both'){
   //return $content = $ncontent .$content. $ncontent ;
   $latestContent =  $ncontent.=$content.=$ncontent;
   return $latestContent;
 }

 else{
   return $content;
 }


}

if(get_option('wpsocial-enable-post') ==  1 ){
add_filter('the_content', 'wpssi_add_social_icons_post');
}


function wpssi_add_social_icons_page($content) {
$ncontent ='';
 if (get_option('wpsocial-enable-page') == 1 && is_page()) {
   global $post;
   $url = get_permalink($page->ID);
   $url = esc_url($url);
   $ncontent .= '<input id="wpsocial-get-post-id" type="hidden" value="' .$url.'" />';
   $ncontent .= '<div id="wpsocial-social-icons-box" class="wpsocial-social-icons-box" data-selected-skin="'.get_option('wpsocial-skins') .'" style="display: block;width: 100%;background-color: ;" id="wpsocial-live-preview-options-settings"></div>';
   $ncontent .= '<input id="wpsocial-selected-social-network1" name="wpsocial-selcetion-network" type="hidden" value="'.get_option('wpsocial-facebook').'"></input>';
   $ncontent .= '<input id="wpsocial-selected-social-network2" name="wpsocial-selcetion-network" type="hidden" value="'.get_option('wpsocial-twitter').'"></input>';
   $ncontent .= '<input id="wpsocial-selected-social-network3" name="wpsocial-selcetion-network" type="hidden" value="'.get_option('wpsocial-google').'"></input>';
   $ncontent .= '<input id="wpsocial-selected-social-network4" name="wpsocial-selcetion-network" type="hidden" value="'.get_option('wpsocial-linkedin').'"></input>';
   $ncontent .= '<input id="wpsocial-selected-social-network5" name="wpsocial-selcetion-network" type="hidden" value="'.get_option('wpsocial-pinterest').'"></input>';
   $ncontent .= '<input id="wpsocial-selected-skin" type="hidden" value="'. get_option("wpsocial-skins") .'"/>';
   $ncontent .= '<input id="wpsocial-selected-positioning" type="hidden" value="'. get_option("wpsocial-positioning") .'"/>';
   $ncontent .= '<input id="wpsocial-selected-message" type="hidden" value="'. get_option("wpsocial-message-selection") .'"/>';
   $ncontent .= '<input id="wpsocial-selected-custom-message" type="hidden" value="'. get_option("wpsocial-custom-message") .'"/>';
   $ncontent .= '<input id="wpsocial-selected-alignment" type="hidden" value="'. get_option("wpsocial-alignment") .'"/>';
   $ncontent .= '<input id="wpsocial-selected-message-font" type="hidden" value="'. get_option("wpsocial-gfonts") .'"/>';

 }
 if(get_option('wpsocial-positioning') == 'afterpost'){
   return $content =$content . $ncontent;
 }

 if(get_option('wpsocial-positioning') == 'beforepost'){
   return $content = $ncontent .$content;
 }

 if(get_option('wpsocial-positioning') == 'both'){
   return $content = $ncontent .$content. $ncontent ;
   //$latestContent =  $ncontent.=$content.=$ncontent;
   //return $latestContent.get_option('wpsocial-enable-page');
 }

 else{
   return $content;
 }


}

if(get_option('wpsocial-enable-page') ==  1 ){
add_filter('the_content', 'wpssi_add_social_icons_page');
}



function wpssi_add_social_icons_home($content) {
$ncontent ='';
 if (get_option('wpsocial-enable-home') == 1 && is_home() || is_front_page()) {
   global $post;
   $url = get_permalink($post->ID);
   $url = esc_url($url);
   $ncontent .= '<input id="wpsocial-get-post-id" type="hidden" value="' .$url.'" />';
   $ncontent .= '<div id="wpsocial-social-icons-box" class="wpsocial-social-icons-box" data-selected-skin="'.get_option('wpsocial-skins') .'" style="display: block;width: 100%;background-color: ;" id="wpsocial-live-preview-options-settings"></div>';
   $ncontent .= '<input id="wpsocial-selected-social-network1" name="wpsocial-selcetion-network" type="hidden" value="'.get_option('wpsocial-facebook').'"></input>';
   $ncontent .= '<input id="wpsocial-selected-social-network2" name="wpsocial-selcetion-network" type="hidden" value="'.get_option('wpsocial-twitter').'"></input>';
   $ncontent .= '<input id="wpsocial-selected-social-network3" name="wpsocial-selcetion-network" type="hidden" value="'.get_option('wpsocial-google').'"></input>';
   $ncontent .= '<input id="wpsocial-selected-social-network4" name="wpsocial-selcetion-network" type="hidden" value="'.get_option('wpsocial-linkedin').'"></input>';
   $ncontent .= '<input id="wpsocial-selected-social-network5" name="wpsocial-selcetion-network" type="hidden" value="'.get_option('wpsocial-pinterest').'"></input>';
   $ncontent .= '<input id="wpsocial-selected-skin" type="hidden" value="'. get_option("wpsocial-skins") .'"/>';
   $ncontent .= '<input id="wpsocial-selected-positioning" type="hidden" value="'. get_option("wpsocial-positioning") .'"/>';
   $ncontent .= '<input id="wpsocial-selected-message" type="hidden" value="'. get_option("wpsocial-message-selection") .'"/>';
   $ncontent .= '<input id="wpsocial-selected-custom-message" type="hidden" value="'. get_option("wpsocial-custom-message") .'"/>';
   $ncontent .= '<input id="wpsocial-selected-alignment" type="hidden" value="'. get_option("wpsocial-alignment") .'"/>';
   $ncontent .= '<input id="wpsocial-selected-message-font" type="hidden" value="'. get_option("wpsocial-gfonts") .'"/>';
   
 }
 if(get_option('wpsocial-positioning') == 'afterpost'){
   return $content =$content . $ncontent;
 }

 if(get_option('wpsocial-positioning') == 'beforepost'){
   return $content = $ncontent .$content;
 }

 if(get_option('wpsocial-positioning') == 'both'){
   return $content = $ncontent .$content. $ncontent ;
   //$latestContent =  $ncontent.=$content.=$ncontent;
   //return $latestContent.get_option('wpsocial-enable-page');
 }

 else{
   return $content;
 }


}

if(get_option('wpsocial-enable-home') ==  1 ){
add_filter('the_excerpt', 'wpssi_add_social_icons_home');
add_filter('the_content', 'wpssi_add_social_icons_home');
}

register_uninstall_hook( __FILE__, 'wpssi_delete_options' ); 


require('wpsocial-enque-script.php');
require('wpsocial-admin.php');
require('wpsocial-del-option.php');

?>