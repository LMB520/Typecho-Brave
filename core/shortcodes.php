<?php
/**
 * WordPress API for creating bbcode-like tags or what WordPress calls
 * "shortcodes". The tag and attribute parsing or regular expression code is
 * based on the Textpattern tag parser.
 *
 * A few examples are below:
 *
 * [shortcode /]
 * [shortcode foo="bar" baz="bing" /]
 * [shortcode foo="bar"]content[/shortcode]
 *
 * Shortcode tags support attributes and enclosed content, but does not entirely
 * support inline shortcodes in other shortcodes. You will have to call the
 * shortcode parser in your function to account for that.
 *
 * {@internal
 * Please be aware that the above note was made during the beta of WordPress 2.6
 * and in the future may not be accurate. Please update the note when it is no
 * longer the case.}}
 *
 * To apply shortcode tags to content:
 *
 *     $out = do_shortcode( $content );
 *
 * @link https://developer.wordpress.org/plugins/shortcodes/
 *
 * @package WordPress
 * @subpackage Shortcodes
 * @since 2.5.0
 */
/**
 * Container for storing shortcode tags and their hook to call for the shortcode
 *
 * @since 2.5.0
 *
 * @name $shortcode_tags
 * @var array
 * @global array $shortcode_tags
 */
$shortcode_tags = array();
/**
 * Adds a new shortcode.
 *
 * Care should be taken through prefixing or other means to ensure that the
 * shortcode tag being added is unique and will not conflict with other,
 * already-added shortcode tags. In the event of a duplicated tag, the tag
 * loaded last will take precedence.
 *
 * @param string $tag Shortcode tag to be searched in post content.
 * @param callable $callback The callback function to run when the shortcode is found.
 *                           Every shortcode callback is passed three parameters by default,
 *                           including an array of attributes (`$atts`), the shortcode content
 *                           or null if not set (`$content`), and finally the shortcode tag
 *                           itself (`$shortcode_tag`), in that order.
 * @since 2.5.0
 *
 * @global array $shortcode_tags
 *
 */
function add_shortcode($tag, $callback)
{
    global $shortcode_tags;
    if ('' == trim($tag)) {
        $message = __('Invalid shortcode name: Empty name given.');
        _doing_it_wrong(__FUNCTION__, $message, '4.4.0');
        return;
    }
    if (0 !== preg_match('@[<>&/\[\]\x00-\x20=]@', $tag)) {
        /* translators: 1: Shortcode name, 2: Space-separated list of reserved characters. */
        $message = sprintf(__('Invalid shortcode name: %1$s. Do not use spaces or reserved characters: %2$s'), $tag, '& / < > [ ] =');
        _doing_it_wrong(__FUNCTION__, $message, '4.4.0');
        return;
    }
    $shortcode_tags[$tag] = $callback;
}

/**
 * Removes hook for shortcode.
 *
 * @param string $tag Shortcode tag to remove hook for.
 * @global array $shortcode_tags
 *
 * @since 2.5.0
 *
 */
function remove_shortcode($tag)
{
    global $shortcode_tags;
    unset($shortcode_tags[$tag]);
}

/**
 * Clear all shortcodes.
 *
 * This function is simple, it clears all of the shortcode tags by replacing the
 * shortcodes global by a empty array. This is actually a very efficient method
 * for removing all shortcodes.
 *
 * @since 2.5.0
 *
 * @global array $shortcode_tags
 */
function remove_all_shortcodes()
{
    global $shortcode_tags;
    $shortcode_tags = array();
}

/**
 * Whether a registered shortcode exists named $tag
 *
 * @param string $tag Shortcode tag to check.
 * @return bool Whether the given shortcode exists.
 * @since 3.6.0
 *
 * @global array $shortcode_tags List of shortcode tags and their callback hooks.
 *
 */
function shortcode_exists($tag)
{
    global $shortcode_tags;
    return array_key_exists($tag, $shortcode_tags);
}

/**
 * Whether the passed content contains the specified shortcode
 *
 * @param string $content Content to search for shortcodes.
 * @param string $tag Shortcode tag to check.
 * @return bool Whether the passed content contains the given shortcode.
 * @global array $shortcode_tags
 *
 * @since 3.6.0
 *
 */
