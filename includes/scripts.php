<?php
/***********************************
*	SCRIPT CONTROLS
***********************************/

// add a custom admin stylesheet - this will be global for admin and also login
// Load styles into admin head on wp2yt uploader plugin page
// Load scripts into admin head on wp2yt uploader plugin page
function custom_admin_style($hook) {	
	if( $hook != 'toplevel_page_wp2yt_uploader' && $hook != 'settings_page_wp2yt_settings') {
		return;
	} else {
		// Styles
		wp_register_style( 'jquery-ui-css', '//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css');		
		wp_enqueue_style( 'jquery-ui-css' );		
		
		wp_register_style( 'jquery-joyride', plugin_dir_url(__FILE__).'css/minified/joyride-2.1-minified.css');	
		wp_enqueue_style( 'jquery-joyride' );				

		wp_register_style( 'wp2yt-admin-stylesheet',  plugin_dir_url(__FILE__).'css/minified/wp2yt_plugin_style_minified.css');	
		wp_enqueue_style( 'wp2yt-admin-stylesheet');
		
		// Scripts
		wp_register_script( 'google-jquery-ui', '//code.jquery.com/ui/1.10.3/jquery-ui.js');				
		wp_enqueue_script( 'google-jquery-ui' );

		// Scripts
		wp_register_script( 'jquery-joyride-js', plugin_dir_url(__FILE__).'js/minified/jquery.joyride-2.1.minified.js');				
		wp_enqueue_script( 'jquery-joyride-js' );		
		
		// Combined WP2YT-Admin.js, jQuery.Cookie.js, and tag-it.js
		wp_register_script( 'cookie_adminJS_tag-it', plugin_dir_url(__FILE__).'js/minified/cookie_adminJS_tag-it.js');				
		wp_enqueue_script( 'cookie_adminJS_tag-it' );				
		

	}	
}
add_action( 'admin_enqueue_scripts', 'custom_admin_style');


// Load scripts and styles into front end for shortcode use
function wp2yt_load_frontend_files() {		
		wp_register_style( 'wp2yt_front_end_style', plugin_dir_url(__FILE__).'css/minified/wp2yt_plugin_style_frontend_minified.css');		
		wp_enqueue_style( 'wp2yt_front_end_style' );			

		// wp_register_script( 'wp2yt-admin-jQuery-scripts', plugin_dir_url(__FILE__).'js/wp2yt-admin-jQuery-scripts.js');				
		// wp_enqueue_script( 'wp2yt-admin-jQuery-scripts' );
		
		wp_register_script( 'wp2yt_front_end_script', plugin_dir_url(__FILE__).'js/wp2yt_plugin_script_frontend.js');			
		wp_enqueue_script( 'wp2yt_front_end_script' );		

		wp_register_script( 'google-jquery-ui', '//code.jquery.com/ui/1.10.3/jquery-ui.js');				
		wp_enqueue_script( 'google-jquery-ui' );		

		wp_register_script( 'tag-it', plugin_dir_url(__FILE__).'js/tag-it.min.js');			
		wp_enqueue_script( 'tag-it' );
	
	// If use fit vid is checked, enqueue fluidVis.js, else if it is not checked do not load the file
	// used for avoiding plugin conflicts
	if(get_option('use_fitvid_checkbox')== true) :
			// Check if fluidVid is enqueued
			$handle = 'fluidVids.js';
			if (wp_script_is( $handle, 'enqueued' ))	{
				// if it is return;
				return;
			} else {
				// else register+enqueue the script
				wp_register_script( 'fluidVids.js', plugin_dir_url(__FILE__).'js/fluidvids.min.js');
				wp_enqueue_script( 'fluidVids.js' );
			}	
	endif;
}
add_action('wp_head','wp2yt_load_frontend_files');


// Load these scripts into the add media modal
function wp2yt_loadModalScripts() {	
	
		wp_register_script( 'google-jquery-ui', '//code.jquery.com/ui/1.10.3/jquery-ui.js');				
		wp_enqueue_script( 'google-jquery-ui' );						
		
		wp_register_style( 'jquery-ui-css', '//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css');		
		wp_enqueue_style( 'jquery-ui-css' );				

		wp_register_style( 'wp2yt-admin-stylesheet',  plugin_dir_url(__FILE__).'css/minified/wp2yt_plugin_style_minified.css');	
		wp_enqueue_style( 'wp2yt-admin-stylesheet');
		
		// Combined WP2YT-Admin.js, jQuery.Cookie.js, and tag-it.js
		wp_register_script( 'cookie_adminJS_tag-it', plugin_dir_url(__FILE__).'js/minified/cookie_adminJS_tag-it.js');				
		wp_enqueue_script( 'cookie_adminJS_tag-it' );		
		
}
add_action( 'admin_print_scripts-media-upload-popup', 'wp2yt_loadModalScripts');