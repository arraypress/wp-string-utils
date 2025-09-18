<?php
/**
 * String Utility Class
 *
 * Essential string manipulation utilities for WordPress development.
 * Focuses on commonly needed operations that WordPress doesn't provide.
 *
 * @package ArrayPress\StringUtils
 * @since   1.0.0
 * @author  ArrayPress
 * @license GPL-2.0-or-later
 */

declare( strict_types=1 );

namespace ArrayPress\StringUtils;

/**
 * Str Class
 *
 * Core operations for string manipulation and validation.
 */
class Str {

	/** String Checking *******************************************************/

	/**
	 * Check if a string contains any of the given needles.
	 *
	 * @param string $haystack   The string to search in.
	 * @param string ...$needles The strings to search for.
	 *
	 * @return bool True if any needle is found.
	 */
	public static function contains_any( string $haystack, string ...$needles ): bool {
		foreach ( $needles as $needle ) {
			if ( str_contains( $haystack, $needle ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Check if a string contains all the given needles.
	 *
	 * @param string $haystack   The string to search in.
	 * @param string ...$needles The strings to search for.
	 *
	 * @return bool True if all needles are found.
	 */
	public static function contains_all( string $haystack, string ...$needles ): bool {
		foreach ( $needles as $needle ) {
			if ( ! str_contains( $haystack, $needle ) ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Check if a string starts with any of the given needles.
	 *
	 * @param string       $haystack The string to search in.
	 * @param string|array $needles  The substring(s) to search for.
	 *
	 * @return bool True if starts with any needle.
	 */
	public static function starts_with( string $haystack, $needles ): bool {
		if ( is_string( $needles ) ) {
			return str_starts_with( $haystack, $needles );
		}

		if ( is_array( $needles ) ) {
			foreach ( $needles as $needle ) {
				if ( str_starts_with( $haystack, $needle ) ) {
					return true;
				}
			}
		}

		return false;
	}

	/**
	 * Check if a string ends with any of the given needles.
	 *
	 * @param string       $haystack The string to search in.
	 * @param string|array $needles  The substring(s) to search for.
	 *
	 * @return bool True if ends with any needle.
	 */
	public static function ends_with( string $haystack, $needles ): bool {
		if ( is_string( $needles ) ) {
			return str_ends_with( $haystack, $needles );
		}

		if ( is_array( $needles ) ) {
			foreach ( $needles as $needle ) {
				if ( str_ends_with( $haystack, $needle ) ) {
					return true;
				}
			}
		}

		return false;
	}

	/**
	 * Check if a string matches any pattern in an array.
	 *
	 * @param string $string   The string to check.
	 * @param array  $patterns Array of patterns to match against.
	 * @param bool   $wildcard Whether to support wildcard (*) matching.
	 *
	 * @return bool True if a match is found.
	 */
	public static function matches_any( string $string, array $patterns, bool $wildcard = false ): bool {
		if ( empty( $string ) || empty( $patterns ) ) {
			return false;
		}

		$string = strtolower( trim( $string ) );

		foreach ( $patterns as $pattern ) {
			$pattern = strtolower( trim( $pattern ) );

			if ( $wildcard && str_ends_with( $pattern, '*' ) ) {
				$pattern = rtrim( $pattern, '*' );
				if ( str_starts_with( $string, $pattern ) ) {
					return true;
				}
			} elseif ( $string === $pattern ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Check if a string is valid JSON.
	 *
	 * @param string $string The string to check.
	 *
	 * @return bool True if valid JSON.
	 */
	public static function is_json( string $string ): bool {
		json_decode( $string );

		return json_last_error() === JSON_ERROR_NONE;
	}

	/**
	 * Check if a string contains only alphanumeric characters.
	 *
	 * @param string $string The string to validate.
	 *
	 * @return bool True if the string is alphanumeric.
	 */
	public static function is_alphanumeric( string $string ): bool {
		return ctype_alnum( $string );
	}

	/**
	 * Check if a string is numeric.
	 *
	 * @param string $string The string to check.
	 *
	 * @return bool True if the string is numeric.
	 */
	public static function is_numeric( string $string ): bool {
		return is_numeric( $string );
	}

	/**
	 * Check if a string is an integer.
	 *
	 * @param string $string The string to check.
	 *
	 * @return bool True if the string is an integer.
	 */
	public static function is_integer( string $string ): bool {
		return filter_var( $string, FILTER_VALIDATE_INT ) !== false;
	}

	/**
	 * Check if a string is a float.
	 *
	 * @param string $string The string to check.
	 *
	 * @return bool True if the string is a float.
	 */
	public static function is_float( string $string ): bool {
		return filter_var( $string, FILTER_VALIDATE_FLOAT ) !== false;
	}

	/**
	 * Check if a string is a valid email address.
	 *
	 * @param string $string The string to check.
	 *
	 * @return bool True if the string is a valid email.
	 */
	public static function is_email( string $string ): bool {
		return is_email( $string );
	}

	/**
	 * Check if a string is a valid URL.
	 *
	 * @param string $string The string to check.
	 *
	 * @return bool True if the string is a valid URL.
	 */
	public static function is_url( string $string ): bool {
		return filter_var( $string, FILTER_VALIDATE_URL ) !== false;
	}

	/**
	 * Check if a string is a valid date.
	 *
	 * @param string $string The string to check.
	 *
	 * @return bool True if the string is a valid date.
	 */
	public static function is_date( string $string ): bool {
		return strtotime( $string ) !== false;
	}

	/**
	 * Check if a string is a valid IP address.
	 *
	 * @param string $string The string to check.
	 *
	 * @return bool True if the string is a valid IP.
	 */
	public static function is_ip( string $string ): bool {
		return filter_var( $string, FILTER_VALIDATE_IP ) !== false;
	}

	/**
	 * Check if a string contains only alphabetic characters.
	 *
	 * @param string $string The string to check.
	 *
	 * @return bool True if the string is alphabetic.
	 */
	public static function is_alpha( string $string ): bool {
		return ctype_alpha( $string );
	}

	/**
	 * Check if a string is uppercase.
	 *
	 * @param string $string The string to check.
	 *
	 * @return bool True if the string is uppercase.
	 */
	public static function is_upper( string $string ): bool {
		return $string === strtoupper( $string ) && ctype_alpha( $string );
	}

	/**
	 * Check if a string is lowercase.
	 *
	 * @param string $string The string to check.
	 *
	 * @return bool True if the string is lowercase.
	 */
	public static function is_lower( string $string ): bool {
		return $string === strtolower( $string ) && ctype_alpha( $string );
	}

	/**
	 * Check if a string is empty or only whitespace.
	 *
	 * @param string $string The string to check.
	 *
	 * @return bool True if the string is blank.
	 */
	public static function is_blank( string $string ): bool {
		return trim( $string ) === '';
	}

	/**
	 * Check if a string contains only hexadecimal characters.
	 *
	 * @param string $string The string to check.
	 *
	 * @return bool True if the string is hexadecimal.
	 */
	public static function is_hex( string $string ): bool {
		return ctype_xdigit( $string );
	}

	/**
	 * Check if a string's length is within a specified range.
	 *
	 * @param string $string     The string to check.
	 * @param int    $min_length The minimum allowed length.
	 * @param int    $max_length The maximum allowed length.
	 *
	 * @return bool True if the string length is within range.
	 */
	public static function is_length_valid( string $string, int $min_length = 1, int $max_length = PHP_INT_MAX ): bool {
		$length = mb_strlen( $string );

		return ( $length >= $min_length && $length <= $max_length );
	}

	/** String Manipulation ***************************************************/

	/**
	 * Replace the first occurrence of a string.
	 *
	 * @param string $search  The string to search for.
	 * @param string $replace The replacement string.
	 * @param string $subject The string to search in.
	 *
	 * @return string The modified string.
	 */
	public static function replace_first( string $search, string $replace, string $subject ): string {
		if ( empty( $search ) || empty( $subject ) ) {
			return $subject;
		}

		$position = strpos( $subject, $search );
		if ( $position !== false ) {
			return substr_replace( $subject, $replace, $position, strlen( $search ) );
		}

		return $subject;
	}

	/**
	 * Replace the last occurrence of a string.
	 *
	 * @param string $search  The string to search for.
	 * @param string $replace The replacement string.
	 * @param string $subject The string to search in.
	 *
	 * @return string The modified string.
	 */
	public static function replace_last( string $search, string $replace, string $subject ): string {
		if ( empty( $search ) || empty( $subject ) ) {
			return $subject;
		}

		$position = strrpos( $subject, $search );
		if ( $position !== false ) {
			return substr_replace( $subject, $replace, $position, strlen( $search ) );
		}

		return $subject;
	}

	/**
	 * Extract content between two strings.
	 *
	 * @param string $start   The start delimiter.
	 * @param string $end     The end delimiter.
	 * @param string $subject The string to search in.
	 *
	 * @return string The content between delimiters or empty string.
	 */
	public static function between( string $start, string $end, string $subject ): string {
		$start_pos = strpos( $subject, $start );
		if ( $start_pos === false ) {
			return '';
		}

		$start_pos += strlen( $start );
		$end_pos   = strpos( $subject, $end, $start_pos );

		if ( $end_pos === false ) {
			return '';
		}

		return substr( $subject, $start_pos, $end_pos - $start_pos );
	}

	/**
	 * Truncate a string to a specified length with optional suffix.
	 *
	 * @param string $string The string to truncate.
	 * @param int    $length The maximum length.
	 * @param string $suffix The suffix to append if truncated.
	 *
	 * @return string The truncated string.
	 */
	public static function truncate( string $string, int $length, string $suffix = '...' ): string {
		if ( mb_strlen( $string ) <= $length ) {
			return $string;
		}

		return mb_substr( $string, 0, $length - mb_strlen( $suffix ) ) . $suffix;
	}

	/**
	 * Limit the number of words in a string.
	 *
	 * @param string $string     The input string.
	 * @param int    $word_limit The number of words to limit to.
	 * @param string $suffix     The suffix to append if truncated.
	 *
	 * @return string The word-limited string.
	 */
	public static function words( string $string, int $word_limit, string $suffix = '...' ): string {
		$words = explode( ' ', $string );
		if ( count( $words ) <= $word_limit ) {
			return $string;
		}

		return implode( ' ', array_slice( $words, 0, $word_limit ) ) . $suffix;
	}

	/**
	 * Reduce multiple whitespace characters to a single space.
	 *
	 * @param string $string The input string.
	 *
	 * @return string The cleaned string.
	 */
	public static function reduce_whitespace( string $string ): string {
		return preg_replace( '/\s+/', ' ', trim( $string ) );
	}

	/**
	 * Remove all whitespace from a string.
	 *
	 * @param string $string The input string.
	 *
	 * @return string The string with all whitespace removed.
	 */
	public static function remove_whitespace( string $string ): string {
		return preg_replace( '/\s+/', '', $string );
	}

	/**
	 * Remove line breaks from a string.
	 *
	 * @param string $string The input string.
	 *
	 * @return string The string with line breaks removed.
	 */
	public static function remove_line_breaks( string $string ): string {
		return str_replace( [ "\r", "\n", PHP_EOL ], '', trim( $string ) );
	}

	/** Case Conversion *******************************************************/

	/**
	 * Convert a string to camelCase.
	 *
	 * @param string $string The string to convert.
	 *
	 * @return string The camelCase string.
	 */
	public static function camel( string $string ): string {
		$string = str_replace( [ '-', '_' ], ' ', $string );
		$string = ucwords( $string );
		$string = str_replace( ' ', '', $string );

		return lcfirst( $string );
	}

	/**
	 * Convert a string to snake_case.
	 *
	 * @param string $string The string to convert.
	 *
	 * @return string The snake_case string.
	 */
	public static function snake( string $string ): string {
		return sanitize_key( str_replace( ' ', '_', $string ) );
	}

	/**
	 * Convert a string to kebab-case.
	 *
	 * @param string $string The string to convert.
	 *
	 * @return string The kebab-case string.
	 */
	public static function kebab( string $string ): string {
		return sanitize_title( $string );
	}

	/**
	 * Convert a string to Title Case.
	 *
	 * @param string $string The string to convert.
	 *
	 * @return string The Title Case string.
	 */
	public static function title( string $string ): string {
		return ucwords( strtolower( $string ) );
	}

	/**
	 * Convert to uppercase.
	 *
	 * @param mixed $value The value to convert.
	 *
	 * @return string The uppercase string.
	 */
	public static function upper( $value ): string {
		return strtoupper( self::from( $value ) );
	}

	/**
	 * Convert to lowercase.
	 *
	 * @param mixed $value The value to convert.
	 *
	 * @return string The lowercase string.
	 */
	public static function lower( $value ): string {
		return strtolower( self::from( $value ) );
	}

	/**
	 * Convert to sentence case (first letter uppercase).
	 *
	 * @param mixed $value The value to convert.
	 *
	 * @return string The sentence case string.
	 */
	public static function sentence( $value ): string {
		return ucfirst( strtolower( self::from( $value ) ) );
	}

	/** Content Processing ****************************************************/

	/**
	 * Create a safe excerpt from content.
	 *
	 * @param string $content    The content to excerpt.
	 * @param int    $length     Maximum length in characters.
	 * @param bool   $strip_tags Whether to strip HTML tags.
	 *
	 * @return string The excerpt.
	 */
	public static function excerpt( string $content, int $length = 150, bool $strip_tags = true ): string {
		if ( $strip_tags ) {
			$content = wp_strip_all_tags( $content );
		}

		return self::truncate( $content, $length );
	}

	/**
	 * Get an estimated reading time for text content.
	 *
	 * @param string $content          The content to analyze.
	 * @param int    $words_per_minute Average reading speed.
	 *
	 * @return array Array with 'minutes' and 'seconds' keys.
	 */
	public static function reading_time( string $content, int $words_per_minute = 200 ): array {
		$word_count    = str_word_count( wp_strip_all_tags( $content ) );
		$total_minutes = $word_count / $words_per_minute;

		$minutes = floor( $total_minutes );
		$seconds = round( ( $total_minutes - $minutes ) * 60 );

		return [
			'minutes' => (int) $minutes,
			'seconds' => (int) $seconds
		];
	}

	/**
	 * Count the number of words in a string.
	 *
	 * @param string $string The text to count words in.
	 *
	 * @return int The number of words.
	 */
	public static function word_count( string $string ): int {
		return str_word_count( wp_strip_all_tags( $string ) );
	}

	/** Utility Methods *******************************************************/

	/**
	 * Convert a value to string safely.
	 *
	 * @param mixed $value The value to convert.
	 *
	 * @return string The string representation.
	 */
	public static function from( $value ): string {
		if ( is_array( $value ) || is_object( $value ) ) {
			return wp_json_encode( $value ) ?: '';
		}

		return (string) $value;
	}

	/**
	 * Remove accents and convert to ASCII.
	 *
	 * @param string $string The string to convert.
	 *
	 * @return string The ASCII string.
	 */
	public static function ascii( string $string ): string {
		return remove_accents( $string );
	}

	/**
	 * Normalize a string by trimming and converting to lowercase.
	 *
	 * @param string $string The string to normalize.
	 *
	 * @return string The normalized string.
	 */
	public static function normalize( string $string ): string {
		return strtolower( trim( $string ) );
	}

	/**
	 * Convert a comma-separated string to an array.
	 *
	 * @param string $string    The comma-separated string.
	 * @param string $separator The separator to use.
	 *
	 * @return array The resulting array.
	 */
	public static function to_array( string $string, string $separator = ',' ): array {
		return array_map( 'trim', explode( $separator, $string ) );
	}

	/**
	 * Convert an array to CSV string.
	 *
	 * @param array  $array     The array to convert.
	 * @param string $separator The separator to use.
	 *
	 * @return string The CSV string.
	 */
	public static function to_csv( array $array, string $separator = ',' ): string {
		return implode( $separator, array_map( 'trim', $array ) );
	}

	/**
	 * Split string into words array.
	 *
	 * @param string $string The string to split.
	 *
	 * @return array Array of words.
	 */
	public static function to_words( string $string ): array {
		return array_filter( preg_split( '/\s+/', $string ) );
	}

	/**
	 * Split string into lines array.
	 *
	 * @param string $string The string to split.
	 *
	 * @return array Array of lines.
	 */
	public static function to_lines( string $string ): array {
		return array_filter( explode( PHP_EOL, $string ) );
	}

	/**
	 * Split string into sentences array.
	 *
	 * @param string $string The string to split.
	 *
	 * @return array Array of sentences.
	 */
	public static function to_sentences( string $string ): array {
		return array_filter( preg_split( '/[.!?]+/', $string ) );
	}

}