function has_shortcode($content, $tag)
{
    if (false === strpos($content, '[')) {
        return false;
    }
    if (shortcode_exists($tag)) {
        preg_match_all('/' . get_shortcode_regex() . '/', $content, $matches, PREG_SET_ORDER);
        if (empty($matches)) {
            return false;
        }
        foreach ($matches as $shortcode) {
            if ($tag === $shortcode[2]) {
                return true;
            } elseif (!empty($shortcode[5]) && has_shortcode($shortcode[5], $tag)) {
                return true;
            }
        }
    }
    return false;
}

/**
 * Search content for shortcodes and filter shortcodes through their hooks.
 *
 * This function is an alias for do_shortcode().
 *
 * @param string $content Content to search for shortcodes.
 * @param bool $ignore_html When true, shortcodes inside HTML elements will be skipped.
 *                            Default false.
 * @return string Content with shortcodes filtered out.
 * @see do_shortcode()
 *
 * @since 5.4.0
 *
 */
function apply_shortcodes($content, $ignore_html = false)
{
    return do_shortcode($content, $ignore_html);
}

/**
 * Search content for shortcodes and filter shortcodes through their hooks.
 *
 * If there are no shortcode tags defined, then the content will be returned
 * without any filtering. This might cause issues when plugins are disabled but
 * the shortcode will still show up in the post or content.
 *
 * @param string $content Content to search for shortcodes.
 * @param bool $ignore_html When true, shortcodes inside HTML elements will be skipped.
 *                            Default false.
 * @return string Content with shortcodes filtered out.
 * @global array $shortcode_tags List of shortcode tags and their callback hooks.
 *
 * @since 2.5.0
 *
 */
function do_shortcode($content, $ignore_html = false)
{
    global $shortcode_tags;
    if (false === strpos($content, '[')) {
        return $content;
    }
    if (empty($shortcode_tags) || !is_array($shortcode_tags)) {
        return $content;
    }
// Find all registered tag names in $content.
    preg_match_all('@\[([^<>&/\[\]\x00-\x20=]++)@', $content, $matches);
    $tagnames = array_intersect(array_keys($shortcode_tags), $matches[1]);
    if (empty($tagnames)) {
        return $content;
    }
    $content = do_shortcodes_in_html_tags($content, $ignore_html, $tagnames);
    $pattern = get_shortcode_regex($tagnames);
    $content = preg_replace_callback("/$pattern/", 'do_shortcode_tag', $content);
// Always restore square braces so we don't break things like <!--[if IE ]>.
    $content = unescape_invalid_shortcodes($content);
    return $content;
}

/**
 * Retrieve the shortcode regular expression for searching.
 *
 * The regular expression combines the shortcode tags in the regular expression
 * in a regex class.
 *
 * The regular expression contains 6 different sub matches to help with parsing.
 *
 * 1 - An extra [ to allow for escaping shortcodes with double [[]]
 * 2 - The shortcode name
 * 3 - The shortcode argument list
 * 4 - The self closing /
 * 5 - The content of a shortcode when it wraps some content.
 * 6 - An extra ] to allow for escaping shortcodes with double [[]]
 *
 * @param array $tagnames Optional. List of shortcodes to find. Defaults to all registered shortcodes.
 * @return string The shortcode search regular expression
 * @global array $shortcode_tags
 *
 * @since 2.5.0
 * @since 4.4.0 Added the `$tagnames` parameter.
 *
 */
