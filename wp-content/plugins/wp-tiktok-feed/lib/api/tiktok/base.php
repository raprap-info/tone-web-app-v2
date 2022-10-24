<?php

namespace QUADLAYERS\TIKTOK\Api\Tiktok;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class Base {

	protected static $messages       = array();
	protected $config                = array();
	protected $ajax_stream           = 'qlttf-stream';
	protected $ajax_download         = 'qlttf-download';
	public $authorized_url           = 'https://tiktokfeed.quadlayers.com/authCallback';
	public $refresh_access_token_url = 'https://tiktokfeed.quadlayers.com/refreshToken';
	protected $client_key            = 'aw91ba7ajkdontnx';
	protected static $cookie_key     = 'tiktok-api-cookie';

	protected $profile_data = array(
		'id'                 => '',
		'username'           => '',
		'full_name'          => '',
		'profile_pic_url'    => 'http://2.gravatar.com/avatar/b642b4217b34b1e8d3bd915fc65c4452?s=150&d=mm&r=g',
		'profile_pic_url_hd' => 'http://2.gravatar.com/avatar/b642b4217b34b1e8d3bd915fc65c4452?s=320&d=mm&r=g',
		'link'               => '',
		'video_count'        => 0,
	);

	protected $defaults = array(
		'user-agent'     => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.75 Safari/537.36',
		'proxy-host'     => false,
		'proxy-port'     => false,
		'proxy-username' => false,
		'proxy-password' => false,
		'cache-timeout'  => 3600, // in seconds
	);

	public function __construct() {
		$this->init_config();
		static::$messages = array();
	}

	public function init_config() {
		$this->config = array_merge(
			array(
				'cookie_file' => get_temp_dir() . 'tiktok.txt',
			),
			$this->defaults
		);
	}

	/* abstract */ protected function get_feed_response(){}

	/* abstract */ protected function get_feed_data(){}

	public function setup_media_items( $data, $last_id = null, $author_data = null, $has_more = null ) {

		static $load = false;
		static $i    = 1;

		if ( ! $last_id ) {
			$load = true;
		}

		$tiktok_items = array();
		if ( is_array( $data ) && ! empty( $data ) ) {

			foreach ( $data as $item ) {
				if ( $load ) {
					$share_url = base64_encode($item['share_url']);
					preg_match_all( '/#(\\w+)/', $item['video_description'], $hashtags );
					preg_match_all( '/(?<!\S)#([0-9a-zA-Z]+)/', $item['video_description'], $hashtags );
					
					$url_ajax       = admin_url( "admin-ajax.php?action={$this->ajax_stream}&user_name={$author_data['data']['user']['union_id']}&video_id={$item['id']}&share_url={$share_url}" );
					$url_download   = base64_encode( $url_ajax );
					$tiktok_items[] = array(
						'i'             => $i,
						'create_time'   => $has_more ? $item['create_time'] : '',
						'id'            => $item['id'],
						'covers'        => array(
							'default' => $item['cover_image_url'],
							'origin'  => $item['cover_image_url'],
							'dynamic' => $item['cover_image_url'],
							'video'   => $url_ajax,
						),
						'download'      => admin_url( "admin-ajax.php?action={$this->ajax_download}&url={$url_download}&video_id={$item['id']}" ), // admin_url("admin-ajax.php?action={$this->ajax_download}&url={$url_encode}&user_name={$item->authorInfos->uniqueId}&video_id={$item->itemInfos->id}"),
						'share_count'   => $item['share_count'],
						'comment_count' => $item['comment_count'],
						'digg_count'    => $item['like_count'],
						'play_count'    => $item['view_count'],
						'width'         => $item['width'],
						'height'        => $item['height'],
						'text'          => preg_replace( '/(?<!\S)#([0-9a-zA-Z]+)/', '<a target="_blank" href="' . QLTTF_TIKTOK_URL . '/tag/$1">#$1</a>', htmlspecialchars( $item['video_description'] ) ),
						'hashtags'      => isset( $hashtags[1] ) ? $hashtags[1] : '',
						'link'          => $item['share_url'],
						// 'date'          => date_i18n( 'j F, Y', strtotime( $item['create_time'] ) ),
						'date'          => date_i18n( 'j F, Y', $item['create_time'] ),
						'author'        => array(
							'id'        => $author_data['data']['user']['open_id'],
							'username'  => $this->get_username( $item['share_url'] ),
							'full_name' => $author_data['data']['user']['display_name'],
							// 'tagline' => $item->authorInfos->signature,
							// 'verified' => $item->authorInfos->verified,
							'image'     => array(
								'small'  => $author_data['data']['user']['avatar_url_100'],
								'medium' => $author_data['data']['user']['avatar_url'],
								'larger' => $author_data['data']['user']['avatar_large_url'],
							),
							'link'      => QLTTF_TIKTOK_URL . "/@{$this->get_username($item['share_url'])}",
						),
					);
				}
				if ( $last_id && ( $last_id == $i ) ) {
					$i    = $last_id;
					$load = true;
				}
				$i++;
			}
			return $tiktok_items;
		}
	}

