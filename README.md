# WordPress String Utilities

Essential string manipulation utilities for WordPress development. Provides powerful methods for string checking, validation, manipulation, and content processing that WordPress doesn't offer out of the box.

## Features

* 🎯 **Comprehensive API**: 42 focused methods for common string operations
* 🔍 **Enhanced Checking**: Multi-needle contains, starts/ends with arrays, pattern matching
* ✅ **Built-in Validation**: Email, URL, date, numeric, and format validation
* 🔧 **Smart Manipulation**: First/last replace, content extraction, whitespace handling
* 📝 **Content Processing**: Reading time, word limits, excerpts with WordPress integration
* 🎨 **Case Conversion**: camelCase, snake_case, kebab-case, and more
* 🛡️ **WordPress-Native**: Uses WordPress functions like `wp_strip_all_tags()`, `is_email()`

## Requirements

* PHP 7.4 or later
* WordPress 5.0 or later

## Installation

```bash
composer require arraypress/wp-string-utils
```

## Basic Usage

### String Checking

```php
use ArrayPress\StringUtils\Str;

// Check for multiple needles
Str::contains_any( 'admin-dashboard.php', 'admin', 'dashboard' );  // true
Str::contains_all( 'WordPress Plugin', 'Word', 'Press' );          // true

// Enhanced starts/ends checking
Str::starts_with( 'image.jpg', ['.jpg', '.png', '.gif'] );        // false
Str::ends_with( 'image.jpg', ['.jpg', '.png', '.gif'] );          // true

// Pattern matching with wildcards
Str::matches_any( 'admin.php', ['admin.*', 'edit.*'], true );     // true
```

### String Validation

```php
// Format validation
Str::is_email( 'user@example.com' );      // true
Str::is_url( 'https://example.com' );     // true
Str::is_date( '2024-01-15' );             // true
Str::is_ip( '192.168.1.1' );             // true

// Type checking
Str::is_numeric( '123.45' );              // true
Str::is_integer( '123' );                 // true
Str::is_float( '123.45' );                // true
Str::is_json( '{"key":"value"}' );        // true

// Character validation
Str::is_alpha( 'HelloWorld' );            // true
Str::is_alphanumeric( 'Hello123' );       // true
Str::is_hex( 'FF0000' );                  // true
Str::is_blank( '   ' );                   // true
```

### String Manipulation

```php
// Advanced replacement
Str::replace_first( 'hello', 'hi', 'hello world hello' );    // 'hi world hello'
Str::replace_last( 'hello', 'hi', 'hello world hello' );     // 'hello world hi'

// Content extraction
Str::between( '[', ']', 'Hello [world] test' );              // 'world'
Str::between( '<p>', '</p>', '<p>Content</p>' );             // 'Content'

// Smart truncation
Str::truncate( 'This is a long sentence', 10 );              // 'This is...'
Str::words( 'The quick brown fox jumps', 3 );                // 'The quick brown...'

// Whitespace handling
Str::reduce_whitespace( '  hello    world  ' );              // 'hello world'
Str::remove_whitespace( 'hello world' );                     // 'helloworld'
Str::remove_line_breaks( "line1\nline2" );                   // 'line1line2'
```

### Case Conversion

```php
// Modern case formats
Str::camel( 'hello-world' );              // 'helloWorld'
Str::snake( 'HelloWorld' );               // 'hello_world'  
Str::kebab( 'Hello World' );              // 'hello-world'
Str::title( 'hello world' );              // 'Hello World'

// Basic case conversion (accepts any type)
Str::upper( ['a', 'b'] );                 // '["A","B"]'
Str::lower( 'HELLO' );                    // 'hello'
Str::sentence( 'HELLO WORLD' );           // 'Hello world'
```

### Content Processing

```php
// WordPress-optimized content handling
Str::excerpt( '<p>Long content here...</p>', 50 );           // 'Long content here...'
Str::word_count( '<p>Hello <strong>world</strong></p>' );    // 2
Str::reading_time( $post_content );                          // ['minutes' => 3, 'seconds' => 45]

// Content splitting
Str::to_words( 'hello world test' );                         // ['hello', 'world', 'test']
Str::to_lines( "line1\nline2\nline3" );                      // ['line1', 'line2', 'line3']
Str::to_sentences( 'Hello world. How are you?' );            // ['Hello world', ' How are you']
```

### Utility Operations

```php
// Safe conversion
Str::from( ['a', 'b'] );                  // '["a","b"]'
Str::from( 123 );                         // '123'

// Array conversion
Str::to_array( 'apple, banana, cherry' ); // ['apple', 'banana', 'cherry']
Str::to_csv( ['red', 'green', 'blue'] );  // 'red,green,blue'

// Text processing
Str::ascii( 'café naïve' );               // 'cafe naive'
Str::normalize( '  HELLO World  ' );      // 'hello world'
```

## API Reference

### String Checking Methods

| Method | Description | Returns |
|--------|-------------|---------|
| `contains_any($haystack, ...$needles)` | Check if string contains any needle | `bool` |
| `contains_all($haystack, ...$needles)` | Check if string contains all needles | `bool` |
| `starts_with($haystack, $needles)` | Check if starts with needle(s) | `bool` |
| `ends_with($haystack, $needles)` | Check if ends with needle(s) | `bool` |
| `matches_any($needle, $patterns, $wildcard)` | Pattern matching with wildcards | `bool` |

### Validation Methods