function get_shortcode_regex($tagnames = null)
{
    global $shortcode_tags;
    if (empty($tagnames)) {
        $tagnames = array_keys($shortcode_tags);
    }
    $tagregexp = join('|', array_map('preg_quote', $tagnames));
// WARNING! Do not change this regex without changing do_shortcode_tag() and strip_shortcode_tag().
// Also, see shortcode_unautop() and shortcode.js.
// phpcs:disable Squiz.Strings.ConcatenationSpacing.PaddingFound -- don't remove regex indentation
    return '\\[' // Opening bracket.
        . '(\\[?)' // 1: Optional second opening bracket for escaping shortcodes: [[tag]].
        . "($tagregexp)" // 2: Shortcode name.
        . '(?![\\w-])' // Not followed by word character or hyphen.
        . '(' // 3: Unroll the loop: Inside the opening shortcode tag.
        . '[^\\]\\/]*' // Not a closing bracket or forward slash.
        . '(?:'
        . '\\/(?!\\])' // A forward slash not followed by a closing bracket.
        . '[^\\]\\/]*' // Not a closing bracket or forward slash.
        . ')*?'
        . ')'
        . '(?:'
        . '(\\/)' // 4: Self closing tag...
        . '\\]' // ...and closing bracket.
        . '|'
        . '\\]' // Closing bracket.
        . '(?:'
        . '(' // 5: Unroll the loop: Optionally, anything between the opening and closing shortcode tags.
        . '[^\\[]*+' // Not an opening bracket.
        . '(?:'
        . '\\[(?!\\/\\2\\])' // An opening bracket not followed by the closing shortcode tag.
        . '[^\\[]*+' // Not an opening bracket.
        . ')*+'
        . ')'
        . '\\[\\/\\2\\]' // Closing shortcode tag.
        . ')?'
        . ')'
        . '(\\]?)'; // 6: Optional second closing brocket for escaping shortcodes: [[tag]].
// phpcs:enable
}

/**
 * Regular Expression callable for do_shortcode() for calling shortcode hook.
 *
 * @param array $m Regular expression match array
 * @return string|false False on failure.
 * @global array $shortcode_tags
 *
 * @see get_shortcode_regex for details of the match array contents.
 *
 * @since 2.5.0
 * @access private
 *
 */
function do_shortcode_tag($m)
{
    global $shortcode_tags;
// Allow [[foo]] syntax for escaping a tag.
    if ('[' === $m[1] && ']' === $m[6]) {
        return substr($m[0], 1, -1);
    }
    $tag = $m[2];
    $attr = shortcode_parse_atts($m[3]);
    if (!is_callable($shortcode_tags[$tag])) {
        /* translators: %s: Shortcode tag. */
        $message = sprintf(__('Attempting to parse a shortcode without a valid callback: %s'), $tag);
        _doing_it_wrong(__FUNCTION__, $message, '4.3.0');
        return $m[0];
    }
    /**
     * Filters whether to call a shortcode callback.
     *
     * Returning a non-false value from filter will short-circuit the
     * shortcode generation process, returning that value instead.
     *
     * @param false|string $return Short-circuit return value. Either false or the value to replace the shortcode with.
     * @param string $tag Shortcode name.
     * @param array|string $attr Shortcode attributes array or empty string.
     * @param array $m Regular expression match array.
     * @since 4.7.0
     *
     */
    $return = apply_filters('pre_do_shortcode_tag', false, $tag, $attr, $m);
    if (false !== $return) {
        return $return;
    }
    $content = isset($m[5]) ? $m[5] : null;
    $output = $m[1] . call_user_func($shortcode_tags[$tag], $attr, $content, $tag) . $m[6];
    /**
     * Filters the output created by a shortcode callback.
     *
     * @param string $output Shortcode output.
     * @param string $tag Shortcode name.
     * @param array|string $attr Shortcode attributes array or empty string.
     * @param array $m Regular expression match array.
     * @since 4.7.0
     *
     */
    return apply_filters('do_shortcode_tag', $output, $tag, $attr, $m);
}

/**
 * Search only inside HTML elements for shortcodes and process them.
 *
 * Any [ or ] characters remaining inside elements will be HTML encoded
 * to prevent interference with shortcodes that are outside the elements.
 * Assumes $content processed by KSES already.  Users with unfiltered_html
 * capability may get unexpected output if angle braces are nested in tags.
 *
 * @param string $content Content to search for shortcodes
 * @param bool $ignore_html When true, all square braces inside elements will be encoded.
 * @param array $tagnames List of shortcodes to find.
 * @return string Content with shortcodes filtered out.
 * @since 4.2.3
 *
 */
