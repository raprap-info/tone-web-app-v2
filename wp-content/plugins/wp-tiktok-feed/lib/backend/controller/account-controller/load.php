<?php

namespace QUADLAYERS\TIKTOK\Backend\Controller\AccountController;

use QUADLAYERS\TIKTOK\Backend\Controller\Base as Controller;
use QUADLAYERS\TIKTOK\Models\Account\Load as Models_Account;
use QUADLAYERS\TIKTOK\Api\Tiktok\User\Load as Api_Tiktok_User;

class Load extends Controller {

	protected static $instance;
	protected static $slug = QLTTF_DOMAIN . '_account';

	public function __construct() {
		add_action( 'admin_init', array( $this, 'init_add_account' ) );
		add_action( 'wp_ajax_qlttf_delete_account', array( $this, 'ajax_delete_account' ) );
		add_action( 'wp_ajax_qlttf_renew_access_token', array( $this, 'ajax_renew_access_token' ) );
		add_action( 'wp_ajax_qlttf_add_account_by_rft', array( $this, 'ajax_add_account_by_rft' ) );
		add_action( 'admin_menu', array( $this, 'add_menu' ) );
	}

	function add_menu() {
		add_submenu_page( QLTTF_DOMAIN, esc_html__( 'Accounts', 'wp-tiktok-feed' ), esc_html__( 'Accounts', 'wp-tiktok-feed' ), 'manage_options', self::$slug, array( $this, 'add_panel' ) );
	}

	function add_panel() {
		global $submenu;
		$api_user      = new Api_Tiktok_User();
		$account_model = new Models_Account();
		$accounts      = $account_model->get_accounts();

		include \QLTTF_PLUGIN_DIR . '/lib/backend/pages/parts/header.php';
		include \QLTTF_PLUGIN_DIR . '/lib/backend/pages/account.php';
	}

	function ajax_add_account_by_rft() {

		if ( ! empty( $_REQUEST['account_rft'] ) && current_user_can( 'manage_options' ) && check_ajax_referer( 'qlttf_add_account_by_rft', 'nonce', false ) ) {
			$account_model = new Models_Account();

			$response = $account_model->renew_access_token( $_REQUEST['account_rft'] );

			if ( isset( $account['error']['message'] ) ) {
				parent::error_ajax( esc_html( $response['error']['message'] ) );
			}
			if ( isset( $account['message'] ) ) {
				parent::error_ajax( esc_html( $response['message'] ) );
			}

			$account_data['open_id']                       = $response->open_id;
			$account_data['access_token']                  = $response->access_token;
			$account_data['refresh_token']                 = $response->refresh_token;
			$account_data['access_token_renew_atemps']     = 0;
			$account_data['access_token_expiration_date']  = $account_model->calculate_expiration_date( $response->access_token_expires_in );
			$account_data['refresh_token_expiration_date'] = $account_model->calculate_expiration_date( $response->refresh_token_expires_in );

			$account = $account_model->add_account( $account_data );

			if ( $account ) {
				if ( isset( $account['open_id'] ) ) {
					parent::success_ajax( esc_html__( 'The account has been added successfully', 'wp-tiktok-feed' ) );
				}
			}
		}
	}

	function ajax_renew_access_token() {
		if ( ! empty( $_REQUEST['account_id'] ) && current_user_can( 'manage_options' ) && check_ajax_referer( 'qlttf_renew_access_token', 'nonce', false ) ) {

			$account_model = new Models_Account();

			if ( $account = $account_model->force_refresh_access_token( $_REQUEST['account_id'] ) ) {

				if ( isset( $account['open_id'] ) ) {
					parent::success_ajax( esc_html__( 'The token has been updated successfully', 'wp-tiktok-feed' ) );
				}
				if ( isset( $account['error']['message'] ) ) {
					parent::error_ajax( esc_html( $account['error']['message'] ) );
				}
				if ( isset( $account['message'] ) ) {
					parent::error_ajax( esc_html( $account['message'] ) );
				}
			}
		}
	}

	function init_add_account() {
		if ( isset( $_REQUEST['accounts'][0]['open_id'] ) ) {
			$account_model = new Models_Account();

			foreach ( $_REQUEST['accounts'] as $response_account_data ) {
				if ( isset( $response_account_data['open_id'] ) && isset( $response_account_data['access_token'] ) && isset( $response_account_data ['access_token_expires_in'] ) && isset( $response_account_data['refresh_token'] ) && isset( $response_account_data['refresh_token_expires_in'] )
				) {

					$sanitized_response = array_map(
						function( $value ) {
							return sanitize_text_field( base64_decode( $value ) );
						},
						$response_account_data
					);

					$open_id                       = $sanitized_response['open_id'];
					$access_token                  = $sanitized_response['access_token'];
					$access_token_expires_in       = $sanitized_response['access_token_expires_in'];
					$refresh_token                 = $sanitized_response['refresh_token'];
					$refresh_token_expires_in      = $sanitized_response['refresh_token_expires_in'];
					$access_token_expiration_date  = $account_model->calculate_expiration_date( $sanitized_response['access_token_expires_in'] );
					$refresh_token_expiration_date = $account_model->calculate_expiration_date( $sanitized_response['refresh_token_expires_in'] );

					$account_model->add_account(
						array(
							'open_id'                      => $open_id,
							'access_token'                 => $access_token,
							'access_token_expires_in'      => $access_token_expires_in,
							'refresh_token'                => $refresh_token,
							'refresh_token_expires_in'     => $refresh_token_expires_in,
							'access_token_expiration_date' => $access_token_expiration_date,
							'refresh_token_expiration_date' => $refresh_token_expiration_date,
						)
					);
				}
			}

			if ( wp_safe_redirect( admin_url( 'admin.php?page=qlttf_account' ) ) ) {
				exit;
			}
		}
	}

	function ajax_delete_account() {
		if ( ! empty( $_REQUEST['account_id'] ) && current_user_can( 'manage_options' ) && check_ajax_referer( 'qlttf_delete_account', 'nonce', false ) ) {

			$account_model = new Models_Account();

			$account_id = sanitize_text_field( $_REQUEST['account_id'] );

			$account_model->delete_account( $account_id );

			parent::success_ajax( esc_html__( 'Account removed successfully', 'wp-tiktok-feed' ) );
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
