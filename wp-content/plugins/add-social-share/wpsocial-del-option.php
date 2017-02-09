<?php 
function wpssi_delete_options(){
        delete_option('wpsocial-enable-plugin');
        delete_option('wpsocial-enable-post');
        delete_option('wpsocial-enable-page');
        delete_option('wpsocial-enable-home');
        delete_option('wpsocial-message-selection');
        delete_option('wpsocial-positioning');
        delete_option('wpsocial-alignment');
        delete_option('wpsocial-facebook');
        delete_option('wpsocial-twitter');
        delete_option('wpsocial-google');
        delete_option('wpsocial-linkedin');
        delete_option('wpsocial-pinterest');
        delete_option('wpsocial-skins');
}


?>