function do_shortcodes_in_html_tags($content, $ignore_html, $tagnames)
{
// Normalize entities in unfiltered HTML before adding placeholders.
    $trans = array(
        '&#91;' => '&#091;',
        '&#93;' => '&#093;',
    );
    $content = strtr($content, $trans);
    $trans = array(
        '[' => '&#91;',
        ']' => '&#93;',
    );
    $pattern = get_shortcode_regex($tagnames);
    $textarr = preg_split(get_html_split_regex(), $content, -1, PREG_SPLIT_DELIM_CAPTURE);
    foreach ($textarr as &$element) {
        if ('' == $element || '<' !== $element[0]) {
            continue;
        }
        $noopen = false === strpos($element, '[');
        $noclose = false === strpos($element, ']');
        if ($noopen || $noclose) {
// This element does not contain shortcodes.
            if ($noopen xor $noclose) {
// Need to encode stray '[' or ']' chars.
                $element = strtr($element, $trans);
            }
            continue;
        }
        if ($ignore_html || '<!--' === substr($element, 0, 4) || '<![CDATA[' === substr($element, 0, 9)) {
// Encode all '[' and ']' chars.
            $element = strtr($element, $trans);
            continue;
        }
        $attributes = wp_kses_attr_parse($element);
        if (false === $attributes) {
// Some plugins are doing things like [name] <[email]>.
            if (1 === preg_match('%^<\s*\[\[?[^\[\]]+\]%', $element)) {
                $element = preg_replace_callback("/$pattern/", 'do_shortcode_tag', $element);
            }
// Looks like we found some crazy unfiltered HTML. Skipping it for sanity.
            $element = strtr($element, $trans);
            continue;
        }
// Get element name.
        $front = array_shift($attributes);
        $back = array_pop($attributes);
        $matches = array();
        preg_match('%[a-zA-Z0-9]+%', $front, $matches);
        $elname = $matches[0];
// Look for shortcodes in each attribute separately.
        foreach ($attributes as &$attr) {
            $open = strpos($attr, '[');
            $close = strpos($attr, ']');
            if (false === $open || false === $close) {
                continue; // Go to next attribute. Square braces will be escaped at end of loop.
            }
            $double = strpos($attr, '"');
            $single = strpos($attr, "'");
            if ((false === $single || $open < $single) && (false === $double || $open < $double)) {
                /*
                * $attr like '[shortcode]' or 'name = [shortcode]' implies unfiltered_html.
                * In this specific situation we assume KSES did not run because the input
                * was written by an administrator, so we should avoid changing the output
                * and we do not need to run KSES here.
                */
                $attr = preg_replace_callback("/$pattern/", 'do_shortcode_tag', $attr);
            } else {
// $attr like 'name = "[shortcode]"' or "name = '[shortcode]'".
// We do not know if $content was unfiltered. Assume KSES ran before shortcodes.
                $count = 0;
                $new_attr = preg_replace_callback("/$pattern/", 'do_shortcode_tag', $attr, -1, $count);
                if ($count > 0) {
// Sanitize the shortcode output using KSES.
                    $new_attr = wp_kses_one_attr($new_attr, $elname);
                    if ('' !== trim($new_attr)) {
// The shortcode is safe to use now.
                        $attr = $new_attr;
                    }
                }
            }
        }
        $element = $front . implode('', $attributes) . $back;
// Now encode any remaining '[' or ']' chars.
        $element = strtr($element, $trans);
    }
    $content = implode('', $textarr);
    return $content;
}

/**
 * Remove placeholders added by do_shortcodes_in_html_tags().
 *
 * @param string $content Content to search for placeholders.
 * @return string Content with placeholders removed.
 * @since 4.2.3
 *
 */
function unescape_invalid_shortcodes($content)
{
// Clean up entire string, avoids re-parsing HTML.
    $trans = array(
        '&#91;' => '[',
        '&#93;' => ']',
    );
    $content = strtr($content, $trans);
    return $content;
}

/**
 * Retrieve the shortcode attributes regex.
 *
 * @return string The shortcode attribute regular expression
 * @since 4.4.0
 *
 */
