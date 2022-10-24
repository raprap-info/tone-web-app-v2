<?php

namespace QUADLAYERS\TIKTOK\Frontend\Video;

// use QUADLAYERS\TIKTOK\Api\Tiktok\User\Load as Api_Tiktok_User;
use QUADLAYERS\TIKTOK\Api\Tiktok\Base as Base;
use QUADLAYERS\TIKTOK\Utils\Cache as Cache;



class Stream extends Base {

	protected static $instance;

	public $tiktok_api_url = 'https://www.tiktok.com/node';
	protected $buffer_size = 256 * 1024;

	protected $headers = array();

	protected $headers_sent = false;
	protected $tt_webid_v2  = null;

	protected $cache_engine;
	protected $stream_cache_prefix = 'stream_url';

	public function __construct() {

		$this->cache_engine = new Cache( 1, true, $this->stream_cache_prefix );

		add_action( "wp_ajax_{$this->ajax_stream}", array( $this, 'video_stream' ) );
		add_action( "wp_ajax_nopriv_{$this->ajax_stream}", array( $this, 'video_stream' ) );

		parent::__construct();
	}

	public function video_stream() {

		if (
			! isset( $_GET['user_name'] ) ||
			! isset( $_GET['video_id'] )
		) {
			wp_die( 'Cheating?' );
		}
		$user_name    = sanitize_key( $_GET['user_name'] );
		$video_id     = sanitize_key( $_GET['video_id'] );
		$protocols    = array( 'http://', 'http://www.', 'www.', 'https://', 'https://www.' );
		$home_url     = str_replace( $protocols, '', home_url() );
		$http_referer = wp_get_referer();

		if ( strpos( $http_referer, $home_url ) === false ) {
			wp_die( 'Cheating?' );
		}

		// Build url if video comes from a username feed
		if ( empty( $_GET['url'] ) ) {
			$share_url = $_GET['share_url'];
			$share_url = base64_decode($share_url);

			$url = $this->get_video_by_user( $share_url, $video_id );

			$this->stream( $url );
			return;
		}
		// Clean url if video comes from hashtag or trending feed
		$url_decoded = base64_decode( $_GET['url'] );

		$url_esc_raw = esc_url_raw( $url_decoded );

		$this->stream( $url_esc_raw );

	}

	public function get_video_by_user( $share_url, $video_id ) {

		$search_key = $video_id;
		$cache      = $this->cache_engine->get( $search_key );
		error_log('cache: ' . json_encode($cache, JSON_PRETTY_PRINT));
		error_log('search_key78: ' . json_encode($search_key, JSON_PRETTY_PRINT));

		// Entra si no existe la search_key del la url, en base al usuario y id del video
		if ( ! isset( $cache['response'][ $search_key ] ) ) {

			$url = $this->get_video_link( $share_url );
			$url = base64_decode( $url );

			$cache['response'][ $search_key ] = $url;		

			$this->cache_engine->update( $search_key, $cache['response'] );
		}

		return $cache['response'][ $search_key ];
	}

	protected function string_between( $string, $start, $end ) {
		$string = ' ' . $string;
		$ini    = strpos( $string, $start );
		if ( 0 === $ini ) {
			return '';
		}

		$ini += strlen( $start );
		$len  = strpos( $string, $end, $ini ) - $ini;
		return substr( $string, $ini, $len );
	}

	public function get_video_link( $url ){
		error_log('url: ' . json_encode($url, JSON_PRETTY_PRINT));
		$response = $this->remote_get($url, false, true);

		$video_url = $this->string_between( $response, 'playAddr":"https:', '","downloadAddr' );
		$video_url = str_replace( 'u002F', '', $video_url);
		$video_url = str_replace('\\', '/', $video_url);
		$video_url = str_replace('//', 'https://', $video_url);

		return base64_encode($video_url);
	}

	/* public function get_video_by_user( $user_name = '', $video_id = '' ) {

		$search_key = $video_id;
		$cache      = $this->cache_engine->get( $search_key );

		// Entra si no existe la search_key del la url, en base al usuario y id del video
		if ( ! isset( $cache['response'][ $search_key ] ) ) {
			$url   = "{$this->tiktok_api_url}/share/video/@{$user_name}/{$video_id}";
			$query = wp_remote_get( $url );
			$data  = json_decode( $query['body'] );

			$cache['response'][ $search_key ] = $data->itemInfo->itemStruct->video->playAddr;

			preg_match( '/(?<=\=).*?(?=&)/', $data->itemInfo->itemStruct->video->dynamicCover, $expiration );

			$expiration_time = intval( $expiration[0] );
			$current_time    = strtotime( current_time( 'mysql' ) );

			$expiration_lapse_time = $expiration_time - $current_time;

			$this->cache_engine->update( $search_key, $cache['response'], $expiration_lapse_time );
		}

		return $cache['response'][ $search_key ];
	} */

