<?php
require_once B2S_PLUGIN_DIR . 'includes/B2S/Ship/Navbar.php';
require_once B2S_PLUGIN_DIR . 'includes/B2S/Ship/Image.php';
require_once B2S_PLUGIN_DIR . 'includes/B2S/Ship/Portale.php';
delete_option('B2S_PLUGIN_POST_META_TAGES_' . (int) $_GET['postId']);
B2S_Tools::checkUserBlogUrl();
$postData = get_post((int) $_GET['postId']);
$postStatus = array('publish' => __('published', 'blog2social'), 'pending' => __('draft', 'blog2social'), 'future' => __('scheduled', 'blog2social'));
?>

<div class="b2s-container">
    <div class="b2s-inbox">
        <?php require_once B2S_PLUGIN_DIR . 'views/b2s/html/header.phtml'; ?>

        <div class="col-xs-12 col-md-9 del-padding-left">
            <div class="col-xs-12 del-padding-left hidden-xs">
                <div class="panel panel-group">
                    <div class="panel-body b2s-post-details">
                        <h3><?php _e('Social Media Scheduling & Sharing', 'blog2social') ?></h3>
                        <div class="info"><?php _e('Title', 'blog2social') ?>: <?php echo $postData->post_title; ?></div>
                        <p class="info hidden-xs"># <?php echo $postData->ID; ?>  | <?php echo $postStatus[trim(strtolower($postData->post_status))] . ' ' . __('on blog', 'blog2social') . ': ' . B2S_Util::getCustomDateFormat($postData->post_date, substr(B2S_LANGUAGE, 0, 2)); ?></p>

                    </div>
                </div>
            </div>
            <div class="clearfix"></div>

            <?php if (defined("B2S_PLUGIN_ERROR_SITE_URL") && B2S_PLUGIN_ERROR_SITE_URL != false) { ?>
                <div class="b2s-settings-user-sched-time-area col-xs-12 del-padding-left hidden-xs">
                    <button type="button" class="btn btn-link pull-left btn-xs  scroll-to-bottom"><span class="glyphicon glyphicon-chevron-down"></span> <?php _e('scroll to bottom', 'blog2social') ?> </button>
                    <div class="pull-right">
                        <a href="#" data-toggle="modal" data-target="#b2sInfoSchedTimesModal" class="btn btn-link btn-lg del-padding-left b2s-load-settings-sched-time-default-info"><span class="glyphicon glyphicon-info-sign glyphicon-success"></span></a>
                        <?php if (B2S_PLUGIN_USER_VERSION > 0) { ?>
                            <a href="#" class="btn btn-primary btn-xs b2s-get-settings-sched-time-user">
                            <?php } else { ?>
                                <a href="#" class="btn btn-primary btn-xs" data-toggle="modal" data-title="<?php _e('You want to load your time settings?', 'blog2social') ?>" data-target="#b2sProFeatureModal">
                                <?php } _e('My Time Settings', 'blog2social'); ?></a>

                            <?php if (B2S_PLUGIN_USER_VERSION > 0) { ?>
                                <a href="#" class="btn btn-primary btn-xs b2s-get-settings-sched-time-default">
                                <?php } else { ?>
                                    <a href="#" class="btn btn-primary btn-xs b2s-get-settings-sched-time-open-modal" data-toggle="modal" data-title="<?php _e('You want to schedule your posts and use the Best Time Scheduler?', 'blog2social') ?>" data-target="#b2sProFeatureModal">
                                    <?php } _e('Best Time Scheduler', 'blog2social'); ?></a>
                                </div>
                                </div>
                            <?php } ?>


                            </div>
                            <?php require_once B2S_PLUGIN_DIR . 'views/b2s/html/service.phtml'; ?>

                            <div class="clearfix"></div>

                            <div id="b2s-wrapper" class="b2s-wrapper-content">
                                <div id="b2s-sidebar-wrapper" class="sidebar-default">
                                    <ul class="sidebar-nav b2s-sidbar-wrapper-nav-ul">
                                        <li>
                                            <a href="#" class="btn-toggle-menu">
                                                <div class="b2s-network-list">
                                                    <div class="b2s-network-thumb">
                                                        <div class="toggelbutton">
                                                            <i class="glyphicon glyphicon-chevron-right btn-toggle-glyphicon"></i>
                                                        </div>
                                                        <div class="network-icon">
                                                            <i class="glyphicon glyphicon-user"></i>
                                                        </div>
                                                    </div>
                                                    <div class="b2s-network-details-header">
                                                        <?php
                                                        $navbar = new B2S_Ship_Navbar();
                                                        $mandantData = $navbar->getData();
                                                        ?>
                                                        <h3> <?php echo count($mandantData['auth']); ?> <?php _e('Social Accounts', 'blog2social') ?></h3>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>

                                        <li class="sidebar-brand">
                                            <div class="form-group">
                                                <?php
                                                echo $navbar->getSelectMandantHtml($mandantData['mandanten']);
                                                ?>
                                            </div>
                                        </li>
                                        <li class="b2s-sidbar-network-auth-btn">
                                            <a href="#" data-toggle="modal" data-target="#b2s-network-list-modal">
                                                <div class="b2s-network-list">
                                                    <div class="b2s-network-thumb">
                                                        <i class="glyphicon glyphicon-plus"></i>
                                                    </div>
                                                    <div class="b2s-network-details">
                                                        <h4><?php _e('Add more...', 'blog2social') ?></h4>
                                                        <p>
                                                            <?php _e('Profiles | Pages | Groups', 'blog2social') ?>
                                                        </p>
                                                    </div>
                                                    <div class="b2s-network-status"></div>
                                                </div>
                                            </a>
                                        </li>
                                        <?php
                                        $orderArray = array();
                                        foreach ($mandantData['auth'] as $k => $channelData) {
                                            echo $navbar->getItemHtml($channelData, 0);
                                            $orderArray[] = $channelData->networkAuthId;
                                        }
                                        ?>

                                        <li>
                                            <div class="b2s-network-list">
                                                <div class="b2s-network-thumb">
                                                    <a href="#" data-toggle="modal" data-target="#b2s-network-setting-save" class="btn btn-link b2s-network-setting-save"><i class="glyphicon glyphicon-info-sign glyphicon-success"></i></a>
                                                </div>
                                                <div class="b2s-network-details-header">
                                                    <?php if (B2S_PLUGIN_USER_VERSION > 0) { ?>
                                                        <a href="#" class="btn btn-success b2s-network-setting-save-btn b2s-loading-area-save-profile-change">
                                                        <?php } else { ?>
                                                            <a href="#" class="btn btn-success b2s-network-setting-save-btn" data-toggle="modal" data-title="<?php _e('You want to save network settings in an additional profile?', 'blog2social') ?>" data-target="#b2sProFeatureModal">
                                                            <?php } _e('Save Settings', 'blog2social') ?></a>     
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="b2s-network-list">
                                                <div class="b2s-network-details-legend">
                                                    <span class="b2s-no-textwarp"><i class="glyphicon glyphicon-ok glyphicon-success"></i> <?php _e('active network', 'blog2social'); ?></span>
                                                    <span class="b2s-no-textwarp"><i class="glyphicon glyphicon-danger glyphicon-ban-circle"></i> <?php _e('only with image', 'blog2social'); ?></span>
                                                    <span class="b2s-no-textwarp"><i class="glyphicon glyphicon-danger glyphicon-refresh"></i> <?php _e('refresh authorization', 'blog2social'); ?></span>
                                                </div>
                                            </div>

                                        </li>
                                    </ul>
                                    <input type="hidden" class="b2s-network-navbar-order" value='<?php echo json_encode($orderArray) ?>'>
                                </div>

                                <div id="b2s-content-wrapper" class="b2s-content-wrapper-content-default">
                                    <div class="b2s-loading-area col-md-9 del-padding-left" style="display: none;">
                                        <div class="b2s-loader-impulse b2s-loader-impulse-md"></div>
                                        <div class="clearfix"></div>
                                        <small><?php _e('Loading...', 'blog2social') ?> .</small>
                                    </div>

                                    <?php if (defined("B2S_PLUGIN_ERROR_SITE_URL") && B2S_PLUGIN_ERROR_SITE_URL == false) { ?>
                                        <div class="b2s-info-blog-url-area">   
                                            <div class="b2s-post-area col-md-9 del-padding-left">
                                                <div class="panel panel-group">
                                                    <div class="panel-body">
                                                        <h4><?php _e('Notice:<br><p>Please make sure, that your website address is reachable. The Social Networks do not allow postings from local installations.</p>', 'blog2social') ?></h4>
                                                        <?php $settingsBlogUrl = get_option('siteurl') . ((substr(get_option('siteurl'), -1, 1) == '/') ? '' : '/') . 'wp-admin/options-general.php'; ?>
                                                        <a href="<?php echo $settingsBlogUrl; ?>" class="btn btn-primary"><?php _e('change website address', 'blog2social') ?></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <?php } else { ?>

                                        <form id="b2sNetworkSent" method="post">
                                            <div class="b2s-post-area col-md-9 del-padding-left">
                                                <div class="b2s-empty-area">
                                                    <div class="panel panel-group">
                                                        <div class="panel-body">
                                                            <h4><?php _e('First, connect or select network before posting', 'blog2social') ?></h4>
                                                            <a href="#" class="btn btn-primary text-break" data-target="#b2s-network-list-modal" data-toggle="modal"><?php _e('connect', 'blog2social') ?></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="b2s-post-list"></div>

                                                <div class="b2s-image-area">
                                                    <div class="panel panel-group">
                                                        <div class="panel-body">
                                                            <?php
                                                            $image = new B2S_Ship_Image();
                                                            echo $image->getItemHtml($postData->ID);
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="b2s-publish-area">
                                                    <button type="button" class="btn btn-link pull-left btn-xs scroll-to-top"><span class="glyphicon glyphicon-chevron-up"></span> <?php _e('scroll to top', 'blog2social') ?> </button>
                                                    <button class="btn btn-success pull-right btn-lg b2s-submit-btn"><?php _e('Share', 'blog2social') ?></button>
                                                </div>
                                                <div class="navbar navbar-default navbar-fixed-bottom navbar-small b2s-footer-menu" style="display: block;">
                                                    <div class="b2s-publish-navbar-btn">
                                                        <button class="btn btn-success btn-lg b2s-submit-btn-scroll"><?php _e('Share', 'blog2social') ?></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" id="publish_date" name="publish_date" value="">
                                            <input type="hidden" id="action" name="action" value="b2s_save_ship_data">
                                            <input type='hidden' id='post_id' name="post_id" value='<?php echo (int) $_GET['postId']; ?>'>
                                            <input type='hidden' id='user_timezone' name="user_timezone" value="0">
                                            <input type='hidden' id='default_titel' name="default_titel" value='<?php echo $postData->post_title; ?>'>

                                            <div class="b2s-reporting-btn-area col-md-9 del-padding-left" style="display: none;">
                                                <div class="panel panel-group">
                                                    <div class="panel-body">
                                                        <?php $allPosts = get_option('siteurl') . ((substr(get_option('siteurl'), -1, 1) == '/') ? '' : '/') . 'wp-admin/admin.php?page=blog2social-post'; ?>
                                                        <a class="btn btn-primary pull-right" href="<?php echo $allPosts; ?>"><?php _e('Share new post on Social Media', 'blog2social') ?></a>
                                                        <?php if (B2S_PLUGIN_USER_VERSION > 0) { ?>
                                                            <button class="btn btn-primary pull-right b2s-re-share-btn"><?php _e('Re-share this post', 'blog2social') ?></button>                    
                                                        <?php } else { ?>
                                                            <a href="#" class="btn btn-primary pull-right" data-toggle="modal" data-title="You want to re-share your blog post?" data-target="#b2sProFeatureModal"><?php _e('Re-share this post', 'blog2social') ?></a>
                                                        <?php } ?> 
                                                        <a href="#" data-toggle="modal" data-target="#b2s-re-share-info" class="btn btn-link btn-lg pull-right del-padding-left b2s-re-share-info"><span class="glyphicon glyphicon-info-sign glyphicon-success"></span></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    <?php } ?>
                                </div>
                            </div>
                            </div>
                            </div>
                            <?php
                            $noLegend = 1;
                            require_once (B2S_PLUGIN_DIR . 'views/b2s/html/footer.phtml');
                            ?>

                            <!-- B2S-Network -->
                            <div id="b2s-network-list-modal" class="modal fade" role="dialog" aria-labelledby="b2s-network-list-modal" aria-hidden="true" data-backdrop="false">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="b2s-modal-close close" data-modal-name="#b2s-network-list-modal">&times;</button>
                                            <h4 class="modal-title"><?php _e('Connect for', 'blog2social') ?>: <span class="b2s-network-list-modal-mandant"></span></h4>
                                        </div>
                                        <div class="modal-body">
                                            <?php
                                            $portale = new B2S_Ship_Portale();
                                            echo $portale->getItemHtml($mandantData['portale']);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="b2s-network-no-image-modal" class="modal fade" role="dialog" aria-labelledby="b2s-network-no-image-modal" aria-hidden="true" data-backdrop="false">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="b2s-modal-close close" data-modal-name="#b2s-network-no-image-modal">&times;</button>
                                            <h4 class="modal-title"><?php _e('No Image Selected', 'blog2social') ?></h4>
                                        </div>
                                        <div class="modal-body">
                                            <?php _e('No Image is selected, but no image can not be published on this network.', 'blog2social') ?>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-primary b2s-network-reset-image"><?php _e('Select Image', 'blog2social') ?></button>
                                            <input type="hidden" class="b2s-network-no-image-modal-datanetworkauthid" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div id="b2s-network-no-sched-time-user" class="modal fade" role="dialog" aria-labelledby="b2s-network-no-sched-time-user" aria-hidden="true" data-backdrop="false">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="b2s-modal-close close" data-modal-name="#b2s-network-no-sched-time-user" >&times;</button>
                                            <h4 class="modal-title"><?php _e('Time Scheduling', 'blog2social') ?></h4>
                                        </div>
                                        <div class="modal-body">
                                            <?php $settingsUrl = get_option('siteurl') . ((substr(get_option('siteurl'), -1, 1) == '/') ? '' : '/') . 'wp-admin/admin.php?page=blog2social-settings'; ?>
                                            <?php _e('You have not set a time. Under Blog2Social Settings (navigation on the left) you can permanently save and load your times to any publication before.', 'blog2social') ?>
                                        </div>
                                        <div class="modal-footer">
                                            <a target="_blank" href="<?php echo $settingsUrl; ?>" class="btn btn-primary"><?php _e('Settings', 'blog2social') ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="b2s-re-share-info" class="modal fade" role="dialog" aria-labelledby="b2s-re-share-info" aria-hidden="true" data-backdrop="false">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="b2s-modal-close close" data-modal-name="#b2s-re-share-info">&times;</button>
                                            <h4 class="modal-title"><?php _e('Re-share this Post', 'blog2social') ?></h4>
                                        </div>
                                        <div class="modal-body">
                                            <?php _e('You can re-share your post for a different sharing purpose, or to share on a different choice of networks, profiles, pages or groups, or with different comments or images, or if you want to share your blog post images to image networks only, or re-share them at different times. You may vary your comments and images in order to produce more variations of your social media posts to share more often without sharing the same message over and over again. Whatever your choose to do for re-sharing your post, you can simply click "Re-share this post" and you will be led to the preview page where your can select your networks and edit your texts, comments or images according to your current sharing preferences.', 'blog2social') ?>
                                            <?php if (B2S_PLUGIN_USER_VERSION == 0) { ?>
                                                <hr>
                                                <h4><?php _e('You want re-share your blog post?', 'blog2social'); ?></h4>
                                                <?php _e('Upgrade to Blog2Social Premium', 'blog2social') ?>
                                                <br>
                                                <br>
                                                <span class="glyphicon glyphicon-ok glyphicon-success"></span> <?php _e('Social Media Auto-Posting', 'blog2social') ?><br>
                                                <span class="glyphicon glyphicon-ok glyphicon-success"></span> <?php _e('Post on pages and groups', 'blog2social') ?><br>
                                                <span class="glyphicon glyphicon-ok glyphicon-success"></span> <?php _e('Share on multiple accounts per network', 'blog2social') ?><br>
                                                <span class="glyphicon glyphicon-ok glyphicon-success"></span> <?php _e('Best Time Scheduler: Schedule once, multiple times or recurringly.', 'blog2social') ?><br>  
                                                <span class="glyphicon glyphicon-ok glyphicon-success"></span> <?php _e('Reporting with links to all published social media posts', 'blog2social') ?><br>  
                                                <br>
                                                <a target="_blank" href="https://service.blog2social.com/" class="btn btn-success center-block"><?php _e('Upgrade to PREMIUM', 'blog2social') ?></a>
                                                <br>
                                                <center><?php _e('or <a href="http://service.blog2social.com/trial" target="_blank">start with free 30-days-trial of Blog2Social Premium</a> (no payment information needed)', 'blog2social') ?></center>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="b2s-network-setting-save" class="modal fade" role="dialog" aria-labelledby="b2s-network-setting-save" aria-hidden="true" data-backdrop="false">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="b2s-modal-close close" data-modal-name="#b2s-network-setting-save">&times;</button>
                                            <h4 class="modal-title"><?php _e('Save Network Settings', 'blog2social') ?></h4>
                                        </div>
                                        <div class="modal-body">
                                            <?php _e('You can save your current network settings as "Standard" network settings for any future sharing activities or as a "Profile" to choose from (Premium).<br><br>Your Standard selection will show as activated upon pressing the "share on social media" button on the right hand side bar. You can change these settings any time per click, or choose another network profile (Premium).<br><br>You can also pre-define various different sets of networks, for specific social media accounts, target groups, contents or sharing purposes. For example you can define a specific set of networks for sharing your posts images only or for re-sharing your evergreen content on a recurring basis. On the preview-page you may edit your selected or pre-selected networks anytime by simply clicking on the respective network account to select or remove an account from the current sharing scheme.', 'blog2social') ?>
                                            <?php if (B2S_PLUGIN_USER_VERSION == 0) { ?>
                                                <hr>
                                                <h4><?php _e('You want to save network settings in an additional profile?', 'blog2social'); ?></h4>
                                                <?php _e('Upgrade to Blog2Social Premium', 'blog2social') ?>
                                                <br>
                                                <br>
                                                <span class="glyphicon glyphicon-ok glyphicon-success"></span> <?php _e('Social Media Auto-Posting', 'blog2social') ?><br>
                                                <span class="glyphicon glyphicon-ok glyphicon-success"></span> <?php _e('Post on pages and groups', 'blog2social') ?><br>
                                                <span class="glyphicon glyphicon-ok glyphicon-success"></span> <?php _e('Share on multiple accounts per network', 'blog2social') ?><br>
                                                <span class="glyphicon glyphicon-ok glyphicon-success"></span> <?php _e('Best Time Scheduler: Schedule once, multiple times or recurringly.', 'blog2social') ?><br>  
                                                <span class="glyphicon glyphicon-ok glyphicon-success"></span> <?php _e('Reporting with links to all published social media posts', 'blog2social') ?><br>  
                                                <br>
                                                <a target="_blank" href="https://service.blog2social.com/" class="btn btn-success center-block"><?php _e('Upgrade to PREMIUM', 'blog2social') ?></a>
                                                <br>
                                                <center><?php _e('or <a href="http://service.blog2social.com/trial" target="_blank">start with free 30-days-trial of Blog2Social Premium</a> (no payment information needed)', 'blog2social') ?></center>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" id="b2sLang" value="<?php echo substr(B2S_LANGUAGE, 0, 2); ?>">
                            <input type="hidden" id="b2sPostId" value="<?php echo $postData->ID; ?>">
                            <input type="hidden" id="b2sDefault_url" name="default_url" value="<?php echo get_permalink($postData->ID) !== false ? get_permalink($postData->ID) : $postData->guid; ?>">
                            <input type="hidden" id="b2sPortalImagePath" value="<?php echo plugins_url('/assets/images/portale/', B2S_PLUGIN_FILE); ?>">
                            <input type="hidden" id="b2sServerUrl" value="<?php echo B2S_PLUGIN_SERVER_URL; ?>">
                            <input type="hidden" id="b2sJsTextLoading" value="<?php _e('Loading...', 'blog2social') ?>">
                            <input type="hidden" id="b2sJsTextConnectionFail" value="<?php _e('The connection to the server failed. Try again!', 'blog2social') ?>">
                            <input type="hidden" id="b2sSelectedNetworkAuthId" value="<?php echo (isset($_GET['network_auth_id']) && (int) $_GET['network_auth_id'] > 0) ? (int) $_GET['network_auth_id'] : ''; ?>">
                            <input type="hidden" id="b2sDefaultNoImage" value="<?php echo plugins_url('/assets/images/no-image.png', B2S_PLUGIN_FILE); ?>">
                            <?php if (trim(strtolower($postData->post_status)) == 'future') { ?>
                                <input type="hidden" id="b2sBlogPostSchedDate" value="<?php echo strtotime($postData->post_date); ?>000"> <!--for milliseconds-->  
                            <?php }