function get_shortcode_atts_regex()
{
    return '/([\w-]+)\s*=\s*"([^"]*)"(?:\s|$)|([\w-]+)\s*=\s*\'([^\']*)\'(?:\s|$)|([\w-]+)\s*=\s*([^\s\'"]+)(?:\s|$)|"([^"]*)"(?:\s|$)|\'([^\']*)\'(?:\s|$)|(\S+)(?:\s|$)/';
}

/**
 * Retrieve all attributes from the shortcodes tag.
 *
 * The attributes list has the attribute name as the key and the value of the
 * attribute as the value in the key/value pair. This allows for easier
 * retrieval of the attributes, since all attributes have to be known.
 *
 * @param string $text
 * @return array|string List of attribute values.
 *                      Returns empty array if trim( $text ) == '""'.
 *                      Returns empty string if trim( $text ) == ''.
 *                      All other matches are checked for not empty().
 * @since 2.5.0
 *
 */
function shortcode_parse_atts($text)
{
    $atts = array();
    $pattern = get_shortcode_atts_regex();
    $text = preg_replace("/[\x{00a0}\x{200b}]+/u", ' ', $text);
    if (preg_match_all($pattern, $text, $match, PREG_SET_ORDER)) {
        foreach ($match as $m) {
            if (!empty($m[1])) {
                $atts[strtolower($m[1])] = stripcslashes($m[2]);
            } elseif (!empty($m[3])) {
                $atts[strtolower($m[3])] = stripcslashes($m[4]);
            } elseif (!empty($m[5])) {
                $atts[strtolower($m[5])] = stripcslashes($m[6]);
            } elseif (isset($m[7]) && strlen($m[7])) {
                $atts[] = stripcslashes($m[7]);
            } elseif (isset($m[8]) && strlen($m[8])) {
                $atts[] = stripcslashes($m[8]);
            } elseif (isset($m[9])) {
                $atts[] = stripcslashes($m[9]);
            }
        }
// Reject any unclosed HTML elements.
        foreach ($atts as &$value) {
            if (false !== strpos($value, '<')) {
                if (1 !== preg_match('/^[^<]*+(?:<[^>]*+>[^<]*+)*+$/', $value)) {
                    $value = '';
                }
            }
        }
    } else {
        $atts = ltrim($text);
    }
    return $atts;
}

/**
 * Combine user attributes with known attributes and fill in defaults when needed.
 *
 * The pairs should be considered to be all of the attributes which are
 * supported by the caller and given as a list. The returned attributes will
 * only contain the attributes in the $pairs list.
 *
 * If the $atts list has unsupported attributes, then they will be ignored and
 * removed from the final returned list.
 *
 * @param array $pairs Entire list of supported attributes and their defaults.
 * @param array $atts User defined attributes in shortcode tag.
 * @param string $shortcode Optional. The name of the shortcode, provided for context to enable filtering
 * @return array Combined and filtered attribute list.
 * @since 2.5.0
 *
 */
function shortcode_atts($pairs, $atts, $shortcode = '')
{
    $atts = (array)$atts;
    $out = array();
    foreach ($pairs as $name => $default) {
        if (array_key_exists($name, $atts)) {
            $out[$name] = $atts[$name];
        } else {
            $out[$name] = $default;
        }
    }
    if ($shortcode) {
        /**
         * Filters shortcode attributes.
         *
         * If the third parameter of the shortcode_atts() function is present then this filter is available.
         * The third parameter, $shortcode, is the name of the shortcode.
         *
         * @param array $out The output array of shortcode attributes.
         * @param array $pairs The supported attributes and their defaults.
         * @param array $atts The user defined shortcode attributes.
         * @param string $shortcode The shortcode name.
         * @since 3.6.0
         * @since 4.4.0 Added the `$shortcode` parameter.
         *
         */
        $out = apply_filters("shortcode_atts_{$shortcode}", $out, $pairs, $atts, $shortcode);
    }
    return $out;
}

/**
 * Remove all shortcode tags from the given content.
 *
 * @param string $content Content to remove shortcode tags.
 * @return string Content without shortcode tags.
 * @since 2.5.0
 *
 * @global array $shortcode_tags
 *
 */