	public function body_callback( $ch, $data ) {
		if ( true ) {
			echo $data;
			flush();
		}

		return strlen( $data );
	}

	public function header_callback( $ch, $data ) {
		if ( preg_match( '/HTTP\/[\d.]+\s*(\d+)/', $data, $matches ) ) {
			$status_code = $matches[1];

			if ( 200 == $status_code || 206 == $status_code || 403 == $status_code || 404 == $status_code ) {
				$this->headers_sent = true;
				$this->send_header( rtrim( $data ) );
			}
		} else {

			$forward = array( 'content-type', 'content-length', 'accept-ranges', 'content-range' );

			$parts = explode( ':', $data, 2 );

			if ( $this->headers_sent && count( $parts ) == 2 && in_array( trim( strtolower( $parts[0] ) ), $forward ) ) {
				$this->send_header( rtrim( $data ) );
			}
		}

		return strlen( $data );
	}

	public function stream( $url ) {
		$ch = curl_init();

		$headers = array();

		if ( isset( $_SERVER['HTTP_RANGE'] ) ) {
			$headers[] = 'Range: ' . $_SERVER['HTTP_RANGE'];
		}

		curl_setopt( $ch, CURLOPT_FORBID_REUSE, 1 );
		curl_setopt( $ch, CURLOPT_FRESH_CONNECT, 1 );

		curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );

		curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );

		curl_setopt( $ch, CURLOPT_BUFFERSIZE, $this->buffer_size );
		curl_setopt( $ch, CURLOPT_URL, $url );

		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1 );

		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 0 );
		curl_setopt( $ch, CURLOPT_HEADER, 0 );
		curl_setopt( $ch, CURLOPT_USERAGENT, $this->config['user-agent'] );
		curl_setopt( $ch, CURLOPT_REFERER, 'https://www.tiktok.com/' );
		curl_setopt( $ch, CURLOPT_COOKIEFILE, $this->config['cookie_file'] );
		curl_setopt( $ch, CURLOPT_COOKIEJAR, $this->config['cookie_file'] );
		curl_setopt( $ch, CURLOPT_HEADERFUNCTION, array( $this, 'header_callback' ) );

		curl_setopt( $ch, CURLOPT_WRITEFUNCTION, array( $this, 'body_callback' ) );

		$ret = curl_exec( $ch );

		$info = curl_getinfo( $ch );
		curl_close( $ch );

		return $info['http_code'] <= 206 && $info['http_code'] >= 200;
	}

	protected function send_header( $header ) {
		header( $header );
	}

	function remote_get( $url = '', $cache_enabled = true, $is_html = false ) {
		$cache = null;
		if ( $cache_enabled ) {
			$cache = $this->cache_engine->get( $url );
		}

		if ( ! isset( $cache['response'] ) ) {
			$ch      = curl_init();
			$options = array(
				CURLOPT_URL            => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_HEADER         => false,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_USERAGENT      => $this->config['user-agent'],
				CURLOPT_ENCODING       => 'utf-8',
				CURLOPT_AUTOREFERER    => true,
				CURLOPT_CONNECTTIMEOUT => 30,
				CURLOPT_SSL_VERIFYHOST => false,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_TIMEOUT        => 30,
				CURLOPT_MAXREDIRS      => 10,
				CURLOPT_HTTPHEADER     => array(
					'Referer: https://www.tiktok.com/foryou?lang=en',
				),
				CURLOPT_COOKIEJAR      => $this->config['cookie_file'],
			);

			if ( file_exists( $this->config['cookie_file'] ) ) {
				curl_setopt( $ch, CURLOPT_COOKIEFILE, $this->config['cookie_file'] );
			}

			curl_setopt_array( $ch, $options );

			if ( defined( 'CURLOPT_IPRESOLVE' ) && defined( 'CURL_IPRESOLVE_V4' ) ) {
				curl_setopt( $ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
			}

			if ( $this->config['proxy-host'] && $this->config['proxy-port'] ) {
				curl_setopt( $ch, CURLOPT_PROXY, $this->config['proxy-host'] . ':' . $this->config['proxy-port'] );
				if ( $this->config['proxy-username'] && $this->config['proxy-password'] ) {
					curl_setopt( $ch, CURLOPT_PROXYUSERPWD, $this->config['proxy-username'] . ':' . $this->config['proxy-password'] );
				}
			}

			$response = curl_exec( $ch );
			curl_close( $ch );

			if ( $cache_enabled ) {
				$this->cache_engine->update( $url, $response );
			}
			$cache = array( 'response' => $response );
		}

		if ( $is_html ) {
			return $response;
		}
		return json_decode( $cache['response'] );
	}
	
	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}
