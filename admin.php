<?php

function videojs_enqueue_color_picker() {
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'videojs-admin', plugins_url('admin.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
}
add_action('load-settings_page_videojs-settings', 'videojs_enqueue_color_picker');

function videojs_menu() {
	global $videojs_admin;
	$videojs_admin = add_options_page('Video.js Settings', 'Video.js Settings', 'manage_options', 'videojs-settings', 'videojs_settings');
}
add_action('admin_menu', 'videojs_menu');

/* Contextual Help */
function videojs_help($contextual_help, $screen_in, $screen) {
	global $videojs_admin;
	if ($screen_in == $videojs_admin) {
		$contextual_help = <<<_end_
		<p><strong>Video.js Settings Screen</strong></p>
		<p>The values set here will be the default values for all videos, unless you specify differently in the shortcode. Uncheck <em>Use CDN hosted version?</em> if you want to use a self-hosted copy of Video.js instead of the CDN hosted version. <strong>Using the CDN hosted version is preferable in most situations.</strong></p>
		<p>If you are using a responsive WordPress theme, you may want to check the <em>Responsive Video</em> checkbox.</p>
		<p>Uncheck the <em>Use the [video] shortcode?</em> option <strong>only</strong> if you are using WordPress 3.6+ and wish to use the [video] tag for MediaElement.js. You will still be able to use the [videojs] tag to embed videos using Video.js.</p>
_end_;
	}
	return $contextual_help;
}
add_filter('contextual_help', 'videojs_help', 10, 3);


function videojs_settings() {
	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
	?>
	<div class="wrap">
	<h2>Video.js Settings</h2>
	
	<form method="post" action="options.php">
	<?php
	settings_fields( 'videojs_options' );
	do_settings_sections( 'videojs-settings' );
	?>
	<p class="submit">
	<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
	</p>
	<h2>Using Video.js</h2>
	<?php echo file_get_contents(plugin_dir_path( __FILE__ ) . 'help.html'); ?>
	</form>
	</div>
	<?php
	
}
add_action('admin_init', 'register_videojs_settings');

function register_videojs_settings() {
	register_setting('videojs_options', 'videojs_options', 'videojs_options_validate');
	add_settings_section('videojs_defaults', 'Default Settings', 'defaults_output', 'videojs-settings');
	
	add_settings_field('videojs_width', 'Width', 'width_output', 'videojs-settings', 'videojs_defaults');
	add_settings_field('videojs_height', 'Height', 'height_output', 'videojs-settings', 'videojs_defaults');
	
	add_settings_field('videojs_preload', 'Preload', 'preload_output', 'videojs-settings', 'videojs_defaults');
	add_settings_field('videojs_autoplay', 'Autoplay', 'autoplay_output', 'videojs-settings', 'videojs_defaults');
	
	add_settings_field('videojs_responsive', 'Responsive Video', 'responsive_output', 'videojs-settings', 'videojs_defaults');
	
	add_settings_field('videojs_cdn', 'Use CDN hosted version?', 'cdn_output', 'videojs-settings', 'videojs_defaults');
	
	add_settings_field('videojs_color_one', 'Icon Color', 'color_one_output', 'videojs-settings', 'videojs_defaults');
	add_settings_field('videojs_color_two', 'Progress Color', 'color_two_output', 'videojs-settings', 'videojs_defaults');
	add_settings_field('videojs_color_three', 'Background Color', 'color_three_output', 'videojs-settings', 'videojs_defaults');
	
	add_settings_field('videojs_video_shortcode', 'Use the [video] shortcode?', 'video_shortcode_output', 'videojs-settings', 'videojs_defaults');
	
	add_settings_field('videojs_reset', 'Restore defaults upon plugin deactivation/reactivation', 'reset_output', 'videojs-settings', 'videojs_defaults');
}

/* Validate our inputs */

function videojs_options_validate($input) {
	$newinput['videojs_height'] = $input['videojs_height'];
	$newinput['videojs_width'] = $input['videojs_width'];
	$newinput['videojs_preload'] = $input['videojs_preload'];
	$newinput['videojs_autoplay'] = $input['videojs_autoplay'];
	$newinput['videojs_responsive'] = $input['videojs_responsive'];
	$newinput['videojs_cdn'] = $input['videojs_cdn'];
	$newinput['videojs_color_one'] = $input['videojs_color_one'];
	$newinput['videojs_color_two'] = $input['videojs_color_two'];
	$newinput['videojs_color_three'] = $input['videojs_color_three'];
	$newinput['videojs_reset'] = $input['videojs_reset'];
	$newinput['videojs_video_shortcode'] = $input['videojs_video_shortcode'];
	
	if(!preg_match("/^\d+$/", trim($newinput['videojs_width']))) {
		 $newinput['videojs_width'] = '';
	 }
	 
	 if(!preg_match("/^\d+$/", trim($newinput['videojs_height']))) {
		 $newinput['videojs_height'] = '';
	 }
	 
	 if(!preg_match("/#([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?\b/", trim($newinput['videojs_color_one']))) {
		 $newinput['videojs_color_one'] = '#ccc';
	 }
	 
	 if(!preg_match("/#([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?\b/", trim($newinput['videojs_color_two']))) {
		 $newinput['videojs_color_two'] = '#66A8CC';
	 }
	 
	 if(!preg_match("/#([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?\b/", trim($newinput['videojs_color_three']))) {
		 $newinput['videojs_color_three'] = '#000';
	 }
	
	return $newinput;
}

/* Display the input fields */

function defaults_output() {
	//echo '';
}

function height_output() {
	$options = get_option('videojs_options');
	echo "<input id='videojs_height' name='videojs_options[videojs_height]' size='40' type='text' value='{$options['videojs_height']}' />";
}

function width_output() {
	$options = get_option('videojs_options');
	echo "<input id='videojs_width' name='videojs_options[videojs_width]' size='40' type='text' value='{$options['videojs_width']}' />";
}

function preload_output() {
	$options = get_option('videojs_options');
	if($options['videojs_preload']) { $checked = ' checked="checked" '; } else { $checked = ''; }
	echo "<input ".$checked." id='videojs_preload' name='videojs_options[videojs_preload]' type='checkbox' />";
}

function autoplay_output() {
	$options = get_option('videojs_options');
	if($options['videojs_autoplay']) { $checked = ' checked="checked" '; } else { $checked = ''; }
	echo "<input ".$checked." id='videojs_autoplay' name='videojs_options[videojs_autoplay]' type='checkbox' />";
}

function responsive_output() {
	$options = get_option('videojs_options');
	if($options['videojs_responsive']) { $checked = ' checked="checked" '; } else { $checked = ''; }
	echo "<input ".$checked." id='videojs_responsive' name='videojs_options[videojs_responsive]' type='checkbox' />";
}

function cdn_output() {
	$options = get_option('videojs_options');
	if($options['videojs_cdn']) { $checked = ' checked="checked" '; } else { $checked = ''; }
	echo "<input ".$checked." id='videojs_cdn' name='videojs_options[videojs_cdn]' type='checkbox' />";
}

function color_one_output() {
	$options = get_option('videojs_options');
	echo "<input id='videojs_color_one' name='videojs_options[videojs_color_one]' size='40' type='text' value='{$options['videojs_color_one']}' data-default-color='#ccc' class='videojs-color-field' />";
}

function color_two_output() {
	$options = get_option('videojs_options');
	echo "<input id='videojs_color_two' name='videojs_options[videojs_color_two]' size='40' type='text' value='{$options['videojs_color_two']}' data-default-color='#66A8CC' class='videojs-color-field' />";
}

function color_three_output() {
	$options = get_option('videojs_options');
	echo "<input id='videojs_color_three' name='videojs_options[videojs_color_three]' size='40' type='text' value='{$options['videojs_color_three']}' data-default-color='#000' class='videojs-color-field' />";
}

function video_shortcode_output() {
	$options = get_option('videojs_options');
	if(array_key_exists('videojs_video_shortcode', $options)){
		if($options['videojs_video_shortcode']) { $checked = ' checked="checked" '; } else { $checked = ''; }
	} else { $checked = ' checked="checked" '; }
	echo "<input ".$checked." id='videojs_video_shortcode' name='videojs_options[videojs_video_shortcode]' type='checkbox' />";
}

function reset_output() {
	$options = get_option('videojs_options');
	if($options['videojs_reset']) { $checked = ' checked="checked" '; } else { $checked = ''; }
	echo "<input ".$checked." id='videojs_reset' name='videojs_options[videojs_reset]' type='checkbox' />";
}


/* Set Defaults */
register_activation_hook(plugin_dir_path( __FILE__ ) . 'video-js.php', 'add_defaults_fn');

function add_defaults_fn() {
	$tmp = get_option('videojs_options');
    if(($tmp['videojs_reset']=='on')||(!is_array($tmp))) {
		$arr = array("videojs_height"=>"264","videojs_width"=>"640","videojs_preload"=>"","videojs_autoplay"=>"","videojs_responsive"=>"","videojs_cdn"=>"on","videojs_color_one"=>"#ccc","videojs_color_two"=>"#66A8CC","videojs_color_three"=>"#000","videojs_video_shortcode"=>"on","videojs_reset"=>"");
		update_option('videojs_options', $arr);
		update_option("videojs_db_version", "1.0");
	}
}


/* Plugin Updater */
function update_videojs() {
	$videojs_db_version = "1.0";
	
	if( get_option("videojs_db_version") != $videojs_db_version ) { //We need to update our database options
		$options = get_option('videojs_options');
		
		//Set the new options to their defaults
		$options['videojs_color_one'] = "#ccc";
		$options['videojs_color_two'] = "#66A8CC";
		$options['videojs_color_three'] = "#000";
		$options['videojs_video_shortcode'] = "on";
		
		update_option('videojs_options', $options);
		
		update_option("videojs_db_version", $videojs_db_version); //Update the database version setting
	}
}
add_action('admin_init', 'update_videojs');

?>
