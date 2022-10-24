<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function qlttf_thousands_roud( $num ) {
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


if ( ! class_exists( 'QLTTF_Frontend' ) ) {

	class QLTTF_Frontend {

		static function template_path( $template_name, $template_file = false ) {

			if ( file_exists( QLTTF_PLUGIN_DIR . "templates/{$template_name}" ) ) {
				$template_file = QLTTF_PLUGIN_DIR . "templates/{$template_name}";
			}

			if ( file_exists( trailingslashit( get_stylesheet_directory() ) . "tiktok-feed/{$template_name}" ) ) {
				$template_file = trailingslashit( get_stylesheet_directory() ) . "tiktok-feed/{$template_name}";
			}

			return apply_filters( 'qlttf_template_file', $template_file, $template_name );
		}
	}
}
