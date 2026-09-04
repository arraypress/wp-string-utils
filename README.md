# WordPress String Utilities

The string operations you keep rewriting in every plugin.

## What it does

PHP's string functions stop short of what a plugin actually needs, and
WordPress only fills part of the gap. This covers the rest: testing a string
against several needles at once, converting between naming conventions,
shortening copy to a word or character limit, and masking values you should
not print in full.

Where WordPress already does it better it calls WordPress — `wp_strip_all_tags()`
for excerpts, rather than a regex of its own.

## Features

- Test whether a string contains, starts with, or ends with any of several needles
- Match against a list of patterns, with optional wildcards
- Shorten text to a word limit, or to a character limit with a suffix
- Build an excerpt from post content, with tags stripped
- Convert between camelCase, snake_case, Title Case and sentence case
- Replace only the first or only the last occurrence of a substring
- Pull the text sitting between two markers
- Mask the middle of a licence key or card number, keeping a few characters at each end
- Reduce a name to its initials, for an avatar placeholder
- Split a delimited string into an array, words, or lines

## Installation

```bash
composer require arraypress/wp-string-utils
```

## Quick start

```php
use ArrayPress\StringUtils\Str;

// Does this filename look like one of ours, however it was named?
if ( Str::contains_any( $filename, 'invoice', 'receipt', 'order' ) ) {
    // ...
}

// A blurb for a product listing, cut cleanly at 20 words.
$blurb = Str::words( $product->description, 20 );

// Show a licence key in the admin without showing all of it: AB12********3A9F
$safe = Str::mask( $licence_key, 4 );

// "Acme Trading Co" -> "AT"
$avatar_text = Str::initials( $customer->name, 2 );
```

## Requirements

* PHP 8.3 or later
* WordPress 7.1 or later

## License

GPL-2.0-or-later
