<div class="b2s-container">
    <div class="col-xs-12 col-md-offset-4 col-md-4">
        <div class="panel panel-group">
            <div class="panel-body text-center">
                <!--Logo-->
                <a target="_blank" href="http://www.blog2social.com">
                    <img class="img-error img-responsive" src="<?php echo plugins_url('/assets/images/b2s/b2s_logo.png', B2S_PLUGIN_FILE); ?>" alt="blog2social">
                </a>
                <?php if (defined("B2S_PLUGIN_ERROR")) { ?>
                    <h3><?php _e('Connection is broken...', 'blog2social') ?></h3>
                    <br>    
                    <?php _e('Please make sure, that your website address is reachable. Please contact our support!', 'blog2social') ?>
                    <br>
                    <br>
                    <a target="_blank" class="btn btn-link btn-lg" href="https://service.blog2social.com/<?php echo substr(B2S_LANGUAGE, 0, 2); ?>/support?url=<?php echo get_option('home'); ?>"><?php _e('Contact Support', 'blog2social') ?></a>
                    <br>
                <?php } else if (B2S_PLUGIN_UPATE == 1) { ?> 
                    <h3><?php _e('Update...', 'blog2social') ?></h3>
                    <br> 
                    <?php _e('<b> A new version of Blog2Social is available. </b> Update now <br> Blog2Social to continue to use the latest version of the plugin.', 'blog2social') ?>
                    <br>
                    <br>
                    <?php $updateUrl = get_option('home') . ((substr(get_option('home'), -1, 1) == '/') ? '' : '/') . 'wp-admin/plugins.php'; ?>
                    <a class="btn btn-link btn-lg" href="<?php echo $updateUrl; ?>"><?php _e('Update Blog2Social', 'blog2social') ?></a>
                    <br>
                <?php } else { ?>
                    <h3><?php _e('Sorry...', 'blog2social') ?></h3>
                    <br> 
                   <?php _e('<b> An unknown error occurred! </b> <br>  Please contact our support!', 'blog2social') ?>
                    <br>
                    <br>
                    <a target="_blank" class="btn btn-link btn-lg" href="https://service.blog2social.com/<?php echo substr(B2S_LANGUAGE, 0, 2); ?>/support?url=<?php echo get_option('home'); ?>"><?php _e('Contact Support', 'blog2social') ?></a>
                    <br>
                <?php } ?>
                <br>
            </div>
        </div>
    </div>    
</div>




