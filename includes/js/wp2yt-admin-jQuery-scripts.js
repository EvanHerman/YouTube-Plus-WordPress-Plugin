/* main jQuery file that controls most admin interactivity */
/*	Compiled By: Evan Herman (eherman24) */
/*			www.Evan-Herman.com				*/

			
jQuery(document).ready(function() {
			
			// set width and visibility on playlists that return an error
			jQuery("#get_playlists_div_holder").find(".no_videos_error").css({"margin":"0 auto", "margin-top":"1.5em","margin-bottom":"1.5em","text-align":"center"}).parent(".scrollable-content").css("width","auto").parent(".show_playlist").css("overflow-x","scroll");
			// hide "Recent Uploads By" title if playlists return zero or an error
			jQuery("#get_playlists_div_holder").find(".no_videos_error").parent(".scrollable-content").prev().remove();
			

			jQuery('.wp2yt-page-load-image').fadeOut(500);
			jQuery('#wp2yt-tabs').fadeTo(750, 1);
			jQuery('#wp2yt-tabs').css('cursor','default');		
						
			/* insitialize tabs() on #tabs */
			jQuery( "#wp2yt-tabs" ).tabs();

			/* enable inputs+dropdown after page has fully loaded */
			jQuery('#wp2yt-tabs input').attr('disabled' , false);
			jQuery('#wp2yt-tabs textarea').attr('disabled' , false);
			jQuery('#wp2yt-tabs select').attr('disabled' , false);
			
			/* set sampleTags variable for tagit */
			var sampleTags = ['funny', 'movie', 'comedy', 'show', 'game', 'short', 'film', 'animation', 'hand', 'drawn'];

			/* using tag-it.js, initialize tagit on #video_keywords */
			jQuery('#video_keywords').tagit({
                availableTags: sampleTags,
				singleField: true,
				removeConfirmation: true
            });
			
			/* jQuery for main tab selection - selecting first tab (new_content) */
			jQuery('.new_content').click(function(){
				jQuery('.help_page').fadeOut('slow');
				jQuery('.analytics_page').fadeOut('fast');
				jQuery('.recent_uploads').fadeOut('fast');
				jQuery('.upload_content').fadeIn('slow');
			});
			
			/* jQuery for main tab selection - selecting second tab (currcont (current content)) */
			jQuery('.currcont').click(function(){
				jQuery('.help_page').fadeOut('slow');
				jQuery('.upload_content').fadeOut('fast');
				jQuery('.analytics_page').fadeOut('fast');
				jQuery('.recent_uploads').fadeIn('slow');
			});
			
			/* jQuery for main tab selection - selecting third tab (analytics) */	
			jQuery('.analytics').click(function(){
				jQuery('.help_page').fadeOut('slow');
				jQuery('.upload_content').fadeOut('fast');
				jQuery('.recent_uploads').fadeOut('fast');
				jQuery('.analytics_page').fadeIn('slow');
			});		
			
			/* jQuery for main tab selection - selecting fourth tab (help) */
			jQuery('.help').click(function(){
				jQuery('.upload_content').fadeOut('fast');
				jQuery('.recent_uploads').fadeOut('fast');
				jQuery('.analytics_page').fadeOut('fast');
				jQuery('.help_page').fadeIn('slow');
			});
			
			
					/* jQuery for the HELP PAGE navigation: click first tab - about */
					jQuery('.about_btn').click(function(){
						jQuery('.help_page > ul > li > a').removeClass('wp2yt-active-link');
						jQuery('.about_btn > a').addClass('wp2yt-active-link');
						jQuery('#help_page_uploader_div').hide();
						jQuery('#help_page_recent_uploads_div').hide();
						jQuery('#help_page_oauth2help_div').hide();
						jQuery('#help_page_feedback_div').hide();
						jQuery('#help_page_about_div').fadeIn('fast');
					});

					/* jQuery for the HELP PAGE navigation: click second tab - uploader */
					jQuery('.uploader_btn').click(function(){
						jQuery('.help_page > ul > li > a').removeClass('wp2yt-active-link');
						jQuery('.uploader_btn > a').addClass('wp2yt-active-link');
						jQuery('#help_page_about_div').hide();
						jQuery('#help_page_recent_uploads_div').hide();
						jQuery('#help_page_oauth2help_div').hide();
						jQuery('#help_page_feedback_div').hide();
						jQuery('#help_page_uploader_div').fadeIn('fast');
					});

					/* jQuery for the HELP PAGE navigation: click third tab - current content */
					jQuery('.cc_btn').click(function(){
						jQuery('.help_page > ul > li > a').removeClass('wp2yt-active-link');
						jQuery('.cc_btn > a').addClass('wp2yt-active-link');
						jQuery('#help_page_uploader_div').hide();
						jQuery('#help_page_about_div').hide();
						jQuery('#help_page_oauth2help_div').hide();
						jQuery('#help_page_feedback_div').hide();
						jQuery('#help_page_recent_uploads_div').fadeIn('fast');
					});

					/* jQuery for the HELP PAGE navigation: click fourth tab - analytics */
					jQuery('.analytics_btn').click(function(){
						jQuery('.help_page > ul > li > a').removeClass('wp2yt-active-link');
						jQuery('.analytics_btn > a').addClass('wp2yt-active-link');
						jQuery('#help_page_uploader_div').hide();
						jQuery('#help_page_recent_uploads_div').hide();
						jQuery('#help_page_about_div').hide();
						jQuery('#help_page_feedback_div').hide();
						jQuery('#help_page_oauth2help_div').fadeIn('fast');
					});

					/* jQuery for the HELP PAGE navigation: click fifth tab - feedback */
					jQuery('.feedback_btn').click(function(){
						jQuery('.help_page > ul > li > a').removeClass('wp2yt-active-link');
						jQuery('.feedback_btn > a').addClass('wp2yt-active-link');
						jQuery('#help_page_uploader_div').hide();
						jQuery('#help_page_recent_uploads_div').hide();
						jQuery('#help_page_about_div').hide();
						jQuery('#help_page_oauth2help_div').hide();
						jQuery('#help_page_feedback_div').fadeIn('fast');
					});
					
			/* jQuery to enable/disable input boxes */
			if (jQuery('#add_yt_account2_checkbox').is(':checked')){
					jQuery('#yt_account2').removeAttr("disabled");
					jQuery('#yt_account2').css("background-color", "white");
					jQuery('#yt_account2').css("opacity", "1");
			} else {
					jQuery('#yt_account2').attr("disabled", "disabled");
					jQuery('#yt_account2').css("background-color", "c4c4c4");
					jQuery('#yt_account2').css("opacity", ".18");
			}
		
			/* jQuery to enable/disable input boxes */
			jQuery('#add_yt_account2_checkbox').on("click", function(){
				if (jQuery('#add_yt_account2_checkbox').is(':checked')){
						jQuery('#yt_account2').removeAttr("disabled");
						jQuery('#yt_account2').css("background-color", "white");
						jQuery('#yt_account2').css("opacity", "1");
				} else {
						jQuery('#yt_account2').attr("disabled", "disabled");
						jQuery('#yt_account2').css("background-color", "c4c4c4");
						jQuery('#yt_account2').css("opacity", ".18");
				}
			});
			
			/* jQuery to enable/disable input boxes */
			if (jQuery('#add_yt_account3_checkbox').is(':checked')){
					jQuery('#yt_account3').removeAttr("disabled");
					jQuery('#yt_account3').css("background-color", "white");
					jQuery('#yt_account3').css("opacity", "1");
			} else {
					jQuery('#yt_account3').attr("disabled", "disabled");
					jQuery('#yt_account3').css("background-color", "c4c4c4");
					jQuery('#yt_account3').css("opacity", ".18");
			}
		
			/* jQuery to enable/disable input boxes */
			jQuery('#add_yt_account3_checkbox').on("click", function(){
				if (jQuery('#add_yt_account3_checkbox').is(':checked')){
						jQuery('#yt_account3').removeAttr("disabled");
						jQuery('#yt_account3').css("background-color", "white");
						jQuery('#yt_account3').css("opacity", "1")
				} else {
						jQuery('#yt_account3').attr("disabled", "disabled");
						jQuery('#yt_account3').css("background-color", "c4c4c4");
						jQuery('#yt_account3').css("opacity", ".18");
				}
			});
			
			/* jQuery to enable/disable input boxes */
			if (jQuery('#add_yt_account4_checkbox').is(':checked')){
					jQuery('#yt_account4').removeAttr("disabled");
					jQuery('#yt_account4').css("background-color", "white");
					jQuery('#yt_account4').css("opacity", "1");
			} else {
					jQuery('#yt_account4').attr("disabled", "disabled");
					jQuery('#yt_account4').css("background-color", "c4c4c4");
					jQuery('#yt_account4').css("opacity", ".18");
			}
		
		/* jQuery to enable/disable input boxes */
		jQuery('#add_yt_account4_checkbox').on("click", function(){
			if (jQuery('#add_yt_account4_checkbox').is(':checked')){
					jQuery('#yt_account4').removeAttr("disabled");
					jQuery('#yt_account4').css("background-color", "white");
					jQuery('#yt_account4').css("opacity", "1")
			} else {
					jQuery('#yt_account4').attr("disabled", "disabled");
					jQuery('#yt_account4').css("background-color", "c4c4c4");
					jQuery('#yt_account4').css("opacity", ".18");
			}
		});
		
		/* jQuery to enable/disable input boxes */
		if (jQuery('#add_yt_account5_checkbox').is(':checked')){
					jQuery('#yt_account5').removeAttr("disabled");
					jQuery('#yt_account5').css("background-color", "white");
					jQuery('#yt_account5').css("opacity", "1");
			} else {
					jQuery('#yt_account5').attr("disabled", "disabled");
					jQuery('#yt_account5').css("background-color", "c4c4c4");
					jQuery('#yt_account5').css("opacity", ".18");
			}
		
		/* jQuery to enable/disable input boxes */
		jQuery('#add_yt_account5_checkbox').on("click", function(){
			if (jQuery('#add_yt_account5_checkbox').is(':checked')){
					jQuery('#yt_account5').removeAttr("disabled");
					jQuery('#yt_account5').css("background-color", "white");
					jQuery('#yt_account5').css("opacity", "1")
			} else {
					jQuery('#yt_account5').attr("disabled", "disabled");
					jQuery('#yt_account5').css("background-color", "c4c4c4");
					jQuery('#yt_account5').css("opacity", ".18");
			}
		});
		
		/* jQuery to insert embed code into posts, and to close media upload thicbox */
		jQuery('.insert-video-to-post-btn').click(function() {
			var embedLink = jQuery(this).parents('div#videos').find('#embedLinkDiv').text();
			embedLink = jQuery.trim(embedLink);
			window.parent.send_to_editor(embedLink);
			window.parent.tb_remove();
		});
		
		/* jQuery to insert new uploads into posts, and to close media upload thicbox */
		jQuery('.new-upload-insert-video-to-post-btn').click(function() {
			var embedLink = jQuery(this).attr('value');
			embedLink = jQuery.trim(embedLink);
			window.parent.send_to_editor(embedLink);
			window.parent.tb_remove();
		});
		
		jQuery('.wp2yt-external-wordpress-link').mouseenter(function() {
					jQuery('.wp2yt-wordpress-link-text').stop().fadeIn('fast');
				});
		jQuery('.wp2yt-external-wordpress-link').mouseleave(function() {
					jQuery('.wp2yt-wordpress-link-text').stop().fadeOut('fast');
				});	
		jQuery('.wp2yt-external-site-link').mouseenter(function() {
						jQuery('.wp2yt-external-site-link-text').stop().fadeIn('fast');
					});
		jQuery('.wp2yt-external-site-link').mouseleave(function() {
					jQuery('.wp2yt-external-site-link-text').stop().fadeOut('fast');
				});	
		jQuery('.wp2yt-external-plugin-link').mouseenter(function() {
						jQuery('.wp2yt-plugin-link-text').stop().fadeIn('fast');
					});
		jQuery('.wp2yt-external-plugin-link').mouseleave(function() {
					jQuery('.wp2yt-plugin-link-text').stop().fadeOut('fast');
				});		

		jQuery('.stv_oauth2_input').parents('td').addClass('wp2yt-flex');
		
		jQuery('.wp2yt-eherman-profile-pic').mouseenter(function(){
			jQuery('.wp2yt-profile-pic-text').stop().fadeIn('fast');
		});
		jQuery('.wp2yt-eherman-profile-pic').mouseleave(function(){
			jQuery('.wp2yt-profile-pic-text').stop().fadeOut('fast');
		});
		
		jQuery('.ui-tabs-nav > li > a').click(function() {
			jQuery('.ui-tabs-anchor').removeClass('wp2yt-active-link');
			jQuery(this).addClass('wp2yt-active-link');
		});
		
		/* disable inputs on form submit */	
		/* uploader form validation and tooltips */
		jQuery('#form1').tooltip({track:true});
			jQuery('.wp2yt-first-uploader-step-btn').click(function(){
				jQuery('#wp2yt_video_title').removeAttr('title');
				jQuery('#wp2yt-video-description').removeAttr('title');
				jQuery('#wp2yt_video_title').val().trim(wp2yt_video_title);
					if(jQuery.trim(jQuery('#wp2yt_video_title').val() ) == '' && jQuery.trim(jQuery('#wp2yt-video-description').val() ) == '') {
						jQuery('#wp2yt_video_title').attr('title','Please enter a video title');
						jQuery('#wp2yt-video-description').attr('title','Please enter a description for your video');
						var tooltips = jQuery("#form1 [title]").tooltip();
						tooltips.tooltip( "open" );
						return false;
					} else if (jQuery.trim(jQuery('#wp2yt_video_title').val() ) == '') {
						jQuery('#wp2yt_video_title').attr('title','Please enter a video title');
						var tooltips = jQuery("#form1 [title]").tooltip();
						tooltips.tooltip( "open" );
						return false;
					} else if (jQuery.trim(jQuery('#wp2yt-video-description').val() ) == '') {
						jQuery('#wp2yt-video-description').attr('title','Please enter a description for your video');
						var tooltips = jQuery("#form1 [title]").tooltip();
						tooltips.tooltip( "open" );
						return false;
					} else {
						jQuery('#form1').submit();
						jQuery('#wp2yt_video_title').attr('disabled' , true);
						jQuery('#wp2yt-video-description').attr('disabled' , true);
						jQuery('.tagit-new > input[type=text]').attr('disabled' , true);
						jQuery('#wp2yt_video_categories').attr('disabled' , true);
						jQuery('.wp2yt-first-uploader-step-btn').attr('disabled' , true);
					}
		});	
		
		/* check file extension on file being uploaded */
		jQuery('#submit2').click(function() {
			wp2ytCheckFileExtension();
		});
		
		function wp2ytCheckFileExtension() {
			var ext = jQuery('.youtube-input input[name=file]').val().split('.').pop().toLowerCase();
				if(jQuery.inArray(ext, ['mov','mp4','avi','wmv', 'mpegps', 'flv', 'webm']) == -1) {
					alert('That file format is unsupported. Please select a supported format.');
					event.preventDefault();
			} else {
				jQuery('#fileUploadForm').submit();
				jQuery('.youtube-input input[type=file]').attr('disabled',true);
				jQuery('.block > label').css('cursor','default');
				jQuery('#submit2').attr('disabled',true);
			}
		}
		
		/* youtube connection checker - show/hide images dependent upon auth value in hidden input */
		jQuery('.wp2yt-check-yt-connect-btn').click(function() {
			jQuery('.check-complete-message').hide();
			jQuery('.check-settings-images').hide();
			jQuery('.wp2yt-check-settings-img').hide();
			jQuery('.check-settings-images').fadeIn('fast');
			jQuery('.wp-default-preloader').fadeIn('fast').delay(600).fadeOut('fast');
			var youtubeAuthKeyResponse = jQuery('#youTubeAuthKeyResponseInput').val();
				if (youtubeAuthKeyResponse == "BadAuthentication" || youtubeAuthKeyResponse == "Unknown") {
					jQuery('.incorrect-settings-x').delay(800).fadeIn('slow');
					setTimeout(function() {
						jQuery('.wp2yt-check-yt-connection').append('<p class="check-complete-message wp2yt-red">Error: Please check your account name and password are entered correctly</p>');	
					}, 1000);
				} else {
					jQuery('.correct-settings-checkmark').delay(800).fadeIn('slow');
					setTimeout(function() {
						jQuery('.wp2yt-check-yt-connection').append('<p class="check-complete-message wp2yt-green">Success: Your account and password appear correct.</p>');	
					}, 1000);
				}	
		});
						
		/* add class on load - to color active tab */
		jQuery('#ui-id-1').addClass('wp2yt-active-link');
		/* tabs color acting funny, work around */		
		jQuery('#ui-id-3').css('color','#fff');
		jQuery('#ui-id-2').css('color','#fff');
		
		
		/* Fix Error Checking */
		jQuery('#use_yt_analytics_checkbox').click(function() {
			var googleAuthID = jQuery("#stv_oauth2_input").val();
						console.log(googleAuthID);

			if( googleAuthID == "" ) {
				jQuery(".wp2yt-oauth2-clientid-length-warning").fadeIn();
				jQuery(this).prop("checked", false);
			} 
		});
		
		/*
		jQuery("#stv_oauth2_input").keyup(checkOAUTH2Length);
		
		**** Function included in the minified version, minified and beautified version are different ****
		
		function checkOAUTH2Length() {
			var googAuthID=jQuery("#stv_oauth2_input").val().length;
			if (googAuthID < 72) {
				jQuery("#use_yt_analytics_checkbox").prop("checked",false);
				jQuery(".wp2yt-oauth2-clientid-length-warning").fadeIn();
			} else {
				jQuery(".wp2yt-oauth2-clientid-length-warning").fadeOut();
			}
		}
		*?
		
		/* show hide OAUTH2 Input on select/deselect 
		jQuery('#use_yt_analytics_checkbox').click(hideAndDisplayOAUTH2Input);
		if (jQuery('#use_yt_analytics_checkbox').is(':checked')){
						// do nothing
				} else {
						jQuery('#use_yt_analytics_checkbox').parents('tr').next().hide();
		}
			
		function hideAndDisplayOAUTH2Input() {
			if (jQuery('#use_yt_analytics_checkbox').is(':checked')){
					 jQuery('#use_yt_analytics_checkbox').parents('tr').next().fadeIn('fast');
			} else {
					jQuery('#use_yt_analytics_checkbox').parents('tr').next().fadeOut('fast');
			}
		}
	  */
	  
	jQuery(window).scroll(function(){
		jQuery('.title_and_video_count_div').css({
			'left': jQuery(this).scrollLeft() + 15 //Why this 15, because in the CSS, we have set left 15, so as we scroll, we would want this to remain at 15px left
		});
	});
		
});  /* end document ready */

// URL To Direct to after selecting 'Upload New Content'
function refresh_upload_page() {
	 window.location.href = '/wp-admin/admin.php?page=wp2yt_uploader';
}