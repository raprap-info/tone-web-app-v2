<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die( -1 );
}
// TODO: remove all models data
//foreach feeds delete, dentro de delete feed delete cache
//foreach account deelete
//settings delete
if ( ! is_multisite() ) {
	$qlttf = get_option( 'tiktok_feed_settings' );
	if ( ! empty( $qlttf['flush'] ) ) {
		delete_option( 'tiktok_feed_settings' );
		delete_option( 'tiktok_feed_feeds' );
	}
}
