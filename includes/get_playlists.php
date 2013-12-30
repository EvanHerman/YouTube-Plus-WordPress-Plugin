<?php
/* get_playlist.php grabs users videos from youtube account via json */
/* contains oauth2 variable, api key, account names and password */
/*					Compiled By: Evan Herman (eherman24)				 */
/*							www.Evan-Herman.com							  */
/*---------------------------------------------------------------------------------------*/	
	//Declare Variables
	$account = get_option('yt_account');
	$account2_checkbox = get_option('add_yt_account2_checkbox');
	$account3_checkbox = get_option('add_yt_account3_checkbox');
	$account4_checkbox = get_option('add_yt_account4_checkbox');
	$account5_checkbox = get_option('add_yt_account5_checkbox');
	$password = get_option('yt_pass');
	
	/* hide the insert to post button if not on new-page.php new-post.php edit-page edit-post etc. */
	$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
	
			if (false !== strpos($url,'media-upload.php')) { ?>
				<style>.insert-video-to-post-btn, .new-upload-insert-video-to-post-btn { display:inherit; } #ui-id-4, .wp2yt-delete-video-btn  { display:none !important; } </style>
				<?php /* echo 'this is the media upload page'; */ ?>
		<?php	} else { ?>
				<style>.insert-video-to-post-btn, .new-upload-insert-video-to-post-btn { display:none; } #ui-id-4, .wp2yt-delete-video-btn { display:inherit; }</style>
				<?php /* echo 'nahhhh'; */ ?>
			<?php } ?>
	

	<?php if(empty($account)) : ?>

	<script>
	jQuery(document).ready(function() {
		jQuery(".wp2yt-refresh-playlists").remove();	
	});
	</script>
	
	<div id="missing-information" style="width:600px;">

			<h3 style="color:red; width:350px; display:inline;"><img alt='' style="margin-right:10px;" src="<?php echo plugins_url( '/WP2YT-Uploader/includes/images/red-x.png' );?>">Error!<img alt='' style="margin-left:10px;" src="<?php echo plugins_url( '/WP2YT-Uploader/includes/images/red-x.png' );?>"> </h3> 

			<p>Your missing your <b>account name</b>. Without this you wont be able to view the content on your YouTube channel.

			Please go in to the <i><a href="<?php echo admin_url() . 'options-general.php?page=wp2yt_settings';?>">'Youtube Uploader Settings'</a></i> page and double check

			that you have entered it properly.</p>						<p><i><span class="wp2yt-red">note: </span>You must enter your account name even if there is no content on your channel.</i></p>

	</div>

	

	<?php elseif(!empty($account)) : ?>

	<div id="playlists">	<div id="500-internal-error"></div>
	<input type="hidden" name="youtubeAccountName" value="<?php echo $account; ?>">
		<div id="ytu_recent_upload_content" class="show_playlist"> <!-- start playlist1 div -->		
	<?php	

			//Recent Uploads Variable
			$account_name = get_option('yt_account');

			//Recent Uploads Get Link
			$url = "http://gdata.youtube.com/feeds/api/users/". $account_name ."/uploads?v=2&alt=json";

			$data = json_decode(@file_get_contents($url),true);

			$info = $data["feed"];

			$video = $info["entry"];

			$nVideo = count($video);

			?>
				
				<div class="title_and_video_count_div"> 
			<?php
					echo "<h4>Recent ".$info["title"]['$t'].'</h4>';
					echo "<b><i>Number of Videos: ".$nVideo."</i></b>";
			?>
				</div>	

			<div class="scrollable-content">			

			<?php

			for($i=0;$i<25;$i++){
			
			

			?>				
			
			<!-- if loop returns no video title due to incorrect account name, or no videos -->
			<?php if($nVideo == '0') : ?>				<script>				jQuery(document).ready(function() {					jQuery('#ytu_recent_upload_content').css('height','227px');				});				</script>			
				<div class="no_videos_error" style="width:714px; padding-bottom:15px;">
					<h3 style="color:red;"><img alt='' style="margin-right:10px; margin-bottom:0px; border:none; height:14px;box-shadow:none;" src="<?php echo plugins_url( '/WP2YT-Uploader/includes/images/red-x.png' );?>"> OH NO! <img alt='' style="margin-left:10px; margin-bottom:0px; border:none; height:14px;box-shadow:none;" src="<?php echo plugins_url( '/WP2YT-Uploader/includes/images/red-x.png' );?>"></h3>
						<p><i>It appears that there is currently no content on <?php echo '<b>'.get_option('yt_account').'</b>'; ?>'s YouTube channel. If you are sure there are videos, double 
						check that you have entered the account name properly. </i></p>
						<br/>
						<br/>
						<li style="padding-left:15px; font-size:11px;"><i><b style="color:green;">Tip:  </b> If the account name was mistyped you will receive this error.</i></li>
						</div>	
					<?php break; ?> <!-- break loop -->
				</div>
				
			<!-- if loop returns no video title break loop -->
			<?php elseif(@$video[$i]['title']['$t'] == '') : ?>
					<?php break; ?> <!-- break loop -->	
				
		
			<!-- if title is found -->	
			<?php elseif($video[$i]['title']['$t'] !== '') : ?>	
			
			<div id="videos" style="display:inline; float:left; padding:1em;">
			
				<!-- add if statement -->
				
				<div class="titlebox">

				<?php
					//Print Video Title
					echo "<a class='wp2yt-title-link' href='http://www.youtube.com/watch?feature=player_embedded&v=".$video[$i]['media$group']['yt$videoid']['$t']."' target='_blank'>".$video[$i]['title']['$t']; ?>
				   </div>

				<div class="imagebox"><!-- start imagebox div -->									
					<?php echo "<a href='http://www.youtube.com/watch?feature=player_embedded&v=".$video[$i]['media$group']['yt$videoid']['$t']."' target='_blank'><span class='wp2yt-preview-image-overlay'><span style='font-size:4em;' class='wp2yt-icon-play'><i> </i></span></span><img class='wp2yt-video-thumbnail' alt='' src='".$video[$i]['media$group']['media$thumbnail'][1]['url']."' /></a><br />"; ?>

					<!-- add a preview button -->
					<div class="wp-2-yt-buttons">
						<a class="button-primary preview-yt-video-btn" target="_blank" href="http://www.youtube.com/watch?feature=player_embedded&v=<?php echo $video[$i]['media$group']['yt$videoid']['$t']; ?>"><span class="wp2yt-icon-play"><i> </i></span></a>						
						<button class="btn btn-small btn-success insert-video-to-post-btn"><span class="icon-forward"><i> </i></span></button>
						<button class="btn btn-small btn-danger wp2yt-delete-video-btn" onclick="wp2yt_delete_video.call(this)"><span class="icon-remove"><i> </i></span></button>						
					</div>

					</div><!--end imagebox --> 
					
					<div class="statsBox"><!--start statsBox -->
							
						<div class="viewBox"><?php if (@$video[$i]['yt$statistics']["viewCount"] == 0) { echo '<p>Total Views: 0</p>'; } else { echo "<p>Total Views:".@$video[$i]['yt$statistics']["viewCount"].'</p><br/>'; } ?> </div> <!-- end viewBox -->
						<div class="likeBox"><?php if (@$video[$i]['yt$rating']["numLikes"] == 0) { echo '<p>Total Likes: 0</p>'; } else { echo "<p>Total Likes:".@$video[$i]['yt$rating']["numLikes"].'</p><br/>'; } ?> </div> 	<!-- end likeBox -->

					</div><!-- end statsBox -->

					<div id="descriptionDiv" style="padding-top:.3em; width:500px; overflow:hidden; max-height:155px; min-height:145px;"> 

					<?php

					// add description

					echo "<p><b>Description:</b> ".$video[$i]['media$group']['media$description']['$t'].'<br/></p>';

					?> </div> <!-- end descriptionDIV --> 

					<div id="embedLinkDiv" style="width:500px; padding-top:.5em;">
					<input name="uniqueVideoID" type="hidden" value="<?php echo $video[$i]['media$group']['yt$videoid']['$t']; ?>">
						<?php echo  htmlentities('[iframe]<iframe width="640" height="480" src="http://www.youtube.com/embed/') . $video[$i]['media$group']['yt$videoid']['$t'] . htmlentities('" frameborder="0" allowfullscreen="1"></iframe>[/iframe]'); ?>
					
					</div> <!-- end embedDiv div -->				
					
			</div> <!-- end videos div -->
			<?php endif; ?>
						<?php

						}
					
						?>

			</div> <!-- end scrollable-content div -->

		</div> <!-- end kenrd_knews_playlist div -->

			
		
	<?php if(($account2_checkbox)==true) { ?> 	
		
		<div id="ytu2_recent_upload_content" class="show_playlist"> <!-- start playlist1 div -->

	<?php	

			//Recent Uploads Variable

			$account_name2 = get_option('yt_account2');

			//Recent Uploads Get Link

			$url = "http://gdata.youtube.com/feeds/api/users/". $account_name2 ."/uploads?v=2&alt=json";

			$data = json_decode(@file_get_contents($url),true);

			$info = $data["feed"];

			$video = $info["entry"];

			$nVideo = count($video);

			
			?>
				<div class="title_and_video_count_div"> 
			<?php
					echo "<h4>Recent ".$info["title"]['$t'].'</h4>';
					echo "<b><i>Number of Videos: ".$nVideo."</i></b>";
			?>
				</div>
	
			<div class="scrollable-content">

			<?php

			for($i=0;$i<25;$i++){

			?>
			<!-- if loop returns no video title due to incorrect account name, or no videos -->
			<?php if($nVideo == '0') : ?>
				<div class="no_videos_error" style="width:714px; padding-bottom:15px;">
					<h3 style="color:red;"><img alt='' style="margin-right:10px; margin-bottom:0px; border:none; height:14px;box-shadow:none;" src="<?php echo plugins_url( '/WP2YT-Uploader/includes/images/red-x.png' );?>"> OH NO! <img alt='' style="margin-left:10px; margin-bottom:0px; border:none; height:14px;box-shadow:none;" src="<?php echo plugins_url( '/WP2YT-Uploader/includes/images/red-x.png' );?>"></h3>
						<p><i>It appears that there is currently no content on <?php echo '<b>'.get_option('yt_account2').'</b>'; ?>'s YouTube channel. If you are sure there are videos, double 
						check that you have entered the account name properly. </i></p>
						<br/>
						<br/>
						<li style="padding-left:15px; font-size:11px;"><i><b style="color:green;">Tip: </b> If the account name was mistyped you will receive this error.</i></li>
						</div>	
					<?php break; ?> <!-- break loop -->
				</div>
			
			<!-- if loop returns no video title break loop -->
			<?php elseif(@$video[$i]['title']['$t'] == '') : ?>
					<?php break; ?> <!-- break loop -->
			
			<!-- if title is found -->	
			<?php elseif($video[$i]['title']['$t'] !== '') : ?>	
			
			<div id="videos" style="display:inline; float:left; padding:1em;">

				<div class="titlebox">

				<?php

					//Print Video Title

					echo "<a class='wp2yt-title-link' href='http://www.youtube.com/watch?feature=player_embedded&v=".$video[$i]['media$group']['yt$videoid']['$t']."' target='_blank'>".$video[$i]['title']['$t'].'</a><br/>';

				?> </div>

				<div class="imagebox"><!-- start imagebox div -->
				
				<?php echo "<a href='http://www.youtube.com/watch?feature=player_embedded&v=".$video[$i]['media$group']['yt$videoid']['$t']."' target='_blank'><span class='wp2yt-preview-image-overlay'><span style='font-size:4em;' class='wp2yt-icon-play'><i> </i></span></span><img class='wp2yt-video-thumbnail' alt='' src='".$video[$i]['media$group']['media$thumbnail'][1]['url']."' /></a><br />"; ?>
					
					<div class="wp-2-yt-buttons">
						<!-- add a preview button -->
						<a class="button-primary preview-yt-video-btn" target="_blank" href="http://www.youtube.com/watch?feature=player_embedded&v=<?php echo $video[$i]['media$group']['yt$videoid']['$t']; ?>"><span class="wp2yt-icon-play"><i> </i></span></a>
						<button class="btn btn-small btn-success insert-video-to-post-btn"><span class="icon-forward"><i> </i></span></button>
					</div>
					
					</div><!--end imagebox --> 

					
					<div class="statsBox"><!--start statsBox -->

						<div class="viewBox"><?php if (@$video[$i]['yt$statistics']["viewCount"] == 0) { echo '<p>Total Views: 0</p>'; } else { echo "<p>Total Views:".@$video[$i]['yt$statistics']["viewCount"].'</p><br/>'; } ?> </div> <!-- end viewBox -->
						<div class="likeBox"><?php if (@$video[$i]['yt$rating']["numLikes"] == 0) { echo '<p>Total Likes: 0</p>'; } else { echo "<p>Total Likes:".@$video[$i]['yt$rating']["numLikes"].'</p><br/>'; } ?> </div> 	<!-- end likeBox -->

					</div><!-- end statsBox -->

					

					<div id="descriptionDiv" style="padding-top:.3em; width:500px;overflow:hidden; max-height:155px; min-height:145px;"> 

					<?php

					// add description

					echo "<p><b>Description:</b> ".$video[$i]['media$group']['media$description']['$t'].'<br/></p>';

					?> </div> <!-- end descriptionDIV --> 

					<!-- begin hidden embed link div -->
					
					<div id="embedLinkDiv" style="width:500px; padding-top:.5em;">
					<input name="uniqueVideoID" type="hidden" value="<?php echo $video[$i]['media$group']['yt$videoid']['$t']; ?>">
						<?php echo  htmlentities('[iframe]<iframe width="640" height="480" src="http://www.youtube.com/embed/') . $video[$i]['media$group']['yt$videoid']['$t'] . htmlentities('" frameborder="0" allowfullscreen="1"></iframe>[/iframe]'); ?>
					
					</div> <!-- end enbedDiv div -->				

					<?php					


				?>	

			</div> <!-- end videos div -->

			<?php endif; ?> <!-- end if checking yt_account2 video title -->
			
						<?php

						} //end loop
		
		
						?>

			</div> <!-- end scrollable-content div -->

		</div> <!-- end kenrd_knews_playlist div -->
	<?php } ?>

	<?php if(($account3_checkbox)==true) { ?> 	
		
		<div id="ytu2_recent_upload_content" class="show_playlist"> <!-- start playlist1 div -->

	<?php	

			//Recent Uploads Variable

			$account_name3 = get_option('yt_account3');

			//Recent Uploads Get Link

			$url = "http://gdata.youtube.com/feeds/api/users/". $account_name3 ."/uploads?v=2&alt=json";

			$data = json_decode(@file_get_contents($url),true);

			$info = $data["feed"];

			$video = $info["entry"];

			$nVideo = count($video);

			
			?>
				<div class="title_and_video_count_div"> 
			<?php
					echo "<h4>Recent ".$info["title"]['$t'].'</h4>';
					echo "<b><i>Number of Videos: ".$nVideo."</i></b>";
			?>
				</div>	

			<div class="scrollable-content">

	

			<?php

			for($i=0;$i<25;$i++){

			?>	
			
			<!-- if loop returns no video title due to incorrect account name, or no videos -->
			<?php if($nVideo == '0') : ?>
				<div class="no_videos_error" style="width:714px; padding-bottom:15px;">
					<h3 style="color:red;"><img alt='' style="margin-right:10px; margin-bottom:0px; border:none; height:14px;box-shadow:none;" src="<?php echo plugins_url( '/WP2YT-Uploader/includes/images/red-x.png' );?>"> OH NO! <img alt='' style="margin-left:10px; margin-bottom:0px; border:none; height:14px;box-shadow:none;" src="<?php echo plugins_url( '/WP2YT-Uploader/includes/images/red-x.png' );?>"></h3>
						<p><i>It appears that there is currently no content on <?php echo '<b>'.get_option('yt_account3').'</b>'; ?>'s YouTube channel. If you are sure there are videos, double 
						check that you have entered the account name properly. </i></p>
						<br/>
						<br/>
						<li style="padding-left:15px; font-size:11px;"><i><b style="color:green;">Tip: </b> If the account name was mistyped you will receive this error.</i></li>
						</div>	
					<?php break; ?> <!-- break loop -->
				</div>
				
			<!-- if loop returns no video title break loop -->
			<?php elseif(@$video[$i]['title']['$t'] == '') : ?>
					<?php break; ?> <!-- break loop -->	
			
			<!-- if title is found -->	
			<?php elseif($video[$i]['title']['$t'] !== '') : ?>	
			
			<div id="videos" style="display:inline; float:left; padding:1em;">

				<div class="titlebox">

				<?php

					//Print Video Title

					echo "<a class='wp2yt-title-link' href='http://www.youtube.com/watch?feature=player_embedded&v=".$video[$i]['media$group']['yt$videoid']['$t']."' target='_blank'>".$video[$i]['title']['$t'].'<br/>';

				?> </div>

				<div class="imagebox"><!-- start imagebox div -->

				<?php echo "<a href='http://www.youtube.com/watch?feature=player_embedded&v=".$video[$i]['media$group']['yt$videoid']['$t']."' target='_blank'><span class='wp2yt-preview-image-overlay'><span style='font-size:4em;' class='wp2yt-icon-play'><i> </i></span></span><img class='wp2yt-video-thumbnail' alt='' src='".$video[$i]['media$group']['media$thumbnail'][1]['url']."' /><br />"; ?>
					
					<div class="wp-2-yt-buttons">
						<!-- add a preview button -->
						<a class="button-primary preview-yt-video-btn" target="_blank" href="http://www.youtube.com/watch?feature=player_embedded&v=<?php echo $video[$i]['media$group']['yt$videoid']['$t']; ?>"><span class="wp2yt-icon-play"><i> </i></span></a>
						<button class="btn btn-small btn-success insert-video-to-post-btn"><span class="icon-forward"><i> </i></span></button>
					</div>
					
					</div><!--end imagebox --> 
					
					<div class="statsBox"><!--start statsBox -->

						<div class="viewBox"><?php if (@$video[$i]['yt$statistics']["viewCount"] == 0) { echo '<p>Total Views: 0</p>'; } else { echo "<p>Total Views:".@$video[$i]['yt$statistics']["viewCount"].'</p><br/>'; } ?> </div> <!-- end viewBox -->
						<div class="likeBox"><?php if (@$video[$i]['yt$rating']["numLikes"] == 0) { echo '<p>Total Likes: 0</p>'; } else { echo "<p>Total Likes:".@$video[$i]['yt$rating']["numLikes"].'</p><br/>'; } ?> </div> 	<!-- end likeBox -->

					</div><!-- end statsBox -->

					

					<div id="descriptionDiv" style="padding-top:.3em; width:500px; overflow:hidden; max-height:155px; min-height:145px;"> 

					<?php

					// add description

					echo "<p><b>Description:</b> ".$video[$i]['media$group']['media$description']['$t'].'<br/></p>';

					?> </div> <!-- end descriptionDIV --> 

					<!-- begin hidden embed link div -->

					<div id="embedLinkDiv" style="width:500px; padding-top:.5em;">
					<input name="uniqueVideoID" type="hidden" value="<?php echo $video[$i]['media$group']['yt$videoid']['$t']; ?>">	
						<?php echo  htmlentities('[iframe]<iframe width="640" height="480" src="http://www.youtube.com/embed/') . $video[$i]['media$group']['yt$videoid']['$t'] . htmlentities('" frameborder="0" allowfullscreen="1"></iframe>[/iframe]'); ?>
					
					</div> <!-- end enbedDiv div -->				

			</div> <!-- end videos div -->

			<?php endif; ?> <!-- end if yt_account3 video title -->
			
						<?php

						} //end loop
		
		
						?>

			</div> <!-- end scrollable-content div -->

		</div> <!-- end kenrd_knews_playlist div -->
	<?php } ?>

	<?php if(($account4_checkbox)==true) { ?> 	
		
		<div id="ytu2_recent_upload_content" class="show_playlist"> <!-- start playlist1 div -->

	<?php	

			//Recent Uploads Variable

			$account_name4 = get_option('yt_account4');

			//Recent Uploads Get Link

			$url = "http://gdata.youtube.com/feeds/api/users/". $account_name4 ."/uploads?v=2&alt=json";

			$data = json_decode(@file_get_contents($url),true);

			$info = $data["feed"];

			$video = $info["entry"];

			$nVideo = count($video);

			?>
				<div class="title_and_video_count_div"> 
			<?php
					echo "<h4>Recent ".$info["title"]['$t'].'</h4>';
					echo "<b><i>Number of Videos: ".$nVideo."</i></b>";
			?>
				</div>	

			<div class="scrollable-content">

	

			<?php for($i=0;$i<25;$i++){ ?>		
			
			<!-- if loop returns no video title due to incorrect account name, or no videos -->
			<?php if($nVideo == '0') : ?>
				<div class="no_videos_error" style="width:714px; padding-bottom:15px;">
					<h3 style="color:red;"><img alt='' style="margin-right:10px; margin-bottom:0px; border:none; height:14px;box-shadow:none;" src="<?php echo plugins_url( '/WP2YT-Uploader/includes/images/red-x.png' );?>"> OH NO! <img alt='' style="margin-left:10px; margin-bottom:0px; border:none; height:14px;box-shadow:none;" src="<?php echo plugins_url( '/WP2YT-Uploader/includes/images/red-x.png' );?>"></h3>
						<p><i>It appears that there is currently no content on <?php echo '<b>'.get_option('yt_account4').'</b>'; ?>'s YouTube channel. If you are sure there are videos, double 
						check that you have entered the account name properly. </i></p>
						<br/>
						<br/>
						<li style="padding-left:15px; font-size:11px;"><i><b style="color:green;">Tip: </b> If the account name was mistyped you will receive this error.</i></li>
						</div>	
					<?php break; ?> <!-- break loop -->
				</div>
				
			<!-- if loop returns no video title break loop -->
			<?php elseif(@$video[$i]['title']['$t'] == '') : ?>
					<?php break; ?> <!-- break loop -->	
			
			<!-- if title is found -->	
			<?php elseif($video[$i]['title']['$t'] !== '') : ?>	
			
			<div id="videos" style="display:inline; float:left; padding:1em;">

				<div class="titlebox">

				<?php

					//Print Video Title

					echo "<a class='wp2yt-title-link' href='http://www.youtube.com/watch?feature=player_embedded&v=".$video[$i]['media$group']['yt$videoid']['$t']."' target='_blank'>".$video[$i]['title']['$t'].'<br/>';

				?> </div>

				<div class="imagebox"><!-- start imagebox div -->

				<?php echo "<a href='http://www.youtube.com/watch?feature=player_embedded&v=".$video[$i]['media$group']['yt$videoid']['$t']."' target='_blank'><span class='wp2yt-preview-image-overlay'><span style='font-size:4em;' class='wp2yt-icon-play'><i> </i></span></span><img class='wp2yt-video-thumbnail' alt='' src='".$video[$i]['media$group']['media$thumbnail'][1]['url']."' /><br />"; ?>
					
					<div class="wp-2-yt-buttons">
						<!-- add a preview button -->
						<a class="button-primary preview-yt-video-btn" target="_blank" href="http://www.youtube.com/watch?feature=player_embedded&v=<?php echo $video[$i]['media$group']['yt$videoid']['$t']; ?>"><span class="wp2yt-icon-play"><i> </i></span></a>
						<button class="btn btn-small btn-success insert-video-to-post-btn"><span class="icon-forward"><i> </i></span></button>
					</div>
					
					</div><!--end imagebox --> 
					
					<div class="statsBox"><!--start statsBox -->

						<div class="viewBox"><?php if (@$video[$i]['yt$statistics']["viewCount"] == 0) { echo '<p>Total Views: 0</p>'; } else { echo "<p>Total Views:".@$video[$i]['yt$statistics']["viewCount"].'</p><br/>'; } ?> </div> <!-- end viewBox -->
						<div class="likeBox"><?php if (@$video[$i]['yt$rating']["numLikes"] == 0) { echo '<p>Total Likes: 0</p>'; } else { echo "<p>Total Likes:".@$video[$i]['yt$rating']["numLikes"].'</p><br/>'; } ?> </div> 	<!-- end likeBox -->


					</div><!-- end statsBox -->

					

					<div id="descriptionDiv" style="padding-top:.3em; width:500px; overflow:hidden; max-height:155px; min-height:145px;"> 

					<?php

					// add description

					echo "<p><b>Description:</b> ".$video[$i]['media$group']['media$description']['$t'].'<br/></p>';

					?> </div> <!-- end descriptionDIV --> 

					<!-- begin hidden embed link div -->

					<div id="embedLinkDiv" style="width:500px; padding-top:.5em;">
					<input name="uniqueVideoID" type="hidden" value="<?php echo $video[$i]['media$group']['yt$videoid']['$t']; ?>">
						<?php echo  htmlentities('[iframe]<iframe width="640" height="480" src="http://www.youtube.com/embed/') . $video[$i]['media$group']['yt$videoid']['$t'] . htmlentities('" frameborder="0" allowfullscreen="1"></iframe>[/iframe]'); ?>
					
					</div> <!-- end enbedDiv div -->

			</div> <!-- end videos div -->

			<?php endif; ?> <!-- end if yt_account4 video title -->
			
						<?php

						} //end loop
		
		
						?>

			</div> <!-- end scrollable-content div -->

		</div> <!-- end kenrd_knews_playlist div -->
	<?php } ?>	
	
	<?php if(($account5_checkbox)==true) { ?> 	
		
		<div id="ytu2_recent_upload_content" class="show_playlist"> <!-- start playlist1 div -->

	<?php	

			//Recent Uploads Variable

			$account_name5 = get_option('yt_account5');

			//Recent Uploads Get Link

			$url = "http://gdata.youtube.com/feeds/api/users/". $account_name5 ."/uploads?v=2&alt=json";

			$data = json_decode(@file_get_contents($url),true);

			$info = $data["feed"];

			$video = $info["entry"];

			$nVideo = count($video);

			
			?>
				<div class="title_and_video_count_div"> 
			<?php
					echo "<h4>Recent ".$info["title"]['$t'].'</h4>';
					echo "<b><i>Number of Videos: ".$nVideo."</i></b>";
			?>
				</div>	

			<div class="scrollable-content">

	

			<?php for($i=0;$i<25;$i++){ ?>	
			
			<!-- if loop returns no video title due to incorrect account name, or no videos -->
			<?php if($nVideo == '0') : ?>
				<div class="no_videos_error" style="width:714px; padding-bottom:15px;">
					<h3 style="color:red;"><img alt='' style="margin-right:10px; margin-bottom:0px; border:none; height:14px;box-shadow:none;" src="<?php echo plugins_url( '/WP2YT-Uploader/includes/images/red-x.png' );?>"> OH NO! <img alt='' style="margin-left:10px; margin-bottom:0px; border:none; height:14px;box-shadow:none;" src="<?php echo plugins_url( '/WP2YT-Uploader/includes/images/red-x.png' );?>"></h3>
						<p><i>It appears that there is currently no content on <?php echo '<b>'.get_option('yt_account5').'</b>'; ?>'s YouTube channel. If you are sure there are videos, double 
						check that you have entered the account name properly. </i></p>
						<br/>
						<br/>
						<li style="padding-left:15px; font-size:11px;"><i><b style="color:green;">Tip: </b> If the account name was mistyped you will receive this error.</i></li>
						</div>	
					<?php break; ?> <!-- break loop -->
				</div>
				
			<!-- if loop returns no video title break loop -->
			<?php elseif(@$video[$i]['title']['$t'] == '') : ?>
					<?php break; ?> <!-- break loop -->	
			
			<!-- if title is found -->	
			<?php elseif($video[$i]['title']['$t'] !== '') : ?>

			<div id="videos" style="display:inline; float:left; padding:1em;">

				<div class="titlebox">

				<?php

					//Print Video Title

					echo "<a class='wp2yt-title-link' href='http://www.youtube.com/watch?feature=player_embedded&v=".$video[$i]['media$group']['yt$videoid']['$t']."' target='_blank'>".$video[$i]['title']['$t'].'<br/>';

				?> </div>

				<div class="imagebox"><!-- start imagebox div -->

				<?php echo "<a href='http://www.youtube.com/watch?feature=player_embedded&v=".$video[$i]['media$group']['yt$videoid']['$t']."' target='_blank'><span class='wp2yt-preview-image-overlay'><span style='font-size:4em;' class='wp2yt-icon-play'><i> </i></span></span><img class='wp2yt-video-thumbnail' alt='' src='".$video[$i]['media$group']['media$thumbnail'][1]['url']."' /><br />"; ?>
				
					<div class="wp-2-yt-buttons">
						<!-- add a preview button -->
						<a class="button-primary preview-yt-video-btn" target="_blank" href="http://www.youtube.com/watch?feature=player_embedded&v=<?php echo $video[$i]['media$group']['yt$videoid']['$t']; ?>"><span class="wp2yt-icon-play"><i> </i></span></a>
						<button class="btn btn-small btn-success insert-video-to-post-btn"><span class="icon-forward"><i> </i></span></button>
					</div>
					
				</div><!--end imagebox --> 

					<div class="statsBox"><!--start statsBox -->

						<div class="viewBox"><?php if (@$video[$i]['yt$statistics']["viewCount"] == 0) { echo '<p>Total Views: 0</p>'; } else { echo "<p>Total Views:".@$video[$i]['yt$statistics']["viewCount"].'</p><br/>'; } ?> </div> <!-- end viewBox -->
						<div class="likeBox"><?php if (@$video[$i]['yt$rating']["numLikes"] == 0) { echo '<p>Total Likes: 0</p>'; } else { echo "<p>Total Likes:".@$video[$i]['yt$rating']["numLikes"].'</p><br/>'; } ?> </div> 	<!-- end likeBox -->

					</div><!-- end statsBox -->

					

					<div id="descriptionDiv" style="padding-top:.3em; width:500px; overflow:hidden; max-height:155px; min-height:145px;"> 

					<?php

					// add description

					echo "<p><b>Description:</b> ".$video[$i]['media$group']['media$description']['$t'].'<br/></p>';

					?> </div> <!-- end descriptionDIV --> 

					<!-- begin hidden embed link div -->

					<div id="embedLinkDiv" style="width:500px; padding-top:.5em;">
					<input name="uniqueVideoID" type="hidden" value="<?php echo $video[$i]['media$group']['yt$videoid']['$t']; ?>">
						<?php echo  htmlentities('[iframe]<iframe width="640" height="480" src="http://www.youtube.com/embed/') . $video[$i]['media$group']['yt$videoid']['$t'] . htmlentities('" frameborder="0" allowfullscreen="1"></iframe>[/iframe]'); ?>
					
					</div> <!-- end enbedDiv div -->

			</div> <!-- end videos div -->

			<?php endif; ?> <!-- end if return yt_account5 video title -->
			
						<?php

						} //end loop
		
		
						?>

			</div> <!-- end scrollable-content div -->

		</div> <!-- end kenrd_knews_playlist div -->
	<?php } ?>

	
	</div> <!-- end playlists div -->
<?php endif; ?>