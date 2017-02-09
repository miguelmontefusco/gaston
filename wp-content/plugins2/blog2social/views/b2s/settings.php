<?php
require_once B2S_PLUGIN_DIR . 'includes/B2S/Settings/Item.php';
$settingsItem = new B2S_Settings_Item();
?>

<div class="b2s-container">
    <?php require_once (B2S_PLUGIN_DIR . 'views/b2s/html/header.phtml'); ?>
    <div class=" b2s-inbox col-md-12 del-padding-left">
        <div class="col-md-9 del-padding-left">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="grid b2s-post"></div>
                        <div class="row b2s-loading-area width-100" style="display: none;">
                            <div class="b2s-loader-impulse b2s-loader-impulse-md"></div>
                             <div class="text-center b2s-loader-text"><?php _e("save...", "blog2social"); ?></div>
                        </div>
                        <div class="row b2s-user-settings-area">
                            <ul  class="nav nav-pills">
                                <li>
                                    <a href="#b2s-general" data-toggle="tab"><?php _e('General', 'blog2social') ?></a>
                                </li>
                                <li class="active">
                                    <a href="#b2s-best-time-manager" data-toggle="tab"><?php _e('Best Time Settings', 'blog2social') ?></a>
                                </li>
                                <li>
                                    <a href="#b2s-network" data-toggle="tab"><?php _e('Network Settings', 'blog2social') ?></a>
                                </li>
                            </ul>
                            <hr>
                            <div class="tab-content clearfix">
                                <div class="tab-pane" id="b2s-general">
                                    <?php echo $settingsItem->getGeneralSettingsHtml(); ?>
                                </div>
                                <div class="tab-pane active" id="b2s-best-time-manager">
                                    <div class="pull-right">
                                        <a href="#" data-toggle="modal" data-target="#b2sInfoSchedTimesModal" class="btn btn-link btn-lg del-padding-left b2s-load-settings-sched-time-default-info"><span class="glyphicon glyphicon-info-sign glyphicon-success"></span></a>
                                        <?php if (B2S_PLUGIN_USER_VERSION > 0) { ?>    
                                            <a href="#" class="btn btn-primary btn-xs b2s-get-settings-sched-time-default">                                        
                                            <?php } else { ?>
                                                <a href="#" class="btn btn-primary btn-xs" data-title = "<?php _e('You want to schedule your posts and use the Best Time Scheduler?', 'blog2social') ?>" data-toggle ="modal" data-target ="#b2sProFeatureModal">
                                                <?php } _e('Best Time Scheduler', 'blog2social'); ?></a>
                                    </div>
                                    <div class="clearfix"></div>
                                    <?php echo $settingsItem->getSchedSettingsHtml(); ?>
                                </div>
                                <div class="tab-pane" id="b2s-network">
                                    <?php echo $settingsItem->getNetworkSettingsHtml(); ?>
                                </div>
                            </div>
                        </div>
                        <?php
                        $noLegend = 1;
                        require_once (B2S_PLUGIN_DIR . 'views/b2s/html/footer.phtml');
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php require_once (B2S_PLUGIN_DIR . 'views/b2s/html/service.phtml'); ?>
        <?php require_once (B2S_PLUGIN_DIR . 'views/b2s/html/sidebar.phtml'); ?>
    </div>
</div>
<input type="hidden" id="b2sLang" value="<?php echo substr(B2S_LANGUAGE, 0, 2); ?>">


<div class="modal fade" id="b2sInfoFBFormatModal" tabindex="-1" role="dialog" aria-labelledby="b2sInfoFBFormatModal" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="b2s-modal-close close" data-modal-name="#b2sInfoFBFormatModal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php _e('Facebook - Specify the publication format', 'blog2social') ?></h4>
            </div>
            <div class="modal-body">
                <b><?php _e('Define yourself how to post on your Facebook account:', 'blog2social') ?></b>
                <br><br>
                <b>1) <?php _e('Share with a focus on the link', 'blog2social') ?></b><br>
                <?php _e('Publish the social media post with a focus on the link included to the post. The picture in your post is linked to your blog site.<br>Facebook automatically generates a teaser from your text and shows the headline and a short teaser at the bottom of your post. By clicking on the picture the Facebook user will then automatically be forwarded to the post.', 'blog2social'); ?>
                <br><br>
                <b>2) <?php _e('Share with a focus on the image', 'blog2social') ?></b><br>
                <?php _e('Publish the social media post with a focus on the picture. The link to the publication on your wordpress site is placed under your customized post-text.<br>If your followers click on the picture, the picture will be displayed in a bigger size by facebook. By instead clicking on the link, your followers are redirected to the whole blog contribution. The advantage: Research shows that social media posts, in which the image is not linked, seem to generate a greater reach in Facebook and lead more interested readers to read your blog-post.', 'blog2social'); ?> 
            </div>
        </div>
    </div>
</div>




