<?php

namespace QUADLAYERS\TIKTOK\Backend\Controller\WelcomeController;

class Load {

	protected static $instance;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_menu' ) );
	}
	function add_menu() {
		add_menu_page( QLTTF_PLUGIN_NAME, QLTTF_PLUGIN_NAME, 'edit_posts', QLTTF_DOMAIN, array( $this, 'add_panel' ), plugins_url( '/assets/backend/img/tiktok-white.svg', QLTTF_PLUGIN_FILE ) );
		add_submenu_page( QLTTF_DOMAIN, esc_html__( 'Welcome', 'wp-tiktok-feed' ), esc_html__( 'Welcome', 'wp-tiktok-feed' ), 'edit_posts', QLTTF_DOMAIN, array( $this, 'add_panel' ) );
	}

	function add_panel() {
		global $submenu;
		include \QLTTF_PLUGIN_DIR . '/lib/backend/pages/parts/header.php';
		include \QLTTF_PLUGIN_DIR . '/lib/backend/pages/welcome.php';
	}

	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

}
