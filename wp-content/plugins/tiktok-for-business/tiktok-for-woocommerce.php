<?php
/**
 * Copyright (c) Bytedance, Inc. and its affiliates. All Rights Reserved
 *
 * This source code is licensed under the license found in the
 * LICENSE file in the root directory of this source tree.
 *
 * Plugin Name: TikTok
 * Plugin URI: https://wordpress.org/plugins/tiktok-for-business
 * Description: With the TikTok x WooCommerce integration, it's easier than ever to unlock innovative social commerce features for your business to drive traffic and sales to a highly engaged community. With guided & simple setup prompts, you can sync your WooCommerce product catalog and promote it with custom ads without leaving your dashboard. Also, in just 1 click you can install the most-advanced TikTok pixel to unlock advanced visibility into detailed campaign performance tracking. Reach over 1 billion users, globally, and drive more e-commerce sales when you sell via one of the world’s most downloaded applications!
 * Author: TikTok
 * Version: 1.0.10
 *
 * Woo:
 *
 * @package TikTok
 */

if ( ! defined( 'ABSPATH' ) ) {
	die;
}
require_once __DIR__ . '/mapi/Tt4b_Mapi_Class.php';
require_once __DIR__ . '/logging/Logger.php';
require_once __DIR__ . '/catalog/Tt4b_Catalog_Class.php';
require_once __DIR__ . '/pixel/Tt4b_Pixel_Class.php';

/**
 * The plugin loader class
 */
class Tiktokforbusiness {

	/**
	 * The instance of the class
	 *
	 * @var Tiktokforbusiness
	 */
	private static $instance = null;

	/**
	 * The version of TikTok for WooCommerce
	 *
	 * @var string[]
	 */
	private static $current_tiktok_for_woocommerce_version = [
		'version' => '1.0.10',
	];

	/**
	 * Constructor.
	 *
	 * @return void
	 */
	private function __construct() {
		$this->initialize_hooks();
	}

	/**
	 * Initializes instances.
	 *
	 * @return tiktokforbusiness
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Initializes hooks.
	 *
	 * @return void
	 */
	private function initialize_hooks() {
		include_once 'admin/tt4b_menu.php';
		include_once 'pixel/tt4b_pixel.php';
		add_action(
			'plugins_loaded',
			function () {
				if ( get_option( 'tt4b_version' ) !== json_encode( self::$current_tiktok_for_woocommerce_version ) ) {
					update_option( 'tt4b_version', json_encode( self::$current_tiktok_for_woocommerce_version ) );
				}
				$logger  = new Logger( wc_get_logger() );
				$mapi    = new Tt4b_Mapi_Class( $logger );
				$catalog = new Tt4b_Catalog_Class( $mapi, $logger );
				$mapi->init();
				$catalog->init();
			}
		);
		register_deactivation_hook(
			__FILE__,
			[ 'Tiktokforbusiness', 'tt_plugin_deactivate' ]
		);
		register_activation_hook(
			__FILE__,
			[ 'Tiktokforbusiness', 'tt_plugin_activate' ]
		);
	}

	/**
	 * Deactivates plugin.
	 *
	 * @return void
	 */
	public static function tt_plugin_deactivate() {
		// call disconnect API
		$access_token         = get_option( 'tt4b_access_token' );
		$external_business_id = get_option( 'tt4b_external_business_id' );
		$app_id               = get_option( 'tt4b_app_id' );
		$params               = [
			'external_business_id' => $external_business_id,
			'business_platform'    => 'WOO_COMMERCE',
			'is_setup_page'        => 0,
			'app_id'               => $app_id,
		];

		// delete scheduled TikTok related actions
		as_unschedule_all_actions( 'tt4b_trust_signal_collection' );
		as_unschedule_all_actions( 'tt4b_trust_signal_helper' );
		as_unschedule_all_actions( 'tt4b_catalog_sync' );
		as_unschedule_all_actions( 'tt4b_catalog_sync_helper' );

		$mapi = new Tt4b_Mapi_Class( new Logger( wc_get_logger() ) );
		$mapi->mapi_post( 'tbp/business_profile/disconnect/', $access_token, $params );

		// delete tiktok credentials
		delete_option( 'tt4b_app_id' );
		delete_option( 'tt4b_secret' );
		delete_option( 'tt4b_access_token' );
		delete_option( 'tt4b_external_data_key' );
		delete_option( 'tt4b_catalog_page_total' );
		delete_option( 'tt4b_eligibility_page_total' );
		delete_option( 'tt4b_version' );
		delete_option( 'tt4b_mapi_total_gmv' );
		delete_option( 'tt4b_mapi_total_orders' );
		delete_option( 'tt4b_mapi_tenure' );
	}

	/**
	 * Generates app credentials.
	 *
	 * @return void
	 */
	public static function tt_plugin_activate() {
		$mapi                 = new Tt4b_Mapi_Class( new Logger( wc_get_logger() ) );
		$external_business_id = get_option( 'tt4b_external_business_id' );
		if ( false === $external_business_id ) {
			$external_business_id = uniqid( 'tt4b_woocommerce_' );
			update_option( 'tt4b_external_business_id', $external_business_id );
		}
		add_option( 'tt4b_catalog_page_total', 0 );
		add_option( 'tt4b_eligibility_page_total', 0 );
		add_option( 'tt4b_version', json_encode( self::$current_tiktok_for_woocommerce_version ) );
		add_option( 'tt4b_mapi_total_gmv', 0 );
		add_option( 'tt4b_mapi_total_orders', 0 );
		add_option( 'tt4b_mapi_tenure', 0 );
		$cleaned_redirect = preg_replace( '/[^A-Za-z0-9\-]/', '', admin_url() );
		$smb_id           = $external_business_id . $cleaned_redirect;
		$app_rsp          = $mapi->create_open_source_app( $smb_id, 'PROD', admin_url() );
		if ( false !== $app_rsp ) {
			$open_source_app_rsp = json_decode( $app_rsp, true );
			$app_id              = $open_source_app_rsp['data']['app_id'];
			$secret              = $open_source_app_rsp['data']['app_secret'];
			$external_data_key   = $open_source_app_rsp['data']['external_data_key'];
			update_option( 'tt4b_app_id', $app_id );
			update_option( 'tt4b_secret', $secret );
			update_option( 'tt4b_external_data_key', $external_data_key );
		}
	}
}

Tiktokforbusiness::get_instance();
