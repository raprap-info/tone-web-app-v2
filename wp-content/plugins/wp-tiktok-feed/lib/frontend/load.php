<?php

namespace QUADLAYERS\TIKTOK\Frontend;

use QUADLAYERS\TIKTOK\Models\Feed\Load as Models_Feed;
use QUADLAYERS\TIKTOK\Api\Tiktok\User\Load as Api_Tiktok_User;
use QUADLAYERS\TIKTOK\Frontend\Video\Stream as Video_Stream;


class Load {

	protected static $instance;

	public function __construct() {
		add_action( 'wp_ajax_nopriv_qlttf_load_item_images', array( $this, 'ajax_load_item_images' ) );
		add_action( 'wp_ajax_qlttf_load_item_images', array( $this, 'ajax_load_item_images' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'add_js' ) );
		add_shortcode( 'tiktok-feed', array( $this, 'do_shortcode' ) );

		Video_Stream::instance();

		if ( class_exists( '\QUADLAYERS\TIKTOK_PRO\Frontend\Video\Download\Load' ) ) {
			\QUADLAYERS\TIKTOK_PRO\Frontend\Video\Download\Load::instance();
		}
	}

	function add_js() {

		$frontend = include_once QLTTF_PLUGIN_DIR . 'build/frontend/js/index.asset.php';

		wp_register_style( 'wp-tiktok-feed', plugins_url( '/build/frontend/css/style.css', QLTTF_PLUGIN_FILE ), null, QLTTF_PLUGIN_VERSION );

		wp_register_script( 'wp-tiktok-feed', plugins_url( '/build/frontend/js/index.js', QLTTF_PLUGIN_FILE ), $frontend['dependencies'], $frontend['version'], true );

		wp_localize_script(
			'wp-tiktok-feed',
			'qlttf',
			array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
			)
		);

		// Masonry
		// -----------------------------------------------------------------------
		wp_register_script( 'masonry', plugins_url( '/assets/frontend/masonry/masonry.pkgd.min.js', QLTTF_PLUGIN_FILE ), null, QLTTF_PLUGIN_VERSION, true );

		// Swiper
		// -----------------------------------------------------------------------
		wp_register_style( 'swiper', plugins_url( '/assets/frontend/swiper/swiper.min.css', QLTTF_PLUGIN_FILE ), null, QLTTF_PLUGIN_VERSION );
		wp_register_script( 'swiper', plugins_url( '/assets/frontend/swiper/swiper.min.js', QLTTF_PLUGIN_FILE ), array( 'jquery' ), QLTTF_PLUGIN_VERSION, true );

