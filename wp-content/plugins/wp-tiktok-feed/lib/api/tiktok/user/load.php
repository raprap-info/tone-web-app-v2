<?php

namespace QUADLAYERS\TIKTOK\Api\Tiktok\User;

use QUADLAYERS\TIKTOK\Api\Tiktok\Base as Base;
use QUADLAYERS\TIKTOK\Models\Account\Load as Models_Account;
use QUADLAYERS\TIKTOK\Models\Setting\Load as Models_Settings;
use QUADLAYERS\TIKTOK\Utils\Cache as Cache;

/**
 * Class Api_User extends Api
 */
class Load extends Base {

	/**
	 * User open_id given by tiktok
	 *
	 * @var string
	 */
	protected $open_id = '';
	/**
	 * User access_token given by tiktok
	 *
	 * @var string
	 */
	protected $access_token = '';

	/**
	 * User profile API
	 *
	 * @var string
	 */
	public $tiktok_user_info_endpoint = 'https://tiktokfeed.quadlayers.com/data/userProfile';

	/**
	 * User video list API
	 *
	 * @var string
	 */
	public $tiktok_video_list_endpoint = 'https://tiktokfeed.quadlayers.com/data/userVideoList';

	/**
	 * Cache prefix
	 *
	 * @var string
	 */
	public $profile_cache_key = 'user_profile_';
	public $feed_cache_key    = 'user_feed_';
	public $profile_cache_engine;
	public $feed_cache_engine;
	public $limit = 0;

	/**
	 * Class constructor
	 *
	 * @param string $open_id *open_id given by TikTok API*.
	 */
	public function __construct( $open_id = null, $limit = null ) {

		$profile_complete_prefix = '';
		$feed_complete_prefix    = '';

		$this->limit = $limit;

		// get_cache_key();
		if ( null !== $open_id ) {
			$profile_complete_prefix = $this->profile_cache_key . $open_id;
			$feed_complete_prefix    = $this->feed_cache_key . $open_id;
		}
		// $this->build_url()

		// $cache_engine = new Cache( 1, false );
		$this->profile_cache_engine = new Cache( 1, true, $profile_complete_prefix );
		$this->feed_cache_engine    = new Cache( 1, true, $feed_complete_prefix );
		parent::__construct();

		if ( null !== $open_id ) {
			$this->open_id = $open_id;

			$account_model = new Models_Account();

			$account = $account_model->get_account( $open_id );

			if ( empty( $account['access_token'] ) ) {
				if ( current_user_can( 'manage_options' ) ) {
					$this->set_message( sprintf( __( 'Access token required. Please go to <a href="%s" target="_blank">Accounts</a> and create your access token.' ), admin_url( 'admin.php?page=qlttf_account' ) ) );
				} else {
					$this->set_message( __( 'Access token required. We\'re unable to load feed videos. Please contact site admin.' ) );
				}
				return;
			}

			if ( ( Models_Account::access_token_renew_attemps_exceded( $account ) ) ) {
				if ( current_user_can( 'manage_options' ) ) {
					$this->set_message( sprintf( __( 'Access token autorenew fail. Please go to <a href="%s" target="_blank">Accounts</a> and update your access token manually.' ), admin_url( 'admin.php?page=qlttf_account' ) ) );
				} else {
					$this->set_message( __( 'Access token autorenew fail. We\'re unable to load feed videos. Please contact site admin.' ) );
				}
				return;
			}

			if ( ! empty( $account['access_token'] ) ) {
				$this->access_token = $account['access_token'];
			}
		}
	}

	/**
	 * Function: POST to TikTok endpoint to get user.info.basic
	 * https://developers.tiktok.com/doc/login-kit-user-info-basic/
	 *
	 * @return $response
	 */
	protected function get_profile_response() {

		$args = array(
			'open_id'      => $this->open_id,
			'access_token' => $this->access_token,
			'fields'       => array( 'open_id', 'union_id', 'avatar_url', 'avatar_url_100', 'avatar_url_200', 'avatar_large_url', 'display_name' ),
		);

		$cache_key = $this->build_url( $this->tiktok_user_info_endpoint, $args );

		$response = $this->profile_cache_engine->get( $cache_key );

		if ( ! isset( $response['response'] ) ) {

			$response = $this->remote_post( $this->tiktok_user_info_endpoint, $args );

			if ( ! isset( $response['data']['user'] ) ) {
				return;
			}

			$this->profile_cache_engine->update( $cache_key, $response );

			$response = array( 'response' => $response );
		}

		return $response['response'];
	}

