<?php

namespace QUADLAYERS\TIKTOK\Utils\Dashboard;

class Links {

	protected static $instance;

	public function __construct() {
		add_filter( 'plugin_action_links_' . plugin_basename( QLTTF_PLUGIN_FILE ), array( $this, 'add_action_links' ) );
	}

	public function add_action_links( $links ) {
		$links[] = '<a target="_blank" href="' . QLTTF_WORDPRESS_URL . '">' . esc_html__( 'Premium', 'wp-tiktok-feed' ) . '</a>';
		$links[] = '<a href="' . admin_url( 'admin.php?page=' . sanitize_title( QLTTF_PREFIX ) ) . '">' . esc_html__( 'Settings', 'wp-tiktok-feed' ) . '</a>';
		return $links;
	}

	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

}
