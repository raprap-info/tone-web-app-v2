<?php


namespace QUADLAYERS\TIKTOK\Backend\Controller\SettingController;

use QUADLAYERS\TIKTOK\Models\Setting\Load as Models_Settings;
use QUADLAYERS\TIKTOK\Backend\Controller\Base as Controller;

class Load extends Controller {

	protected static $instance;
	protected static $slug = QLTTF_DOMAIN . '_setting';

	public function __construct() {
		add_action( 'wp_ajax_qlttf_save_settings', array( $this, 'ajax_save_settings' ) );
		add_action( 'admin_menu', array( $this, 'add_menu' ) );
	}

	function add_menu() {
		add_submenu_page( QLTTF_DOMAIN, esc_html__( 'Settings', 'wp-tiktok-feed' ), esc_html__( 'Settings', 'wp-tiktok-feed' ), 'manage_options', self::$slug, array( $this, 'add_panel' ) );
	}

	function add_panel() {
		global $submenu;
		$settings_model = new Models_Settings();
		$settings       = $settings_model->get_settings();

		include \QLTTF_PLUGIN_DIR . '/lib/backend/pages/parts/header.php';
		include \QLTTF_PLUGIN_DIR . '/lib/backend/pages/settings.php';
	}

	function ajax_save_settings() {
		if ( ! empty( $_REQUEST['settings_data'] ) && current_user_can( 'manage_options' ) && check_admin_referer( 'qlttf_save_settings', 'nonce' ) ) {
			$settings_model = new Models_Settings();

			$settings_data = array();
			parse_str( $_REQUEST['settings_data'], $settings_data );

			$settings_model->save_settings( $settings_data );
			parent::success_ajax( esc_html__( 'Settings updated successfully', 'wp-tiktok-feed' ) );
		}

		parent::error_ajax( esc_html__( 'Invalid Request', 'wp-tiktok-feed' ) );
	}

	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}