	/**
	 * Function: POST to TikTok endpoint to get video.list
	 * https://developers.tiktok.com/doc/login-kit-video-list/
	 *
	 * @param int $cursor *Cursor for pagination*.
	 * @param int $max_count *The maximum number of videos that will be returned from each page. Default is 10. Maximum is 20*.
	 * @return $response
	 */
	protected function get_feed_response( $cursor = null ) {
		$args = array(
			'open_id'      => $this->open_id,
			'access_token' => $this->access_token,
			'cursor'       => $cursor,
			'max_count'    => $this->limit,
			'fields'       => array(
				'create_time',
				'cover_image_url',
				'share_url',
				'video_description',
				'duration',
				'height',
				'width',
				'id',
				'title',
				'embed_html',
				'embed_link',
				'like_count',
				'comment_count',
				'share_count',
				'view_count',
			),
		);

		$cache_key = $this->build_url( $this->tiktok_video_list_endpoint, $args );

		$response = $this->feed_cache_engine->get( $cache_key );

		if ( ! isset( $response['response'] ) || 0 !== $cursor ) {

			$response = $this->remote_post( $this->tiktok_video_list_endpoint, $args );

			if ( ! empty( $response['message'] ) && ! empty( $response['error'] ) ) {
				return $response['message'];
			}

			$this->feed_cache_engine->update( $cache_key, $response );

			$response = array( 'response' => $response );
		}

		return $response['response'];
	}

	/**
	 * Function: returns profile_data parsed to data structure required by plugin
	 *
	 * @return wp_parse_args($defaults, $profile_data)
	 */
	public function get_profile_data() {

		$defaults = array(
			'open_id'         => $this->open_id,
			'display_name'    => '',
			'website'         => '',
			'biography'       => '',
			'name'            => '',
			'followers_count' => 0,
			'media_count'     => 0,
			'avatar_url'      => 'http://2.gravatar.com/avatar/b642b4217b34b1e8d3bd915fc65c4452?s=320&d=mm&r=g',
			'link'            => '',
			/**
			 * Compatibility with wp-tiktok-feed-pro 1.0.4
			 */
			'profile_pic_url' => 'http://2.gravatar.com/avatar/b642b4217b34b1e8d3bd915fc65c4452?s=320&d=mm&r=g',
			'username'        => '',
			'full_name'       => '',
		);

		if ( ! $this->access_token ) {
			return $defaults;
		}

		$_profile_info = $this->get_profile_response();

		if ( ! empty( $_profile_info['error'] ) && 0 !== $_profile_info['error']['code'] ) {
			if ( ! empty( $_profile_info['message'] ) ) {
				$this->set_message( sprintf( 'Error code: %s,  %s', $_profile_info['error'], $_profile_info['message'] ) );
				return $this->get_messages();
			}
			$this->set_message( sprintf( 'Error: %s', 'Unknown error.' ) );
			return $this->get_messages();
		}

		if ( null === $_profile_info ) {
			return $defaults;
		}

		$profile_info = wp_parse_args( $_profile_info['data']['user'], $defaults );

		$author_infos = $_profile_info['data']['user'];

		return wp_parse_args(
			array_filter(
				array(
					'id'                 => $author_infos['open_id'],
					'full_name'          => $author_infos['display_name'],
					'username'           => $author_infos['display_name'],
					'profile_pic_url'    => $author_infos['avatar_url'],
					'profile_pic_url_hd' => $author_infos['avatar_large_url'],
					'link'               => QLTTF_TIKTOK_URL . "/@{$_profile_info['data']['user']['display_name']}",
					// 'verified'           => $author_infos->verified,
					// 'tagline'            => $author_infos->signature,
					// 'following_count'    => $author_stats->followingCount,
					// 'fans_count'         => $author_stats->followerCount,
					// 'heart_count'        => $author_stats->heartCount,
					// 'video_count'        => $author_stats->videoCount,
				)
			),
			$profile_info
		);
	}

	/**
	 * Function: returns users_feeds parsed to data structure required by plugin
	 *
	 * @param int $last_id *Last id to use as a pointer*.
	 * @return $feeds
	 */
	public function get_feed_data( $last_id = null ) {

		if ( ! $this->access_token ) {
			return $this->get_messages();
		}
		$response = $this->get_feed_response( intval( $last_id ), $this->limit );

		if ( ! empty( $response['error'] ) && 0 !== $response['error']['code'] ) {
			if ( ! empty( $response['message'] ) ) {
				$this->set_message( sprintf( 'Error code: %s,  %s', $response['error'], $response['message'] ) );
				return $this->get_messages();
			}
			$this->set_message( sprintf( 'Error: %s', 'Unknown error.' ) );
			return $this->get_messages();
		}

		if ( ! isset( $response['data']['videos'] ) ) {
			if ( is_string( $response ) ) {
				$this->set_message( esc_html( $response ) );
			} else {
				$this->set_message( esc_html__( 'Unknown error.', 'wp-tiktok-feed' ) );
			}
			return $this->get_messages();
		}

		$author_data = $this->get_profile_response();

		$feeds = $this->setup_media_items( $response['data']['videos'], 0, $author_data, $response['data']['has_more'] );

		return $feeds;
	}

	public function delete_feed_cache() {
		$this->feed_cache_engine->delete();
	}

	public function delete_profile_cache( $url ) {
		$this->profile_cache_engine->delete_key( $url );
	}

	public function get_feed_url() {
		return $this->feed_cache_key;
	}

	public function get_profile_url() {
		return $this->profile_cache_key;
	}


}
