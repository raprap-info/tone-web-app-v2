<?php

namespace QUADLAYERS\TIKTOK\Backend\Controller\BlockController;

use QUADLAYERS\TIKTOK\Backend\Controller\Base as Controller;
use QUADLAYERS\TIKTOK\Frontend\Load as Frontend;
use QUADLAYERS\TIKTOK\Models\Feed\Load as Models_Feed;

class Load extends Controller {

	protected static $instance;
	protected static $slug = QLTTF_DOMAIN . '_feeds';

	public function __construct() {
		add_action( 'admin_print_scripts-post-new.php', array( $this, 'add_js' ), 11 );
		add_action( 'admin_print_scripts-post.php', array( $this, 'add_js' ), 11 );
		add_filter( 'block_categories_all', array( $this, 'register_block_category' ), 11 );
		register_block_type(
			'qlttf/box',
			array(
				'attributes'      => $this->get_attributes(),
				'render_callback' => array( $this, 'render_callback' ),
			)
		);
	}

	public function register_block_category( $categories ) {
		$categories = array_merge(
			$categories,
			array(
				array(
					'slug'  => 'qlttf',
					'title' => QLTTF_PLUGIN_NAME,
				),
			)
		);
		return $categories;
	}

	function sanitize_value( &$value ) {
		if ( $value === 'true' ) {
			$value = true;
		} elseif ( $value === 'false' ) {
			$value = false;
		} elseif ( is_numeric( $value ) ) {
			$value = (int) $value;
		}
	}

	function render_callback( $feed, $content, $block = array() ) {
		$block = (object) $block;
		array_walk_recursive( $feed, array( $this, 'sanitize_value' ) );
		$id = rand();
		return Frontend::create_shortcode( $feed, $id );
	}


	function get_attributes() {
		$feed_model = new Models_Feed();
		$feed_arg   = $feed_model->get_args();

		$attributes = array();
		foreach ( $feed_arg as $id => $value ) {
			$attributes[ $id ] = array(
				'type'    => array( 'string', 'object', 'array', 'boolean', 'number' ),
				'default' => $value,
			);
		}
		return $attributes;
	}

	function add_js() {
		$gutenberg = include_once QLTTF_PLUGIN_DIR . 'build/backend/js/gutenberg.asset.php';

		wp_enqueue_style( 'wp-tiktok-feed' );
		wp_enqueue_script( 'wp-tiktok-feed' );
		wp_enqueue_style( 'magnific-popup' );
		wp_enqueue_script( 'magnific-popup' );
		wp_enqueue_style( 'swiper' );
		wp_enqueue_script( 'swiper' );
		wp_enqueue_script( 'masonry' );
		wp_enqueue_style( 'qlttf-editor-admin-gutenberg', plugins_url( '/build/backend/css/style.css', QLTTF_PLUGIN_FILE ), array(), QLTTF_PLUGIN_VERSION );
		wp_enqueue_script( 'qlttf-admin-gutenberg', plugins_url( '/build/backend/js/index.js', QLTTF_PLUGIN_FILE ), $gutenberg['dependencies'], $gutenberg['version'], true );
		wp_localize_script(
			'qlttf-admin-gutenberg',
			'qlttf_gutenberg',
			array(
				'nonce'      => array(),
				'attributes' => $this->get_attributes(),
				'image_url'  => plugins_url( '/assets/backend/img', QLTTF_PLUGIN_FILE ),
			)
		);

		wp_localize_script(
			'qlttf-admin-gutenberg',
			'qlttf',
			array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
			)
		);
	}

	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}