function strip_shortcodes($content)
{
    global $shortcode_tags;
    if (false === strpos($content, '[')) {
        return $content;
    }
    if (empty($shortcode_tags) || !is_array($shortcode_tags)) {
        return $content;
    }
// Find all registered tag names in $content.
    preg_match_all('@\[([^<>&/\[\]\x00-\x20=]++)@', $content, $matches);
    $tags_to_remove = array_keys($shortcode_tags);
    /**
     * Filters the list of shortcode tags to remove from the content.
     *
     * @param array $tags_to_remove Array of shortcode tags to remove.
     * @param string $content Content shortcodes are being removed from.
     * @since 4.7.0
     *
     */
    $tags_to_remove = apply_filters('strip_shortcodes_tagnames', $tags_to_remove, $content);
    $tagnames = array_intersect($tags_to_remove, $matches[1]);
    if (empty($tagnames)) {
        return $content;
    }
    $content = do_shortcodes_in_html_tags($content, true, $tagnames);
    $pattern = get_shortcode_regex($tagnames);
    $content = preg_replace_callback("/$pattern/", 'strip_shortcode_tag', $content);
// Always restore square braces so we don't break things like <!--[if IE ]>.
    $content = unescape_invalid_shortcodes($content);
    return $content;
}

/**
 * Strips a shortcode tag based on RegEx matches against post content.
 *
 * @param array $m RegEx matches against post content.
 * @return string|false The content stripped of the tag, otherwise false.
 * @since 3.3.0
 *
 */
function strip_shortcode_tag($m)
{
    // Allow [[foo]] syntax for escaping a tag.
    if ('[' === $m[1] && ']' === $m[6]) {
        return substr($m[0], 1, -1);
    }
    return $m[1] . $m[6];
}

function get_html_split_regex()
{
    static $regex;
    if (!isset($regex)) {
        // phpcs:disable Squiz.Strings.ConcatenationSpacing.PaddingFound -- don't remove regex indentation
        $comments =
            '!' // Start of comment, after the <.
            . '(?:' // Unroll the loop: Consume everything until --> is found.
            . '-(?!->)' // Dash not followed by end of comment.
            . '[^\-]*+' // Consume non-dashes.
            . ')*+' // Loop possessively.
            . '(?:-->)?';
        // End of comment. If not found, match all input.
        $cdata =
            '!\[CDATA\[' // Start of comment, after the <.
            . '[^\]]*+' // Consume non-].
            . '(?:' // Unroll the loop: Consume everything until ]]> is found.
            . '](?!]>)' // One ] not followed by end of comment.
            . '[^\]]*+' // Consume non-].
            . ')*+' // Loop possessively.
            . '(?:]]>)?';
        // End of comment. If not found, match all input.
        $escaped =
            '(?=' // Is the element escaped?
            . '!--'
            . '|'
            . '!\[CDATA\['
            . ')'
            . '(?(?=!-)' // If yes, which type?
            . $comments
            . '|'
            . $cdata
            . ')';
        $regex =
            '/(' // Capture the entire match.
            . '<' // Find start of element.
            . '(?' // Conditional expression follows.
            . $escaped // Find end of escaped element.
            . '|' // ...else...
            . '[^>]*>?' // Find end of normal element.
            . ')'
            . ')/';
        // phpcs:enable
    }
    return $regex;
}

function apply_filters($tag, $value)
{
    global $wp_filter, $wp_current_filter;
    $args = func_get_args();
    // Do 'all' actions first.
    //    if ( isset( $wp_filter['all'] ) ) {
    //        $wp_current_filter[] = $tag;
    //        _wp_call_all_hook( $args );
    //    }
    if (!isset($wp_filter[$tag])) {
        if (isset($wp_filter['all'])) {
            array_pop($wp_current_filter);
        }
        return $value;
    }
    if (!isset($wp_filter['all'])) {
        $wp_current_filter[] = $tag;
    }
    // Don't pass the tag name to WP_Hook.
    array_shift($args);
    $filtered = $wp_filter[$tag]->apply_filters($value, $args);
    array_pop($wp_current_filter);
    return $filtered;
}