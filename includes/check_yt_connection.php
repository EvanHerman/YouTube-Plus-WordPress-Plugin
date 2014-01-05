<?php
    $youtube_email = get_option('yt_email'); // Change this to your youtube sign in email.
    $youtube_password = get_option('yt_pass'); // Change this to your youtube sign in password.
	$key = ''; //no longer needed
	
    $source = 'WordPress to YouTube Uploader Plugin'; // A short string that identifies your application for logging purposes.
    $postdata = "Email=".$youtube_email."&Passwd=".$youtube_password."&service=youtube&source=" . $source;
    $curl = curl_init( "https://www.google.com/youtube/accounts/ClientLogin" );
    curl_setopt( $curl, CURLOPT_HEADER, "Content-Type:application/x-www-form-urlencoded" );
    curl_setopt( $curl, CURLOPT_POST, 1 );
    curl_setopt( $curl, CURLOPT_POSTFIELDS, $postdata );
    curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, 0 );
    curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt( $curl, CURLOPT_SSL_VERIFYHOST, 2 );
    $response = curl_exec( $curl );

    curl_close( $curl );

	
    list( $auth, $youtubeuser ) = explode( "\n", $response );
    list( $authlabel, $authvalue ) = array_map( "trim", explode( "=", $auth ) );
    list( $youtubeuserlabel, $youtubeuservalue ) = array_map( "trim", explode( "=", $youtubeuser ) );
	
	$youTubeAuthKeyResponse = $authvalue;
	    
	$youtube_video_title = 'test video title';
	$youtube_video_description = 'test video description'; // This is the uploading video description.   
	$youtube_video_keywords = 'keyword1, keyword2, keyword3'; // This is the uploading video keywords.
	$youtube_video_category = 'Film'; // This is the uploading video category. There are only certain categories that are accepted. See below 
	
    $data = '<?xml version="1.0"?>
                <entry xmlns="http://www.w3.org/2005/Atom"
                  xmlns:media="http://search.yahoo.com/mrss/"
                  xmlns:yt="http://gdata.youtube.com/schemas/2007">
                  <media:group>
                    <media:title type="plain">Test Video Check</media:title>
                    <media:description type="plain">Test video description</media:description>
                    <media:category
                      scheme="http://gdata.youtube.com/schemas/2007/categories.cat">News</media:category>
                    <media:keywords>key1, key2, key3</media:keywords>
				  </media:group>
                </entry>';

    $headers = array( "Authorization: GoogleLogin auth=".$authvalue,
                 "GData-Version: 2",
                 "X-GData-Key: key=".$key,
                 "Content-length: ".strlen( $data ),
                 "Content-Type: application/atom+xml; charset=UTF-8" );

$curl = curl_init( "http://gdata.youtube.com/action/GetUploadToken");
curl_setopt( $curl, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"] );
curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
curl_setopt( $curl, CURLOPT_TIMEOUT, 10 );
curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $curl, CURLOPT_POST, 1 );
curl_setopt( $curl, CURLOPT_FOLLOWLOCATION, 1 );
curl_setopt( $curl, CURLOPT_HTTPHEADER, $headers );
curl_setopt( $curl, CURLOPT_POSTFIELDS, $data );
curl_setopt( $curl, CURLOPT_REFERER, true );
curl_setopt( $curl, CURLOPT_FOLLOWLOCATION, 1 );
curl_setopt( $curl, CURLOPT_HEADER, 0 );

$response = simplexml_load_string( curl_exec( $curl ) );

curl_close( $curl );

?>