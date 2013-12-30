<?php
/*
Plugin Name: WP2YT Uploader
Plugin URI: www.Evan-Herman.com/wp-plugins/WP2YT-UploaderPlugin
Description: Upload videos right to your YouTube account, and insert them in to posts without having to leave your blog!
Author: <a href="http://www.evan-herman.com">Evan Herman</a>
Version: 1.0

	Copyright 2013  Evan Herman (email : Evan.M.Herman@gmail.com)
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 


    published by the Free Software Foundation.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/

/***********************************
*	GLOBAL VARIABLES
***********************************/
// Plugin name
$wp2yt_plugin_name = 'WP2YT Uploader';

// retrieve our plugin settings from the options table
$wp2yt_options = get_option('wp2yt_settings');

// Declare Plugin Version Number
$version_num = '1.0';


/***********************************
*	INCLUDES
***********************************/
/* path to any included files */
include(dirname(__FILE__) . '/includes/scripts.php'); // this controls all js/css
include(dirname(__FILE__) . '/includes/display-functions.php'); // display content functions


// on plugin activation
register_activation_hook(__FILE__, 'my_plugin_activate');
add_action('admin_init', 'my_plugin_redirect');

function my_plugin_activate() {
    add_option('my_plugin_do_activation_redirect', true);
}

function my_plugin_redirect() {
    if (get_option('my_plugin_do_activation_redirect', false)) {
        delete_option('my_plugin_do_activation_redirect');
        if(!isset($_GET['activate-multi']))
        {
            wp_redirect("options-general.php?page=wp2yt_settings");
        }
    }
}

//Create 'add-media' menu for new form
function youtube_wp_upload_tabs ($tabs) {
	
	$new_tab = array('youtube_uploader' => 'WordPress To Youtube Uploader');
	$ret = array_merge($tabs,$new_tab);
	return $ret;
	
}
add_filter('media_upload_tabs', 'youtube_wp_upload_tabs');

// change a few styles depending on color scheme <= for readability
function get_admin_color_scheme() { 

	$current_color = get_user_option( 'admin_color', get_current_user_id() );

	

	
	if ( $current_color == 'light' ) {
		echo '<style>#wp2yt-tabs ul.ui-tabs-nav li a { color:#333;}#wp2yt_progress_bar{background-color:#A8A8A8;}.wp2yt-active-link{color:#333 !important;}</style>';	
	} else if ($current_color == 'blue') {
		echo '<style>#wp2yt-tabs ul.ui-tabs-nav li.ui-state-active > a { color:#333 !important; }#wp2yt-tabs ul.ui-tabs-nav li a:hover{color:#333;}</style>';
	}
	
}
add_action('admin_head','get_admin_color_scheme');

//Create Menu Page
function wp2yt_add_menu_page(){
	
	add_menu_page( 'WP2YT Uploader', 
							  'WP2YT Uploader', 
							  'manage_options', 
							  'wp2yt_uploader', 
							  'wp2yt_menu_validate',
							  plugins_url( '/WP2YT-Uploader/includes/images/youtube-color-icon.png' )
							); 						  
}
add_action('admin_menu', 'wp2yt_add_menu_page');