	public function get_messages() {
		return self::$messages;
	}

	public function set_message( $message = '' ) {

		if ( ! is_string( $message ) ) {
			return;
		}

		array_push( static::$messages, $message );
	}

	function get_access_token_link() {

		$redirect_url = admin_url( 'admin.php?page=qlttf_account' );
		$url          = "https://tiktokfeed.quadlayers.com/auth/?redirect_url={$redirect_url}";

		return $url;
	}

	/**
	 * Function curl_post: make a curl get to the given $url
	 *
	 * @param string $url - Url.
	 * @return object - Response.
	 */

	/*
	 public function curl_get( $url ) {
		$ch = curl_init( $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

		$response = json_decode( curl_exec( $ch ), true );

		curl_close( $ch );

		return $response;
	} */

	/**
	 * Function curl_post: make a curl post to the given $url and $post arguments
	 *
	 * @param string $url - Url.
	 * @param [type] $post - Arguments to pass to culr.
	 * @return object - Response.
	 */

	/*
	public function curl_post( $url, $post ) {
		$ch = curl_init( $url );

		curl_setopt( $ch, CURLOPT_POSTFIELDS, $post );

		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

		$response = curl_exec( $ch );

		curl_close( $ch );

		return json_decode( $response );
	} */

	/**
	 * Function build_url: build url query string with url and arguments given by the user.
	 *
	 * @param string $base_url - param.
	 * @param string $args - param.
	 * @return string
	 */

	public function build_url( $base_url, $args ) {
		return add_query_arg(
			$args,
			$base_url
		);
	}

	public function remote_post( $base_url = '', $args = array() ) {

		$response = wp_remote_post(
			$base_url,
			array(
				'method'  => 'POST',
				'timeout' => 45,
				'body'    => json_encode( $args ),
			)
		);

		$response = $this->validate_response( $response );

		if ( isset( $response['message'] ) && isset( $response['error'] ) && $response['error'] > 0 ) {
			return array(
				'message' => ! empty( $response['message'] ) ? $response['message'] : esc_html__( 'Unknown error.', 'wp-tiktok-feed' ),
				'error'   => ! empty( $response['error'] ) ? $response['error'] : 0,
			);
		}

		return $response;
	}

	/**
	 * Function validate_response: check if get_profile_response is valid
	 *
	 * @param string $json *get_profile_response*.
	 * @return boolean
	 */

	public function validate_response( $json = null ) {
		if ( ! ( $response = json_decode( wp_remote_retrieve_body( $json ), true ) ) || 200 !== wp_remote_retrieve_response_code( $json ) ) {

			if ( isset( $response['data']['error_code'] ) ) {
				$message = $response['data']['description'];
				return array(
					'error'   => 1,
					'message' => $message,
				);
			}

			if ( isset( $response['message'] ) && 'error' === $response['message'] ) {
				$message = $response['data']['description'];
				return array(
					'error'   => 1,
					'message' => $message,
				);
			}

			if ( isset( $response['error'] ) ) {
				$message = $response['error']['message'];
				return array(
					'error'   => $response['error']['code'],
					'message' => $message,
				);
			}

			if ( is_wp_error( $json ) ) {
				$response = array(
					'error'   => 1,
					'message' => $json->get_error_message(),
				);
			} else {
				$response = array(
					'error'   => 1,
					'message' => esc_html__( 'Unknow error occurred, please try again', 'wp-tiktok-feed' ),
				);
			}
		}

		return $response;
	}

	private function get_username( $url ) {
		$url_components = parse_url( $url );
		$value          = explode( '/@', $url_components['path'] )[1];
		$value          = explode( '/', $value )[0];

		return $value;
	}
}
