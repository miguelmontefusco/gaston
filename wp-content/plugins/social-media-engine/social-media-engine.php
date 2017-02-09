<?php
/*
Plugin Name: Social Media Engine
Plugin URI: http://awothemes.pro/plugins/social-media-engine
Description: Social Media Plugin
Version: 1.0.2
Author: AwoThemes
Author URI: http://awothemes.pro

Copyright 2016  Eugene Cvasnii  (email: e.kvasnyi@awodev.pro)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * Scripts and styles
 */

function sme_scripts() {
	$plugin_url = plugin_dir_url( __FILE__ );
	 
	wp_enqueue_style( 'sme-stylesheet', $plugin_url .  'css/style.css', array(), '1.0', false );

    wp_enqueue_style( 'sme-font-awesome', $plugin_url .  'font-awesome/css/font-awesome.css', array(), '1.0', false );
}
add_action( 'wp_enqueue_scripts', 'sme_scripts' );


	// Add Shortcode
function sme_social_links_function( $shortcode_atts ) {
	
	// Attributes
	$shortcode_atts = shortcode_atts(
		array(
			'skin' => '',
			'shape' => '',
			'size' => '',
			'float' => '',
			'500px' => '',
			'behance' => '',
			'bitbucket' => '',
			'delicious' => '',
			'deviantart' => '',
			'digg' => '',
			'dribbble' => '',
			'etsy' => '',
			'facebook' => '',
			'flickr' => '',
			'foursquare' => '',
			'github' => '',
			'google-plus' => '',
			'instagram' => '',
			'lastfm' => '',
			'linkedin' => '',
			'medium' => '',
			'mixcloud' => '',
			'odnoklassniki' => '',
			'pinterest' => '',
			'quora' => '',
			'reddit' => '',
			'skype' => '',
			'slideshare' => '',
			'soundcloud' => '',
			'spotify' => '',
			'tumblr' => '',
			'twitter' => '',
			'vimeo' => '',
			'vk' => '',
			'wordpress' => '',
			'youtube' => ''
		),
		$shortcode_atts, 'sme_social_links'
	);

	ob_start();?>

	<?php
	
	$shortcode_class_array[] = 'sme-social-follow';
	$shortcode_class_array[] = trim($shortcode_atts['skin']);
	$shortcode_class_array[] = trim($shortcode_atts['shape']);
	$shortcode_class_array[] = trim($shortcode_atts['size']);
	$shortcode_class_array[] = trim($shortcode_atts['float']);
	
	$shortcode_class = trim(implode(' ', $shortcode_class_array));
	
	?>

	<div class="<?php echo $shortcode_class; ?>">
	
		<ul>
		
		<?php if($shortcode_atts['500px']):?>
			<li><a href="<?php echo $shortcode_atts['500px'];?>"><i class="fa fa-500px"></i></a></li>
		<?php endif;?>	
		
		<?php if($shortcode_atts['behance']):?>
			<li><a href="<?php echo $shortcode_atts['behance'];?>"><i class="fa fa-behance"></i></a></li>
		<?php endif;?>	
		
		<?php if($shortcode_atts['bitbucket']):?>		
			<li><a href="<?php echo $shortcode_atts['bitbucket'];?>"><i class="fa fa-bitbucket"></i></a></li>
		<?php endif;?>		
		
		<?php if($shortcode_atts['delicious']):?>
			<li><a href="<?php echo $shortcode_atts['delicious'];?>"><i class="fa fa-delicious"></i></a></li>
		<?php endif;?>	
		
		<?php if($shortcode_atts['deviantart']):?>			
			<li><a href="<?php echo $shortcode_atts['deviantart'];?>"><i class="fa fa-deviantart"></i></a>
		<?php endif;?>	
		
		<?php if($shortcode_atts['digg']):?>		
			<li><a href="<?php echo $shortcode_atts['digg'];?>"><i class="fa fa-digg"></i></a></li>
		<?php endif;?>	
		
		<?php if($shortcode_atts['dribbble']):?>		
			<li><a href="<?php echo $shortcode_atts['dribbble'];?>"><i class="fa fa-dribbble"></i></a></li>
		<?php endif;?>		
		
		<?php if($shortcode_atts['etsy']):?>		
			<li><a href="<?php echo $shortcode_atts['etsy'];?>"><i class="fa fa-etsy"></i></a></li>
		<?php endif;?>	
		
		<?php if($shortcode_atts['facebook']):?>		
			<li><a href="<?php echo $shortcode_atts['facebook'];?>"><i class="fa fa-facebook"></i></a></li>
		<?php endif;?>	
		
		<?php if($shortcode_atts['flickr']):?>		
			<li><a href="<?php echo $shortcode_atts['flickr'];?>"><i class="fa fa-flickr"></i></a></li>
		<?php endif;?>	
		
		<?php if($shortcode_atts['foursquare']):?>		
			<li><a href="<?php echo $shortcode_atts['foursquare'];?>"><i class="fa fa-foursquare"></i></a></li>
		<?php endif;?>	
		
		<?php if($shortcode_atts['github']):?>		 
			<li><a href="<?php echo $shortcode_atts['github'];?>"><i class="fa fa-github"></i></a></li>
		<?php endif;?>	
		
		<?php if($shortcode_atts['google-plus']):?>		
			<li><a href="<?php echo $shortcode_atts['google-plus'];?>"><i class="fa fa-google-plus"></i></a></li>
		<?php endif;?>	
		
		<?php if($shortcode_atts['instagram']):?>		
			<li><a href="<?php echo $shortcode_atts['instagram'];?>"><i class="fa fa-instagram"></i></a></li>
		<?php endif;?>	
		
		<?php if($shortcode_atts['lastfm']):?>
			<li><a href="<?php echo $shortcode_atts['lastfm'];?>"><i class="fa fa-lastfm"></i></a></li>
		<?php endif;?>	
		
		<?php if($shortcode_atts['linkedin']):?>
			<li><a href="<?php echo $shortcode_atts['linkedin'];?>"><i class="fa fa-linkedin"></i></a></li>
		<?php endif;?>	
		
		<?php if($shortcode_atts['medium']):?>			
			<li><a href="<?php echo $shortcode_atts['medium'];?>"><i class="fa fa-medium"></i></a></li>
		<?php endif;?>	
		
		<?php if($shortcode_atts['mixcloud']):?>		
			<li><a href="<?php echo $shortcode_atts['mixcloud'];?>"><i class="fa fa-mixcloud"></i></a></li>
		<?php endif;?>	
		
		<?php if($shortcode_atts['odnoklassniki']):?>			
			<li><a href="<?php echo $shortcode_atts['odnoklassniki'];?>"><i class="fa fa-odnoklassniki"></i></a></li>
		<?php endif;?>	
		
		<?php if($shortcode_atts['pinterest']):?>		
			<li><a href="<?php echo $shortcode_atts['pinterest'];?>"><i class="fa fa-pinterest"></i></a></li>
		<?php endif;?>	
		
		<?php if($shortcode_atts['quora']):?>		
			<li><a href="<?php echo $shortcode_atts['quora'];?>"><i class="fa fa-quora"></i></a></li>
		<?php endif;?>	
		
		<?php if($shortcode_atts['reddit']):?>		
			<li><a href="<?php echo $shortcode_atts['reddit'];?>"><i class="fa fa-reddit"></i></a></li>
		<?php endif;?>	
		
		<?php if($shortcode_atts['skype']):?>
			<li><a href="<?php echo $shortcode_atts['skype'];?>"><i class="fa fa-skype"></i></a></li>
		<?php endif;?>	
		
		<?php if($shortcode_atts['slideshare']):?>		
			<li><a href="<?php echo $shortcode_atts['slideshare'];?>"><i class="fa fa-slideshare"></i></a></li>
		<?php endif;?>	
		
		<?php if($shortcode_atts['soundcloud']):?>		
			<li><a href="<?php echo $shortcode_atts['soundcloud'];?>"><i class="fa fa-soundcloud"></i></a></li>
		<?php endif;?>	
		
		<?php if($shortcode_atts['spotify']):?>		
			<li><a href="<?php echo $shortcode_atts['spotify'];?>"><i class="fa fa-spotify"></i></a></li>
		<?php endif;?>	
		
		<?php if($shortcode_atts['tumblr']):?>
			<li><a href="<?php echo $shortcode_atts['tumblr'];?>"><i class="fa fa-tumblr"></i></a></li>
		<?php endif;?>	
		
		<?php if($shortcode_atts['twitter']):?>		
			<li><a href="<?php echo $shortcode_atts['twitter'];?>"><i class="fa fa-twitter"></i></a></li>
		<?php endif;?>	
		
		<?php if($shortcode_atts['vimeo']):?>		
			<li><a href="<?php echo $shortcode_atts['vimeo'];?>"><i class="fa fa-vimeo"></i></a></li>
		<?php endif;?>	
		
		<?php if($shortcode_atts['vk']):?>		
			<li><a href="<?php echo $shortcode_atts['vk'];?>"><i class="fa fa-vk"></i></a></li>
		<?php endif;?>	
		
		<?php if($shortcode_atts['wordpress']):?>		
			<li><a href="<?php echo $shortcode_atts['wordpress'];?>"><i class="fa fa-wordpress"></i></a></li>
		<?php endif;?>	
		
		<?php if($shortcode_atts['youtube']):?>		
			<li><a href="<?php echo $shortcode_atts['youtube'];?>"><i class="fa fa-youtube"></i></a></li>	
		<?php endif;?>	
		
		</ul>
		
	</div>
	
	<?php
		
	$shortcode_atts = ob_get_contents();
	ob_end_clean();
	return $shortcode_atts;
	
}

add_shortcode( 'sme_social_links', 'sme_social_links_function' );