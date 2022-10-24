<?php

/**
 * Plugin Name:       QuadLayers TikTok Feed
 * Plugin URI:        https://quadlayers.com/documentation/tiktok-feed/
 * Description:       Display beautiful and responsive galleries on your website from your TikTok feed account.
 * Version:           2.2.3
 * Author:            QuadLayers
 * Author URI:        https://quadlayers.com
 * License:           GPLv3
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       wp-tiktok-feed
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'QLTTF_PLUGIN_NAME', 'TikTok Feed (Beta)' );
define( 'QLTTF_PLUGIN_VERSION', '2.2.3' );
define( 'QLTTF_PLUGIN_FILE', __FILE__ );
define( 'QLTTF_PLUGIN_DIR', __DIR__ . DIRECTORY_SEPARATOR );
define( 'QLTTF_DOMAIN', 'qlttf' );
define( 'QLTTF_PREFIX', QLTTF_DOMAIN );
define( 'QLTTF_WORDPRESS_URL', 'https://wordpress.org/plugins/wp-tiktok-feed/' );
define( 'QLTTF_REVIEW_URL', 'https://wordpress.org/support/plugin/wp-tiktok-feed/reviews/?filter=5#new-post' );
define( 'QLTTF_DEMO_URL', 'https://quadlayers.com/tiktok-feed/?utm_source=qlttf_admin' );
define( 'QLTTF_PURCHASE_URL', 'https://quadlayers.com/portfolio/tiktok-feed/?utm_source=qlttf_admin' );
define( 'QLTTF_SUPPORT_URL', 'https://quadlayers.com/account/support/?utm_source=qlttf_admin' );
define( 'QLTTF_DOCUMENTATION_URL', 'https://quadlayers.com/documentation/tiktok-feed/?utm_source=qlttf_admin' );
define( 'QLTTF_DOCUMENTATION_API_URL', 'https://quadlayers.com/documentation/tiktok-feed/api/?utm_source=qlttf_admin' );
define( 'QLTTF_DOCUMENTATION_ACCOUNT_URL', 'https://quadlayers.com/documentation/tiktok-feed/account/?utm_source=qlttf_admin' );
define( 'QLTTF_GROUP_URL', 'https://www.facebook.com/groups/quadlayers' );
define( 'QLTTF_DEVELOPER', false );
define( 'QLTTF_TIKTOK_URL', 'https://www.tiktok.com' );

define( 'QLTTF_PREMIUM_SELL_SLUG', 'wp-tiktok-feed-pro' );
define( 'QLTTF_PREMIUM_SELL_NAME', 'Tiktok Feed' );
define( 'QLTTF_PREMIUM_SELL_URL', 'https://quadlayers.com/portfolio/tiktok-feed/?utm_source=qlttf_admin' );

define( 'QLTTF_CROSS_INSTALL_SLUG', 'insta-gallery' );
define( 'QLTTF_CROSS_INSTALL_NAME', 'Insta Gallery' );
define( 'QLTTF_CROSS_INSTALL_DESCRIPTION', esc_html__( 'Instagram Gallery is the most user-friendly Instagram plugin for WordPress . It was built to simplify the integration, to reduce time to have sites updated and to be on track with social media that shows best growing indicators.', 'wp-tiktok-feed' ) );
define( 'QLTTF_CROSS_INSTALL_URL', 'https://quadlayers.com/portfolio/insta-gallery/?utm_source=qlttf_admin' );

/**
 * Compatibility with wp-tiktok-feed-pro 1.0.4
 */

require_once QLTTF_PLUGIN_DIR . 'compatibility/qlttf-frontend.php';

if ( ! class_exists( '\\QUADLAYERS\\TIKTOK\\Load' ) ) {
	include_once QLTTF_PLUGIN_DIR . 'lib/load.php';
}

register_activation_hook(
	QLTTF_PLUGIN_FILE,
	function() {
		do_action( QLTTF_PREFIX . '_activation' );
	}
);
