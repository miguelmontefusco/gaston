<?php


function wpssi_menu_item()
{
   add_menu_page("Social Share Icons", "Social Share Icons","manage_options", "wpssi-options", "wpssi_settings_page" , 'dashicons-share' , "20"); 
   add_action( 'admin_init', 'wpssi_register_settings');
}

add_action("admin_menu", "wpssi_menu_item");



function wpssi_register_settings(){

  register_setting('wpssi-settings-group', 'wpsocial-enable-plugin' , 'wpssi_sanitize_options');
  register_setting('wpssi-settings-group', 'wpsocial-enable-post' , 'wpssi_sanitize_options');
  register_setting('wpssi-settings-group', 'wpsocial-enable-page' , 'wpssi_sanitize_options');
  register_setting('wpssi-settings-group', 'wpsocial-enable-home' , 'wpssi_sanitize_options');
  register_setting('wpssi-settings-group', 'wpsocial-message-selection' , 'wpssi_sanitize_options');
  register_setting('wpssi-settings-group', 'wpsocial-custom-message' , 'wpssi_sanitize_options');
  register_setting('wpssi-settings-group', 'wpsocial-positioning' , 'wpssi_sanitize_options');
  register_setting('wpssi-settings-group', 'wpsocial-alignment' , 'wpssi_sanitize_options');
  register_setting('wpssi-settings-group', 'wpsocial-facebook' , 'wpssi_sanitize_options');
  register_setting('wpssi-settings-group', 'wpsocial-twitter' , 'wpssi_sanitize_options');
  register_setting('wpssi-settings-group', 'wpsocial-google' , 'wpssi_sanitize_options');
  register_setting('wpssi-settings-group', 'wpsocial-linkedin' , 'wpssi_sanitize_options');
  register_setting('wpssi-settings-group', 'wpsocial-pinterest' , 'wpssi_sanitize_options');
  register_setting('wpssi-settings-group', 'wpsocial-skins' , 'wpssi_sanitize_options');
  register_setting('wpssi-settings-group', 'wpsocial-gfonts', 'wpssi_sanitize_options');

}


