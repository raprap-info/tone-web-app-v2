<?php

namespace QUADLAYERS\TIKTOK\Backend\Controller\FeedController;

use QUADLAYERS\TIKTOK\Backend\Controller\Base as Controller;
use QUADLAYERS\TIKTOK\Models\Feed\Load as Models_Feed;
use QUADLAYERS\TIKTOK\Models\Account\Load as Models_Account;
use QUADLAYERS\TIKTOK\Api\Tiktok\User\Load as Api_Tiktok_User;

class Load extends Controller {

	protected static $instance;
	protected static $slug = QLTTF_DOMAIN . '_feeds';

	public function __construct() {
		add_action( 'wp_ajax_qlttf_edit_feed', array( $this, 'ajax_edit_feed' ) );
		add_action( 'wp_ajax_qlttf_save_feed', array( $this, 'ajax_save_feed' ) );
		add_action( 'wp_ajax_qlttf_delete_feed', array( $this, 'ajax_delete_feed' ) );
		add_action( 'wp_ajax_qlttf_clear_cache', array( $this, 'ajax_clear_cache' ) );
		add_action( 'admin_menu', array( $this, 'add_menu' ) );
	}

	function add_menu() {
		add_submenu_page( QLTTF_DOMAIN, esc_html__( 'Feeds', 'wp-tiktok-feed' ), esc_html__( 'Feeds', 'wp-tiktok-feed' ), 'manage_options', self::$slug, array( $this, 'add_panel' ) );
	}

	function add_panel() {
		global $submenu;
		$feed_model = new Models_Feed();
		$feeds      = $feed_model->get_feeds();
		// MODIFIED
		$account_model = new Models_Account();
		$accounts      = $account_model->get_accounts();

		include \QLTTF_PLUGIN_DIR . '/lib/backend/pages/parts/header.php';
		include \QLTTF_PLUGIN_DIR . '/lib/backend/pages/feeds.php';
	}

	function get_feed( $feed_id ) {
		function get_the_title1( $id ) {
			return ( $id == 'all' ) ? esc_html__( 'All', 'wp-tiktok-feed' ) : get_the_title( $id );
		}

		$feed_model = new Models_Feed();
		$feed       = $feed_model->get_feed( $feed_id );
		return $feed;
	}

	function ajax_edit_feed() {
		if ( current_user_can( 'manage_options' ) && check_ajax_referer( 'qlttf_edit_feed', 'nonce', false ) ) {

			$feed_id = ( isset( $_REQUEST['feed_id'] ) ) ? absint( $_REQUEST['feed_id'] ) : -1;

			if ( $feed_id != -1 ) {
				$feed = $this->get_feed( $feed_id );
				if ( $feed ) {
					return parent::success_ajax( $feed );
				}
			}
			parent::error_reload_page();
		}
		parent::error_access_denied();
	}

	function ajax_save_feed() {
		if ( isset( $_REQUEST['feed'] ) && current_user_can( 'manage_options' ) && check_ajax_referer( 'qlttf_save_feed', 'nonce', false ) ) {

			$feed = json_decode( stripslashes( $_REQUEST['feed'] ), true );

			if ( is_array( $feed ) ) {

				$feed_model = new Models_Feed();

				if ( isset( $feed['id'] ) ) {
					return parent::success_ajax( $feed_model->update_feed( $feed ) );
				} else {
					return parent::success_ajax( $feed_model->add_feed( $feed ) );
				}

				return parent::error_reload_page();
			}
		}
		return parent::error_access_denied();
	}

	function ajax_delete_feed() {
		if ( isset( $_REQUEST['feed_id'] ) && current_user_can( 'manage_options' ) && check_ajax_referer( 'qlttf_delete_feed', 'nonce', false ) ) {

			$feed_id = absint( $_REQUEST['feed_id'] );

			$feed_model = new Models_Feed();

			$feed = $feed_model->delete_feed( $feed_id );

			if ( $feed_id ) {
				return parent::success_ajax( $feed );
			}

			parent::error_reload_page();
		}

		parent::error_access_denied();
	}

	function ajax_clear_cache() {

		if ( isset( $_REQUEST['open_id'] ) && current_user_can( 'manage_options' ) && check_ajax_referer( 'qlttf_clear_cache', 'nonce', false ) ) {

			$api_user = new Api_Tiktok_User( $_REQUEST['open_id'] );

			$api_user->delete_feed_cache();

			return parent::success_ajax( esc_html__( 'Feed cache cleared', 'wp-tiktok-feed' ) );
		}

		parent::error_access_denied();
	}

	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}