| Method | Description | Returns |
|--------|-------------|---------|
| `is_json($string)` | Check if valid JSON | `bool` |
| `is_email($string)` | Check if valid email | `bool` |
| `is_url($string)` | Check if valid URL | `bool` |
| `is_date($string)` | Check if valid date | `bool` |
| `is_ip($string)` | Check if valid IP address | `bool` |
| `is_numeric($string)` | Check if numeric | `bool` |
| `is_integer($string)` | Check if integer | `bool` |
| `is_float($string)` | Check if float | `bool` |
| `is_alpha($string)` | Check if alphabetic only | `bool` |
| `is_alphanumeric($string)` | Check if alphanumeric only | `bool` |
| `is_hex($string)` | Check if hexadecimal | `bool` |
| `is_blank($string)` | Check if empty/whitespace | `bool` |
| `is_length_valid($string, $min, $max)` | Check length within range | `bool` |

### Manipulation Methods

| Method | Description | Returns |
|--------|-------------|---------|
| `replace_first($search, $replace, $subject)` | Replace first occurrence | `string` |
| `replace_last($search, $replace, $subject)` | Replace last occurrence | `string` |
| `between($start, $end, $subject)` | Extract content between delimiters | `string` |
| `truncate($string, $length, $suffix)` | Truncate with suffix | `string` |
| `words($string, $limit, $suffix)` | Limit word count | `string` |
| `reduce_whitespace($string)` | Reduce multiple spaces to single | `string` |
| `remove_whitespace($string)` | Remove all whitespace | `string` |
| `remove_line_breaks($string)` | Remove line breaks | `string` |

### Case Conversion Methods

| Method | Description | Returns |
|--------|-------------|---------|
| `camel($string)` | Convert to camelCase | `string` |
| `snake($string)` | Convert to snake_case | `string` |
| `kebab($string)` | Convert to kebab-case | `string` |
| `title($string)` | Convert to Title Case | `string` |
| `upper($value)` | Convert to UPPERCASE | `string` |
| `lower($value)` | Convert to lowercase | `string` |
| `sentence($value)` | Convert to Sentence case | `string` |

### Content Processing Methods

| Method | Description | Returns |
|--------|-------------|---------|
| `excerpt($content, $length, $stripTags)` | Create safe excerpt | `string` |
| `reading_time($content, $wpm)` | Estimate reading time | `array` |
| `word_count($string)` | Count words (strips HTML) | `int` |

### Utility Methods

| Method | Description | Returns |
|--------|-------------|---------|
| `from($value)` | Convert value to string safely | `string` |
| `ascii($string)` | Remove accents, convert to ASCII | `string` |
| `normalize($string)` | Trim and lowercase | `string` |
| `to_array($string, $separator)` | Convert CSV string to array | `array` |
| `to_csv($array, $separator)` | Convert array to CSV string | `string` |
| `to_words($string)` | Split into words array | `array` |
| `to_lines($string)` | Split into lines array | `array` |
| `to_sentences($string)` | Split into sentences array | `array` |

## Common Use Cases

### Form Validation

```php
// Validate user input
$email_valid = Str::is_email( $_POST['email'] );
$phone_valid = Str::is_numeric( $_POST['phone'] );
$website_valid = Str::is_url( $_POST['website'] );
$birthdate_valid = Str::is_date( $_POST['birthdate'] );

// Check required fields
$name_provided = !Str::is_blank( $_POST['name'] );
$message_length = Str::is_length_valid( $_POST['message'], 10, 500 );
```

### Content Processing

```php
// Create clean excerpts
$excerpt = Str::excerpt( $post_content, 150 );

// Process user content
$clean_title = Str::title( $user_input );
$slug = Str::kebab( $clean_title );
$normalized = Str::normalize( $user_search );

// Content analysis
$reading_time = Str::reading_time( $article_content );
$word_count = Str::word_count( $content );
```

### Data Cleanup

```php
// Clean messy data
$clean_text = Str::reduce_whitespace( $messy_input );
$single_line = Str::remove_line_breaks( $multi_line_text );
$no_accents = Str::ascii( $international_text );

// Parse structured data
$tags = Str::to_array( $comma_separated_tags );
$csv_export = Str::to_csv( $tag_array );
```

### WordPress Integration

```php
// Meta field processing
$featured = Str::is_json( $meta_value ) ? json_decode( $meta_value ) : $meta_value;
$categories = Str::to_array( get_post_meta( $post_id, 'categories', true ) );

// Admin interface
$admin_pages = ['admin.php', 'edit.php', 'options.php'];
$is_admin_page = Str::ends_with( $current_page, $admin_pages );

// Content filtering
$safe_excerpt = Str::excerpt( get_the_content(), 200 );
$estimated_time = Str::reading_time( get_the_content() );
```

## Key Benefits

- **Fills WordPress Gaps**: Provides methods WordPress doesn't offer
- **Enhanced Functionality**: Better versions of basic PHP string functions
- **WordPress-Optimized**: Integrates with WordPress functions and conventions
- **Type Safety**: Strict typing with predictable return values
- **Performance-Focused**: Efficient implementations without heavy dependencies
- **Developer-Friendly**: Intuitive method names and consistent API

## Requirements

- PHP 7.4+
- WordPress 5.0+

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is licensed under the GPL-2.0-or-later License.

## Support

- [Documentation](https://github.com/arraypress/wp-string-utils)
- [Issue Tracker](https://github.com/arraypress/wp-string-utils/issues)