function wpssi_settings_page()
{
  global $post;

   $url = get_permalink($post->ID);
   $url = esc_url($url);
  ?>
  <!-- Top Header Brand Bra -->

 <a class="wpsocial-banner" target="_blank" href="http://www.wpsuperhero.com/add-social-share/"></a>
  <a class="wpsocial-banner-widget" target="_blank" href="http://wordpress.org/plugins/social-media-widget-icon/"></a>
  <form method="post" action="options.php" >
    <?php settings_fields('wpssi-settings-group');?>
    <div class="top-brand">
      <div class="top-brand-icon" style=""></div>
    </div>
    <!-- End Top Header Brand Bra -->

    <!-- Live Preview Container -->
    <p id="wpsocial-submit-date" class="submit">
      <input type="submit" class="button-primary" value="<?php _e( 'Save Changes' ); ?>" />
    </p>
    <a target="_blank" href="http://www.wpsuperhero.com/add-social-share/" id="wpsocial-submit-date" class="submit" style="margin-left: 293px;">
      <input style="" type="button" class="button-primary" value="<?php _e( 'Buy Premium' ); ?>" />
    </a>
    <div id="live-preview">
      <!-- Live Preview Options Container -->
      <div id="wpsocial-live-preview-options" class="col-md-12">
        <div id="wpsocial-live-preview-heading" class="col-md-12 text-center">See Live Preview Here</div>
          <div id="wpsocial-live-preview-options-settings" class="">
            <p>
              <span><strong>Default Message:</strong></span> 
              <span id="wpsocial-default-message-option"><?php if( get_option('wpsocial-custom-message') == "" ) echo get_option('wpsocial-message-selection'); else { echo get_option('wpsocial-custom-message'); }?></span>
            </p>
          </div>
        <div id="wpsocial-live-preview-options-settings">
          <p>
            <span><strong>Post Type:</strong></span> 
            <span id="wpsocial-live-preview-post"><?php if( get_option('wpsocial-enable-post') != "" ) echo "Post"; else { echo ""; }?></span>
            <span id="wpsocial-live-preview-page"><?php if( get_option('wpsocial-enable-page') != "" ) echo "Page"; else{ echo ""; }?></span>
            <span id="wpsocial-live-preview-page"><?php if( get_option('wpsocial-enable-home') != "" ) echo "Home"; else{ echo ""; }?></span>
          </p>
        </div>
        <div id="wpsocial-live-preview-options-settings">
          <p>
            <span><strong>Selected Skin:</strong></span> 

            <span> <?php print_r( get_option('wpsocial-skins')); ?><!-- <?php if( get_option('wpsocial-skins') != "" ) echo get_option('wpsocial-skins'); else { echo ""; }?> --></span>
          </p>
        </div>
        <div id="wpsocial-live-preview-options-settings">
          <p> 
            <span><strong>Location:</strong></span> 
            <span id="wpsocial-live-preview-location"><?php if( get_option('wpsocial-positioning') == "afterpost" ) echo "After Post"; else if(get_option('wpsocial-positioning') == "beforepost") echo "Before Post"; else if(get_option('wpsocial-positioning') == "both") echo "Before and After Post "; else{echo "";} ?></span> 
            <span id="wpsocial-live-preview-align"><?php if( get_option('wpsocial-alignment') == "alignleft" ) echo "Align Left"; else if(get_option('wpsocial-alignment') == "alignright") echo "Align Right"; else if(get_option('wpsocial-alignment') == "aligncenter") echo "Align Center"; else{echo "";} ?></span>
          </p>
        </div>


      </div>
      <!-- End Live Preview Options Container -->

      <!-- Social Skins Preview Container -->
      <span id="wpsocial-messages-selection-span" style="font-family: 'Great Vibes', cursive;font-size: 28px;display: block;margin-bottom: 13px;"><?php if(get_option("wpsocial-message-selection")=="None")echo "";else { echo get_option("wpsocial-message-selection"); }?></span>
      <div id="preview-parent" class="col-md-12 text-center">
        <!-- Live preview will show here -->
      </div>
      <!-- End Social Skins Preview Container -->

    </div>
    <!-- Live Preview Container -->


    <div id="main-container" class="margining">
      <div class="margining">
        <div class="margining">
          <div class="tabs-left">
            <div class="tab-content">

              <!-- All the Plugins Option's Container -->
              <div class="tab-pane active" id="a" style="height: 2650px;">
                <h1 class="">CONFIGURE SOCIAL SHARE SETTINGS</h1>

                <!-- Label for Plugin Enable/Disable Option -->
                <div id="wpsocial-label"><label>Enable Social Share Plugin:</label></div>
                <!-- End Label for Plugin Enable/Disable Option -->

                <!-- Plugin Enable/Disable Option -->
                <div id="wpsocial-value">
                  <div class="switch" style="margin-top: -8px;">
                    <input id="wpsocial-enable-plugin" name="wpsocial-enable-plugin" class="cmn-toggle cmn-toggle-round" type="checkbox"  value='1'<?php checked(1, get_option('wpsocial-enable-plugin')); ?> >
                    <label for="wpsocial-enable-plugin"></label>
                  </div>
                </div>
                <!-- End Plugin Enable/Disable Option -->

                <!-- Added Google Fonts Container -->
                <div id="wpsocial-label"><label>Select Fonts For Message:</label></div>

                <div id="wpsocial-value">
                  <input name="" id="wpsocial_gfonts" class="wpsocial_msgfont" type="text" value=""/></br><a  target="_blank" href="http://www.wpsuperhero.com/add-social-share/"><b>(Google Fonts in Premium)</b></a> 

                </div>
                <!-- End Added Google Fonts Container -->
                
                <!-- Label for Default Message Option -->
                <div id="wpsocial-label"><label>Default Message:</label></div>
                <!-- Label for Default Message Option -->

                <!-- Default Message Option Values -->
                <div id="wpsocial-value">
                  <select id="wpsocial-message-selection" name="wpsocial-message-selection">
                    <option value="None" <?php selected( get_option('wpsocial-message-selection'),'None'); ?>   >None</option>

                    <option value="Share this post"<?php selected( get_option('wpsocial-message-selection'),'Share this post'); ?>   >Share this post</option>

                    <option value="Show Some Love for us!"<?php selected( get_option('wpsocial-message-selection'),'Show Some Love for us!'); ?>   >Show Some Love for us!</option>

                    <option value="Sharing is Caring"<?php selected( get_option('wpsocial-message-selection'),'Sharing is Caring'); ?>   >Sharing is Caring</option>

                    <option value="Hey check this out" <?php selected( get_option('wpsocial-message-selection'),'Hey check this out'); ?>>Hey check this out</option>

                    <option value="Share this!"<?php selected( get_option('wpsocial-message-selection'),'Share this!'); ?>   >Share this!</option>

                    <option value="Share the knowledge"<?php selected( get_option('wpsocial-message-selection'),'Share the knowledge'); ?>   >Share the knowledge</option>

                    <option value="Wanna share this?"<?php selected( get_option('wpsocial-message-selection'),'Wanna share this?'); ?>   >Wanna share this?</option>
                    <option disabled="disabled" value="Custom Message"<?php selected( get_option('wpsocial-message-selection'),'Custom Message'); ?>   >Custom Message <a target="_blank" href="http://www.wpsuperhero.com/add-social-share/"><b>(Premium)</b></a></option>
                  </select>
                  <a style="position: absolute;margin-top: -18px;" target="_blank" href="http://www.wpsuperhero.com/add-social-share/"><b>(Custom Message in Premium)</b></a>
                  <input disabled="disabled" id="wpsocial-custom-default-message" name="wpsocial-custom-message" type="text" value="<?php echo get_option("wpsocial-custom-message"); ?>" placeholder="Set your custom message"/><span id="wpsocial-custom-size-span"> (Add your custom message if don't use default ones)</span>
                  <p class="wpsocial-custom-message-help">Select <strong>"Custom Message"</strong> option from drop down list if you want to add custom message to your social icons</p>
                </div>
                <!-- Default Message Option Values -->

                <!-- Labels for Post Types -->
                <div id="wpsocial-label"><label>Social Buttons Settings:</label></div>
                <!-- End Labels for Post Types -->

               <!-- Post Type Values -->
                <div id="wpsocial-value">
                  <div id="wpsocial-label-value"><label id="wpsocial-post-label">Show on Posts</label>
                    <div class="switch" style="margin-top: -6px;margin-left: 180px;">
                      <input id="wpsocial-enable-post" name="wpsocial-enable-post" class="cmn-toggle cmn-toggle-round" type="checkbox" value='1'<?php checked(1, get_option('wpsocial-enable-post')); ?>>
                      <label for="wpsocial-enable-post"></label>
                    </div>
                  </div>
                  <div id="wpsocial-label-value"><label id="wpsocial-page-label">Show on Pages</label>
                    <div class="switch" style="margin-left: 180px;">
                      <input id="wpsocial-enable-page" name="wpsocial-enable-page" class="cmn-toggle cmn-toggle-round" disabled type="checkbox" value='1'<?php checked(1, get_option('wpsocial-enable-page')); ?>>
                      <label for="wpsocial-enable-page"></label>
                       <a target="_blank" href="http://www.wpsuperhero.com/add-social-share/"><b>Premium</b></a>
                    </div>
                  </div>
                  <div id="wpsocial-label-value"><label id="wpsocial-page-label">Show on Home Page</label>
                    <div class="switch" style="margin-left: 180px;">
                      <input id="wpsocial-enable-home" name="wpsocial-enable-home" class="cmn-toggle cmn-toggle-round" disabled type="checkbox" value='1'<?php checked(1, get_option('wpsocial-enable-home')); ?>>
                      <label for="wpsocial-enable-home"></label>
                       <a target="_blank" href="http://www.wpsuperhero.com/add-social-share/"><b>Premium</b></a>
                    </div>
                  </div>
                </div>
                <hr style="margin-top: 140px;">
                <!-- End Post Type Values -->

                <!-- Position Selection Container for Social Icons -->
                <div id="wpsocial-position-wrapper">
                  <h1 class="">SELECT THE BEST SUITABLE LOCATION</h1> 
                  <div id="wpsocial-positioning-div">
                    <p id="wpsocial-paragraph-seperator">Select Position of your social icons</p>
                    <div id="wpsocial-positioning">
                      <label for="afterpost"><img src='<?php echo plugins_url( 'admin/images/afterpost.png', __FILE__); ?>' /></label><br/>
                      <input id="afterpost" type="radio" name="wpsocial-positioning" value="afterpost" <?php checked('afterpost', get_option('wpsocial-positioning')); ?> />
                    </div>
                    <div id="wpsocial-positioning">
                      <label for="beforepost"><a target="_blank" href="http://www.wpsuperhero.com/add-social-share/"><b>Premium</b></a><img src='<?php echo plugins_url( 'admin/images/beforepost.png', __FILE__); ?>' /></label><br/>
                      <input id="beforepost" type="radio" name="wpsocial-positioning" disabled />
                    </div>
                    <div id="wpsocial-positioning">
                      <label for="both"><a target="_blank" href="http://www.wpsuperhero.com/add-social-share/"><b>Premium</b></a><img src='<?php echo plugins_url( 'admin/images/both.png', __FILE__); ?>' /></label><br/>
                      <input id="both" type="radio" name="wpsocial-positioning"  disabled />
                    </div>
                  </div>
                  <div id="wpsocial-alignment-div">
                    <p id="wpsocial-paragraph-seperator">Select Alignment of your social icons</p>
                    <div id="wpsocial-positioning">
                      <label for="alignleft"><img src='<?php echo plugins_url( 'admin/images/alignleft.png', __FILE__); ?>' /></label><br/>
                      <input id="alignleft" type="radio" name="wpsocial-alignment" value="alignleft"<?php checked('alignleft', get_option('wpsocial-alignment')); ?>/>
                    </div>
                    <div id="wpsocial-positioning">
                      <label for="aligncenter"><a target="_blank" href="http://www.wpsuperhero.com/add-social-share/"><b>Premium</b></a><img src='<?php echo plugins_url( 'admin/images/aligncenter.png', __FILE__); ?>' /></label><br/>
                      <input id="aligncenter" type="radio" name="wpsocial-alignment" disabled />
                    </div>
                    <div id="wpsocial-positioning">
                      <label for="alignright"><a target="_blank" href="http://www.wpsuperhero.com/add-social-share/"><b>Premium</b></a><img src='<?php echo plugins_url( 'admin/images/alignright.png', __FILE__); ?>' /></label><br/>
                      <input id="alignright" disabled type="radio" name="wpsocial-alignment" value="alignright" <?php checked('alignright', get_option('wpsocial-alignment')); ?> />
                    </div>
                  </div>
                </div>
                <!-- Position Selection Container for Social Icons -->

                <!-- Social Network Selection Container -->
                <div id="wpsocial-social-network-selection">
                  <h1 class="">CUSTMOIZE YOUR SOCIAL NETWORK SETTINGS</h1>
                  <h4>SELECT SOCIAL NETWORKS</h4>
                  <div id="wpsocial-selection">
                    <label for="facebook"><a class="facebook" title="Facebook"></a></label><br/>
                    <input id="facebook" class="facebookcb social-selection" type="checkbox" name="wpsocial-facebook" value="wpsocial-facebook" <?php checked('wpsocial-facebook', get_option('wpsocial-facebook')); ?> >
                  </div>
                  <div id="wpsocial-selection">
                    <label for="twitter"><a class="twitter" title="Twitter"></a></label><br/>
                    <input id="twitter" class="twittercb social-selection" type="checkbox" name="wpsocial-twitter" value="wpsocial-twitter" <?php checked('wpsocial-twitter', get_option('wpsocial-twitter')); ?> >
                  </div>
                  <div id="wpsocial-selection">
                    <label for="g-plus"><a class="g-plus" title="Google+"></a></label><br/>
                    <input id="g-plus" class="googlecb social-selection" type="checkbox" name="wpsocial-google"
                    value="wpsocial-google" <?php checked('wpsocial-google', get_option('wpsocial-google')); ?>>
                  </div>
                  <div id="wpsocial-selection">
                    <label for="linkedin"><a class="linkedin" title="LinkedIn"></a></label><br/>
                    <input id="linkedin" class="linkedincb social-selection" type="checkbox" name="wpsocial-linkedin" value="wpsocial-linkedin" <?php checked('wpsocial-linkedin', get_option('wpsocial-linkedin')); ?>>
                  </div>
                  <div id="wpsocial-selection">
                    <label for="pinterest"><a class="pinterest" title="Pinterest"></a></label><br/>
                    <input id="pinterest" class="pinterestcb social-selection" type="checkbox" name="wpsocial-pinterest" value="wpsocial-pinterest" <?php checked('wpsocial-pinterest', get_option('wpsocial-pinterest')); ?> >
                  </div>
                </div>
                <!-- End Social Network Selection Container -->

                <hr>
                <h1 class="">GIVE A UNIQUE LOOK TO YOUR SOCIAL ICONS</h1>
                <h4>SELECT SOCIAL NETWORK SKINS</h4>

                <!-- Including Skins Using js -->
                <div id="includedskin1" data-selected-skin="default-skin">
                  <div class="col-md-12">
                    <input id="default-skin" type="radio" name="wpsocial-skins" value="default-skin"  <?php checked('default-skin', get_option('wpsocial-skins') ); ?> /><label id="wpsocial-skins-label" for="default-skin">  Default  </label>
                    <div class="social1" style="display: block !important;">
                      <a href="#" class="facebook" title="Facebook"></a>
                      <a href="#" class="twitter" title="Twitter"></a>
                      <a href="#" class="google" title="Google+"></a>
                      <a href="#" class="linkedin" title="LinkedIn"></a>
                      <a href="#" class="pinterest" title="Pinterest"></a>
                    </div><!--End Container-->
                  </div>
                </div>
                <div id="includedskin2">
                  <div class="col-md-12">
                    <input id="social-wide" type="radio" disabled name="wpsocial-skins" value="social-wide"  <?php checked('social-wide', get_option('wpsocial-skins') ); ?> /><label id="wpsocial-skins-label" for="social-wide">  Social Wide <a target="_blank" href="http://www.wpsuperhero.com/add-social-share/"><b>Premium</b></a> </label>
                    <div class="social1">
                      <a href="#" class="facebook" title="Facebook"></a>
                      <a href="#" class="twitter" title="Twitter"></a>
                      <a href="#" class="google" title="Google+"></a>
                      <a href="#" class="linkedin" title="LinkedIn"></a>
                      <a href="#" class="pinterest" title="Pinterest"></a>
                    </div><!--End Container-->
                  </div>
                </div>
                <div id="includedskin3">
                  <div class="col-md-12">
                    <input id="bounce-up" type="radio" name="wpsocial-skins" value="bounce-up"  <?php checked('bounce-up', get_option('wpsocial-skins')); ?> /><label id="wpsocial-skins-label" for="bounce-up">  Flip Cards (With Animation)  </label>
                    <div class="social1" style="display: block !important;">
                      <a href="" target="_blank">
                        <div class="social--facebook"></div>
                      </a>
                      <a href="" target="_blank">
                        <div class="social--twitter"></div>
                      </a>
                      <a href="" target="_blank">
                        <div class="social--google"></div>
                      </a>
                      <a href="" target="_blank">
                        <div class="social--linkedin"></div>
                      </a>
                      <a href="" target="_blank">
                        <div class="social--pinterest"></div>
                      </a>
                    </div><!--End Container-->
                  </div>
                </div>
                <div id="includedskin4">
                  <div class="col-md-12">
                    <input id="grind-in" type="radio" name="wpsocial-skins" disabled /><label id="wpsocial-skins-label" for="grind-in">  Roller (With Animation)<a target="_blank" href="http://www.wpsuperhero.com/add-social-share/"><b>Premium</b></a>
 </label>
                    <div class="social_icons">
                      <a class="btn_facebook"><i class="fa fa-facebook"></i><i class="fa fa-facebook"></i></a>
                      <a class="btn_twitter"><i class="fa fa-twitter"></i><i class="fa fa-twitter"></i></a>
                      <a class="btn_google-plus"><i class="fa fa-google-plus"></i><i class="fa fa-google-plus"></i></a>
                      <a class="btn_linkedin"><i class="fa fa-linkedin"></i><i class="fa fa-linkedin"></i></a>
                      <a class="btn_pinterest"><i class="fa fa-pinterest"></i><i class="fa fa-pinterest"></i></a>
                    </div>
                  </div>
                </div>
                <div id="includedskin5">
                  <div class="col-md-12">
                    <input id="paper-fold" type="radio" name="wpsocial-skins" disabled /><label id="wpsocial-skins-label" for="paper-fold">  Paper Fold (With Animation) <a target="_blank" href="http://www.wpsuperhero.com/add-social-share/"><b>Premium</b></a>  </label>
                    <div  id="wpsocial-theme5" class="">
                      <nav>
                        <ul>
                          <li id="facebooktheme5">
                            <div><a href="#">
                              <span class="wpsocial-theme5-facebook hvr-wobble-vertical"></span>
                            </a>
                          </div>
                        </li>
                        <li id="twittertheme5">
                          <div ><a href="#">
                            <span class="wpsocial-theme5-twitter hvr-wobble-vertical"></span>
                          </a>
                        </div>
                      </li>
                      <li id="google-plustheme5">
                        <div >
                          <a href="#"><span class="wpsocial-theme5-gplus hvr-wobble-vertical"></span>
                          </a>
                        </div>
                      </li>
                      <li id="linkedintheme5">
                        <div >
                          <a href="#">
                            <span class="wpsocial-theme5-linkedin hvr-wobble-vertical"></span>
                          </a>
                        </div>
                      </li>
                      <li id="pinteresttheme5">
                        <div >
                          <a href="#">
                            <span class="wpsocial-theme5-pinterest hvr-wobble-vertical"></span>
                          </a>
                        </div>
                      </li>
                    </ul>
                  </nav>
                </div><!--End Container-->
              </div>
            </div>
            <div id="includedskin6">
              <div class="col-md-12">
                <input id="branded" type="radio" name="wpsocial-skins" disabled <label id="wpsocial-skins-label" for="branded">  Branded (With Animation) <a target="_blank" href="http://www.wpsuperhero.com/add-social-share/"><b>Premium</b></a>  </label>
                <div  id="wpsocial-theme6" class="">
                  <nav>
                    <ul>
                      <li id="facebooktheme6">
                        <div><a href="#">
                          <span class="wpsocial-theme6-facebook hvr-outline-infacebook"></span>
                        </a>
                      </div>
                    </li>
                    <li id="twittertheme6">
                      <div ><a href="#">
                        <span class="wpsocial-theme6-twitter hvr-outline-intwitter"></span>
                      </a>
                    </div>
                  </li>
                  <li id="google-plustheme6">
                    <div >
                      <a href="#"><span class="wpsocial-theme6-gplus hvr-outline-ingplus"></span>
                      </a>
                    </div>
                  </li>
                  <li id="linkedintheme6">
                    <div >
                      <a href="#">
                        <span class="wpsocial-theme6-linkedin hvr-outline-inlinkedin"></span>
                      </a>
                    </div>
                  </li>
                  <li id="pinteresttheme6">
                    <div >
                      <a href="#">
                        <span class="wpsocial-theme6-pinterest hvr-outline-inpinterest"></span>
                      </a>
                    </div>
                  </li>
                </ul>
              </nav>
            </div><!--End Container-->
          </div>
        </div>
        <div id="includedskin7">
          <div class="col-md-12">
            <input id="radiused" type="radio" name="wpsocial-skins" disabled  /><label id="wpsocial-skins-label" for="radiused">  Radiused (With Animation) <a target="_blank" href="http://www.wpsuperhero.com/add-social-share/"><b>Premium</b></a> </label>
            <div  id="wpsocial-theme7" class="">
              <nav>
                <ul>
                  <li id="facebooktheme7">
                    <div><a href="#">
                      <span class="wpsocial-theme7-facebook rotatefacebook"></span>
                    </a>
                  </div>
                </li>
                <li id="twittertheme7">
                  <div ><a href="#">
                    <span class="wpsocial-theme7-twitter rotatetwitter"></span>
                  </a>
                </div>
              </li>
              <li id="google-plustheme7">
                <div >
                  <a href="#"><span class="wpsocial-theme7-gplus rotategplus"></span>
                  </a>
                </div>
              </li>
              <li id="linkedintheme7">
                <div >
                  <a href="#">
                    <span class="wpsocial-theme7-linkedin rotatelinkedin"></span>
                  </a>
                </div>
              </li>
              <li id="pinteresttheme7">
                <div >
                  <a href="#">
                    <span class="wpsocial-theme7-pinterest rotatepinterest"></span>
                  </a>
                </div>
              </li>
            </ul>
          </nav>
        </div><!--End Container-->
      </div>
    </div>
    <div id="includedskin8">
      <div class="col-md-12">
        <input id="octagon" type="radio" name="wpsocial-skins" disabled /><label id="wpsocial-skins-label" for="octagon">  Octagon (With Animation) <a target="_blank" href="http://www.wpsuperhero.com/add-social-share/"><b>Premium</b></a>  </label>
        <div  id="wpsocial-theme8" class="">
          <nav>
            <ul>
              <li id="facebooktheme8">
                <div><a href="#">
                  <span class="wpsocial-theme8-facebook hvr-float-shadow"></span>
                </a>
              </div>
            </li>
            <li id="twittertheme8">
              <div ><a href="#">
                <span class="wpsocial-theme8-twitter hvr-float-shadow"></span>
              </a>
            </div>
          </li>
          <li id="google-plustheme8">
            <div >
              <a href="#"><span class="wpsocial-theme8-gplus hvr-float-shadow"></span>
              </a>
            </div>
          </li>
          <li id="linkedintheme8">
            <div >
              <a href="#">
                <span class="wpsocial-theme8-linkedin hvr-float-shadow"></span>
              </a>
            </div>
          </li>
          <li id="pinteresttheme8">
            <div >
              <a href="#">
                <span class="wpsocial-theme8-pinterest hvr-float-shadow"></span>
              </a>
            </div>
          </li>
        </ul>
      </nav>
    </div><!--End Container-->
  </div>
</div>
<div id="includedskin9">
  <div class="col-md-12">
    <input id="hanging" type="radio" name="wpsocial-skins" disabled /><label id="wpsocial-skins-label" for="hanging">  Hanging (With Animation) <a target="_blank" href="http://www.wpsuperhero.com/add-social-share/"><b>Premium</b></a>  </label>
    <div  id="wpsocial-theme9" class="">
      <nav>
        <ul>
          <li id="facebooktheme9">
            <div><a href="#">
              <span class="wpsocial-theme9-facebook hvr-wobble-bottom"></span>
            </a>
          </div>
        </li>
        <li id="twittertheme9">
          <div ><a href="#">
            <span class="wpsocial-theme9-twitter hvr-wobble-bottom"></span>
          </a>
        </div>
      </li>
      <li id="google-plustheme9">
        <div >
          <a href="#"><span class="wpsocial-theme9-gplus hvr-wobble-bottom"></span>
          </a>
        </div>
      </li>
      <li id="linkedintheme9">
        <div >
          <a href="#">
            <span class="wpsocial-theme9-linkedin hvr-wobble-bottom"></span>
          </a>
        </div>
      </li>
      <li id="pinteresttheme9">
        <div >
          <a href="#">
            <span class="wpsocial-theme9-pinterest hvr-wobble-bottom"></span>
          </a>
        </div>
      </li>
    </ul>
  </nav>
</div><!--End Container-->
</div>
</div>
<div id="includedskin10">
  <div class="col-md-12">
    <input id="tricon" type="radio" name="wpsocial-skins" disabled /><label id="wpsocial-skins-label" for="tricon">  Tricon (With Animation) <a target="_blank" href="http://www.wpsuperhero.com/add-social-share/"><b>Premium</b></a>  </label>
    <div  id="wpsocial-theme10" class="">
      <nav>
        <ul>
          <li id="facebooktheme10">
            <div><a href="#">
              <span class="wpsocial-theme10-facebook hvr-buzz-out"></span>
            </a>
          </div>
        </li>
        <li id="twittertheme10">
          <div ><a href="#">
            <span class="wpsocial-theme10-twitter hvr-buzz-out"></span>
          </a>
        </div>
      </li>
      <li id="google-plustheme10">
        <div >
          <a href="#"><span class="wpsocial-theme10-gplus hvr-buzz-out"></span>
          </a>
        </div>
      </li>
      <li id="linkedintheme10">
        <div >
          <a href="#">
            <span class="wpsocial-theme10-linkedin hvr-buzz-out"></span>
          </a>
        </div>
      </li>
      <li id="pinteresttheme10">
        <div >
          <a href="#">
            <span class="wpsocial-theme10-pinterest hvr-buzz-out"></span>
          </a>
        </div>
      </li>
    </ul>
  </nav>
</div><!--End Container-->
</div>
</div>
<div id="includedskin11">
  <div class="col-md-12">
    <input id="hollow" type="radio" name="wpsocial-skins" disabled /><label id="wpsocial-skins-label" for="hollow">  Hollow (With Animation) <a target="_blank" href="http://www.wpsuperhero.com/add-social-share/"><b>Premium</b></a>  </label>
    <div  id="wpsocial-theme11" class="">
      <nav>
        <ul>
          <li id="facebooktheme11">
            <div><a href="#">
              <span class="wpsocial-theme11-facebook rotatefacebook"></span>
            </a>
          </div>
        </li>
        <li id="twittertheme11">
          <div ><a href="#">
            <span class="wpsocial-theme11-twitter rotatetwitter"></span>
          </a>
        </div>
      </li>
      <li id="google-plustheme11">
        <div >
          <a href="#"><span class="wpsocial-theme11-gplus rotategplus"></span>
          </a>
        </div>
      </li>
      <li id="linkedintheme11">
        <div >
          <a href="#">
            <span class="wpsocial-theme11-linkedin rotatelinkedin"></span>
          </a>
        </div>
      </li>
      <li id="pinteresttheme11">
        <div >
          <a href="#">
            <span class="wpsocial-theme11-pinterest rotatepinterest"></span>
          </a>
        </div>
      </li>
    </ul>
  </nav>
</div><!--End Container-->
</div>
</div>
<div id="includedskin12">
  <div class="col-md-12">
    <input id="sociallambs" type="radio" name="wpsocial-skins" disabled /><label id="wpsocial-skins-label" for="sociallambs">  Social Lambs (With Animation) <a target="_blank" href="http://www.wpsuperhero.com/add-social-share/"><b>Premium</b></a>  </label>
    <div  id="wpsocial-theme12" class="">
      <nav>
        <ul>
          <li id="facebooktheme12">
            <div><a href="#">
              <span class="wpsocial-theme12-facebook hvr-pop"></span>
            </a>
          </div>
        </li>
        <li id="twittertheme12">
          <div ><a href="#">
            <span class="wpsocial-theme12-twitter hvr-pop"></span>
          </a>
        </div>
      </li>
      <li id="google-plustheme12">
        <div >
          <a href="#"><span class="wpsocial-theme12-gplus hvr-pop"></span>
          </a>
        </div>
      </li>
      <li id="linkedintheme12">
        <div >
          <a href="#">
            <span class="wpsocial-theme12-linkedin hvr-pop"></span>
          </a>
        </div>
      </li>
      <li id="pinteresttheme12">
        <div >
          <a href="#">
            <span class="wpsocial-theme12-pinterest hvr-pop"></span>
          </a>
        </div>
      </li>
    </ul>
  </nav>
</div><!--End Container-->
</div>
</div>
<div id="includedskin13">
  <div class="col-md-12">
    <input id="3dicons" type="radio" name="wpsocial-skins" disabled /><label id="wpsocial-skins-label" for="3dicons">  3D Icons (With Animation) <a target="_blank" href="http://www.wpsuperhero.com/add-social-share/"><b>Premium</b></a> </label>
    <div  id="wpsocial-theme17" class="">
      <nav>
        <ul>
          <li id="facebooktheme17">
            <div><a href="#">
              <span class="wpsocial-theme17-facebook hvr-grow-rotate"></span>
            </a>
          </div>
        </li>
        <li id="twittertheme17">
          <div ><a href="#">
            <span class="wpsocial-theme17-twitter hvr-grow-rotate"></span>
          </a>
        </div>
      </li>
      <li id="google-plustheme17">
        <div >
          <a href="#"><span class="wpsocial-theme17-gplus hvr-grow-rotate"></span>
          </a>
        </div>
      </li>
      <li id="linkedintheme17">
        <div >
          <a href="#">
            <span class="wpsocial-theme17-linkedin hvr-grow-rotate"></span>
          </a>
        </div>
      </li>
      <li id="pinteresttheme17">
        <div >
          <a href="#">
            <span class="wpsocial-theme17-pinterest hvr-grow-rotate"></span>
          </a>
        </div>
      </li>
    </ul>
  </nav>
</div><!--End Container-->
</div>
</div>
<div id="includedskin14">
  <div class="col-md-12">
    <input id="whitestitchedborder" type="radio" name="wpsocial-skins" disabled /><label id="wpsocial-skins-label" for="whitestitchedborder">  White Stitched Border  (With Animation) <a target="_blank" href="http://www.wpsuperhero.com/add-social-share/"><b>Premium</b></a>  </label>
    <div  id="wpsocial-theme14" class="">
      <nav>
        <ul>
          <li id="facebooktheme14">
            <div><a href="#">
              <span class="wpsocial-theme14-facebook hvr-wobble-skew"></span>
            </a>
          </div>
        </li>
        <li id="twittertheme14">
          <div ><a href="#">
            <span class="wpsocial-theme14-twitter hvr-wobble-skew"></span>
          </a>
        </div>
      </li>
      <li id="google-plustheme14">
        <div >
          <a href="#"><span class="wpsocial-theme14-gplus hvr-wobble-skew"></span>
          </a>
        </div>
      </li>
      <li id="linkedintheme14">
        <div >
          <a href="#">
            <span class="wpsocial-theme14-linkedin hvr-wobble-skew"></span>
          </a>
        </div>
      </li>
      <li id="pinteresttheme14">
        <div >
          <a href="#">
            <span class="wpsocial-theme14-pinterest hvr-wobble-skew"></span>
          </a>
        </div>
      </li>
    </ul>
  </nav>
</div><!--End Container-->
</div>
</div>
<div id="includedskin15"><div class="col-md-12">
  <input id="whiterounded" type="radio" name="wpsocial-skins"  disabled /><label id="wpsocial-skins-label" for="whiterounded">  White Rounded (With Animation) <a target="_blank" href="http://www.wpsuperhero.com/add-social-share/"><b>Premium</b></a> </label>
  <div  id="wpsocial-theme15" class="">
    <nav>
      <ul>
        <li id="facebooktheme15">
          <div><a href="#">
            <span class="wpsocial-theme15-facebook hvr-bounce-out"></span>
          </a>
        </div>
      </li>
      <li id="twittertheme15">
        <div ><a href="#">
          <span class="wpsocial-theme15-twitter hvr-bounce-out"></span>
        </a>
      </div>
    </li>
    <li id="google-plustheme15">
      <div >
        <a href="#">
          <span class="wpsocial-theme15-gplus hvr-bounce-out"></span>
        </a>
      </div>
    </li>
    <li id="linkedintheme15">
      <div >
        <a href="#">
          <span class="wpsocial-theme15-linkedin hvr-bounce-out"></span>
        </a>
      </div>
    </li>
    <li id="pinteresttheme15">
      <div >
        <a href="#">
          <span class="wpsocial-theme15-pinterest hvr-bounce-out"></span>
        </a>
      </div>
    </li>
  </ul>
</nav>
</div><!--End Container-->
</div>  </div>
<!-- End Includeing Skins Using js -->
</div>
<!-- End All the Plugins Option's Container -->

</div>
</div>
</div>
</div>
</div>
<input id="wpsocial-selected-skin" type="hidden" value="<?php echo get_option("wpsocial-skins"); ?>"/>
<input id="wpsocial-selected-social-network1" name="wpsocial-selcetion-network" type="hidden" value="<?php echo get_option("wpsocial-facebook"); ?>"></input>
<input id="wpsocial-selected-social-network2" name="wpsocial-selcetion-network" type="hidden" value="<?php echo get_option("wpsocial-twitter"); ?>"></input>
<input id="wpsocial-selected-social-network3" name="wpsocial-selcetion-network" type="hidden" value="<?php echo get_option("wpsocial-google"); ?>"></input>
<input id="wpsocial-selected-social-network4" name="wpsocial-selcetion-network" type="hidden" value="<?php echo get_option("wpsocial-linkedin"); ?>"></input>
<input id="wpsocial-selected-social-network5" name="wpsocial-selcetion-network" type="hidden" value="<?php echo get_option("wpsocial-pinterest"); ?>"></input>
<input id="wpsocial-facebook-url" type="hidden" value="http://www.facebook.com/sharer.php?u=" . <?php echo $url; ?> ></input>
<input id="wpsocial-twitter-url" type="hidden" value="https://twitter.com/share?url=". <?php echo $url; ?>></input>
<input id="wpsocial-linkedin-url" type="hidden" value="http://www.linkedin.com/shareArticle?url=". <?php echo $url; ?>></input>
<input id="wpsocial-google-url" type="hidden" value="https://plus.google.com/share?url" . <?php echo $url; ?>></input>
<input id="wpsocial-pinterest-url" type="hidden" value="https://pinterest.com/pin/create/button/?url" .<?php echo $url; ?>></input>
</form>
<?php

}

function wpssi_sanitize_options($value){
  $value = stripslashes($value);
  $value = filter_var($value,FILTER_SANITIZE_STRING);

  return $value;
}
?>