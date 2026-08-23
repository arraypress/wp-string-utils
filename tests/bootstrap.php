<?php
/**
 * PHPUnit bootstrap.
 *
 * @package ArrayPress\StringUtils
 */

declare( strict_types=1 );

require_once dirname( __DIR__ ) . '/vendor/autoload.php';

if ( ! function_exists( 'sanitize_key' ) ) {
	function sanitize_key( $key ) {
		return strtolower( preg_replace( '/[^a-z0-9_\-]/i', '', (string) $key ) );
	}
}

if ( ! function_exists( 'sanitize_title' ) ) {
	function sanitize_title( $title ) {
		$title = strtolower( trim( (string) $title ) );
		$title = preg_replace( '/[^a-z0-9\s-]/', '', $title );

		return trim( preg_replace( '/[\s-]+/', '-', $title ), '-' );
	}
}

if ( ! function_exists( 'wp_strip_all_tags' ) ) {
	function wp_strip_all_tags( $string, $remove_breaks = false ) {
		$string = preg_replace( '@<(script|style)[^>]*?>.*?</\\1>@si', '', (string) $string );

		return trim( strip_tags( $string ) );
	}
}

if ( ! function_exists( 'remove_accents' ) ) {
	function remove_accents( $string ) {
		return $string;
	}
}
