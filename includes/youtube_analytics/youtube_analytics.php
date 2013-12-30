<html>
<head>
  <title>YouTube Analytics</title>
	<script type="text/javascript" src="//www.google.com/jsapi"></script>
	<script type="text/javascript" src="https://apis.google.com/js/client.js?onload=onJSClientLoad"></script>
	
  <style>
body {
  font-family: Helvetica, sans-serif;
  height: auto;
}

.pre-auth {
  display: none;
}

.post-auth {
  display: none;
  width: 95%;
  margin:0 auto;
}

.all-charts-div {
	display: none;
	height: 330px;
}

.choose-video-div {
	padding-bottom: 4em;
}

#message {
	display: none;
	padding-left: 8em;
	padding-top: 2em;
	margin-bottom: 30px;
}

.tables_div {
	width:500px;
	float:right;
	margin-right:2em;
}

.channel_analytics_div {
	width: 100%;
	display:inline-block;
}

		.geo_div {
			width: 760px;  
			float:left;
			
		}
		.channel_stats_div {
			width: 500px; 
			height:100%;
			float:left;
		}		.gender_stats_div {
			width: 500px; 
			height:100%;
			float:left;
			margin-top: 2em;
		}
		.geo_stats_table_div {
			width: 500px; 
			height:100%;
			float:left;
			margin-top: 2em;
		}
		.top_videos_table_div {
			float:left;
			margin-top:2em;
		}
#chart {
  width: 500px;
  height: 300px;
  margin-bottom: 1em;
  float:left;
}

#chart2 {
  width: 500px;
  height: 300px;
  margin-bottom: 1em;
  float:left;
}

#video-list {
  padding-left: 1em;
  list-style-type: none;
}
#video-list > li {
  cursor: pointer;
  float: left;
  padding-right: 1em;
}
#video-list > li:hover {
  color: blue;
}
</style>
  
