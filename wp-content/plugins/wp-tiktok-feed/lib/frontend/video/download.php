<?php

namespace QUADLAYERS\TIKTOK\Frontend\Video;

use QUADLAYERS\TIKTOK\Api\Tiktok\User\Load as Api_Tiktok_User;
use QUADLAYERS\TIKTOK\Utils\Cache as Cache;

class Download {

	// TODO: eliminar archivo pasar metodos a premium /lib/frontend/load.php
	protected static $instance;
	protected $ajax_download = 'qlttf-download';

	public function __construct() {
		add_action( "wp_ajax_{$this->ajax_download}", array( $this, 'video_download' ) );
		add_action( "wp_ajax_nopriv_{$this->ajax_download}", array( $this, 'video_download' ) );
		// parent::__construct();
	}

	public function video_download() {
		if (
			! isset( $_GET['url'] ) ||
			! isset( $_GET['video_id'] )
		) {
			wp_die( 'Cheating?' );
		}

		if ( ! class_exists( 'QLTTF_Download' ) ) {
			wp_die( 'Cheating?' );
		}

		$downloader = new \QLTTF_Download();

		$video_id = sanitize_key( $_GET['video_id'] );
		$url      = sanitize_text_field( $_GET['url'] );

		if ( strpos( wp_get_referer(), home_url() ) !== false ) {
			$downloader->force_download( $url, $video_id );
		}
	}

	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}