		// Popup
		// -----------------------------------------------------------------------
		wp_register_style( 'magnific-popup', plugins_url( '/assets/frontend/magnific-popup/magnific-popup.min.css', QLTTF_PLUGIN_FILE ), null, QLTTF_PLUGIN_VERSION );
		wp_register_script( 'magnific-popup', plugins_url( '/assets/frontend/magnific-popup/jquery.magnific-popup.min.js', QLTTF_PLUGIN_FILE ), array( 'jquery' ), QLTTF_PLUGIN_VERSION, true );
	}

	function get_feed_data( $feed = false, $last_item_create_time = false ) {

		switch ( $feed['source'] ) {
			case 'username':
				if ( ! isset( $feed['open_id'] ) ) {
					return sprintf( esc_html__( 'The feed open_id %s dosen\'t exists.', 'wp-tiktok-feed' ), $feed['open_id'] );
				}
				$api_user = new Api_Tiktok_User( $feed['open_id'], intval( $feed['limit'] ) );

				$cursor = null;

				if ( '0' !== $last_item_create_time ) {
					$cursor = $last_item_create_time . '000';
				}

				return $api_user->get_feed_data( $cursor );

			case 'hashtag':
				if ( ! isset( $feed['hashtag'] ) ) {
					return sprintf( esc_html__( 'The feed hashtag %s dosen\'t exists.', 'wp-tiktok-feed' ), $feed['hashtag'] );
				}
				if ( ! class_exists( '\\QUADLAYERS\\TIKTOK_PRO\\Api\\Tiktok\\Hashtag\\Load' ) ) {
					return wp_kses_post(
						sprintf(
							__( 'Trending Feed is a Premium feature. For more info click %s.' ),
							sprintf( '<a href="%s">here.</a>', esc_url( $premium_url ) )
						)
					);
				}
				$api_hashtag = new \QUADLAYERS\TIKTOK_PRO\Api\Tiktok\Hashtag\Load( $feed['hashtag'], 5600, $feed['limit'] );

				$load_more = false;

				if ( '0' !== $last_item_create_time ) {
					$load_more = true;
				}

				return $api_hashtag->get_feed_data( $load_more );

			case 'trending':
				if ( ! class_exists( '\\QUADLAYERS\\TIKTOK_PRO\\Api\\Tiktok\\Trending\\Load' ) ) {
					return wp_kses_post(
						sprintf(
							__( 'Trending Feed is a Premium feature. For more info click %s.' ),
							sprintf( '<a href="%s">here.</a>', esc_url( $premium_url ) )
						)
					);
				}
				$api_trending = new \QUADLAYERS\TIKTOK_PRO\Api\Tiktok\Trending\Load( intval( $feed['limit'] ) );
				$load_more    = false;

				if ( '0' !== $last_item_create_time ) {
					$load_more = true;
				}

				return $api_trending->get_feed_data( $load_more );
		}
	}

	static function get_feed_profile( $feed = false ) {
		$profile_info = array(
			'open_id'      => null,
			'avatar_url'   => null,
			'display_name' => null,
			'is_valid'     => false,
		);

		switch ( $feed['source'] ) {

			case 'username':
				$api_user                 = new Api_Tiktok_User( $feed['open_id'] );
				$profile_info             = $api_user->get_profile_data();
				$profile_info['link']     = QLTTF_TIKTOK_URL . "/@{$feed['username']}";
				$profile_info['is_valid'] = true;

				break;

			case 'hashtag':
				$profile_info = array(
					'avatar_url'   => plugins_url( '/assets/backend/img/hashtag.svg', QLTTF_PLUGIN_FILE ),
					'display_name' => $feed['hashtag'],
					'open_id'      => $feed['hashtag'],
					'link'         => QLTTF_TIKTOK_URL . "/tag/{$feed['hashtag']}",
					'is_valid'     => false,
				);
				if ( class_exists( '\\QUADLAYERS\\TIKTOK_PRO\\Api\\Tiktok\\Hashtag\\Load' ) ) {
					$profile_info['is_valid'] = true;
				}

				break;

			case 'trending':
				$profile_info = array(
					'avatar_url'   => plugins_url( '/assets/backend/img/hashtag.svg', QLTTF_PLUGIN_FILE ),
					'display_name' => 'trending',
					'open_id'      => 'trending',
					'link'         => QLTTF_TIKTOK_URL,
					'is_valid'     => false,
				);

				if ( class_exists( '\\QUADLAYERS\\TIKTOK_PRO\\Api\\Tiktok\\Trending\\Load' ) ) {
					$profile_info['is_valid'] = true;
				}

				break;
		}
		return $profile_info;
	}

	function ajax_load_item_images() {

		if ( ! isset( $_REQUEST['feed'] ) ) {
			wp_send_json_error( esc_html__( 'Invalid item id', 'wp-tiktok-feed' ) );
		}

		$feed = json_decode( stripslashes( $_REQUEST['feed'] ), true );

		$last_item_create_time = isset( $_REQUEST['last_item_create_time'] ) ? $_REQUEST['last_item_create_time'] : null;

		$feed_data = $this->get_feed_data( $feed, $last_item_create_time );

		ob_start();

		if ( isset( $feed_data[0]['covers'] ) ) {
			// Template.
			$i = 1;

			foreach ( $feed_data as $item ) {

				$image = $item['covers'][ $feed['video']['covers'] ];

				include self::template_path( 'item/item.php' );

				$i++;

				if ( ( $feed['limit'] != 0 ) && ( $i > $feed['limit'] ) ) {
					break;
				}
			}
			wp_send_json_success( ob_get_clean() );
		}

		$messages = $feed_data;

		include self::template_path( 'alert.php' );

		wp_send_json_error( ob_get_clean() );
	}

	static function template_path( $template_name, $template_file = false ) {
		if ( file_exists( QLTTF_PLUGIN_DIR . "templates/{$template_name}" ) ) {
			$template_file = QLTTF_PLUGIN_DIR . "templates/{$template_name}";
		}

		if ( file_exists( trailingslashit( get_stylesheet_directory() ) . "tiktok-feed/{$template_name}" ) ) {
			$template_file = trailingslashit( get_stylesheet_directory() ) . "tiktok-feed/{$template_name}";
		}

		return apply_filters( 'qlttf_template_file', $template_file, $template_name );
	}

	static function create_shortcode( $feed, $id = null ) {

		wp_enqueue_style( 'wp-tiktok-feed' );

		$premium_url = admin_url( 'admin.php?page=qlttf_premium' );

		$profile_info = array();

		if ( isset( $feed['source'] ) ) {
			$profile_info = self::get_feed_profile( $feed );
		}

		if ( empty( $profile_info['is_valid'] ) ) {

			if ( empty( $feed ) ) {
				$messages = array(
					wp_kses_post(
						sprintf(
							__( 'Feed %s dosen\'t exists.', 'wp-tiktok-feed' ),
							 $id
						)
					),
				);
			} else {
				$messages = array(
					wp_kses_post(
						sprintf(
							__( '%s Feed is a Premium feature.', 'wp-tiktok-feed' ),
							ucfirst( $feed['source'] )
						)
					),
				);
				if ( current_user_can( 'manage_options' ) ) {
					$messages = array(
						wp_kses_post(
							sprintf(
								__( '%1$s Feed is a Premium feature. For more info click %2$s.', 'wp-tiktok-feed' ),
								ucfirst( $feed['source'] ),
								sprintf( '<a href="%s">here.</a>', esc_url( $premium_url ) )
							)
						),
					);
				}
			}

			ob_start();
			include self::template_path( 'alert.php' );
			return ob_get_clean();
		}

		$template_file = self::template_path( "{$feed['layout']}.php" );

		if ( ! $template_file ) {
			$messages = array(
				sprintf( esc_html__( 'The layout %s is not a available.', 'wp-tiktok-feed' ), $feed['layout'] ),
			);
			ob_start();
			include self::template_path( 'alert.php' );
			return ob_get_clean();
		}

		wp_enqueue_script( 'wp-tiktok-feed' );

		$feed['highlight']        = explode( ',', trim( str_replace( ' ', '', "{$feed['highlight']['tag']},{$feed['highlight']['id']},{$feed['highlight']['position']}" ), ',' ) );
		$feed['highlight-square'] = explode( ',', trim( str_replace( ' ', '', "{$feed['highlight-square']['tag']},{$feed['highlight-square']['id']},{$feed['highlight-square']['position']}" ), ',' ) );

		if ( ! empty( $feed['popup']['display'] ) ) {
			wp_enqueue_style( 'magnific-popup' );
			wp_enqueue_script( 'magnific-popup' );
		}

		if ( $feed['layout'] == 'carousel' || $feed['layout'] == 'carousel-vertical' ) {
			wp_enqueue_style( 'swiper' );
			wp_enqueue_script( 'swiper' );
		}

		if ( $feed['layout'] == 'highlight' || $feed['layout'] == 'highlight-square' || $feed['layout'] == 'masonry' ) {
			wp_enqueue_script( 'masonry' );
		}

		if ( $id === null ) {
			$id = rand();
		}

		$item_selector = "tiktok-feed-feed-{$id}";

		ob_start();
		?>
		<style>
			<?php
			if ( $feed['layout'] != 'carousel' ) {
				if ( ! empty( $feed['video']['spacing'] ) ) {
					echo "#{$item_selector} .tiktok-feed-list {margin: 0 -{$feed['video']['spacing']}px;}";
				}
				if ( ! empty( $feed['video']['spacing'] ) ) {
					echo "#{$item_selector} .tiktok-feed-list .tiktok-feed-item {padding: {$feed['video']['spacing']}px;}";
				}
				if ( ! empty( $feed['video']['radius'] ) ) {
					echo "#{$item_selector} .tiktok-feed-item .tiktok-feed-video-wrap {border-radius: {$feed['video']['radius']}px; overflow: hidden;}";
					echo "#{$item_selector} .tiktok-feed-list .tiktok-feed-link {border-radius: {$feed['video']['radius']}px; overflow: hidden;}";
				}
			}
			if ( ! empty( $feed['mask']['background'] ) ) {
				echo "#{$item_selector} .tiktok-feed-list .tiktok-feed-item .tiktok-feed-video-wrap .tiktok-feed-video-mask {background-color: {$feed['mask']['background']};}";
			}
			if ( ! empty( $feed['button']['background'] ) ) {
				echo "#{$item_selector} .tiktok-feed-actions .tiktok-feed-button {background-color: {$feed['button']['background']};}";
			}
			if ( ! empty( $feed['button']['background_hover'] ) ) {
				echo "#{$item_selector} .tiktok-feed-actions .tiktok-feed-button:hover {background-color: {$feed['button']['background_hover']};}";
			}

			if ( ! empty( $settings['spinner_id'] ) ) {

				$spinner = wp_get_attachment_image_src( $settings['spinner_id'], 'full' );

				if ( ! empty( $spinner[0] ) ) {
					echo "#{$item_selector} .tiktok-feed-spinner {background-image:url($spinner[0])}";
				}
			}
				do_action( 'qlttf_template_style', $item_selector, $feed );
			?>
		</style>
		<?php

		include $template_file;

		return ob_get_clean();
	}

	function do_shortcode( $atts, $content = null ) {

		$atts = shortcode_atts(
			array(
				'id' => 0,
			),
			$atts
		);

		$id = absint( $atts['id'] );

		$feed_model = new Models_Feed();
		$feed       = $feed_model->get_feed( $id );

		return self::create_shortcode( $feed, $id );

	}

	static function qlttf_thousands_roud( $num ) {
		if ( $num > 1000 ) {

			$x               = round( $num );
			$x_number_format = number_format( $x );
			$x_array         = explode( ',', $x_number_format );
			$x_parts         = array( 'k', 'm', 'b', 't' );
			$x_count_parts   = count( $x_array ) - 1;
			$x_display       = $x;
			$x_display       = $x_array[0] . ( (int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '' );
			$x_display      .= $x_parts[ $x_count_parts - 1 ];

			return $x_display;
		}

		return $num;
	}

	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}
