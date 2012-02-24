<?php

if( is_admin() ) {
	add_action('admin_menu', 'videojs_menu');
	add_action('admin_init', 'register_videojs_settings');
}

function videojs_menu() {
	add_options_page('Video.js Settings', 'Video.js Settings', 'manage_options', 'videojs-settings', 'videojs_settings');
}

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
	</form>
	</div>
	<?php
	
}

function register_videojs_settings() {
	register_setting('videojs_options', 'videojs_options', 'videojs_options_validate');
	add_settings_section('videojs_defaults', 'Default Settings', 'defaults_output', 'videojs-settings');
	
	add_settings_field('videojs_width', 'Width', 'width_output', 'videojs-settings', 'videojs_defaults');
	add_settings_field('videojs_height', 'Height', 'height_output', 'videojs-settings', 'videojs_defaults');
	
	add_settings_field('videojs_preload', 'Preload', 'preload_output', 'videojs-settings', 'videojs_defaults');
	add_settings_field('videojs_autoplay', 'Autoplay', 'autoplay_output', 'videojs-settings', 'videojs_defaults');
	
	add_settings_field('videojs_cdn', 'Use CDN hosted version?', 'cdn_output', 'videojs-settings', 'videojs_defaults');
	
	add_settings_field('videojs_reset', 'Restore defaults upon plugin deactivation/reactivation', 'reset_output', 'videojs-settings', 'videojs_defaults');
}

/* Validate our inputs */

function videojs_options_validate($input) {
	$newinput['videojs_height'] = $input['videojs_height'];
	$newinput['videojs_width'] = $input['videojs_width'];
	$newinput['videojs_preload'] = $input['videojs_preload'];
	$newinput['videojs_autoplay'] = $input['videojs_autoplay'];
	$newinput['videojs_cdn'] = $input['videojs_cdn'];
	$newinput['videojs_reset'] = $input['videojs_reset'];
	
	if(!preg_match("/^\d+$/", trim($newinput['videojs_width']))) {
		 $newinput['videojs_width'] = '';
	 }
	 
	 if(!preg_match("/^\d+$/", trim($newinput['videojs_height']))) {
		 $newinput['videojs_height'] = '';
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

function cdn_output() {
	$options = get_option('videojs_options');
	if($options['videojs_cdn']) { $checked = ' checked="checked" '; } else { $checked = ''; }
	echo "<input ".$checked." id='videojs_cdn' name='videojs_options[videojs_cdn]' type='checkbox' />";
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
		$arr = array("videojs_height"=>"264","videojs_width"=>"640","videojs_preload"=>"","videojs_autoplay"=>"","videojs_cdn"=>"on","videojs_reset"=>"");
		update_option('videojs_options', $arr);
	}
}

?>
