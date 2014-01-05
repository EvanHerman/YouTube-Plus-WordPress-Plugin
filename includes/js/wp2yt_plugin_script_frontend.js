/* 	   WP2YT Front End jQuery Scripts 	*/
/* Created by Evan Herman (eherman24) */
/* 			www.Evan-Herman.com				*/


jQuery(function() {

		jQuery("#progress_bar_container").addClass("no-progress-bar");
		
		jQuery('#youtube_uploader_image > img').addClass("wp2yt-logo-frontend");
	
			jQuery('#video_keywords').tagit({
				singleField: true,
				removeConfirmation: true
            });
		jQuery('.ui-helper-hidden-accessible').hide();	
		
		// Add margin underneath iframe
		jQuery(".entry-content > .fluidvids").css("margin-bottom","1em");
		
});