<?php

namespace QUADLAYERS\TIKTOK\Backend;

use QUADLAYERS\TIKTOK\Models\Feed\Load as Models_Feed;
use QUADLAYERS\TIKTOK\Models\Account\Load as Models_Account;

class Load {

	protected static $instance;

	public function __construct() {
		Controller\WelcomeController\Load::instance();
		Controller\AccountController\Load::instance();
		Controller\FeedController\Load::instance();
		// Controller\BlockController\Load::instance();
		Controller\SettingController\Load::instance();
		Controller\PremiumController\Load::instance();
		Controller\SuggestionsController\Load::instance();
		add_action( 'admin_enqueue_scripts', array( $this, 'add_js' ) );
		add_filter( 'sanitize_option_qlttf', 'wp_unslash' );
	}

	function add_js() {

		$feed_model    = new Models_Feed();
		$account_model = new Models_Account();

		wp_register_script( 'jquery-serializejson', plugins_url( '/assets/backend/jquery-serializejson/jquery-serializejson.min.js', QLTTF_PLUGIN_FILE ), array( 'jquery' ), QLTTF_PLUGIN_VERSION, true );
		wp_register_script( 'wp-color-picker-alpha', plugins_url( '/assets/backend/rgba/wp-color-picker-alpha.min.js', QLTTF_PLUGIN_FILE ), array( 'jquery', 'wp-color-picker' ), QLTTF_PLUGIN_VERSION, true );
		wp_localize_script(
			'wp-color-picker-alpha',
			'wpColorPickerL10n',
			array(
				'clear'            => __( 'Clear', 'wp-tiktok-feed' ),
				'clearAriaLabel'   => __( 'Clear color', 'wp-tiktok-feed' ),
				'defaultString'    => __( 'Default', 'wp-tiktok-feed' ),
				'defaultAriaLabel' => __( 'Select default color', 'wp-tiktok-feed' ),
				'pick'             => __( 'Select Color', 'wp-tiktok-feed' ),
				'defaultLabel'     => __( 'Color value', 'wp-tiktok-feed' ),
			)
		);

		$backend = include_once QLTTF_PLUGIN_DIR . 'build/backend/js/index.asset.php';

		wp_register_script( 'qlttf-backend', plugins_url( '/build/backend/js/index.js', QLTTF_PLUGIN_FILE ), $backend['dependencies'], $backend['version'], true );

		wp_localize_script(
			'qlttf-backend',
			'qlttf_account',
			array(
				'nonce'   => array(
					'qlttf_add_account'        => wp_create_nonce( 'qlttf_add_account' ),
					'qlttf_delete_account'     => wp_create_nonce( 'qlttf_delete_account' ),
					'qlttf_renew_access_token' => wp_create_nonce( 'qlttf_renew_access_token' ),
					'qlttf_add_account_by_rft' => wp_create_nonce( 'qlttf_add_account_by_rft' ),
				),
				'message' => array(
					'confirm_delete' => esc_html__( 'Do you want to delete the account?', 'wp-tiktok-feed' ),
				),
			)
		);

		wp_localize_script(
			'qlttf-backend',
			'qlttf_feed',
			array(
				'nonce'    => array(
					'qlttf_edit_feed'   => wp_create_nonce( 'qlttf_edit_feed' ),
					'qlttf_save_feed'   => wp_create_nonce( 'qlttf_save_feed' ),
					'qlttf_delete_feed' => wp_create_nonce( 'qlttf_delete_feed' ),
					'qlttf_clear_cache' => wp_create_nonce( 'qlttf_clear_cache' ),
				),
				'message'  => array(
					'save'                => __( 'Please save feed settings to update user account.', 'wp-tiktok-feed' ),
					'confirm_delete'      => __( 'Do you want to delete the feed?', 'wp-tiktok-feed' ),
					'confirm_clear_cache' => __( 'Do you want to delete the feed?', 'wp-tiktok-feed' ),
					'confirm_username'    => __( 'You need to create token before creating a feed.', 'wp-tiktok-feed' ),
				),
				'accounts' => $account_model->get_accounts(),
				'args'     => $feed_model->get_args(),
				'redirect' => array(
					'accounts' => admin_url( 'admin.php?page=qlttf_account' ),
				),
			)
		);

		wp_localize_script(
			'qlttf-backend',
			'qlttf_settings',
			array(
				'nonce' => array(
					'qlttf_save_settings' => wp_create_nonce( 'qlttf_save_settings' ),
				),
			)
		);

		wp_register_style( 'qlttf-backend', plugins_url( '/build/backend/css/style.css', QLTTF_PLUGIN_FILE ), array( 'wp-color-picker', 'media-views' ), QLTTF_PLUGIN_VERSION, 'all' );

		if ( isset( $_GET['page'] ) && strpos( $_GET['page'], QLTTF_PREFIX ) !== false ) {
			wp_enqueue_style( 'qlttf-backend' );
			wp_enqueue_script( 'qlttf-backend' );
		}
	}

	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}