<script>
(function() {
  // Retrieve your client ID from the Google APIs Console at
  // https://code.google.com/apis/console.
  var OAUTH2_CLIENT_ID = "<?php echo get_option('stv_oauth2_text') ?>";
  var OAUTH2_SCOPES = [
    'https://www.googleapis.com/auth/yt-analytics.readonly',
    'https://www.googleapis.com/auth/youtube.readonly',	'https://gdata.youtube.com'
  ];
  var ONE_MONTH_IN_MILLISECONDS = 1000 * 60 * 60 * 24 * 30;
  // Keeps track of the currently authenticated user's YouTube user ID.
  var channelId;
  // For information about the Google Chart Tools API, see
  // https://developers.google.com/chart/interactive/docs/quick_start
  google.load('visualization', '1.0', {'packages': ['corechart']});
  google.load('visualization', '1', {'packages': ['geochart']});	
  google.load('visualization', '1', {'packages':['table']});
  // The Google APIs JS client invokes this callback automatically after loading.
  // See http://code.google.com/p/google-api-javascript-client/wiki/Authentication
  window.onJSClientLoad = function() {	
    gapi.auth.init(function() {	  	
      window.setTimeout(checkAuth, 1);
    });	
  };
  // Attempt the immediate OAuth 2 client flow as soon as the page loads.
  // If the currently logged-in Google Account has previously authorized
  // OAUTH2_CLIENT_ID, then it will succeed with no user intervention.
  // Otherwise, it will fail and the user interface that prompts for
  // authorization will need to be displayed.
  function checkAuth() {
    gapi.auth.authorize({
      client_id: OAUTH2_CLIENT_ID,
      scope: OAUTH2_SCOPES,
      immediate: true
    }, handleAuthResult);
  }
  // Handle the result of a gapi.auth.authorize() call.
  function handleAuthResult(authResult) {
    if (authResult) {
      // Auth was successful. Hide auth prompts and show things
      // that should be visible after auth succeeds.
      jQuery('.pre-auth').hide();
      jQuery('.post-auth').show();
      loadAPIClientInterfaces();
    } else {
      // Auth was unsuccessful. Show things related to prompting for auth
      // and hide the things that should be visible after auth succeeds.
      jQuery('.post-auth').hide();
      jQuery('.pre-auth').show();
      // Make the #login-link clickable. Attempt a non-immediate OAuth 2 client
      // flow. The current function will be called when that flow completes.
      jQuery('#login-link').click(function() {
        gapi.auth.authorize({
          client_id: OAUTH2_CLIENT_ID,
          scope: OAUTH2_SCOPES,
          immediate: false
        }, handleAuthResult);
      });
    }
  }
  // Load the client interface for the YouTube Analytics and Data APIs, which
  // is required to use the Google APIs JS client. More info is available at
  // http://code.google.com/p/google-api-javascript-client/wiki/GettingStarted#Loading_the_Client
  function loadAPIClientInterfaces() {
    gapi.client.load('youtube', 'v3', function() {
      gapi.client.load('youtubeAnalytics', 'v1', function() {
        // After both client interfaces load, use the Data API to request
        // information about the authenticated user's channel.
        getUserChannel();
      });
    });
  }
  // Calls the Data API to retrieve info about the currently authenticated
  // user's YouTube channel.
  function getUserChannel() {
    // https://developers.google.com/youtube/v3/docs/channels/list
    var request = gapi.client.youtube.channels.list({      // "mine: true" indicates that you want to retrieve the authenticated user's channel.
      mine: true,
      part: 'id,contentDetails'
    });
    request.execute(function(response) {
      if ('error' in response) {
        displayMessage(response.error.message);
      } else {
        // We will need the channel's channel ID to make calls to the
        // Analytics API. The channel ID looks like "UCdLFeWKpkLhkguiMZUp8lWA".
        channelId = response.items[0].id;
        // This string, of the form "UUdLFeWKpkLhkguiMZUp8lWA", is a unique ID
        // for a playlist of videos uploaded to the authenticated user's channel.
        var uploadsListId = response.items[0].contentDetails.relatedPlaylists.uploads;
        // Use the uploads playlist ID to retrieve the list of uploaded videos.
        getPlaylistItems(uploadsListId);
      }
    });
  }
  // Calls the Data API to retrieve the items in a particular playlist. In this
  // example, we are retrieving a playlist of the currently authenticated user's
  // uploaded videos. By default, the list returns the most recent videos first.
  function getPlaylistItems(listId) {
    // https://developers.google.com/youtube/v3/docs/playlistitems/list
    var request = gapi.client.youtube.playlistItems.list({
      playlistId: listId,
      part: 'snippet'
    });

    request.execute(function(response) {
      if ('error' in response) {
        displayMessage(response.error.message);
      } else {
        if ('items' in response) {
          // jQuery.map() iterates through all of the items in the response and
          // creates a new array that only contains the specific property we're
          // looking for: videoId.
          var videoIds = jQuery.map(response.items, function(item) {
            return item.snippet.resourceId.videoId;
          });

          // Now that we know the IDs of all the videos in the uploads list,
          // we can retrieve info about each video.
          getVideoMetadata(videoIds);
        } else {
          displayMessage('There are no videos in your channel.');
        }
      }
    });
  }
  
  // Given an array of video ids, obtains metadata about each video and then
  // uses that metadata to display a list of videos to the user.
  function getVideoMetadata(videoIds) {
    // https://developers.google.com/youtube/v3/docs/videos/list
    var request = gapi.client.youtube.videos.list({
      // The 'id' property value is a comma-separated string of video IDs.
      id: videoIds.join(','),
      part: 'id,snippet,statistics'
    });

    request.execute(function(response) {
      if ('error' in response) {
        displayMessage(response.error.message);
      } else {
        // Get the jQuery wrapper for #video-list once outside the loop.
        var videoList = jQuery('#video-list');
        jQuery.each(response.items, function() {
          // Exclude videos that don't have any views, since those videos
          // will not have any interesting viewcount analytics data.
          if (this.statistics.viewCount == 0) {
            return;
          }

          var title = this.snippet.title;
          var videoId = this.id;
		  
		// Geo Chart
	    displayVideoAnalytics3(videoId);
		
		// Display Channel Stats Table 
		displayVideoAnalytics6(videoId);
				
		// Geo Chart Stats Table
		displayVideoAnalytics4(videoId);
		
		// Display Top Videos Table 
		displayVideoAnalytics5(videoId);
				
          // Create a new <li> element that contains an <a> element.
          // Set the <a> element's text content to the video's title, and
          // add a click handler that will display Analytics data when invoked.
          var liElement = jQuery('<li>');
          var aElement = jQuery('<a class="button-secondary video-list-button">');
          // The dummy href value of '#' ensures that the browser renders the
          // <a> element as a clickable link.
          aElement.attr({'href':'#', 'onclick':'return false;'});
          aElement.text(title);
          aElement.click(function() {
		    //FADE IN CHARTS HERE
			jQuery('#message').hide();
			jQuery('.all-charts-div').fadeIn('fast');
            displayVideoAnalytics(videoId);
			displayVideoAnalytics2(videoId);
			
          });

          // Call the jQuery.append() method to add the new <a> element to
          // the <li> element, and the <li> element to the parent
          // list, which is identified by the 'videoList' variable.
          liElement.append(aElement);
          videoList.append(liElement);
        });

        if (videoList.children().length == 0) {
		  jQuery('#chart').hide();
		  jQuery('.choose').hide();		  jQuery('.choose-video-div').hide();		  		  jQuery('.channel_analytics_div').hide();		  		  
          displayMessage('Your channel does not have any videos that have been viewed.');
        }
      }
    });
  }

  // Requests YouTube Analytics for a video, and displays results in a chart.
  function displayVideoAnalytics(videoId) {
    if (channelId) {
      // To use a different date range, modify the ONE_MONTH_IN_MILLISECONDS
      // variable to a different millisecond delta as desired.
      var today = new Date();
      var lastMonth = new Date(today.getTime() - ONE_MONTH_IN_MILLISECONDS);
	  
      var request = gapi.client.youtubeAnalytics.reports.query({
        // The start-date and end-date parameters need to be YYYY-MM-DD strings.
        'start-date': formatDateString(lastMonth),
        'end-date': formatDateString(today),
        // A future YouTube Analytics API release should support channel==default.
        // In the meantime, you need to explicitly specify channel==channelId.
        // See https://devsite.googleplex.com/youtube/analytics/v1/#ids
        ids: 'channel==' + channelId,
        dimensions: 'day',
        // See https://developers.google.com/youtube/analytics/v1/available_reports for details
        // on different filters and metrics you can request when dimensions=day.
        metrics: 'views,estimatedMinutesWatched,averageViewDuration',
        filters: 'video==' + videoId
      });
	  	  
		  
      request.execute(function(response) {
        // This function is called regardless of whether the request succeeds.
        // The response either has valid analytics data or an error message.
        if ('error' in response) {
          displayMessage(response.error.message);
        } else {
          displayChart(videoId, response);
        }
      });
    } else {
      displayMessage('The YouTube user id for the current user is not available.');
    }
  }
  
  //my test
   // Requests YouTube Analytics for a video, and displays results in a chart.
  function displayVideoAnalytics2(videoId) {
    if (channelId) {
     var today = new Date();
     var lastMonth = new Date(today.getTime() - ONE_MONTH_IN_MILLISECONDS);
	  
      var request2 = gapi.client.youtubeAnalytics.reports.query({
        // The start-date and end-date parameters need to be YYYY-MM-DD strings.
        'start-date': formatDateString(lastMonth),
        'end-date': formatDateString(today),
        // A future YouTube Analytics API release should support channel==default.
        // In the meantime, you need to explicitly specify channel==channelId.
        // See https://devsite.googleplex.com/youtube/analytics/v1/#ids
        ids: 'channel==' + channelId,
        dimensions: 'day',
        // See https://developers.google.com/youtube/analytics/v1/available_reports for details
        // on different filters and metrics you can request when dimensions=day.
        metrics: 'comments,likes,shares',
        filters: 'video==' + videoId
      });
	    request2.execute(function(response) {
        // This function is called regardless of whether the request succeeds.
        // The response either has valid analytics data or an error message.
        if ('error' in response) {
          displayMessage(response.error.message);
        } else {
          displayChart2(videoId, response);
        }
      });
    } else {
      displayMessage('The YouTube user id for the current user is not available.');
    }
		
  }
  
  //Geo Chart Code
   // Requests YouTube Analytics for a video, and displays results in a chart.
  function displayVideoAnalytics3(videoId) {
    if (channelId) {
     var today = new Date();
     var lastMonth = new Date(today.getTime() - ONE_MONTH_IN_MILLISECONDS);
	  
      var request3 = gapi.client.youtubeAnalytics.reports.query({
        // The start-date and end-date parameters need to be YYYY-MM-DD strings.
        'start-date': formatDateString(lastMonth),
        'end-date': formatDateString(today),
        // A future YouTube Analytics API release should support channel==default.
        // In the meantime, you need to explicitly specify channel==channelId.
        // See https://devsite.googleplex.com/youtube/analytics/v1/#ids
        ids: 'channel==' + channelId,
        dimensions:'country',
        // See https://developers.google.com/youtube/analytics/v1/available_reports for details
        // on different filters and metrics you can request when dimensions=day.
        metrics:'views,estimatedMinutesWatched',
        sort:'-views'
		

      });
	    request3.execute(function(response3) {
        // This function is called regardless of whether the request succeeds.
        // The response either has valid analytics data or an error message.
        if ('error' in response3) {
          displayMessage(response3.error.message);
        } else {
          displayChart3(videoId, response3);
        }
      });
    } else {
      displayMessage('The YouTube user id for the current user is not available.');
    }
		
  }
  
  //Geo Table Code
   // Requests YouTube Analytics for a video, and displays results in a chart.
  function displayVideoAnalytics4(videoId) {
    if (channelId) {
     var today = new Date();
     var lastMonth = new Date(today.getTime() - ONE_MONTH_IN_MILLISECONDS);
	  
      var request4 = gapi.client.youtubeAnalytics.reports.query({
        // The start-date and end-date parameters need to be YYYY-MM-DD strings.
        'start-date': formatDateString(lastMonth),
        'end-date': formatDateString(today),
        // A future YouTube Analytics API release should support channel==default.
        // In the meantime, you need to explicitly specify channel==channelId.
        // See https://devsite.googleplex.com/youtube/analytics/v1/#ids
        ids: 'channel==' + channelId,
        dimensions:'country',
        // See https://developers.google.com/youtube/analytics/v1/available_reports for details
        // on different filters and metrics you can request when dimensions=day.
        metrics:'views,comments,likes,shares,estimatedMinutesWatched',
        sort:'-views'
		

      });
	    request4.execute(function(response4) {
        // This function is called regardless of whether the request succeeds.
        // The response either has valid analytics data or an error message.
        if ('error' in response4) {
          displayMessage(response4.error.message);
        } else {
		  displayChart4(videoId, response4);
        }
      });
    } else {
      displayMessage('The YouTube user id for the current user is not available.');
    }
		
  }
  
  //Top Videos Table Code
   // Requests YouTube Analytics for a video, and displays results in a chart.
  function displayVideoAnalytics5(videoId) {
    if (channelId) {
     var today = new Date();
     var lastMonth = new Date(today.getTime() - ONE_MONTH_IN_MILLISECONDS);
	  
      var request5 = gapi.client.youtubeAnalytics.reports.query({
        // The start-date and end-date parameters need to be YYYY-MM-DD strings.
        'start-date': formatDateString(lastMonth),
        'end-date': formatDateString(today),
        // A future YouTube Analytics API release should support channel==default.
        // In the meantime, you need to explicitly specify channel==channelId.
        // See https://devsite.googleplex.com/youtube/analytics/v1/#ids
        ids: 'channel==' + channelId,
        dimensions:'video',
        // See https://developers.google.com/youtube/analytics/v1/available_reports for details
        // on different filters and metrics you can request when dimensions=day.
        metrics:'estimatedMinutesWatched,views,likes,subscribersGained',
		'max-results': '10',
        sort:'-views'
		
      });
	    request5.execute(function(response5) {
        // This function is called regardless of whether the request succeeds.
        // The response either has valid analytics data or an error message.
        if ('error' in response5) {
          displayMessage(response5.error.message);
        } else {
		  displayChart5(videoId, response5);
        }
      });
    } else {
      displayMessage('There was an error with your request. Please double check your credentials and try again at a later time.');
    }
		
  }
  
  //Total Channel Metrics
   // Requests YouTube Analytics for a video, and displays results in a chart.
  function displayVideoAnalytics6(videoId) {
    if (channelId) {
     var today = new Date();
     var lastMonth = new Date(today.getTime() - ONE_MONTH_IN_MILLISECONDS);
	  
      var request6 = gapi.client.youtubeAnalytics.reports.query({
        // The start-date and end-date parameters need to be YYYY-MM-DD strings.
        'start-date': formatDateString(lastMonth),
        'end-date': formatDateString(today),
        // A future YouTube Analytics API release should support channel==default.
        // In the meantime, you need to explicitly specify channel==channelId.
        // See https://devsite.googleplex.com/youtube/analytics/v1/#ids
        ids: 'channel==' + channelId,
        // See https://developers.google.com/youtube/analytics/v1/available_reports for details
        // on different filters and metrics you can request when dimensions=day.
        metrics:'views,comments,favoritesAdded,likes,dislikes,estimatedMinutesWatched',
		
      });
	    request6.execute(function(response6) {
        // This function is called regardless of whether the request succeeds.
        // The response either has valid analytics data or an error message.
        if ('error' in response6) {
          displayMessage(response6.error.message);
        } else {
		  displayChart6(videoId, response6);
        }
      });
    } else {
      displayMessage('The YouTube user id for the current user is not available.');
    }
		
  }
  

  
  // Boilerplate code to take a Date object and return a YYYY-MM-DD string.
  function formatDateString(date) {
    var yyyy = date.getFullYear().toString();
    var mm = padToTwoCharacters(date.getMonth() + 1);
    var dd = padToTwoCharacters(date.getDate());

    return yyyy + '-' + mm + '-' + dd;
  }

  // If number is a single digit, prepend a '0'. Otherwise, return it as a string.
  function padToTwoCharacters(number) {
    if (number < 10) {
      return '0' + number;
    } else {
      return number.toString();
    }
  }

  // Calls the Google Chart Tools API to generate a chart of analytics data.
  function displayChart(videoId, response) {
    if ('rows' in response) {
      hideMessage();

      // The columnHeaders property contains an array of objects representing
      // each column's title – e.g.: [{name:"day"},{name:"views"}]
      // We need these column titles as a simple array, so we call jQuery.map()
      // to get each element's "name" property and create a new array that only
      // contains those values.
      var columns = jQuery.map(response.columnHeaders, function(item) {
        return item.name;
      });
      // The google.visualization.arrayToDataTable() wants an array of arrays.
      // The first element is an array of column titles, calculated above as
      // "columns". The remaining elements are arrays that each represent
      // a row of data. Fortunately, response.rows is already in this format,
      // so it can just be concatenated.
      // See https://developers.google.com/chart/interactive/docs/datatables_dataviews#arraytodatatable
      var chartDataArray = [columns].concat(response.rows);
      var chartDataTable = google.visualization.arrayToDataTable(chartDataArray);
	  
      var chart = new google.visualization.LineChart(document.getElementById('chart'));
      chart.draw(chartDataTable, {
        // Additional options can be set if desired.
        // See https://developers.google.com/chart/interactive/docs/reference#visdraw
        title: 'Viewing Information for video ' +  videoId 
      });
    } else {
	  jQuery('.all-charts-div').hide();
      displayMessage('Sorry, no data is available for video ' + videoId);
    }
  }
  
  // MY DISPLAY CHART CODE
  function displayChart2(videoId, response) {
    if ('rows' in response) {
      hideMessage();
	   
      // The columnHeaders property contains an array of objects representing
      // each column's title – e.g.: [{name:"day"},{name:"views"}]
      // We need these column titles as a simple array, so we call jQuery.map()
      // to get each element's "name" property and create a new array that only
      // contains those values.
      var columns = jQuery.map(response.columnHeaders, function(item) {
        return item.name;
      });

      // The google.visualization.arrayToDataTable() wants an array of arrays.
      // The first element is an array of column titles, calculated above as
      // "columns". The remaining elements are arrays that each represent
      // a row of data. Fortunately, response.rows is already in this format,
      // so it can just be concatenated.
      // See https://developers.google.com/chart/interactive/docs/datatables_dataviews#arraytodatatable
      var chartDataArray2 = [columns].concat(response.rows);	
		
	  var chartDataTable2 = google.visualization.arrayToDataTable(chartDataArray2);
	  // my chart
	  var chart2 = new google.visualization.LineChart(document.getElementById('chart2'));
      chart2.draw(chartDataTable2, {
        // Additional options can be set if desired.
        // See https://developers.google.com/chart/interactive/docs/reference#visdraw
        title: 'Enagegement Information for video ' + videoId
      });
    } else {
	  jQuery('.all-charts-div').hide();
      displayMessage('Sorry, no data is available for video ' + videoId);
    }
  }
  
  // Display GEO CHART
  function displayChart3(videoId, response3) {
    if ('rows' in response3) {
      hideMessage();
      // The columnHeaders property contains an array of objects representing
      // each column's title – e.g.: [{name:"day"},{name:"views"}]
      // We need these column titles as a simple array, so we call jQuery.map()
      // to get each element's "name" property and create a new array that only
      // contains those values.
      var columns = jQuery.map(response3.columnHeaders, function(item) {
        return item.name;
      });
      // The google.visualization.arrayToDataTable() wants an array of arrays.
      // The first element is an array of column titles, calculated above as
      // "columns". The remaining elements are arrays that each represent
      // a row of data. Fortunately, response.rows is already in this format,
      // so it can just be concatenated.
      // See https://developers.google.com/chart/interactive/docs/datatables_dataviews#arraytodatatable
      var chartDataArray3 = [columns].concat(response3.rows);

	  var chartDataTable3 = google.visualization.arrayToDataTable(chartDataArray3);
	  // my chart
	  var chart3 = new google.visualization.GeoChart(document.getElementById('geo_chart_div'));
      chart3.draw(chartDataTable3, {
        // Additional options can be set if desired.
        // See https://developers.google.com/chart/interactive/docs/reference#visdraw
        title: 'GeoChart Information ',
      });
    } else {
	  jQuery('.all-charts-div').hide();
      displayMessage('Sorry, no data is available for video ' + videoId
	  );
    }
  }
  
 
  // Display Table For Views Per Country
  function displayChart4(videoId, response4) {
    if ('rows' in response4) {
      hideMessage();
      // The columnHeaders property contains an array of objects representing
      // each column's title – e.g.: [{name:"day"},{name:"views"}]
      // We need these column titles as a simple array, so we call jQuery.map()
      // to get each element's "name" property and create a new array that only
      // contains those values.
      var columns = jQuery.map(response4.columnHeaders, function(item) {
        return item.name;
      });
      // The google.visualization.arrayToDataTable() wants an array of arrays.
      // The first element is an array of column titles, calculated above as
      // "columns". The remaining elements are arrays that each represent
      // a row of data. Fortunately, response.rows is already in this format,
      // so it can just be concatenated.
      // See https://developers.google.com/chart/interactive/docs/datatables_dataviews#arraytodatatable
      var chartDataArray4 = [columns].concat(response4.rows);

	   var data = new google.visualization.DataTable();
        data.addColumn('string', 'Country');
		data.addColumn('number', 'Views');
		data.addColumn('number', 'Comments');
		data.addColumn('number', 'Likes');
		data.addColumn('number', 'Shares');
		data.addColumn('number', 'Mins. Watched');
        
        data.addRows(response4.rows);

        var table = new google.visualization.Table(document.getElementById('geo_stats_table'));
        table.draw(data, {showRowNumber: false});
	  
    } 
  }
  
  // Display Table For Top Overall Videos
  function displayChart5(videoId, response5) {
  
    if ('rows' in response5) {
      hideMessage();
      // The columnHeaders property contains an array of objects representing
      // each column's title – e.g.: [{name:"day"},{name:"views"}]
      // We need these column titles as a simple array, so we call jQuery.map()
      // to get each element's "name" property and create a new array that only
      // contains those values.
      var columns = jQuery.map(response5.columnHeaders, function(item) {
        return item.name;
      });
      // The google.visualization.arrayToDataTable() wants an array of arrays.
      // The first element is an array of column titles, calculated above as
      // "columns". The remaining elements are arrays that each represent
      // a row of data. Fortunately, response.rows is already in this format,
      // so it can just be concatenated.
      // See https://developers.google.com/chart/interactive/docs/datatables_dataviews#arraytodatatable
      var chartDataArray5 = [columns].concat(response5.rows);

	   var data = new google.visualization.DataTable();
        data.addColumn('string', 'Video');
		data.addColumn('number', 'Mins. Watched');
		data.addColumn('number', 'Veiws');
		data.addColumn('number', 'Likes');
		data.addColumn('number', 'Subscribers Gained');	
			
        data.addRows(response5.rows);

        var table2 = new google.visualization.Table(document.getElementById('top_videos_table'));
        table2.draw(data, {showRowNumber: true});
	  
    } 
  }
  
  // Display Table For Top Overall Videos
  function displayChart6(videoId, response6) {
    if ('rows' in response6) {
      hideMessage();
      // The columnHeaders property contains an array of objects representing
      // each column's title – e.g.: [{name:"day"},{name:"views"}]
      // We need these column titles as a simple array, so we call jQuery.map()
      // to get each element's "name" property and create a new array that only
      // contains those values.
      var columns = jQuery.map(response6.columnHeaders, function(item) {
        return item.name;
      });
      // The google.visualization.arrayToDataTable() wants an array of arrays.
      // The first element is an array of column titles, calculated above as
      // "columns". The remaining elements are arrays that each represent
      // a row of data. Fortunately, response.rows is already in this format,
      // so it can just be concatenated.
      // See https://developers.google.com/chart/interactive/docs/datatables_dataviews#arraytodatatable
      var chartDataArray6 = [columns].concat(response6.rows);

	   var data = new google.visualization.DataTable();
		data.addColumn('number', 'Views');
		data.addColumn('number', 'Comments');
		data.addColumn('number', 'Favorites');
		data.addColumn('number', 'Likes');
		data.addColumn('number', 'DisLikes');
		data.addColumn('number', 'Mins. Watched');	
			
        data.addRows(response6.rows);

        var table3 = new google.visualization.Table(document.getElementById('total_channel_stats'));
        table3.draw(data, {showRowNumber: false});
	  
    } 
  }
  
  
  // Helper method to display a message on the page.
  function displayMessage(message) {
    jQuery('#message').text(message).show();
  }


  // Helper method to hide a previously displayed message on the page.
  function hideMessage() {
    jQuery('#message').hide();
  }
})();
</script>  
  