function wp2yt_menu_validate() {
?>
    <!-- start main plugin content -->
	<div class="main-plugin-content">
<html lang="en">
	<head>

		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
				<title>Wordpress to Youtube Uploader Plugin </title>
	
	<style>
		#wpfooter { display:none; }
		.blueNavLinkActiveOverride { color:#333 !important; }
	</style>
	</head>

<body>

<!-- pre loader gif as plugin styles/js files initialize -->
<div class="wp2yt-page-load-image" style="opacity:0;">
	<img src="<?php echo esc_attr(plugins_url( '/WP2YT-Uploader/includes/images/loading.gif' ));?>" alt="page-load-gif" />
</div>

<div id="wp2yt-tabs" style="opacity:0;height:738px;min-height:650px;">

<?php $yt_anlytics_switch = get_option('use_yt_analytics_checkbox'); ?>

<?php if(get_option('use_yt_analytics_checkbox')== true) : ?>
<!-- tabs on the wp2yt page with analytics checkbox true; show analytic tab -->
<ul>
    <li class="new_content"><a href="#tabs-1" class="wp2yt-active-link"><span class="wp2yt-icon-upload-2"><i>  </i></span>Upload New Content</a></li>
    <li class="currcont"><a href="#tabs-2"><span class="wp2yt-icon-history"><i>  </i></span>Recent Uploads</a></li>
    <li class="analytics"><a href="#tabs-3"><span class="wp2yt-icon-stats"><i>  </i></span>Analytics <i style="font-size:9px;">(beta)</i></a></li>
	<li class="help"><a href="#tabs-4"><span class="wp2yt-icon-question"><i>  </i></span>Help?</a></li>
 </ul>

<?php else : ?>

<!-- tabs on the wp2yt page with anayltics checkbox false; hide analytic tab-->
<ul>
    <li class="new_content"><a href="#tabs-1" class="wp2yt-active-link"><span class="wp2yt-icon-upload-2"><i>  </i></span>Upload New Content</a></li>
    <li class="currcont"><a href="#tabs-2"><span class="wp2yt-icon-history"><i>  </i></span>Recent Uploads</a></li>
	<li class="analytics"><a href="#tabs-3" style="display:none;"><span class="wp2yt-icon-stats"><i>  </i></span>Analytics <i style="font-size:9px;">(beta)</i></a></li>
	<li class="help"><a href="#tabs-4"><span class="wp2yt-icon-question"><i>  </i></span>Help?</a></li>
</ul>



 <?php endif; ?>

 <div class="wp2yt-tab-content-holder" style="height:auto;">
  <div id="tabs-1">
	<h2 class="title"><span class="wp2yt-icon-upload-2" style="font-size:35px;"><i>  </i></span>Upload New Content To Your YouTube Channel </h2>

	<hr class="wp2yt-hr"/>

	<div class="upload_content">

	<div class="youtube-upload-logo">

	</div>

	<!-- function to display uploader form -->
	<?php uploader_form(); ?>

	</div> <!-- end new content div -->

  </div> <!-- end tabs-1 div -->

  <div id="tabs-2">
    	<script>
	jQuery(document).ready(function() {
		var headerColor = jQuery("#wpadminbar").css("background-color");
		jQuery("#wp2yt-tabs").find("ul:first-child").css("background-color",headerColor);
		// console.log(headerColor);
	});
	</script>
	<script>
		// run on load to check url
		// extract access token from URL function
				function getParam(hash, key) {
					var kvpairs = hash.substring(1).split('&');

					for (var i = 0; i < kvpairs.length; i++) {
						var kvpair = kvpairs[i].split('=');

						var k = kvpair[0];
						var v = kvpair[1];

						if (k != key)
							continue;

						return v;
					}    

					return null;
				}
			
			var currentURL = window.location.hash;
			
			if(currentURL.indexOf ('#access_token') != -1 ) {
				// if it contains the access token
					// store access token from url in to variable
					var ytAccessKey = getParam(document.location.hash, 'access_token');
					// create the cookie with access key stored in it - should limit to 1 hour not 1 day
					jQuery.cookie('ytAccessKey', ytAccessKey, { expires: new Date(+new Date() + (60 * 60 * 1000)) });
					// set wp2yt to value of ytAccessKey cookie	
					var wp2ytCookie = jQuery.cookie('ytAccessKey');
			} 
		
	<!-- refresh your playlist and show loading gif + retreive new data for uploaded videos -->
	function wp2yt_get_my_uploads() {	
		
	/* store account name variable to pass to refresh file */
	<?php $account = get_option('yt_account'); ?>	

			// hide deletion error message on page refresh
			jQuery('.noAuthCodeError').animate({
				height:"0px",
				background: "transparent"
			}, function() {
				jQuery(this).addClass("error");
			});
					
			
			// jQuery('#ytu_recent_upload_content').css('min-height','565px');
	
		
				jQuery('.wp2yt-refresh-playlists').attr('disabled',true);
								
				jQuery('#ytu_recent_upload_content > .scrollable-content').fadeTo('fast',0, function() {
					
					jQuery(this).remove();
					 
					jQuery('#ytu_recent_upload_content').animate({
						height:'565px'
					}).css({'overflow-x':'scroll'});
					
					
					setTimeout(function() {
						jQuery('#ytu_recent_upload_content').append('<img class="loading_playlist_gif" style="opacity:0; border:none !important; box-shadow:none; height:75px; display:table; margin:0 auto; margin-top:12.5em;" src="<?php echo plugins_url( '/WP2YT-Uploader/includes/images/loading_playlists_gif.gif' );?>"/>');			
						jQuery('#ytu_recent_upload_content').append('<i class="retreiving_text" style="display:table; margin:0 auto; opacity:0;" class="wp2yt-red">Retreiving your playlist data...</i>');			
					
						jQuery('.retreiving_text').fadeTo('fast',1);
						jQuery('.loading_playlist_gif').fadeTo('fast',1);
					}, 450);
					

				});
					

						setTimeout(function() {
							/* add account variable to end of load to pass variable along to refresh file that is loaded in */
							 jQuery('#ytu_recent_upload_content').load('<?php echo esc_attr(plugins_url( '/WP2YT-Uploader/includes/refresh_main_playlist.php' ));?>?account=<?php echo $account; ?>' , function( response, status, xhr ) {
							  if ( status == "error" ) {

								// jQuery('#ytu_recent_upload_content').css({'height':'227px','min-height':'227px'});
								
								jQuery('#ytu_recent_upload_content').animate({
									height:'227px'
								});
								
								var msg = "<p class='500-internal-error' style='margin-top:4em; display:none;'><img style='height:2%;border:none;margin-bottom:0;margin-top:-1em;box-shadow:none;' alt='' id='red-x' src='<?php echo esc_url(plugins_url( '/WP2YT-Uploader/includes/images/red-x.png' ));?>' /><br />Sorry but there was an <span class='wp2yt-red'>error</span>. This usually occurs when the account name doesn't exist, <br /> was typed incorrectly or the YouTube channel isn't set up correctly. <br /> If you are still having issues check the <a href='http://www.evan-herman.com/wp2yt-documentation/' target='_blank' >documentation</a>.</p>";
								setTimeout(function() {
									jQuery('#ytu_recent_upload_content').css({'text-align':'center'}).html(msg);
									jQuery('.500-internal-error').fadeIn();
									jQuery('#ytu_recent_upload_content').css('height','227px');
								}, 500);
							  } else {
								jQuery(this).find('.scrollable-content').hide().fadeIn();
							  }
							});
							
							 jQuery('.loading_playlist_gif').fadeOut();
							 jQuery('.retreiving_text').fadeOut();
							 
							 setTimeout(function() {
								jQuery('.wp2yt-refresh-playlists').attr('disabled',false);
							}, 3000);
							 							 
						}, 1800);	
						
			}
		
	/* delete video function */
	function wp2yt_delete_video() {
		<?php $account = get_option('stv_oauth2_text'); ?>
	
		if (confirm('Are you sure you want to delete this video from your account?')) {
		
			<?php if(empty($account)) : ?>
				
				jQuery('.noAuthCodeError').removeClass("error").css("display","block").animate({
					height:"65px",
					background: "#ffebe8"
				});
				
			<?php elseif(!empty($account)) : ?>	
			// check if cookie exists with access key
			// check if cookie is still valid
			// send request here with access key set https://www.googleapis.com/youtube/v3/channels/?part=id,snippet,contentDetails,statistics,topicDetails&mine=true&access_token=
			// if valid, continue to delete video
			// if not valid or not set, redirect to get access token => create cookie => store access key in cookie => delete video with new access token
			
			// get UniqueID of selected video
			var thisUniqueID = jQuery(this).parents('#videos').find('input[name="uniqueVideoID"]').val();
			var thisDeleteVideo = jQuery(this).parents('#videos');		
				
			// declare variables
			<?php $googleAuthKey = get_option('stv_oauth2_text'); ?>
			<?php $siteURL =  get_site_url(); ?>
			
			// if cookie is found => send delete request; else proceed to get token
			if(jQuery.cookie("ytAccessKey")){
				var wp2ytCookie = jQuery.cookie('ytAccessKey');
				// AJAX delete call, must get YOUTUBE access key
				jQuery.ajax({
					type: 'DELETE',
					url: 'https://www.googleapis.com/youtube/v3/videos?id='+ thisUniqueID + '&key=<?php echo esc_html($googleAuthKey); ?>',
					beforeSend: function(xhr){xhr.setRequestHeader('Authorization', 'Bearer '+ wp2ytCookie);},
					success: function() {
						thisDeleteVideo.fadeOut('slow', function() {
							jQuery(this).remove();
						});
						
					},
					error: function() {
						alert('There was an error with your request.'+'\n\n'+'If you previously deleted the video, please wait for your YouTube account cache to refresh.'+'\n\n'+'If these videos are\'nt on an account you own, you can\'t delete videos you don\'t own.');
					}
				}); 
			} else {
				if (confirm('You must get an access token to delete a video. Tokens are good for 1 hour. Do you want to refresh the page and get a token now?')) {
					window.location.replace("https://accounts.google.com/o/oauth2/auth?client_id=<?php echo esc_html($googleAuthKey); ?>&redirect_uri=<?php echo esc_url($siteURL); ?>/wp-admin/admin.php?page=wp2yt_uploader/&scope=https://gdata.youtube.com&response_type=token");
				} else {
					return;
				}
			}
			<?php endif; ?>	
				
			} else {
			// do nothing.
		}	
	}
	</script> 
	
	<div class="error noAuthCodeError"><img alt="" id="red-x" src="<?php echo esc_url(plugins_url( '/WP2YT-Uploader/includes/images/red-x.png' ));?>" /><strong> Error:</strong>You are required to provide an OAUTH2 ID before you can delete a video. Please retreive one <a href="https://code.google.com/apis/console" target="_blank">here</a>.</div>
 
	<h2 class="title"><span class="wp2yt-icon-history" style="font-size:35px;"><i>  </i></span>Recent Uploads</h2>	
	
		<hr class="wp2yt-hr"/>

		<div class="recent_uploads" style="display:none;">
		
		<!-- if cookie exists show a cookie image, if not remove cookie image -->
		<script>
		jQuery(document).ready(function() {
			if(jQuery.cookie("ytAccessKey")){
				jQuery(".wp2yt-refresh-playlists").before("<img title='This represents your YouTube access cookie, which allows you to delete videos. This will not be visible once your cookie expires.' class='http-cookie-image' src='<?php echo esc_url(plugins_url( "/WP2YT-Uploader/includes/images/http-cookie-icon.jpg" ));?>' alt='You Have A Cookie!' >")
			}
			
		});
		</script>
		<!-- refresh playlist button -->
		<button class="btn btn-small btn-inverse wp2yt-refresh-playlists" onclick="wp2yt_get_my_uploads()"><img alt='refresh icon' id="wp2yt-refresh-icon" src="<?php echo esc_url(plugins_url( '/WP2YT-Uploader/includes/images/refresh.png' ));?>" />Refresh Playlist</button>

		<div id="get_playlists_div_holder">
		<?php require(dirname(__FILE__) . '/includes/get_playlists.php'); ?>
		</div>
		
		</div> <!-- end recent_uploads div -->

  </div> <!-- end tabs-2 div -->

  <div id="tabs-3">

		<!-- check if oauth2 key is set; if oauth2 is not set -->
		<?php $oauth2id = get_option('stv_oauth2_text'); ?>
				
		<?php if(empty($oauth2id)) : ?>

		<h2 class="title"><span class="wp2yt-icon-stats" style="font-size:35px;"><i>  </i></span style="font-size:10px; font-style:italic;padding-left:3px;">YouTube Analytics<span class="wp2yt-blue">(beta)</span></h2>

		<hr class="wp2yt-hr"/>

		<div class="analytics_page" style="display:none;">

			<h3 class="wp2yt-red"><img alt='' id="red-x" src="<?php echo esc_url(plugins_url( '/WP2YT-Uploader/includes/images/red-x.png' ));?>" /> Error <img alt='' id="red-x" src="<?php echo esc_url(plugins_url( '/WP2YT-Uploader/includes/images/red-x.png' ));?>" /> </h3>

				<p id="missing-information"><i>You are missing your <b>OAUTH2 Client ID</b>. You can get one from <a href="https://code.google.com/apis/console" target="_blank">Googles API Console</a>. Please direct yourself to the <i><a href="<?php echo admin_url() . 'options-general.php?page=wp2yt_settings';?>">'WP2YT Uploader Settings'</a></i> page and input your <b>OAUTH2 Client ID</b> if you would like to use the analytics tab.</i></p>
		</div> <!-- end alaytics page -->

		<!-- check if oauth2 key is set;if oauth2 is set -->
		<?php elseif(!empty($oauth2id)) : ?>

		<h2 class="title"><span class="wp2yt-icon-stats" style="font-size:35px;"><i>  </i></span>YouTube Analytics<span class="wp2yt-blue" style="font-size:10px; font-style:italic;padding-left:3px;">(beta)</span></h2>

		<hr class="wp2yt-hr"/>

		<div class="analytics_page">

		
		<!-- include youtube_analytics.php on the analytics page only if analytics option is selected -->
		<?php 
			if (get_option('use_yt_analytics_checkbox')==true) {
				wp_register_script('jsapi', '//www.google.com/jsapi');
				wp_register_script('client.js', 'https://apis.google.com/js/client.js?onload=onJSClientLoad');
				require(dirname(__FILE__) . '/includes/youtube_analytics/youtube_analytics.php');
								
				?><script>
					jQuery(document).ready(function() {
						setTimeout(function() {
							if(jQuery('.post-auth').css('display') == 'none' && jQuery("#login-container").css('display') == 'none') {
								jQuery('.analytics_page').append('<img alt="" id="red-x" src="<?php echo esc_url(plugins_url( '/WP2YT-Uploader/includes/images/red-x.png' ));?>" /><p style="width:550px; margin-top:0;"><i>Oh no! It looks like there was an error retreiving your analytics data. This usually occurs '+
																							'when you have mistyped your OAUTH2 Client ID. Double check you have set up and entered your client id properly.</p>'+
								
																							'<p style="width:550px;"><span class="wp2yt-green">tip </span> you can follow the tutorial in the documentation <a href="http://www.evan-herman.com/wp2yt-documentation/" target="blank">here</a>.</p>'+
								
																							'<p style="width:550px;"> <span class="wp2yt-red">note </span>make sure you have entered a valid OAUTH2 client id and it is linked to your YouTube account.</i></p>');
							
							} else {
								return;
							}
						}, 2000);
					});
				</script><?php
				
				/* enqueue scripts needed for analytics access */
				wp_enqueue_script('jsapi');
				wp_enqueue_script('client.js');
				} 
		?>

		</div><!-- end analytics page -->

	<?php endif; ?>

   </div> <!-- end tabs-3 div -->

   <div id="tabs-4"> <!-- start tabs 4 -->
		<h2 class="title"><span class="wp2yt-icon-question" style="font-size:35px;"><i>  </i></span>Need Help?</h2>
		
		<div class="help_page">

		<!-- help page navigation menu -->
		<ul>
			<li class="about_btn" style="float:left; padding-right: 9px;"><a class="button-secondary"><span class="wp2yt-icon-info"><i> </i></span>About</a></li>
			<li class="uploader_btn" style="float:left;"><a class="button-secondary"><span class="wp2yt-icon-upload-2"><i> </i></span>Uploader</a></li>
			<li class="cc_btn" class="button-secondary" style="float:left; padding-left: 9px;"><a class="button-secondary" ><span class="wp2yt-icon-history"><i> </i></span>Recent Uploads</a></li>
			<li class="analytics_btn" style="float:left; padding-left: 9px;"><a class="button-secondary"><span class="wp2yt-icon-question"><i> </i></span>OAUTH2 Help</a></li>
			<li class="feedback_btn" style="float:left; padding-left: 9px;"><a class="button-secondary"><span class="wp2yt-icon-envelope"><i> </i></span>Feedback</a></li>
		</ul>

		<hr class="wp2yt-hr"/>
			
			<!-- content holder for help page -->
			<div id="inner_holder_div">
			
			<!-- if on about page, keep the about button active -->
			<script>jQuery(document).ready(function(){ jQuery('.about_btn > a').addClass('wp2yt-active-link'); }); </script>
				
					<div id="help_page_about_div" class="inner_content">
						<h3>WordPress 2 YouTube Uploader Plugin <i>(ver. <?php global $version_num; echo esc_html($version_num); echo ')</i>';?></h3>

							<p style="padding-left:8px;"><i>This plugin was created to ease the burdon of uploading content to the
								  users YouTube account. It removes the need to leave your blog to upload
								  content. Now you can upload content right from your WordPress dashboard
								  directly to Youtube. Upon completion you can post the video
								  directly in to a new/existing post.</i>
								  </p>
								  
					</div> <!-- end help_page_about_div -->

					<div id="help_page_uploader_div" class="inner_content" style="display:none;">
					
						<h3>Using The Uploader</h3>

							<p style="padding-left:8px;">To use the 'WordPress 2 YouTube Uploader' go in to the <a href='<?php echo site_url(); ?>/wp-admin/options-general.php?page=wp2yt_settings'>WP2YT Uploader Settings</a> menu and input your <b>Youtube E-Mail Address</b> and your <b>Youtube Password</b>.</p>

							<li style="padding-left:15px; font-size:11px;"><i>If you are having problems uploading new content make sure you have entered your <i class="wp2yt-green">YouTube e-mail Address</i> and not your <i class="wp2yt-red">account name</i>.</i></li>

							<li style="padding-left:15px; font-size:11px;"><i><b class="wp2yt-green">Tip:  </b> Use the account/password verification utility on the settings page to confirm your account and password are correct.</i></li>							
							

					</div> <!-- end help_page_uploader_div -->

					<div id="help_page_recent_uploads_div" class="inner_content" style="display:none;">

						<h3>Setting Up 'Recent Uploads'</h3>

							<p style="padding-left:8px;">To gain access to your recent uploads go in to the <a href='<?php echo site_url(); ?>/wp-admin/options-general.php?page=wp2yt_settings'>WP2YT Uploader Settings</a> page and input your <b>YouTube Account Name</b>.</p>

									<br/>

									<li style="padding-left:15px; font-size:11px;"><i><b class="wp2yt-green">Tip:  </b> You can access other users uploaded content as well. Go into the settings page and insert their <b>YouTube Account Name</b></i></li>

									<li style="padding-left:15px; font-size:11px;"><i><b class="wp2yt-green">Tip:  </b> For help with retreiving your account name view the documentation <a href="http://www.evan-herman.com/wp2yt-documentation/" target="_blank">here</a></i>.</i></li>																		
									
									<li style="padding-left:15px; font-size:11px;"><i>If you are having trouble accessing yours or other users content, double check that
									you enetered your account name correctly.</i></li>
									
									<li style="padding-left:15px; font-size:11px;"><i>Make sure you have entered your <i class="wp2yt-green">account name</i> and not your <i class="wp2yt-red">YouTube email address</i>.</i></li>
																		
					</div> <!-- end help_page_recent_uploads_div -->

					
					<div id="help_page_oauth2help_div" class="inner_content" style="display:none;">

						<h3>Getting an OAUTH2 ID</h3>

						<p>For a step-by-step tutorial on how to set up your API console and retreive an OAUTH2 client ID check the first help topic in the documentation <a href="http://www.evan-herman.com/wp2yt-documentation/" target="_blank">here</a>.</p>

					</div>	 <!-- end help_page_oauth2help_div -->


					<div id="help_page_feedback_div" class="inner_content" style="display:none;">

			<!-- ajax form submission -->

				<script>
					jQuery(document).ready(function() {

					jQuery('.done').hide();

					//if submit button is clicked
					jQuery('#submit').click(function () {        
			
						//Get the data from all the fields
						var name = jQuery('input[name=name]');
						var email = jQuery('input[name=email]');
						var website = jQuery('input[name=website]');
						var comment = jQuery('textarea[name=comment]');
						var reason = jQuery('select[name=reason]');

						//Simple validation to make sure user entered something
						//If error found, add hightlight class to the text field
						if (name.val()=='') {

							name.addClass('hightlight');

							return false;
							
						} else name.removeClass('hightlight');
			
						if (email.val()=='') {

							email.addClass('hightlight');

							return false;

						} else email.removeClass('hightlight');
			
						if (comment.val()=='') {

							comment.addClass('hightlight');

							return false;

						} else comment.removeClass('hightlight');

						//organize the data properly
						var data = 'name=' + name.val() + '&email=' + email.val() + '&website=' + website.val()  + '&reason=' + reason.val() + '&comment='  + encodeURIComponent(comment.val());

						//disabled all the text fields
						jQuery('.text').attr('disabled','true');

						//show the loading sign
						jQuery('.loading').show();
		
						//start the ajax
						jQuery.ajax({
							//this is the php file that processes the data and send mail
							url: "<?php echo esc_url(plugins_url('/WP2YT-Uploader/includes/process.php')); ?>",    
				
							//GET method is used
							type: "GET",

							//pass the data            
							data: data,        
			
							//Do not cache the page
							cache: false,
			
							//success
							success: function (html) {                
							
							//if process.php returned 1/true (send mail success)
								if (html==1) {                    

									//hide the form;
									jQuery('.form').fadeOut('fast');                    
					
									//show the success message
									jQuery('.done').fadeIn('slow');
					
								//if process.php returned 0/false (send mail failed)
								} else alert('Sorry, an unexpected error occurred. Please try again later.');                
							}        
						});

						//cancel the submit button default behaviours
						return false;
					});    
				});
			</script>

						<h3>Submit Feedback</h3>
						
						<p style="padding-left:8px;">Here you can submit feedback. If you have found any bugs, have any question or have suggestions for future updates please feel free to contact me through the form below.</p>

							<div id="feedback_form"> <!-- feedback form -->

								<div id="contact_form">

								  <div class="block">

									<div class="done" style="margin-left:3em;text-align:center;">

									<b class="wp2yt-green" style="margin-top:1em;">Thank you!</b> I have received your message. I greatly appreciate the feedback. 

										<img alt='' id="success-checkmark" src="<?php echo esc_url(plugins_url( '/WP2YT-Uploader/includes/images/success_checkmark.png' ));?>">

									</div>

										<div class="form">

										<form method="post" action="<?php echo esc_url(plugins_url('/WP2YT-Uploader/includes/process.php')); ?>">

										<div class="element">

											<label>Name:</label>
											
											<br />

											<input class="wp2yt-name-submission" type="text" name="name" class="text" />

										</div>

										<div class="element">

											<label>Email:</label>
											
											<br />

											<input class="wp2yt-email-submission" type="text" name="email" class="text" />

										</div>

										<div class="element">

											<label>Website:</label>
											
											<br />

											<input class="wp2yt-website-submission" type="text" name="website" class="text" />

										</div>

										<div class="element">

										<label>Reason For Contact?:</label>
										
										<br />

											<select id="reason" name="reason">

												<option value="Bug">Bug</option>

												<option value="Complaint">Complaint</option>

												<option value="Compliment" selected="selected">Compliment</option>

												<option value="Suggestion">Suggestion</option>

												<option value="Help">Help!</option>

											</select>	

										</div>

										<div class="element comment-element">				

											<label>Comment:</label>
											
											<br />

											<textarea class="wp2yt-comment-submission" name="comment" class="text textarea" /></textarea>

										</div>

										<div class="element">
									
											<input style="width:50% !important;" class="submit-button btn btn-success" type="submit" id="submit"/>

											<div class="loading"></div>

										</div>

										</form>

										</div>

									</div>

									<div class="clear"></div>

								</div> <!-- contact form div end -->

							</div> <!-- feedback form div -->


					</div>	 <!-- end help_page_feedback_div -->

			</div><!-- end inner_holder_div -->

	</div><!-- end help page -->

   </div> <!-- end tab 4 -->
   
</div><!--end tab content holder -->

 </div> <!-- end tabs div -->  

 <div id="branding">

<p><i style="color:black;">This plugin created by <a href="http://www.evan-herman.com" target="_blank">Evan Herman</a></i></p>

</div> 
</body>
</html>


<?php }

 function uploader_form() { ?>	

		<!-- create dynamic url variable for next url -->
		<?php $url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>

		<?php $email = get_option('yt_email'); ?>
		
		<?php $account = get_option('yt_account'); ?>
		
		<?php $pass = get_option('yt_pass'); ?>
		<?php $authID = get_option('stv_oauth2_text'); ?>

		<div id="uploader-form-content">

	<?php
		//If the 1st step form has been submited, run the token script.
        if( isset( $_POST['video_title'] ) && isset( $_POST['video_description'] ) ) {

            $video_title = stripslashes( $_POST['video_title'] );
            $video_description = stripslashes( $_POST['video_description'] );
			$video_keywords = stripslashes( $_POST['video_keywords'] );
			$video_category_value = stripslashes( $_POST['video_category_value'] );

            include_once( dirname(__FILE__) . '/includes/get_youtube_token.php' );
			
			
        }
		
        // Specifies the url that youtube will return to. The data it returns are as get variables         
        $nexturl = $url ; 
        // These are the get variables youtube returns once the video has been uploaded.
        if(isset($_GET['id'])) { $unique_id = $_GET['id']; } else { $unique_id = ''; } 
        if(isset($_GET['status'])) { $status = $_GET['status']; } else { $status = ''; }
		if(isset($response)) { $response->token; } else { $response = ''; }
		
    ?>

		<?php if(empty($email) || empty($pass)) : ?>

		<script> jQuery(document).ready(function(){ jQuery('#missing-information').fadeIn('slow'); }); </script>

		<div id="missing-information" style="display:none;">
			
			<h3 class="wp2yt-red" style="width:350px; display:inline;"><img alt='' style="margin-right:10px;" src="<?php echo esc_url(plugins_url( '/WP2YT-Uploader/includes/images/red-x.png' ));?>">Error<img alt='' style="margin-left:10px;" src="<?php echo esc_url(plugins_url( '/WP2YT-Uploader/includes/images/red-x.png' ));?>"> </h3> 
			
				<p><i>Your missing some vital information that allows you to upload content.
						Please direct yourself to the <i><a href="<?php echo admin_url() . 'options-general.php?page=wp2yt_settings';?>">'WP2YT Uploader Settings'</a></i> page and double check
						that you have entered your <b>YouTube e-mail</b> and <b>YouTube password</b> correctly.</p>
						<p><i><i class="wp2yt-green">Tip: </i>Use the Account/Password checker on the settings page to validate your settings.</i></p>
		</div> <!-- end missing information div -->

		
        <!-- Step 1 of the youtube upload process -->
        <?php elseif( empty( $_POST['video_title'] ) && $unique_id == "" ) : ?> 

		<script>
			jQuery(document).ready(function(){
				jQuery('#form1').submit(function(){
						jQuery('#form1').fadeTo('slow', .25);
						jQuery('#youtube_uploader_image').fadeTo('slow', .25);
						jQuery('#progress_bar_container').fadeTo('slow', .25);
						jQuery('#loading').fadeIn('slow');
				});
			});
		</script>

        <div id="form-div">
				<!-- Progress Bar For YouTube Steps -->
				<div id="progress_bar_container" style="padding-left:1.2em;">
							
					<ul id="wp2yt_progress_bar" class="step_one">
						<li>STEP ONE</li>
						<li>STEP TWO</li>
						<li>STEP THREE</li>
					</ul>
				</div> <!-- end progress bar -->

			<div id="loading" style="position:absolute; z-index:999; display:none;box-shadow:none;" ><img alt="" style="margin-left:28em;margin-top:16%;" src="<?php echo esc_url(plugins_url( 'includes/images/loading.gif' , __FILE__ )); ?>"></div>

			<div id="youtube_uploader_image"><img id='wp2yt-uploader-img' alt='wp2yt-youtube-uploader-img' style="margin-top:-4em;margin-left:40em; position:absolute;" src="<?php echo esc_url(plugins_url( '/WP2YT-Uploader/includes/images/youtube_upload_image.jpg' ));?>"></div>

			<form id="form1" action="" method="post">                
       
				<label style="margin-top:10px;" for="video_title" >Video Title:</label>

                <input type="text" id="wp2yt_video_title" name="video_title" disabled="disabled" style="width:420px;" />

				<label style="margin-top:10px;" for="video_description">Video Description:</label>

                <textarea id="wp2yt-video-description" name="video_description" disabled="disabled" style="width:420px; height:180px;"></textarea>

				<label for="video_keywords" style="margin-top:10px; margin-bottom:0;">Video Keywords: <i style="font-size:11px;">seperate each tag with a comma (,)</i></label>

                <input type="text" id="video_keywords"  disabled="disabled" name="video_keywords" style="width:420px;"/>

				<label style="margin-top:10px;" for="video_category">Select a Video Category:</label>
				<!-- drop down for category selection; populated with YouTube acceptable category names -->
				<select name="video_category_value" disabled="disabled" id="wp2yt_video_categories">
					<option value="News">News</option>
					<option value="Tech">Tech</option>
					<option value="Entertainment">Entertainment</option>
					<option value="Shows">TV Shows</option>
					<option value="Autos">Autos</option>
					<option value="Music">Music</option>
					<option value="Animals">Animals</option>
					<option value="Sports">Sports</option>
					<option value="Games">Games</option>
					<option value="Videblog">Video Blog</option>
					<option value="People">People</option>
					<option value="Comedy">Comedy</option>
					<option value="Howto">How-To</option>
					<option value="Education">Education</option>
					<option value="Nonprofit">Nonprofit</option>
					<optgroup label="Movies">
					<option value="Movies">Movies</option>
					<option value="Film">Film</option>
					<option value="Shortmov">Short Movie</option>
					<option value="Movies_anime_action">Anime Movies</option>
					<option value="Movies_action_adventure">Action Movies</option>
					<option value="Movies_classics">Classic Movies</option>
					<option value="Movies_comedy">Comedy Movies</option>
					<option value="Movies_documentary">Documentaries</option>
					<option value="Moves_drama">Drama Movies</option>
					<option value="Movies_family">Family Movies</option>
					<option value="Movies_foreign">Foreign Movies</option>
					<option value="Movies_horror">Horror Movies</option>
					<option value="Movies_sci_fi_fantasy">Science Fiction Movies</option>
					<option value="Movies_thriller">Thriller Movies</option>
					<option value="Trailers">Trailers</option>					
				</select>
		                
                <input class="btn btn-success wp2yt-first-uploader-step-btn" type="submit" value="Next Step"/>

            </form> <!-- /form -->

		</div> <!-- end form div -->

        <!-- Step 2 form of Upload Process -->           
		<?php elseif( @$response->token != '' ) : ?> 
			<script>
			jQuery(document).ready(function(){
				jQuery('#fileUploadForm').submit(function(){
						jQuery('#fileUploadForm').fadeTo('slow', .25);
						jQuery('#youtube_uploader_image').fadeTo('slow', .25);
						jQuery('#video_info_div').fadeTo('slow', .25);
						jQuery('#progress_bar_container').fadeTo('slow', .25);
						jQuery('#loading').fadeIn('slow');
				});
			});
			</script>

			<!-- loading gif -->
			<div id="loading" style="position:absolute; z-index:999; display:none;" ><img alt='' style="margin-left:28em;margin-top:16%;" src="<?php echo esc_url(plugins_url( 'includes/images/loading.gif' , __FILE__ )); ?>"></div>
			
		<!-- Progress Bar For YouTube Steps -->
		<div id="progress_bar_container" style="padding-left:1.2em;">

			<ul id="wp2yt_progress_bar" class="step_two">
				<li>STEP ONE</li>
				<li>STEP TWO</li>
				<li>STEP THREE</li>
			</ul>

		</div> <!-- end progress bar -->

			<!-- youtube uploader image -->
			<div id="youtube_uploader_image"><img alt='' style="margin-top:-4em;margin-left:40em; position:absolute; margin-top:6em;" class="youtube-upload-image" src="<?php echo esc_url(plugins_url( '/WP2YT-Uploader/includes/images/youtube_upload_image.jpg' ));?>"></div>

			<div id="video_info_div">
			<h2>Review Video Info Below and Attach a File</h2>
				<h4>Title:</h4>
					<p><?php echo esc_html($video_title); ?></p>

				<h4>Description:</h4>
					<p style="width:420px;"><?php echo esc_html($video_description); ?></p>

				<h4>Keywords:</h4>
					<p><?php echo esc_html($video_keywords); ?></p>

				<h4>Categroy:</h4>
					<p><?php echo esc_html($video_category_value); ?></p>

			</div> 

			<form id="fileUploadForm" action="<?php echo $response->url; ?>?nexturl=<?php echo( urlencode( $nexturl ) ); ?>" method="post" enctype="multipart/form-data">
				<p class="block">
                    <label>Upload Video <i class="wp2yt-red" style="font-size: 10px;">(supported formats: .mov, .mp4, .avi, .wmv, .mpegps, .flv, .3gpp, .webm)</i></label><br />
                    <span class="youtube-input">
                        <input id="file" type="file" name="file"/>
                    </span>                        
                </p>
				<input type="hidden" name="token" value="<?php echo $response->token; ?>"/>
                <input id="submit2" class="btn btn-success" type="submit" value="Upload" />
				
			</form>
		

			
			<!-- error check status id -->
            <?php  elseif( $status != '200' ) : ?>

				<div class="upload_error"> 

					<h3 class="wp2yt-red"><img alt='' id="red-x" src="<?php echo esc_url(plugins_url( '/WP2YT-Uploader/includes/images/red-x.png' )); ?>"> Error <img alt='' id="red-x" src="<?php  echo esc_url(plugins_url( '/WP2YT-Uploader/includes/images/red-x.png' )); ?>"> </h3>

						<p style="width:550px;"><i>Oh no! It looks like there was an error during the upload. This generally occurs
							when you have mistyped something. Double check all of your settings, and retry the upload.</p>
							
							<p style="width:550px;"><span class="wp2yt-green">tip </span> use the account/password check utility on the <a href="/wp-admin/options-general.php?page=wp2yt_settings">settings page</a>. if that works, you shouldn't receive any errors.</p>
							
							<p style="width:550px;"> <span class="wp2yt-red">note </span>if this is a new YouTube account make sure you have properly set up your personal channel</i></p>

				</div> <!-- end upload error message -->


        <!-- step 3 and Final Step of the Upload Process -->
			<!-- if unique ID doesnt return blank & status returns 200 -->
        <?php elseif( $unique_id != '' && $status = '200' ) : ?>   
		
			<script>
			/* fade in success message and video info on successful upload */
			jQuery(document).ready(function(){
				jQuery('#video-success').fadeIn('fast');		
			});		
			</script>
			
        <div id="video-success" style="margin-left:12.5em;display:none;">
		
		<?php $yt_username = get_option('yt_account'); ?>
			
		<!-- attempt to get status of recently uploaded video have to pull out <app:data> form the xml response -->	

		<!-- Progress Bar For YouTube Steps -->
		<div id="progress_bar_container" style="padding-left:1.2em;">
			<ul id="wp2yt_progress_bar" class="step_three">
				<li>STEP ONE</li>
				<li>STEP TWO</li>
				<li>STEP THREE</li>
			</ul>
		</div> <!-- end progress bar -->
		
		<!-- Video Upload Success Message -->
		<img alt='' id="success-checkmark" style="position:absolute; margin-left:-12.5em; width:11%; margin-top:-1.5em;" src="<?php echo esc_url(plugins_url( '/WP2YT-Uploader/includes/images/success_checkmark.png' ));?>">

            <b>Video Successfully Uploaded!</b>
            <p>Videos usually take around 10-15 minutes to get accepted and processesed by YouTube (depending on file size). Your video will not show up in recent uploads until it is processed. Please check back soon.</p>
			<b>URL to Video:</b>
            <p>Here is your url to view your video: <a href="http://www.youtube.com/watch?v=<?php echo esc_html($unique_id); ?>" target="_blank">http://www.youtube.com/watch?v=<?php echo esc_html($unique_id); ?></a></p>
			<button class="new-upload-insert-video-to-post-btn btn btn-success" value="<?php echo htmlentities('[iframe]<iframe width="640" height="480" src="http://www.youtube.com/embed/') ?><?php echo esc_html($unique_id); ?><?php echo htmlentities('" frameborder="0" allowfullscreen="1"></iframe>[/iframe]') ?>">Insert into Post</button>
			
			<button class="btn btn-success btn-small" onclick="refresh_upload_page()">Upload More Content</button>
			<br />
						
        </div> <!-- /div#video-success -->

        <?php endif; ?>

	</div> <!-- end uploader form content div -->

<?php 

}
add_action('admin_menu', 'wp2yt_add_settings_page');


/* function for admin Settings page */

function wp2yt_add_settings_page(){
	 add_options_page('WP2YT Uploader Settings', 
								  'WP2YT Uploader', 
								  'manage_options', 
								  'wp2yt_settings', 
								  'wp2yt_settings_page');
								}



// callback function for the settings page
function wp2yt_settings_page() {
?>
<body>
	<div class="wrap wp2yt-settings-page-wrapper">
		<div class="wp2yt-tips-box">
				<h3 style="font-size:1.2rem;">About The Author:</h3>
				<div class="about-evan-box">
					<!-- <a class="about-evan-image-link-tag" href="http://www.evan-herman.com" target="_blank"><div class="wp2yt-eherman-profile-pic"><h2 class="wp2yt-profile-pic-text">Evan Herman</h2></div></a> -->
					<a href="http://www.Evan-Herman.com" target="_blank"><div class="eherman-banner-ad"><img alt="Evan Herman Banner" src="<?php echo esc_url(plugins_url()); ?>/WP2YT-Uploader/includes/images/wp-svg-pro-plugin-banner.png" /></div></a>
					<p class="wp2yt-evan-description"> This plugin was created by Evan Herman. A client of mine maintains a site heavily driven by YouTube hosted content. I wanted a way to streamline the process of uploading new content to YouTube from WordPress, so this plugin was born.<br /> <br /><i>'WP2YT Uploader'</i> took a lot of hard work and long hours to create. If you benefit from it, and can spare a few bucks, a donation will help keep this plugin alive. If you can't afford it, <i class="wp2yt-green">I would appreciate 5 star rating.</i></p>
				<div class="wp2yt-image-links">
				<h3 class="wp2yt-external-links-header">External Links</h3>
					<div class="wp2yt-box1">
						<a href="http://profiles.wordpress.org/eherman24/" target="_blank"><div class="wp2yt-external-wordpress-link"></div></a><h3 class="wp2yt-wordpress-link-text">WordPress Profile</h3>
					</div>
					<div class="wp2yt-box2">
						<a href="http://www.evan-herman.com" target="_blank"><div class="wp2yt-external-site-link"></div></a><h3 class="wp2yt-external-site-link-text">Personal Site</h3>
					</div>
					<div class="wp2yt-box3">
						<a href="http://evan-herman.com/wp-svg-icon-set-1-example/" target="_blank"><div class="wp2yt-external-plugin-link"></div></a><h3 class="wp2yt-plugin-link-text">Other Plugins</h3>
					</div>
				</div> <!-- end wp2yt image links -->
				</div> <!-- end about evan box -->
					<div class="wp2yt-paypal-donation-button">
						<b>- Help Keep This Plugin Alive -</b>
						<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
							<input type="hidden" name="cmd" value="_donations">
							<input type="hidden" name="business" value="emh52@drexel.edu">
							<input type="hidden" name="lc" value="US">
							<input type="hidden" name="item_name" value="Donation for the wp2yt uploader plugin">
							<input type="hidden" name="no_note" value="0">
							<input type="hidden" name="currency_code" value="USD">
							<input type="hidden" name="bn" value="PP-DonationsBF:btn_donate_SM.gif:NonHostedGuest">
							<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
							<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
						</form>
					</div> <!-- end paypal donation button -->
			</div> <!-- end tips box -->	
		
			<h2> WordPress to YouTube Uploader Settings </h2>
		
			<form id="settings_page_form" method="post" action="options.php">
			<?php settings_fields( 'wp2yt_settings' ); ?>
			<?php do_settings_sections( 'wp2yt_settings' ); ?>
			<?php 
			$other_attributes = array('onclick' => 'wp2ytSubmitSettingsForm()');
			submit_button('Update Settings', 'primary', 'submit-form','',$other_attributes); 
			?>
			</form>
			
		</div> <!-- end wrap -->
		
		<!-- joyride tour stops -->
		<!-- hide from the display -->
		<ol id="TourList" data-joyride style="display:none;">
			   <li data-button="Let's Begin" data-options="tip_location:top;tip_animation:fade">
					<h4>Welcome!</h4>
					<p>Thanks for downloading the 'WP2YT Uploader' plugin. Lets go through the initial set up together.</p>
			  </li>
			  <li data-id="yt_email" data-text="Next Step" data-options="tip_location:top;tip_animation:fade">
					<h4>Step #1</h4>
					<p>Enter your YouTube email address. </p>
					<p class="wp2yt-tutorial-small-text"><i class="wp2yt-red">important:</i> if this is a new YouTube account you must first set up your personal YouTube channel. You can do this by logging in to YouTube and clicking 'Video Manager'.</p>
					
			  </li>
			  <li data-id="yt_pass" data-text="Next Step" data-options="tip_location:top;tip_animation:fade">
					<h4>Step #2</h4>
					<p>Enter your YouTube password.</p>
					<p class="wp2yt-tutorial-small-text"><span class="wp2yt-red"><i>important:</i></span> the password is case sensitive.</p>					
			  </li>
			  <li data-id="yt_account" data-text="Next Step" data-options="tip_location:top;tip_animation:fade">
					<h4>Step #3</h4>
					<p>Enter your YouTube account name.</p>
					<p class="wp2yt-tutorial-small-text"><span class="wp2yt-green"><i>note:</i></span> this is used to display all of your personal content.</p>
			  </li>
			  <li data-id="stv_oauth2_input" data-text="Next Step" data-options="tip_location:top;tip_animation:fade">
					<h4>Step #4</h4>
					<p>Retreive and enter your google OAUTH2 client ID. </p>
					<p class="wp2yt-tutorial-small-text"><span class="wp2yt-green"><i>note:</i></span> this field is optional. this is used to retreive analytics information. this is also a required field if you would like to delete videos from your account.</p>
					<p class="wp2yt-tutorial-link-p"><a class="wp2yt-tutorial-link" href="https://code.google.com/apis/console" target="_blank">Google API Console</a></p>
					<p class="wp2yt-tutorial-link-p-last"><a class="wp2yt-tutorial-link" href="/wp-admin/admin.php?page=wp2yt_uploader#tabs-4" target="_blank">OAUTH2 Help</a></p>
			  </li>
			  <li data-id="yt_account2" data-text="Next Step" data-options="tip_location:top;tip_animation:fade">
					<h4>Step #5</h4>
					<p>Add additional YouTube account names that you follow.</p>
					<p class="wp2yt-tutorial-small-text">Great for inserting videos from other YouTube users!</p>
					<p class="wp2yt-tutorial-small-text">Need some ideas? Here are some popular YouTube accounts to get you started: <ol><li>YouTube</li><li>FPSRussia</li><li>Vsauce</li><li>Epic Meal Time</li></ol></p>
			  </li>
			  <li data-id="use_yt_analytics_checkbox" data-text="Next Step" data-options="tip_location:top;tip_animation:fade">
					<h4>Step #6</h4>
					<p>Enable/Disable YouTube Analytics<i class="wp2yt-tutorial-small-text wp2yt-red">(beta)</i></p>
					<p class="wp2yt-tutorial-small-text wp2yt-red">OAUTH2 Client ID is required</p>
			  </li>
			  <li data-id="use_fitvid_checkbox" data-text="Next Step" data-options="tip_location:top;tip_animation:fade">
					<h4>Step #7</h4>
					<p>Enable/Disable FitVid.js</p>
					<p class="wp2yt-tutorial-small-text">FitVid.js enables responsive YouTube videos on your site. Disable this if you notice any issues.</p>
			  </li>
			  <li data-button="End">
					<h4>Enjoy!</h4>
					<p>Now Click 'Update Settings' below</p>
					<p>You can then begin uploading and inserting your favorite YouTube videos! <br /> If you have any questions or comments you can reach me at <a class="wp2yt-tutorial-link" href="mailto:evan.m.herman@gmail.com">Evan.M.Herman@Gmail.com</a> or through the contact form on the help tab.</p>
			  </li>
		</ol>
		<!-- initialize joyride on settings page -->
		<script>
		jQuery(window).load(function() {
		  jQuery("#TourList").joyride({ 
			autoStart : true,
			'tipLocation': 'right',         // 'top' or 'bottom' in relation to parent
			'nubPosition': 'auto', 
			// enable cookies to only run the joyride tutorial one time
			'cookieMonster': true,           // true/false for whether cookies are used
			'cookieName': 'wp2yt-initial-setup-tutorial-complete',         // choose your own cookie name
			'cookieDomain': false	
			});
		});
		</script>
</body>		
<?php 
}

//Whitelist the Settings
function wp2yt_settings_init() {

	//Add uploader_settings_section
	add_settings_section('uploader_settings_section',//id
									'Uploader <b class="wp2yt-red">(required)</b>:',//title
									'uploader_settings_section_callback',//callback
									'wp2yt_settings');	//page
		
	//Add recent_uploads_settings_section
	add_settings_section('recent_uploads_settings_section',//id
									'Recent Uploads Settings:',//title
									'recent_uploads_settings_section_callback',//callback
									'wp2yt_settings');	//page
									
	//Add auth2_clientID_settings_section
	add_settings_section('oauth2_clientID_settings_section',//id
									'Google OAuth2 ID <b class="wp2yt-green">(optional)</b>:',//title
									'oauth2_clientID_settings_section_callback',//callback
									'wp2yt_settings');	//page								

	//Add Youtube Email Settings Field - uploader_settings_section
	add_settings_field('yt_email',
								'YouTube Email*:',
								'yt_email_text_callback',
								'wp2yt_settings',
								'uploader_settings_section');	

	//Add Youtube Password Settings Field - section uploader_settings_section
	add_settings_field('yt_pass',
								'YouTube Password*:',
								'yt_pass_text_callback',
								'wp2yt_settings',
								'uploader_settings_section');	
	
	//Add OAUTH2 Settings field - section uploader_settings_section
	add_settings_field('stv_oauth2_text',
								'OAUTH2 Client ID:',
								'wp2yt_oauth2_text_callback',
								'wp2yt_settings',
								'oauth2_clientID_settings_section'); //section
	
	//Add yt_analytics_switch
	add_settings_field('add_yt_analytics_switch_checkbox',
								'YouTube Analytics Switch:',
								'yt_analytics_switch_section_callback',
								'wp2yt_settings',
								'analytics_switch_section');		

	//Add fitvid_js_switch
	add_settings_field('add_fitvid_js_switch_checkbox',
								'FitVid.js Switch:',
								'fitvid_switch_section_callback',
								'wp2yt_settings',
								'fitvid_switch_section');								

	//Add Youtube Account Settings Field - section recent_uploads_settings_section
	add_settings_field('yt_account',
								'YouTube Account Name:',
								'yt_account_text_callback',
								'wp2yt_settings',
								'recent_uploads_settings_section');

	//Add Add Second YouTube Account
	add_settings_field('add_yt_account2_checkbox',
								'',
								'',
								'wp2yt_settings',
								'');

	//Add Add third YouTube Account
	add_settings_field('add_yt_account3_checkbox',
								'',
								'',
								'wp2yt_settings',
								'');


	//Add Add Second YouTube Account
	add_settings_field('add_yt_account4_checkbox',
								'',
								'',
								'wp2yt_settings',
								'');	

	//Add Add Second YouTube Account
	add_settings_field('add_yt_account5_checkbox',
								'',
								'',
								'wp2yt_settings',
								'');		

	//Add optional_accounts_settings_section
	add_settings_section('optional_accounts_settings_section',//id
								'Add Additional YouTube Accounts <b class="wp2yt-green">(optional)</b>:',//title
								'optional_accounts_settings_section_callback',//callback
								'wp2yt_settings');	//page	
	


	//Add analytics_switch_section
	add_settings_section('analytics_switch_section',//id
									'Use YouTube Analytics <b class="wp2yt-blue">(beta)</b>:',//title
									'yt_analytics_beginning_switch_section_callback',//callback
									'wp2yt_settings');	//page		
									
	//Add fitvid.js swtich
	add_settings_section('fitvid_switch_section',//id
									'Enable FitVid.js:',//title
									'fitvid_beginning_switch_section_callback',//callback
									'wp2yt_settings');	//page								

	//Add Youtube Account Settings Field - section optional_accounts_settings_section
	add_settings_field('yt_account2',
							'Second Account Name:',
							'yt_account2_text_callback',
							'wp2yt_settings',
							'optional_accounts_settings_section');

	//Add Youtube Account Settings Field - section optional_accounts_settings_section
	add_settings_field('yt_account3',
							'Third Account Name:',
							'yt_account3_text_callback',
							'wp2yt_settings',
							'optional_accounts_settings_section');

	//Add Youtube Account Settings Field - section optional_accounts_settings_section
	add_settings_field('yt_account4',
							'Fourth Account Name:',
							'yt_account4_text_callback',
							'wp2yt_settings',
							'optional_accounts_settings_section');


	//Add Youtube Account Settings Field - section optional_accounts_settings_section
	add_settings_field('yt_account5',
								'Fifth Account Name:',
								'yt_account5_text_callback',
								'wp2yt_settings',
								'optional_accounts_settings_section');

	

	//Register Settings
	register_setting( 'wp2yt_settings', 'stv_oauth2_text', 'wp2yt_settings_validate');
	register_setting( 'wp2yt_settings', 'yt_account', 'wp2yt_settings_validate');
	register_setting( 'wp2yt_settings', 'yt_email', 'wp2yt_settings_validate');
	register_setting( 'wp2yt_settings', 'yt_pass', 'wp2yt_settings_validate');
	register_setting( 'wp2yt_settings', 'add_yt_account2_checkbox', 'wp2yt_settings_validate');
	register_setting( 'wp2yt_settings', 'add_yt_account3_checkbox', 'wp2yt_settings_validate');
	register_setting( 'wp2yt_settings', 'add_yt_account4_checkbox', 'wp2yt_settings_validate');
	register_setting( 'wp2yt_settings', 'add_yt_account5_checkbox', 'wp2yt_settings_validate');
	register_setting( 'wp2yt_settings', 'use_yt_analytics_checkbox', 'wp2yt_settings_validate');
	register_setting( 'wp2yt_settings', 'use_fitvid_checkbox', 'wp2yt_settings_validate');
	register_setting( 'wp2yt_settings', 'yt_account2', 'wp2yt_settings_validate');
	register_setting( 'wp2yt_settings', 'yt_account3', 'wp2yt_settings_validate');
	register_setting( 'wp2yt_settings', 'yt_account4', 'wp2yt_settings_validate');
	register_setting( 'wp2yt_settings', 'yt_account5', 'wp2yt_settings_validate');
}

	//Hook wp2yt_settings_init in to admin_init 
	add_action( 'admin_init', 'wp2yt_settings_init' );
	
//Runs at the start of the optional_accounts_settings_section
function optional_accounts_settings_section_callback() {
?>

<i>To retreive other users recently uploaded content add their YouTube accounts in the boxes below.<br /> Click the checkbox to the right of the input field to enable the field.</i> 

<?php
}

//Runs at the start of the fitvid_switch_section_callback
function fitvid_beginning_switch_section_callback() {
?>

<i>Toggle on/off <a href="http://fitvidsjs.com/" target="_blank">FitVid.js</a>.</i>
<br />
<i>FitVid.js enables responsive YouTube videos. Disable if there is a conflict with another plugin.</i> 

<?php
}

//Runs at the start of the yt_analytics_switch_section
function yt_analytics_beginning_switch_section_callback() {
?>

<i>Toggle on/off the analytics tab.</i>
<br />
<i>The OAUTH2 Client ID is required to access your account analytic information.</i> 

<?php
}

//Runs at the start of the optional_accounts_settings_section
function uploader_settings_section_callback() {
?>

<?php
}

//Runs at the start of the optional_accounts_settings_section
function oauth2_clientID_settings_section_callback() {
?>
<i class="wp2yt-red">The OAuth2 Client ID is required to enable analytics and allows you to delete your uploaded videos.</i>
<?php
}


//Runs at the start of the optional_accounts_settings_section
function recent_uploads_settings_section_callback() {
?>
<i>Input your YouTube account name to retreive your recent uploads.</i> 
<?php
}	

// Runs at the start of the settings page
function wp2yt_oauth2_text_callback(){
	 //LEAVING PHP FOR A WHILE 
	?>
		<input type="text" name="stv_oauth2_text" id="stv_oauth2_input" class="stv_oauth2_input"style="width:120% !important;" placeholder="Google OAUTH2 Client ID" value="<?php echo esc_attr(get_option('stv_oauth2_text')); ?>" /><i>Register your site with <a href="https://code.google.com/apis/console" target="_blank">Googles API Console</a>.<br /> Check out the <a href="http://www.evan-herman.com/wp2yt-documentation/" target="_blank" title="WP2YT Documentation">documentation</a> tutorial for help with setting this up.</i>
	
	<?php }

	// start here for youtube account and password

function yt_account_text_callback(){

	 //LEAVING PHP FOR A WHILE 

	?>

	<input type="text" id="yt_account" name="yt_account" placeholder="example: Vsauce" style="min-width:299px;width:100%;" value="<?php echo esc_attr(get_option('yt_account')); ?>" /> <i style="display:block;">Your YouTube account name</i>

	<?php }

function yt_pass_text_callback(){
	 //LEAVING PHP FOR A WHILE 
	?>
	
	<input type="password" id="yt_pass" name="yt_pass" placeholder="your password" value="<?php echo get_option('yt_pass'); ?>" /> <i><a href="http://www.youtube.com/account_recovery" target="_blank">Forgot Password?</a></i> 

	<script>
		/* verify correct youtube email and password settings */
		function wp2ytCheckYouTubeConnection() {
				jQuery(".wp2yt-check-yt-connect-btn").attr("disabled","disabled");
				<?php include_once( dirname(__FILE__) . '/includes/check_yt_connection.php' ); ?>	
				var hiddenTokenInput = jQuery('#wp2yt-hidden-token-input').val();
				setTimeout(function(){
					jQuery(".wp2yt-check-yt-connect-btn").removeAttr("disabled");
				},1500);
				setTimeout(function(){
	
				},1100);
		};
		function wp2ytSubmitSettingsForm() {
			jQuery('#settings_page_form').submit();
			
			// trim + remove duplicate/trailing/preceeding white space
			var yt_account_1_input = jQuery("#yt_account2").val();
				var yt_account_1_input = yt_account_1_input.replace(/ +(?= )/g,'');
				var yt_account_1_input = yt_account_1_input.trim();
			
			jQuery("#yt_account2").val(yt_account_1_input);	
			
			var yt_account_2_input = jQuery("#yt_account3").val(); 
				var yt_account_2_input = yt_account_2_input.replace(/ +(?= )/g,'');
				var yt_account_2_input = yt_account_2_input.trim();
				
			jQuery("#yt_account3").val(yt_account_2_input);	
			
			var yt_account_3_input = jQuery("#yt_account4").val();
				var yt_account_3_input = yt_account_3_input.replace(/ +(?= )/g,'');
				var yt_account_3_input = yt_account_3_input.trim();
				
			jQuery("#yt_account4").val(yt_account_3_input);		
				
			var yt_account_4_input = jQuery("#yt_account5").val();
				var yt_account_4_input = yt_account_4_input.replace(/ +(?= )/g,'');
				var yt_account_4_input = yt_account_4_input.trim(); 
				
				jQuery("#yt_account5").val(yt_account_4_input);	
				
				 
			if ( yt_account_1_input == '' ) {
				jQuery("#add_yt_account2_checkbox").attr("checked",false);
			} 
			if ( yt_account_2_input == '' ) {
				jQuery("#add_yt_account3_checkbox").attr("checked",false);
			} 
			if ( yt_account_3_input == '' ) {
				jQuery("#add_yt_account4_checkbox").attr("checked",false);
			} 
			if ( yt_account_4_input == '' ) {
				jQuery("#add_yt_account5_checkbox").attr("checked",false);
			}
		};	
	</script>
		
	<div class="wp2yt-check-yt-connection">
	<input id="youTubeAuthKeyResponseInput" type="hidden" value="<?php echo esc_attr($youTubeAuthKeyResponse); ?>" />	
		<p><b>Check your email and password settings <i style="font-size:11px">(update settings then run this check)</i></b></p>
		<span style="display:inline-block; margin-top:.5em;"><button onclick="wp2ytSubmitSettingsForm()" class="button-primary">Update Settings</button><span class="button wp2yt-check-yt-connect-btn" href="#" onclick="wp2ytCheckYouTubeConnection()">Check Connection</span></span>
		<br />
		<div class="check-settings-images">	
			<img class="incorrect-settings-x wp2yt-check-settings-img" src="<?php echo esc_url(plugin_dir_url(__FILE__).'includes/images/incorrect-settings-x.png'); ?>" alt="incorrect settings" />	
			<img class="correct-settings-checkmark wp2yt-check-settings-img" src="<?php echo esc_url(plugin_dir_url(__FILE__).'includes/images/success_checkmark.png'); ?>" alt="correct-settings" />	
			<img class="wp-default-preloader wp2yt-check-settings-img" src="<?php echo esc_url(plugin_dir_url(__FILE__).'includes/images/preloader.gif'); ?>" alt="pre-loader" />	
		</div>
	</div>
	
	<br />
	<hr class="wp2yt-hr2"/>
	
	
	<?php }

function yt_email_text_callback(){
	 //LEAVING PHP FOR A WHILE 
	?>
	
	<input type="text" id="yt_email" name="yt_email" placeholder="Example@gmail.com" value="<?php echo esc_attr(get_option('yt_email')); ?>" /> <i style="width:100px;">your login email address</i>

	<?php }	

	// start here for youtube account and password

function yt_account2_text_callback(){
	 //LEAVING PHP FOR A WHILE 
	?>
	
	<input type="text" id="yt_account2" name="yt_account2" style="width:85%;" placeholder="YouTube" value="<?php echo esc_attr(get_option('yt_account2')); ?>" /> <input type="checkbox" id="add_yt_account2_checkbox" name="add_yt_account2_checkbox" <?php if (get_option('add_yt_account2_checkbox')==true) echo 'checked="checked" '; ?> />
	
	<?php }	

	// start here for youtube account and password

function yt_account3_text_callback(){
	 //LEAVING PHP FOR A WHILE 
	?>

	<input type="text" id="yt_account3" name="yt_account3" style="width:85%;" placeholder="BigThink" value="<?php echo esc_attr(get_option('yt_account3')); ?>" /> <input type="checkbox" id="add_yt_account3_checkbox" name="add_yt_account3_checkbox" value="true" <?php if (get_option('add_yt_account3_checkbox')==true) echo 'checked="checked" '; ?> />

	<?php }


// start here for youtube account and password
function yt_account4_text_callback(){
	 //LEAVING PHP FOR A WHILE 
	?>

	<!-- script to enable/disable input boxes -->

	<input type="text" id="yt_account4" name="yt_account4" style="width:85%;" placeholder="Vsauce" value="<?php echo esc_attr(get_option('yt_account4')); ?>" /> <input type="checkbox" id="add_yt_account4_checkbox" name="add_yt_account4_checkbox" value="true" <?php if (get_option('add_yt_account4_checkbox')==true) echo 'checked="checked" '; ?> />

	<?php }	

	// start here for youtube account and password
function yt_account5_text_callback(){
	 //LEAVING PHP FOR A WHILE 
	?>

	<input type="text" id="yt_account5" name="yt_account5" style="width:85%;" placeholder="FPSRussia" value="<?php echo esc_attr(get_option('yt_account5')); ?>" /> <input type="checkbox" id="add_yt_account5_checkbox" name="add_yt_account5_checkbox" value="true" <?php if (get_option('add_yt_account5_checkbox')==true) echo 'checked="checked" '; ?> />
	<br />
	<hr class="wp2yt-hr2"/>
	
	<?php }	

function yt_analytics_switch_section_callback(){
	 //LEAVING PHP FOR A WHILE 
	?>

	<input type="checkbox" id="use_yt_analytics_checkbox" name="use_yt_analytics_checkbox" value="true" <?php if (get_option('use_yt_analytics_checkbox')==true) echo 'checked="checked" '; ?> /><i class="wp2yt-onOff-switch">  (On/Off)</i>
	<br />
	<p class="wp2yt-oauth2-clientid-length-warning wp2yt-red wp2yt-small" style="display:none;">you must enter a valid oauth2 client ID if you want to use analytics</p>
	<hr class="wp2yt-hr2" style="margin-top:1.3em;" />
		
	<?php }	
	
function fitvid_switch_section_callback(){
	 //LEAVING PHP FOR A WHILE 
	?>

	<input type="checkbox" id="use_fitvid_checkbox" name="use_fitvid_checkbox" value="true" <?php if (get_option('use_fitvid_checkbox')==true) echo 'checked="checked" '; ?> /><i class="wp2yt-onOff-switch">  (On/Off)</i>

	<?php }	

 	function wp2yt_settings_validate($input) {

    // Encode
    $newinput = esc_attr($input);
    return $newinput;
	
}

/* add shortcode support to allow uploader on front end 
add_shortcode('wp2yt-uploader', 'uploader_form');
*/
/* add uploader to iframe in media_uploader so as not to exit when proceeding to step 2&3 */
function media_upload_youtube_uploader() {
$errors = '';
	return wp_iframe( 'wp2yt_menu_validate', $errors );
}
add_action('media_upload_youtube_uploader', 'media_upload_youtube_uploader');


// Function to change input type on options.php page <= used to hide the password 
function wp2yt_hide_options_page_password($hook) {
	if ( $hook == 'options.php' ) {
	?>
		<script>
			window.onload = function() {
				document.getElementById('yt_pass').type='password';
			};
		</script>
	<?php	
	}
}
add_action('admin_enqueue_scripts','wp2yt_hide_options_page_password');