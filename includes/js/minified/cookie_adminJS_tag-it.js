function refresh_upload_page(){window.location.href="/wp-admin/admin.php?page=wp2yt_uploader"}(function(e){e.widget("ui.tagit",{options:{allowDuplicates:!1,caseSensitive:!0,fieldName:"tags",placeholderText:null,readOnly:!1,removeConfirmation:!1,tagLimit:null,availableTags:[],autocomplete:{},showAutocompleteOnFocus:!1,allowSpaces:!1,singleField:!1,singleFieldDelimiter:",",singleFieldNode:null,animate:!0,tabIndex:null,beforeTagAdded:null,afterTagAdded:null,beforeTagRemoved:null,afterTagRemoved:null,onTagClicked:null,onTagLimitExceeded:null,onTagAdded:null,onTagRemoved:null,tagSource:null},_create:function(){var t=this;this.element.is("input")?(this.tagList=e("<ul></ul>").insertAfter(this.element),this.options.singleField=!0,this.options.singleFieldNode=this.element,this.element.css("display","none")):this.tagList=this.element.find("ul, ol").andSelf().last();this.tagInput=e('<input type="text" />').addClass("ui-widget-content");this.options.readOnly&&this.tagInput.attr("disabled","disabled");this.options.tabIndex&&this.tagInput.attr("tabindex",this.options.tabIndex);this.options.placeholderText&&this.tagInput.attr("placeholder",this.options.placeholderText);this.options.autocomplete.source||(this.options.autocomplete.source=function(t,n){var r=t.term.toLowerCase(),i=e.grep(this.options.availableTags,function(e){return 0===e.toLowerCase().indexOf(r)});this.options.allowDuplicates||(i=this._subtractArray(i,this.assignedTags()));n(i)});this.options.showAutocompleteOnFocus&&(this.tagInput.focus(function(){t._showAutocomplete()}),"undefined"===typeof this.options.autocomplete.minLength&&(this.options.autocomplete.minLength=0));e.isFunction(this.options.autocomplete.source)&&(this.options.autocomplete.source=e.proxy(this.options.autocomplete.source,this));e.isFunction(this.options.tagSource)&&(this.options.tagSource=e.proxy(this.options.tagSource,this));this.tagList.addClass("tagit").addClass("ui-widget ui-widget-content ui-corner-all").append(e('<li class="tagit-new"></li>').append(this.tagInput)).click(function(n){var r=e(n.target);r.hasClass("tagit-label")?(r=r.closest(".tagit-choice"),r.hasClass("removed")||t._trigger("onTagClicked",n,{tag:r,tagLabel:t.tagLabel(r)})):t.tagInput.focus()});var n=!1;if(this.options.singleField)if(this.options.singleFieldNode){var r=e(this.options.singleFieldNode),i=r.val().split(this.options.singleFieldDelimiter);r.val("");e.each(i,function(e,r){t.createTag(r,null,!0);n=!0})}else this.options.singleFieldNode=e('<input type="hidden" style="display:none;" value="" name="'+this.options.fieldName+'" />'),this.tagList.after(this.options.singleFieldNode);n||this.tagList.children("li").each(function(){e(this).hasClass("tagit-new")||(t.createTag(e(this).text(),e(this).attr("class"),!0),e(this).remove())});this.tagInput.keydown(function(n){if(n.which==e.ui.keyCode.BACKSPACE&&""===t.tagInput.val()){var r=t._lastTag();!t.options.removeConfirmation||r.hasClass("remove")?t.removeTag(r):t.options.removeConfirmation&&r.addClass("remove ui-state-highlight")}else t.options.removeConfirmation&&t._lastTag().removeClass("remove ui-state-highlight");if(n.which===e.ui.keyCode.COMMA||n.which===e.ui.keyCode.ENTER||n.which==e.ui.keyCode.TAB&&""!==t.tagInput.val()||n.which==e.ui.keyCode.SPACE&&!0!==t.options.allowSpaces&&('"'!=e.trim(t.tagInput.val()).replace(/^s*/,"").charAt(0)||'"'==e.trim(t.tagInput.val()).charAt(0)&&'"'==e.trim(t.tagInput.val()).charAt(e.trim(t.tagInput.val()).length-1)&&0!==e.trim(t.tagInput.val()).length-1))n.which===e.ui.keyCode.ENTER&&""===t.tagInput.val()||n.preventDefault(),t.tagInput.data("autocomplete-open")||t.createTag(t._cleanedInput())}).blur(function(){t.tagInput.data("autocomplete-open")||t.createTag(t._cleanedInput())});if(this.options.availableTags||this.options.tagSource||this.options.autocomplete.source)r={select:function(e,n){t.createTag(n.item.value);return!1}},e.extend(r,this.options.autocomplete),r.source=this.options.tagSource||r.source,this.tagInput.autocomplete(r).bind("autocompleteopen",function(){t.tagInput.data("autocomplete-open",!0)}).bind("autocompleteclose",function(){t.tagInput.data("autocomplete-open",!1)})},_cleanedInput:function(){return e.trim(this.tagInput.val().replace(/^"(.*)"$/,"$1"))},_lastTag:function(){return this.tagList.find(".tagit-choice:last:not(.removed)")},_tags:function(){return this.tagList.find(".tagit-choice:not(.removed)")},assignedTags:function(){var t=this,n=[];this.options.singleField?(n=e(this.options.singleFieldNode).val().split(this.options.singleFieldDelimiter),""===n[0]&&(n=[])):this._tags().each(function(){n.push(t.tagLabel(this))});return n},_updateSingleTagsField:function(t){e(this.options.singleFieldNode).val(t.join(this.options.singleFieldDelimiter)).trigger("change")},_subtractArray:function(t,n){for(var r=[],i=0;i<t.length;i++)-1==e.inArray(t[i],n)&&r.push(t[i]);return r},tagLabel:function(t){return this.options.singleField?e(t).find(".tagit-label:first").text():e(t).find("input:first").val()},_showAutocomplete:function(){this.tagInput.autocomplete("search","")},_findTagByLabel:function(t){var n=this,r=null;this._tags().each(function(){if(n._formatStr(t)==n._formatStr(n.tagLabel(this)))return r=e(this),!1});return r},_isNew:function(e){return!this._findTagByLabel(e)},_formatStr:function(t){return this.options.caseSensitive?t:e.trim(t.toLowerCase())},_effectExists:function(t){return Boolean(e.effects&&(e.effects[t]||e.effects.effect&&e.effects.effect[t]))},createTag:function(t,n,r){var i=this;t=e.trim(t);this.options.preprocessTag&&(t=this.options.preprocessTag(t));if(""===t)return!1;if(!this.options.allowDuplicates&&!this._isNew(t))return t=this._findTagByLabel(t),!1!==this._trigger("onTagExists",null,{existingTag:t,duringInitialization:r})&&this._effectExists("highlight")&&t.effect("highlight"),!1;if(this.options.tagLimit&&this._tags().length>=this.options.tagLimit)return this._trigger("onTagLimitExceeded",null,{duringInitialization:r}),!1;var s=e(this.options.onTagClicked?'<a class="tagit-label"></a>':'<span class="tagit-label"></span>').text(t),o=e("<li></li>").addClass("tagit-choice ui-widget-content ui-state-default ui-corner-all").addClass(n).append(s);this.options.readOnly?o.addClass("tagit-choice-read-only"):(o.addClass("tagit-choice-editable"),n=e("<span></span>").addClass("ui-icon ui-icon-close"),n=e('<a><span class="text-icon">×</span></a>').addClass("tagit-close").append(n).click(function(){i.removeTag(o)}),o.append(n));this.options.singleField||(s=s.html(),o.append('<input type="hidden" style="display:none;" value="'+s+'" name="'+this.options.fieldName+'" />'));!1!==this._trigger("beforeTagAdded",null,{tag:o,tagLabel:this.tagLabel(o),duringInitialization:r})&&(this.options.singleField&&(s=this.assignedTags(),s.push(t),this._updateSingleTagsField(s)),this._trigger("onTagAdded",null,o),this.tagInput.val(""),this.tagInput.parent().before(o),this._trigger("afterTagAdded",null,{tag:o,tagLabel:this.tagLabel(o),duringInitialization:r}),this.options.showAutocompleteOnFocus&&!r&&setTimeout(function(){i._showAutocomplete()},0))},removeTag:function(t,n){n="undefined"===typeof n?this.options.animate:n;t=e(t);this._trigger("onTagRemoved",null,t);if(!1!==this._trigger("beforeTagRemoved",null,{tag:t,tagLabel:this.tagLabel(t)})){if(this.options.singleField){var r=this.assignedTags(),i=this.tagLabel(t),r=e.grep(r,function(e){return e!=i});this._updateSingleTagsField(r)}if(n){t.addClass("removed");var r=this._effectExists("blind")?["blind",{direction:"horizontal"},"fast"]:["fast"],s=this;r.push(function(){t.remove();s._trigger("afterTagRemoved",null,{tag:t,tagLabel:s.tagLabel(t)})});t.fadeOut("fast").hide.apply(t,r).dequeue()}else t.remove(),this._trigger("afterTagRemoved",null,{tag:t,tagLabel:this.tagLabel(t)})}},removeTagByLabel:function(e,t){var n=this._findTagByLabel(e);if(!n)throw"No such tag exists with the name '"+e+"'";this.removeTag(n,t)},removeAll:function(){var e=this;this._tags().each(function(t,n){e.removeTag(n,!1)})}})})(jQuery);(function(e){if(typeof define==="function"&&define.amd){define(["jquery"],e)}else{e(jQuery)}})(function(e){function t(e){if(i.raw){return e}try{return decodeURIComponent(e.replace(r," "))}catch(t){}}function n(e){if(e.indexOf('"')===0){e=e.slice(1,-1).replace(/\\"/g,'"').replace(/\\\\/g,"\\")}e=t(e);try{return i.json?JSON.parse(e):e}catch(n){}}var r=/\+/g;var i=e.cookie=function(r,s,o){if(s!==undefined){o=e.extend({},i.defaults,o);if(typeof o.expires==="number"){var u=o.expires,a=o.expires=new Date;a.setDate(a.getDate()+u)}s=i.json?JSON.stringify(s):String(s);return document.cookie=[i.raw?r:encodeURIComponent(r),"=",i.raw?s:encodeURIComponent(s),o.expires?"; expires="+o.expires.toUTCString():"",o.path?"; path="+o.path:"",o.domain?"; domain="+o.domain:"",o.secure?"; secure":""].join("")}var f=r?undefined:{};var l=document.cookie?document.cookie.split("; "):[];for(var c=0,h=l.length;c<h;c++){var p=l[c].split("=");var d=t(p.shift());var v=p.join("=");if(r&&r===d){f=n(v);break}if(!r&&(v=n(v))!==undefined){f[d]=v}}return f};i.defaults={};e.removeCookie=function(t,n){if(e.cookie(t)!==undefined){e.cookie(t,"",e.extend({},n,{expires:-1}));return true}return false}});jQuery(document).ready(function(){function e(){var e=jQuery(".youtube-input input[name=file]").val().split(".").pop().toLowerCase();if(jQuery.inArray(e,["mov","mp4","avi","wmv","mpegps","flv","webm"])==-1){alert("That file format is unsupported. Please select a supported format.");event.preventDefault()}else{jQuery("#fileUploadForm").submit();jQuery(".youtube-input input[type=file]").attr("disabled",true);jQuery(".block > label").css("cursor","default");jQuery("#submit2").attr("disabled",true)}}function t(){var e=jQuery("#stv_oauth2_input").val().length;if(e<30){jQuery("#use_yt_analytics_checkbox").prop("checked",false);jQuery(".wp2yt-oauth2-clientid-length-warning").fadeIn()}else{jQuery(".wp2yt-oauth2-clientid-length-warning").fadeOut()}}jQuery(".wp2yt-page-load-image").fadeTo(200,1);jQuery(".noAuthCodeError").css("display","none");jQuery("#get_playlists_div_holder").find(".no_videos_error").css({margin:"0 auto","margin-top":"1.5em","margin-bottom":"1.5em","text-align":"center"}).parent(".scrollable-content").css("width","auto").parent(".show_playlist").css("overflow-x","scroll");jQuery("#get_playlists_div_holder").find(".no_videos_error").parent(".scrollable-content").prev().remove();jQuery("#wp2yt-tabs").css("cursor","default");setTimeout(function(){jQuery("#wp2yt-tabs").tabs().css("height","auto").next().fadeIn();jQuery(".wp2yt-page-load-image").fadeOut(500);jQuery("#wp2yt-tabs").fadeTo(750,1)},800);jQuery("#wp2yt-tabs input").attr("disabled",false);jQuery("#wp2yt-tabs textarea").attr("disabled",false);jQuery("#wp2yt-tabs select").attr("disabled",false);var n=["funny","movie","comedy","show","game","short","film","animation","hand","drawn"];jQuery("#video_keywords").tagit({availableTags:n,singleField:true,removeConfirmation:true});jQuery(".new_content").click(function(){jQuery(".help_page").fadeOut("slow");jQuery(".analytics_page").fadeOut("fast");jQuery(".recent_uploads").fadeOut("fast");jQuery(".upload_content").fadeIn("slow")});jQuery(".currcont").click(function(){jQuery(".help_page").fadeOut("slow");jQuery(".upload_content").fadeOut("fast");jQuery(".analytics_page").fadeOut("fast");jQuery(".recent_uploads").fadeIn("slow")});jQuery(".analytics").click(function(){jQuery(".help_page").fadeOut("slow");jQuery(".upload_content").fadeOut("fast");jQuery(".recent_uploads").fadeOut("fast");jQuery(".analytics_page").fadeIn("slow")});jQuery(".help").click(function(){jQuery(".upload_content").fadeOut("fast");jQuery(".recent_uploads").fadeOut("fast");jQuery(".analytics_page").fadeOut("fast");jQuery(".help_page").fadeIn("slow")});jQuery(".about_btn").click(function(){jQuery(".help_page > ul > li > a").removeClass("wp2yt-active-link");jQuery(".about_btn > a").addClass("wp2yt-active-link");jQuery("#help_page_uploader_div").hide();jQuery("#help_page_recent_uploads_div").hide();jQuery("#help_page_oauth2help_div").hide();jQuery("#help_page_feedback_div").hide();jQuery("#help_page_about_div").fadeIn("fast")});jQuery(".uploader_btn").click(function(){jQuery(".help_page > ul > li > a").removeClass("wp2yt-active-link");jQuery(".uploader_btn > a").addClass("wp2yt-active-link");jQuery("#help_page_about_div").hide();jQuery("#help_page_recent_uploads_div").hide();jQuery("#help_page_oauth2help_div").hide();jQuery("#help_page_feedback_div").hide();jQuery("#help_page_uploader_div").fadeIn("fast")});jQuery(".cc_btn").click(function(){jQuery(".help_page > ul > li > a").removeClass("wp2yt-active-link");jQuery(".cc_btn > a").addClass("wp2yt-active-link");jQuery("#help_page_uploader_div").hide();jQuery("#help_page_about_div").hide();jQuery("#help_page_oauth2help_div").hide();jQuery("#help_page_feedback_div").hide();jQuery("#help_page_recent_uploads_div").fadeIn("fast")});jQuery(".analytics_btn").click(function(){jQuery(".help_page > ul > li > a").removeClass("wp2yt-active-link");jQuery(".analytics_btn > a").addClass("wp2yt-active-link");jQuery("#help_page_uploader_div").hide();jQuery("#help_page_recent_uploads_div").hide();jQuery("#help_page_about_div").hide();jQuery("#help_page_feedback_div").hide();jQuery("#help_page_oauth2help_div").fadeIn("fast")});jQuery(".feedback_btn").click(function(){jQuery(".help_page > ul > li > a").removeClass("wp2yt-active-link");jQuery(".feedback_btn > a").addClass("wp2yt-active-link");jQuery("#help_page_uploader_div").hide();jQuery("#help_page_recent_uploads_div").hide();jQuery("#help_page_about_div").hide();jQuery("#help_page_oauth2help_div").hide();jQuery("#help_page_feedback_div").fadeIn("fast")});if(jQuery("#add_yt_account2_checkbox").is(":checked")){jQuery("#yt_account2").removeAttr("disabled");jQuery("#yt_account2").css("background-color","white");jQuery("#yt_account2").css("opacity","1")}else{jQuery("#yt_account2").attr("disabled","disabled");jQuery("#yt_account2").css("background-color","c4c4c4");jQuery("#yt_account2").css("opacity",".18")}jQuery("#add_yt_account2_checkbox").on("click",function(){if(jQuery("#add_yt_account2_checkbox").is(":checked")){jQuery("#yt_account2").removeAttr("disabled");jQuery("#yt_account2").css("background-color","white");jQuery("#yt_account2").css("opacity","1")}else{jQuery("#yt_account2").attr("disabled","disabled");jQuery("#yt_account2").css("background-color","c4c4c4");jQuery("#yt_account2").css("opacity",".18")}});if(jQuery("#add_yt_account3_checkbox").is(":checked")){jQuery("#yt_account3").removeAttr("disabled");jQuery("#yt_account3").css("background-color","white");jQuery("#yt_account3").css("opacity","1")}else{jQuery("#yt_account3").attr("disabled","disabled");jQuery("#yt_account3").css("background-color","c4c4c4");jQuery("#yt_account3").css("opacity",".18")}jQuery("#add_yt_account3_checkbox").on("click",function(){if(jQuery("#add_yt_account3_checkbox").is(":checked")){jQuery("#yt_account3").removeAttr("disabled");jQuery("#yt_account3").css("background-color","white");jQuery("#yt_account3").css("opacity","1")}else{jQuery("#yt_account3").attr("disabled","disabled");jQuery("#yt_account3").css("background-color","c4c4c4");jQuery("#yt_account3").css("opacity",".18")}});if(jQuery("#add_yt_account4_checkbox").is(":checked")){jQuery("#yt_account4").removeAttr("disabled");jQuery("#yt_account4").css("background-color","white");jQuery("#yt_account4").css("opacity","1")}else{jQuery("#yt_account4").attr("disabled","disabled");jQuery("#yt_account4").css("background-color","c4c4c4");jQuery("#yt_account4").css("opacity",".18")}jQuery("#add_yt_account4_checkbox").on("click",function(){if(jQuery("#add_yt_account4_checkbox").is(":checked")){jQuery("#yt_account4").removeAttr("disabled");jQuery("#yt_account4").css("background-color","white");jQuery("#yt_account4").css("opacity","1")}else{jQuery("#yt_account4").attr("disabled","disabled");jQuery("#yt_account4").css("background-color","c4c4c4");jQuery("#yt_account4").css("opacity",".18")}});if(jQuery("#add_yt_account5_checkbox").is(":checked")){jQuery("#yt_account5").removeAttr("disabled");jQuery("#yt_account5").css("background-color","white");jQuery("#yt_account5").css("opacity","1")}else{jQuery("#yt_account5").attr("disabled","disabled");jQuery("#yt_account5").css("background-color","c4c4c4");jQuery("#yt_account5").css("opacity",".18")}jQuery("#add_yt_account5_checkbox").on("click",function(){if(jQuery("#add_yt_account5_checkbox").is(":checked")){jQuery("#yt_account5").removeAttr("disabled");jQuery("#yt_account5").css("background-color","white");jQuery("#yt_account5").css("opacity","1")}else{jQuery("#yt_account5").attr("disabled","disabled");jQuery("#yt_account5").css("background-color","c4c4c4");jQuery("#yt_account5").css("opacity",".18")}});jQuery(".new-upload-insert-video-to-post-btn").click(function(){var e=jQuery(this).attr("value");e=jQuery.trim(e);window.parent.send_to_editor(e);window.parent.tb_remove()});jQuery(".wp2yt-external-wordpress-link").mouseenter(function(){jQuery(".wp2yt-wordpress-link-text").stop().fadeIn("fast")});jQuery(".wp2yt-external-wordpress-link").mouseleave(function(){jQuery(".wp2yt-wordpress-link-text").stop().fadeOut("fast")});jQuery(".wp2yt-external-site-link").mouseenter(function(){jQuery(".wp2yt-external-site-link-text").stop().fadeIn("fast")});jQuery(".wp2yt-external-site-link").mouseleave(function(){jQuery(".wp2yt-external-site-link-text").stop().fadeOut("fast")});jQuery(".wp2yt-external-plugin-link").mouseenter(function(){jQuery(".wp2yt-plugin-link-text").stop().fadeIn("fast")});jQuery(".wp2yt-external-plugin-link").mouseleave(function(){jQuery(".wp2yt-plugin-link-text").stop().fadeOut("fast")});jQuery(".stv_oauth2_input").parents("td").addClass("wp2yt-flex");jQuery(".wp2yt-eherman-profile-pic").mouseenter(function(){jQuery(".wp2yt-profile-pic-text").stop().fadeIn("fast")});jQuery(".wp2yt-eherman-profile-pic").mouseleave(function(){jQuery(".wp2yt-profile-pic-text").stop().fadeOut("fast")});jQuery(".ui-tabs-nav > li > a").click(function(){jQuery(".ui-tabs-anchor").removeClass("wp2yt-active-link");jQuery(this).addClass("wp2yt-active-link")});jQuery("#form1").tooltip({track:true});jQuery(".wp2yt-first-uploader-step-btn").click(function(){jQuery("#wp2yt_video_title").removeAttr("title");jQuery("#wp2yt-video-description").removeAttr("title");jQuery("#wp2yt_video_title").val().trim(wp2yt_video_title);if(jQuery.trim(jQuery("#wp2yt_video_title").val())==""&&jQuery.trim(jQuery("#wp2yt-video-description").val())==""){jQuery("#wp2yt_video_title").attr("title","Please enter a video title");jQuery("#wp2yt-video-description").attr("title","Please enter a description for your video");var e=jQuery("#form1 [title]").tooltip();e.tooltip("open");return false}else if(jQuery.trim(jQuery("#wp2yt_video_title").val())==""){jQuery("#wp2yt_video_title").attr("title","Please enter a video title");var e=jQuery("#form1 [title]").tooltip();e.tooltip("open");return false}else if(jQuery.trim(jQuery("#wp2yt-video-description").val())==""){jQuery("#wp2yt-video-description").attr("title","Please enter a description for your video");var e=jQuery("#form1 [title]").tooltip();e.tooltip("open");return false}else{jQuery("#form1").submit();jQuery("#wp2yt_video_title").attr("disabled",true);jQuery("#wp2yt-video-description").attr("disabled",true);jQuery(".tagit-new > input[type=text]").attr("disabled",true);jQuery("#wp2yt_video_categories").attr("disabled",true);jQuery(".wp2yt-first-uploader-step-btn").attr("disabled",true)}});jQuery("#submit2").click(function(){e()});jQuery(".wp2yt-check-yt-connect-btn").click(function(){if(jQuery(".wp-default-preloader").is(":visible")){event.preventDefault()}else{jQuery(".check-complete-message").hide();jQuery(".check-settings-images").hide();jQuery(".wp2yt-check-settings-img").hide();jQuery(".check-settings-images").fadeIn("fast");jQuery(".wp-default-preloader").fadeIn("fast").delay(600).fadeOut("fast");var e=jQuery("#youTubeAuthKeyResponseInput").val();if(e=="BadAuthentication"||e=="Unknown"){jQuery(".incorrect-settings-x").delay(800).fadeIn("slow");setTimeout(function(){jQuery(".wp2yt-check-yt-connection").append('<p class="check-complete-message wp2yt-red">Error: Please check your account name and password are entered correctly</p>')},1e3)}else{jQuery(".correct-settings-checkmark").delay(800).fadeIn("slow");setTimeout(function(){jQuery(".wp2yt-check-yt-connection").append('<p class="check-complete-message wp2yt-green">Success: Your account and password appear correct.</p>').find(".check-complete-message:not(:last-child)").fadeOut()},1e3)}}});jQuery("#ui-id-1").addClass("wp2yt-active-link");jQuery("#ui-id-3").css("color","#eee");jQuery("#ui-id-2").css("color","#eee");jQuery("#use_yt_analytics_checkbox").click(function(){var e=jQuery("#stv_oauth2_input").val().length;if(e<=30){jQuery(this).prop("checked",false);jQuery(".wp2yt-oauth2-clientid-length-warning").fadeIn()}else{jQuery(".wp2yt-oauth2-clientid-length-warning").fadeOut()}});jQuery("#stv_oauth2_input").keyup(t);jQuery(window).scroll(function(){jQuery(".title_and_video_count_div").css({left:jQuery(this).scrollLeft()+15})})});jQuery(document).ready(function(){jQuery(".wp2yt-video-thumbnail").mouseenter(function(){jQuery(this).stop().fadeTo(375,.5).prev().stop().fadeIn(375);jQuery(this).mouseleave(function(){jQuery(this).stop().fadeTo(375,1).prev().stop().fadeOut(375)})})})// Preview YT Video in New ModaljQuery(document).ready(function() {	/* jQuery to insert embed code into posts, and to close media upload thickbox */		jQuery(".preview-yt-video-btn").click(function() {						var e=jQuery(this).parents("div.videos").find("#embedLinkDiv").text();			e=jQuery.trim(e);			// get current SRC			var wp2ytEmbedLinkSRC = jQuery(e).attr("src");			// set new SRC			wp2ytNewEmbedLinkSRC = wp2ytEmbedLinkSRC+"?&autoplay=1&rel=0&showinfo=0";			// str_replace old src with new src			e = e.replace(wp2ytEmbedLinkSRC,wp2ytNewEmbedLinkSRC);									var videoTitle = jQuery(this).parents("div.videos").find(".titlebox").text();					jQuery('#wp2yt-uploader-preview-video').html(e).prepend('<h2 style="margin-bottom:0;">Preview '+videoTitle+'</h2>');					});				// hack to prevent iframe from playing when thicbox closes		window.setInterval(function(){				if (jQuery('#TB_ajaxContent').is(":visible")){					return;				} else {					jQuery('#wp2yt-uploader-preview-video').html('');				}			}, 500);				jQuery(".preview-yt-video").click(function() {						var e=jQuery(this).parents("div.videos").find("#embedLinkDiv").text();			e=jQuery.trim(e);					// get current SRC			var wp2ytEmbedLinkSRC = jQuery(e).attr("src");			// set new SRC			wp2ytNewEmbedLinkSRC = wp2ytEmbedLinkSRC+"?&autoplay=1&rel=0&showinfo=0";			// str_replace old src with new src			e = e.replace(wp2ytEmbedLinkSRC,wp2ytNewEmbedLinkSRC);					var videoTitle = jQuery(this).parents("div.videos").find(".titlebox").text();					jQuery('#wp2yt-uploader-preview-video').html(e).prepend('<h2 style="margin-bottom:0;">Preview '+videoTitle+'</h2>');				});		});// open thickbox and set embed parametersjQuery(document).ready(function() {				// send video to editor after selecting some parameters		jQuery('.insert-video-with-parameters-button').click(function() {				var wp2ytHiddenEmbedLink = jQuery('.wp2yt-hidden-embed-link').val();					var videoQuality = jQuery('#defaultVideoQualityDropDown').val();				var videoQualityValue = jQuery('input[name="vquality"]').val(videoQuality);								var startTimeMinutes = parseInt(jQuery('#youtubeStartTimeMinutes').val());				var startTimeSeconds = parseInt(jQuery('#youtubeStartTimeSeconds').val());								var endTimeMinutes = parseInt(jQuery('#youtubeEndTimeMinutes').val());				var endTimeSeconds = parseInt(jQuery('#youtubeEndTimeSeconds').val());								// start time parameter takes in seconds, so we multiple minutes x 60 (number of seconds in a minute) to get the total number of seconds				var startTimeMinutes = startTimeMinutes*60;				// add startTimeSeconds to mintutes converted to seconds, for the total start time in seconds				var startTimeTotal = startTimeMinutes+startTimeSeconds;								// same for end time				var endTimeMinutes = endTimeMinutes*60;				var endTimeTotal = endTimeMinutes+endTimeSeconds;											jQuery("input[name='startTime']").val("start="+startTimeTotal);				jQuery("input[name='endTime']").val("end="+endTimeTotal);					 var paramaterIDs = jQuery("input:checkbox:checked").map(function(){				  return jQuery(this).val();				}).get();				paramaterIDs = '?'+paramaterIDs.toString();				// replace all , with ampersands				paramaterIDs = paramaterIDs.replace(/,/g,'&amp;');					var wp2ytHiddenEmbedLink = jQuery('.wp2yt-hidden-embed-link').val();								var wp2ytPlayerWithParameters = '[iframe]<iframe width="640" height="480" src="http://www.youtube.com/embed/'+wp2ytHiddenEmbedLink+paramaterIDs+'"></iframe>[/iframe]';				var wp2ytPlayerWithOutParameters = '[iframe]<iframe width="640" height="480" src="http://www.youtube.com/embed/'+wp2ytHiddenEmbedLink+'"></iframe>[/iframe]';								if ( paramaterIDs != '?') {					// iterate through and uncheck all checked checkboxes					jQuery('input[type="checkbox"]').each(function() {						if (jQuery(this).prop("checked",true)) {							jQuery(this).prop("checked",false);						}					});					if ( jQuery('#youTubeStartTime').is(':visible') || jQuery('#youTubeEndTime').is(':visible') || jQuery('#defaultVideoQualityDropDown').is(':visible')) {							jQuery('#youTubeStartTime').hide();						jQuery('#youTubeEndTime').hide();						jQuery('#defaultVideoQualityDropDown').hide();												jQuery('#youTubeStartTime').find('input[type="number"]').val('0').text('0');						jQuery('#youTubeEndTime').find('input[type="number"]').val('0').text('0');					}					window.parent.send_to_editor(wp2ytPlayerWithParameters);					tb_remove();					window.parent.tb_remove();				} else {					window.parent.send_to_editor(wp2ytPlayerWithOutParameters);					tb_remove();					window.parent.tb_remove();				}												// check embed parameters				//console.log(paramaterIDs);		});				jQuery('.wp2ytCancelButton').click(function() {			jQuery('input[type="checkbox"]').each(function() {				if (jQuery(this).prop("checked",true)) {					jQuery(this).prop("checked",false);				}				if ( jQuery('#youTubeStartTime').is(':visible') || jQuery('#youTubeEndTime').is(':visible') || jQuery('#defaultVideoQualityDropDown').is(':visible')) {							jQuery('#youTubeStartTime').hide();						jQuery('#youTubeEndTime').hide();						jQuery('#defaultVideoQualityDropDown').hide();												jQuery('#youTubeStartTime').find('input[type="number"]').val('0').text('0');						jQuery('#youTubeEndTime').find('input[type="number"]').val('0').text('0');					}			});			tb_remove();		});			/* jQuery to insert embed code into posts, and to close media upload thickbox */		jQuery(".insert-video-to-post-btn").click(function() {						var e=jQuery(this).parents("div.videos").find("input[name='uniqueVideoID']").val();			e=jQuery.trim(e);			// swap out content of hidden input field <= placeholder for inserting video			jQuery('.wp2yt-hidden-embed-link').val(e);				});						jQuery('.parameter-more-info-icon').mouseenter(function() {			jQuery(this).prev().stop().fadeIn();					});		jQuery('.parameter-more-info-icon').mouseleave(function() {			jQuery(this).prev().stop().hide();					});		});// Video Quality CheckBox Checkfunction videoQualityCheckBoxCheck() {	if (jQuery('input[name="vquality"]').is(':checked')) {		jQuery('#defaultVideoQualityDropDown').fadeIn();	} else {		jQuery('#defaultVideoQualityDropDown').fadeOut();	}}// YouTube Start Time CheckBox Checkfunction youTubeStartTime() {	if (jQuery('input[name="startTime"]').is(':checked')) {		jQuery('#youTubeStartTime').fadeIn();	} else {		jQuery('#youTubeStartTime').fadeOut();	}}// YouTube End Time CheckBox Checkfunction youTubeEndTime() {	if (jQuery('input[name="endTime"]').is(':checked')) {		jQuery('#youTubeEndTime').fadeIn();	} else {		jQuery('#youTubeEndTime').fadeOut();	}}function loopCallBack() {	var playlistID = jQuery('.wp2yt-hidden-embed-link').val();	jQuery('input[name="loop"]').val('loop=1&amp;playlist='+playlistID);}