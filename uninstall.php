<?php

if (
	!defined( 'WP_UNINSTALL_PLUGIN' )
||
	!WP_UNINSTALL_PLUGIN
||
	dirname( WP_UNINSTALL_PLUGIN ) != dirname( plugin_basename( __FILE__ ) )
) {
	status_header( 404 );
	exit;
}

// Delete all compact options
delete_option( 'stv_oauth2_text'      );
delete_option( 'yt_email'        );
delete_option( 'yt_account'       );
delete_option( 'yt_account2'       );
delete_option( 'yt_account3'       );
delete_option( 'yt_account4'       );
delete_option( 'yt_account5'       );
delete_option( 'yt_pass'      );
unregister_setting( 'use_yt_analytics_checkbox'       );
