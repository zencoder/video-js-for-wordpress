<?php
/**
 * @package Video.js
 * @version 4.0.0
 */
/*
Plugin Name: Video.js - HTML5 Video Player for WordPress
Plugin URI: http://videojs.com/
Description: Self-hosted responsive HTML5 video for WordPress, built on the widely used Video.js HTML5 video player library. Allows you to embed video in your post or page using HTML5 with Flash fallback support for non-HTML5 browsers.
Author: <a href="http://www.nosecreekweb.ca">Dustin Lammiman</a>, <a href="http://steveheffernan.com">Steve Heffernan</a>
Version: 4.0.0
*/


$plugin_dir = plugin_dir_path( __FILE__ );


/* The options page */
include_once($plugin_dir . 'admin.php');


/* Include the script and css file in the page <head> */
function add_videojs_header(){
	$options = get_option('videojs_options');
	
	wp_register_style( 'videojs-plugin', plugins_url( 'plugin-styles.css' , __FILE__ ) );
	wp_enqueue_style( 'videojs-plugin' );
	
	if($options['videojs_cdn'] == 'on') { //use the cdn hosted version
		wp_register_script( 'videojs', 'http://vjs.zencdn.net/4.0/video.js' );
		wp_enqueue_script( 'videojs' );
		
		wp_register_style( 'videojs', 'http://vjs.zencdn.net/4.0/video-js.css' );
		wp_enqueue_style( 'videojs' );
	} else { //use the self hosted version
		wp_register_script( 'videojs', plugins_url( 'videojs/video.js' , __FILE__ ) );
		wp_enqueue_script( 'videojs' );
		
		wp_register_style( 'videojs', plugins_url( 'videojs/video-js.css' , __FILE__ ) );
		wp_enqueue_style( 'videojs' );
	}
	
	if($options['videojs_responsive'] == 'on') { //include the responsive stylesheet
		wp_register_style( 'responsive-videojs', plugins_url('responsive-video.css', __FILE__) );
		wp_enqueue_style( 'responsive-videojs' );
	}
}
add_action( 'wp_enqueue_scripts', 'add_videojs_header' );


/* Prevent mixed content warnings for the self-hosted version */
function add_videojs_swf(){
	$options = get_option('videojs_options');
	if($options['videojs_cdn'] != 'on') {
		echo '
		<script type="text/javascript">
			VideoJS.options.flash.swf = "'. plugins_url( 'videojs/video-js.swf' , __FILE__ ) .'";
		</script>
		';
	}
}
add_action('wp_head','add_videojs_swf');


