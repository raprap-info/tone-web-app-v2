<?php

namespace QUADLAYERS\TIKTOK\Backend\Controller;

abstract class Base {

	protected $error;

	public function __construct() {
		$this->error = new \WP_Error();
	}

	function get_errors() {
		$error_codes = $this->error->get_error_codes();
			return array(
				'success' => false,
				// 'code'    => $error_codes[0],
				'message' => $this->error->get_error_message( $error_codes[0] ),
				'data'    => $this->error->get_error_data( $error_codes[0] ),
			);
	}

	function error_ajax( $data ) {
		return wp_send_json_error( $data );
	}

	function success_ajax( $data ) {
		return wp_send_json_success( $data );
	}

	function error_reload_page() {
		return wp_send_json_error( esc_html__( 'Please, reload page', 'wp-tiktok-feed' ) );
	}

	function error_access_denied() {
		return wp_send_json_error( esc_html__( 'Access denied', 'wp-tiktok-feed' ) );
	}
}