</head>
<body>
  <div id="login-container" class="pre-auth">This application requires access to your YouTube account.
    Please <a href="#" id="login-link">authorize</a> to continue.
  </div>
     	
  <div class="post-auth">
	
	<div class="channel_analytics_div"> <!-- start channel analytics div -->
 
		  <div class="geo_div">
			<h3>Views Per Country:</h3>
			<p style="font-size:11px;"><i>Where in the world are people viewing your videos from?</i></p>
				<div id="geo_chart_div"></div>
			</div>
			<div class="tables_div">	
		  <div class="channel_stats_div">
			<h3>Channel Metrics:</h3>
			<p style="font-size:11px;"><i>Your aggregated channel metrics:</i></p>
				<div id="total_channel_stats"></div>
		  </div>
			
		  <div class="geo_stats_table_div">
			<h3>WorldWide Metrics:</h3>
			<p style="font-size:11px;"><i>In depth metrics per country:</i></p>
				<div id="geo_stats_table"></div>
		  </div>
		  
		</div>  
		
			 <div class="top_videos_table_div">
				<h3>Top Performing Videos:</h3>
				<p style="font-size:11px;"><i>These are your channels top performing videos by views:</i></p>
					<div id="top_videos_table"></div>
			  </div>
			  
		
		
  </div> <!-- end channel analytics div -->
  
	<div class="choose-video-div">
	<h3>Individual Content Analytics:</h3>
		<p class="choose">Select one of your videos to view the view metrics:</p>
		<ul id="video-list"></ul>
	</div><!-- end choose video div -->	
	
	<div id="message" style="color:red;"></div>
		
	<div class="all-charts-div">
		<div id="chart"></div>
		<div id="chart2"></div>
	</div><!-- end all charts div -->
	
  </div>
</body>
</html>