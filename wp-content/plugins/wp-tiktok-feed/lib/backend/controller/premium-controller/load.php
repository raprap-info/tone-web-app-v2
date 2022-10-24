<?php

namespace QUADLAYERS\TIKTOK\Backend\Controller\PremiumController;

use QUADLAYERS\TIKTOK\Backend\Controller\Base as Controller;

class Load extends Controller {

	protected static $instance;
	protected static $slug = QLTTF_DOMAIN . '_premium';

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_menu' ) );
		add_action( 'admin_footer', array( $this, 'add_css' ) );
	}

	function add_menu() {
		add_submenu_page( QLTTF_DOMAIN, esc_html__( 'Premium', 'wp-tiktok-feed' ), sprintf( '%s <i class="dashicons dashicons-awards"></i>', esc_html__( 'Premium', 'wp-tiktok-feed' ) ), 'edit_posts', self::$slug, array( $this, 'add_panel' ) );
	}

	function add_panel() {
		global $submenu;
		include \QLTTF_PLUGIN_DIR . '/lib/backend/pages/parts/header.php';
		include \QLTTF_PLUGIN_DIR . '/lib/backend/pages/premium.php';
	}

	function add_css() {
		if ( $this->is_edit_page() || $this->is_edit_page( 'new' ) || $this->is_edit_page( 'edit' ) ) {
			if ( ! class_exists( 'QLTTF_PRO' ) ) {
				?>
				<style>
					.qlttf-premium-field {
						opacity: 0.5;
						pointer-events: none;
					}

					.qlttf-premium-field .description {
						display: inline-block !important;
					}
				</style>
				<?php
			} else {
				?>
				<style>
					.qlttf-premium-field-username {
						display: none;
					}
				</style>
				<?php
			}
		}
	}

	function is_edit_page( $new_edit = null ) {
		global $pagenow;

		if ( isset( $_GET['page'] ) && strpos( $_GET['page'], QLTTF_DOMAIN ) !== false ) {
			return true;
		} elseif ( $new_edit == 'edit' ) {
			return in_array( $pagenow, array( 'post.php' ) );
		} elseif ( $new_edit == 'new' ) { // check for new post page
			return in_array( $pagenow, array( 'post-new.php' ) );
		} else { // check for either new or edit
			return in_array( $pagenow, array( 'post.php', 'post-new.php' ) );
		}
	}

	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}
