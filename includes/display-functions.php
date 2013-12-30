<?php

/*our display functions for outputting information*/

// Add shortocde to allow iFrame embedding: include [iframe] [/iframe] around your iframe html tags 
$IframeShortcode = new IframeShortcode;

class IframeShortcode {
	
	function __construct() {
		add_shortcode( 'iframe', array( $this, 'iframe_shortcode' ) );
	}
	
	function iframe_shortcode( $atts, $content = null ) {
	    $char = array( '&#8216;', '&#8217;', '&#8220;', '&#8221;', '&#8242;', '&#8243;' );
	    $replace = array( "'", "'", '"', '"', "'", '"' );
	    return html_entity_decode( str_replace( $char, $replace, $content ) );
	}
}
function youtube_uploader_admin_side() {
?>
		<div class="side-widget">
			<span class="title"><?php _e('Support ScrappleTV') ?></span>
			<!-- Paypal Donation Form -->
			<div id="donate-form">
				<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
				<input type="hidden" name="cmd" value="_xclick">
				<input type="hidden" name="business" value="emh52@drexel.edu">
				<input type="hidden" name="lc" value="IN">
				<input type="hidden" name="item_name" value="Donation for Youtube Uploader">
				<input type="hidden" name="item_number" value="Youtube Uploader">
				<strong><?php _e('Enter amount in USD: ') ?></strong> <input name="amount" value="5.00" size="6" type="text"><br />
				<input type="hidden" name="currency_code" value="USD">
				<input type="hidden" name="button_subtype" value="services">
				<input type="hidden" name="bn" value="PP-BuyNowBF:btn_donate_LG.gif:NonHosted">
				<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="<?php _e('Send your donation to the author of the') ?> Youtube Uploader" title="<?php _e('Send your donation to the author of the') ?> Youtube Uploader">
				<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
				</form>
			</div>
		</div>
		<!-- links from admin page -->
		<div class="side-widget">
		<span class="title"><?php _e('Quick Links') ?></span>				
		<ul>
			<li><a href="http://evan-herman.com" target="_blank"><?php _e('Developers Page') ?></a></li>
			<li><a href="http://evan-herman.com/blog/wordpress-plugins/" target="_blank"><?php _e('Other plugins') ?></a></li>
			<li><a href="http://evan-herman.com/blog/wordpress-plugins/youtube-uploader/support" target="_blank"><?php _e('Plugin Support') ?></a></li>
		</ul>
		</div>
<?php	
}