/* The [video] shortcode */
function video_shortcode($atts, $content=null){
	
	$options = get_option('videojs_options'); //load the defaults
	
	extract(shortcode_atts(array(
		'mp4' => '',
		'webm' => '',
		'ogg' => '',
		'poster' => '',
		'width' => $options['videojs_width'],
		'height' => $options['videojs_height'],
		'preload' => $options['videojs_preload'],
		'autoplay' => $options['videojs_autoplay'],
		'loop' => '',
		'controls' => '',
		'id' => '',
		'class' => ''
	), $atts));

	// ID is required for multiple videos to work
	if ($id == '')
		$id = 'example_video_id_'.rand();

	// MP4 Source Supplied
	if ($mp4)
		$mp4_source = '<source src="'.$mp4.'" type=\'video/mp4\' />';
	else
		$mp4_source = '';

	// WebM Source Supplied
	if ($webm)
		$webm_source = '<source src="'.$webm.'" type=\'video/webm; codecs="vp8, vorbis"\' />';
	else
		$webm_source = '';

	// Ogg source supplied
	if ($ogg)
		$ogg_source = '<source src="'.$ogg.'" type=\'video/ogg; codecs="theora, vorbis"\' />';
	else
		$ogg_source = '';
	
	// Poster image supplied
	if ($poster)
		$poster_attribute = ' poster="'.$poster.'"';
	else
		$poster_attribute = '';
	
	// Preload the video?
	if ($preload == "auto" || $preload == "true" || $preload == "on")
		$preload_attribute = ' preload="auto"';
	elseif ($preload == "metadata")
		$preload_attribute = ' preload="metadata"';
	else 
		$preload_attribute = ' preload="none"';

	// Autoplay the video?
	if ($autoplay == "true" || $autoplay == "on")
		$autoplay_attribute = " autoplay";
	else
		$autoplay_attribute = "";
	
	// Loop the video?
	if ($loop == "true")
		$loop_attribute = " loop";
	else
		$loop_attribute = "";
	
	// Controls?
	if ($controls == "false")
		$controls_attribute = "";
	else
		$controls_attribute = " controls";
	
	// Is there a custom class?
	if ($class)
		$class = ' ' . $class;
	
	// Tracks
	if(!is_null( $content ))
		$track = do_shortcode($content);
	else
		$track = "";


	//Output the <video> tag
	$videojs = <<<_end_

	<!-- Begin Video.js -->
	<video id="{$id}" class="video-js vjs-default-skin{$class}" width="{$width}" height="{$height}"{$poster_attribute}{$controls_attribute}{$preload_attribute}{$autoplay_attribute}{$loop_attribute} data-setup="{}">
		{$mp4_source}
		{$webm_source}
		{$ogg_source}{$track}
	</video>
	<!-- End Video.js -->

_end_;
	
	if($options['videojs_responsive'] == 'on') { //add the responsive wrapper
		
		$ratio = ($height && $width) ? $height/$width*100 : 56.25; //Set the aspect ratio (default 16:9)
		
		$maxwidth = ($width) ? "max-width:{$width}px" : ""; //Set the max-width
		
		$videojs = <<<_end_
		
		<!-- Begin Video.js Responsive Wrapper -->
		<div style='{$maxwidth}'>
			<div class='video-wrapper' style='padding-bottom:{$ratio}%;'>
				{$videojs}
			</div>
		</div>
		<!-- End Video.js Responsive Wrapper -->
		
_end_;
	}
	
	return $videojs;

}
add_shortcode('video', 'video_shortcode');


/* The [track] shortcode */
function track_shortcode($atts, $content=null){
	extract(shortcode_atts(array(
		'kind' => '',
		'src' => '',
		'srclang' => '',
		'label' => '',
		'default' => ''
	), $atts));
	
	if($kind)
		$kind = " kind='" . $kind . "'";
	
	if($src)
		$src = " src='" . $src . "'";
	
	if($srclang)
		$srclang = " srclang='" . $srclang . "'";
	
	if($label)
		$label = " label='" . $label . "'";
	
	if($default == "true" || $default == "default")
		$default = " default";
	else
		$default = "";
	
	$track = "
		<track" . $kind . $src . $srclang . $label . $default . " />
	";
	
	return $track;
}
add_shortcode('track', 'track_shortcode');


/* TinyMCE Shortcode Generator */
function video_js_button() {
	if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
		return;
	if ( get_user_option('rich_editing') == 'true' ) {
		add_filter('mce_external_plugins', 'video_js_mce_plugin');
		add_filter('mce_buttons', 'register_video_js_button');
	}
}
add_action('init', 'video_js_button');

function register_video_js_button($buttons) {
	array_push($buttons, "|", "videojs");
	$options = get_option('videojs_options');
	echo('<div style="display:none"><input type="hidden" id="videojs-autoplay-default" value="' . $options['videojs_autoplay'] . '"><input type="hidden" id="videojs-preload-default" value="' . $options['videojs_preload'] . '"></div>'); //the default values from the admin screen, to be used by our javascript
	return $buttons;
}

function video_js_mce_plugin($plugin_array) {
	$plugin_array['videojs'] = plugins_url( 'mce-button.js' , __FILE__ );
	return $plugin_array;
}

?>
