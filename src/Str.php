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
 *
 * A note on `empty()`: it is never used on a string here. `empty( '0' )` is
 * true, so every helper that guarded with it silently did nothing for the one
 * character that is both a legitimate value and a falsy one -- a search for
 * '0' never replaced, a pattern of '0' never matched, a line of '0' vanished.
 * Emptiness is `'' === $value`.
 */
class Str {

	/** Checking ******************************************************************/

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
		foreach ( (array) $needles as $needle ) {
			if ( str_starts_with( $haystack, (string) $needle ) ) {
				return true;
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
		foreach ( (array) $needles as $needle ) {
			if ( str_ends_with( $haystack, (string) $needle ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Check if a string matches any pattern in an array.
	 *
	 * Comparison is case-insensitive and ignores surrounding whitespace. With
	 * wildcards on, a pattern ending in `*` matches any value that starts with
	 * the part before it.
	 *
	 * @param string $value    The string to check.
	 * @param array  $patterns Array of patterns to match against.
	 * @param bool   $wildcard Whether to support wildcard (*) matching.
	 *
	 * @return bool True if a match is found.
	 */
	public static function matches_any( string $value, array $patterns, bool $wildcard = false ): bool {
		$value = strtolower( trim( $value ) );

		if ( '' === $value || [] === $patterns ) {
			return false;
		}

		foreach ( $patterns as $pattern ) {
			// Patterns often come out of a settings array, where a numeric one
			// has already been cast to int. Under strict types that is a
			// TypeError in trim() rather than a non-match.
			$pattern = strtolower( trim( (string) $pattern ) );

			if ( $wildcard && str_ends_with( $pattern, '*' ) ) {
				if ( str_starts_with( $value, rtrim( $pattern, '*' ) ) ) {
					return true;
				}
			} elseif ( $value === $pattern ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Check if a string is alphanumeric.
	 *
	 * @param string $value The string to validate.
	 *
	 * @return bool True if the string is alphanumeric.
	 */
	public static function is_alphanumeric( string $value ): bool {
		return ctype_alnum( $value );
	}

	/** Manipulation **************************************************************/

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
		if ( '' === $search ) {
			return $subject;
		}

		$position = strpos( $subject, $search );

		return false === $position
			? $subject
			: substr_replace( $subject, $replace, $position, strlen( $search ) );
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
		if ( '' === $search ) {
			return $subject;
		}

		$position = strrpos( $subject, $search );

		return false === $position
			? $subject
			: substr_replace( $subject, $replace, $position, strlen( $search ) );
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
	 * The length is the maximum for the whole result, suffix included. The
	 * cut is by character, so it can land mid-word; use words() to cut at a
	 * word boundary instead.
	 *
	 * @param string $value  The string to truncate.
	 * @param int    $length The maximum length.
	 * @param string $suffix The suffix to append if truncated.
	 *
	 * @return string The truncated string.
	 */
	public static function truncate( string $value, int $length, string $suffix = '...' ): string {
		if ( mb_strlen( $value ) <= $length ) {
			return $value;
		}

		// max(0, ...) matters: a length shorter than the suffix makes this
		// negative, and mb_substr() reads a negative length as "all but the
		// last n characters" -- so asking for a shorter string returned a
		// longer one. Below the suffix width there is no room for content, so
		// the suffix alone is the honest answer.
		$room = max( 0, $length - mb_strlen( $suffix ) );

		return mb_substr( $value, 0, $room ) . $suffix;
	}

	/**
	 * Limit the number of words in a string.
	 *
	 * Words are separated by any run of whitespace. A string within the limit
	 * comes back untouched, spacing and all.
	 *
	 * @param string $value      The input string.
	 * @param int    $word_limit The number of words to limit to.
	 * @param string $suffix     The suffix to append if truncated.
	 *
	 * @return string The word-limited string.
	 */
	public static function words( string $value, int $word_limit, string $suffix = '...' ): string {
		$words = self::to_words( $value );

		if ( count( $words ) <= $word_limit ) {
			return $value;
		}

		return implode( ' ', array_slice( $words, 0, max( 0, $word_limit ) ) ) . $suffix;
	}

	/**
	 * Reduce multiple whitespace characters to a single space.
	 *
	 * @param string $value The input string.
	 *
	 * @return string The cleaned string.
	 */
	public static function reduce_whitespace( string $value ): string {
		return (string) preg_replace( '/\s+/', ' ', trim( $value ) );
	}

	/**
	 * Remove all whitespace from a string.
	 *
	 * @param string $value The input string.
	 *
	 * @return string The string with all whitespace removed.
	 */
	public static function remove_whitespace( string $value ): string {
		return (string) preg_replace( '/\s+/', '', $value );
	}

	/**
	 * Mask sensitive data in a string.
	 *
	 * Keeps a few characters at each end and masks the middle. A string too
	 * short to hide anything is masked entirely rather than shown in full.
	 *
	 * @param string $value   The string to mask.
	 * @param int    $visible Number of characters to show at start and at end.
	 * @param string $mask    The masking character.
	 *
	 * @return string The masked string.
	 */
	public static function mask( string $value, int $visible = 4, string $mask = '*' ): string {
		// Counted in characters, not bytes: masking by strlen() cut a
		// multibyte character in half and returned broken UTF-8 in place of
		// the one thing this function exists to keep readable.
		$visible = max( 0, $visible );
		$length  = mb_strlen( $value );

		if ( $length <= $visible * 2 ) {
			return str_repeat( $mask, $length );
		}

		// The tail is taken from an offset counted from the start, because a
		// negative offset of nought is nought: substr( $value, -0 ) is the
		// whole string, so a visible count of 0 showed everything after the
		// mask instead of nothing.
		return mb_substr( $value, 0, $visible ) .
				str_repeat( $mask, $length - ( $visible * 2 ) ) .
				mb_substr( $value, $length - $visible );
	}

	/** Case Conversion ***********************************************************/

	/**
	 * Convert a string to camelCase.
	 *
	 * @param string $value The string to convert.
	 *
	 * @return string The camelCase string.
	 */
	public static function camel( string $value ): string {
		$value = str_replace( [ '-', '_' ], ' ', $value );
		$value = ucwords( $value );
		$value = str_replace( ' ', '', $value );

		return lcfirst( $value );
	}

	/**
	 * Convert a string to snake_case.
	 *
	 * Splits camelCase at its capitals, turns spaces and hyphens into
	 * underscores, and drops anything that is not a letter, digit or
	 * underscore. 'fooBar Baz' and 'foo-bar-baz' both become 'foo_bar_baz'.
	 *
	 * @param string $value The string to convert.
	 *
	 * @return string The snake_case string.
	 */
	public static function snake( string $value ): string {
		// Two passes for the capitals: 'HTMLParser' is 'html_parser', not
		// 'htmlparser', and the first rule alone only sees 'lP'.
		$value = (string) preg_replace( '/([A-Z]+)([A-Z][a-z])/', '$1_$2', $value );
		$value = (string) preg_replace( '/([a-z0-9])([A-Z])/', '$1_$2', $value );
		$value = (string) preg_replace( '/[\s\-]+/', '_', trim( $value ) );
		$value = (string) preg_replace( '/[^A-Za-z0-9_]/', '', $value );
		$value = (string) preg_replace( '/_+/', '_', $value );

		return strtolower( trim( $value, '_' ) );
	}

	/**
	 * Convert a string to Title Case.
	 *
	 * Multibyte-safe: 'élan vital' is 'Élan Vital'. Every word boundary
	 * counts, hyphens included, so 'mother-in-law' is 'Mother-In-Law'.
	 *
	 * @param string $value The string to convert.
	 *
	 * @return string The Title Case string.
	 */
	public static function title( string $value ): string {
		return mb_convert_case( $value, MB_CASE_TITLE, 'UTF-8' );
	}

	/**
	 * Convert to sentence case (first letter uppercase).
	 *
	 * @param string $value The string to convert.
	 *
	 * @return string The sentence case string.
	 */
	public static function sentence( string $value ): string {
		$value = mb_strtolower( $value );

		return mb_strtoupper( mb_substr( $value, 0, 1 ) ) . mb_substr( $value, 1 );
	}

	/**
	 * Extract initials from a name.
	 *
	 * @param string $name      The name to extract initials from.
	 * @param int    $limit     Maximum number of initials to return. Default 0 (no limit).
	 * @param bool   $uppercase Whether to return uppercase initials. Default true.
	 *
	 * @return string The initials.
	 */
	public static function initials( string $name, int $limit = 0, bool $uppercase = true ): string {
		$words = self::to_words( $name );

		if ( [] === $words ) {
			return '';
		}

		if ( $limit > 0 ) {
			$words = array_slice( $words, 0, $limit );
		}

		$initials = implode( '', array_map( fn( $word ) => mb_substr( $word, 0, 1 ), $words ) );

		return $uppercase ? mb_strtoupper( $initials ) : $initials;
	}

	/** Conversion ****************************************************************/

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
	 * Convert a delimited string to an array of trimmed pieces.
	 *
	 * An empty string is an empty list, not a list of one empty string --
	 * which is what explode() gives, and what every caller then has to
	 * filter out again. An empty separator does not split at all.
	 *
	 * @param string $value     The delimited string.
	 * @param string $separator The separator to use.
	 *
	 * @return array The resulting array.
	 */
	public static function to_array( string $value, string $separator = ',' ): array {
		if ( '' === trim( $value ) ) {
			return [];
		}

		if ( '' === $separator ) {
			return [ trim( $value ) ];
		}

		return array_map( 'trim', explode( $separator, $value ) );
	}

	/**
	 * Split string into words array.
	 *
	 * @param string $value The string to split.
	 *
	 * @return array Array of words.
	 */
	public static function to_words( string $value ): array {
		return self::without_empty( preg_split( '/\s+/', $value ) ?: [] );
	}

	/**
	 * Split string into lines array.
	 *
	 * @param string $value The string to split.
	 *
	 * @return array Array of lines.
	 */
	public static function to_lines( string $value ): array {
		return self::without_empty( preg_split( '/\r\n|\r|\n/', $value ) ?: [] );
	}

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
	 * Drop the empty strings from a list of pieces, and reindex.
	 *
	 * Not array_filter() without a callback: that drops '0' too, so a line
	 * or a word that happened to be a zero disappeared from the result.
	 *
	 * @param array $pieces The pieces.
	 *
	 * @return array The non-empty pieces, as a list.
	 */
	private static function without_empty( array $pieces ): array {
		return array_values( array_filter( $pieces, static fn( $piece ): bool => '' !== $piece ) );
	}
}
