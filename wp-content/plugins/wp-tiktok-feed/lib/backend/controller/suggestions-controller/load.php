<?php

namespace QUADLAYERS\TIKTOK\Backend\Controller\SuggestionsController;

use QUADLAYERS\TIKTOK\Models\Suggestions\Load as Suggestions_List_Table;

class Load {

	protected static $instance;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_menu' ) );
		add_action( 'admin_init', array( $this, 'add_redirect' ) );
		add_filter( 'network_admin_url', array( $this, 'network_admin_url' ), 10, 2 );
	}

	function add_menu() {
		add_submenu_page( QLTTF_DOMAIN, esc_html__( 'Suggestions', 'wp-tiktok-feed' ), sprintf( '%s', esc_html__( 'Suggestions', 'wp-tiktok-feed' ) ), 'edit_posts', QLTTF_DOMAIN . '_suggestions', array( $this, 'add_panel' ), 99 );
	}

	function add_panel() {
		global $submenu;
		$wp_list_table = new Suggestions_List_Table();
		$wp_list_table->prepare_items();
		include \QLTTF_PLUGIN_DIR . '/lib/backend/pages/parts/header.php';
		include \QLTTF_PLUGIN_DIR . '/lib/backend/pages/suggestions.php';
	}

	// fix for activateUrl on install now button
	public function network_admin_url( $url, $path ) {
		if ( wp_doing_ajax() && ! is_network_admin() ) {
			if ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'install-plugin' ) {
				if ( strpos( $url, 'plugins.php' ) !== false ) {
					$url = self_admin_url( $path );
				}
			}
		}

		return $url;
	}

	public function add_redirect() {
		if ( isset( $_REQUEST['activate'] ) && $_REQUEST['activate'] == 'true' ) {
			if ( wp_get_referer() == admin_url( 'admin.php?page=' . QLTTF_DOMAIN . '_suggestions' ) ) {
				wp_redirect( admin_url( 'admin.php?page=' . QLTTF_DOMAIN . '_suggestions' ) );
			}
		}
	}

	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}
