<?php
/**
 * Laravel-Markdown
 * 
 * A small, lightweight and easy-to-use Laravel package for
 * handling markdown.
 * 
 * @author    Andreas Indal <andreas@rocketship.se>
 * @package   andreasindal/laravel-markdown
 * @link      https://github.com/andreasindal/laravel-markdown
 * @license   MIT
 */

if (! function_exists('markdown')) {
    /**
     * Short-hand helper function to parse a
     * markdown string to HTML.
     * 
     * @see \Indal\Markdown\Parser::parse
     * @param  string  $markdown
     * @return string
     */
    function markdown($markdown)
    {
        return app('Indal\Markdown\Parser')->parse($markdown);
    }
}

if (! function_exists('markdown_capture')) {
    /**
     * Short-hand helper function to parse
     * all output from a closure from markdown
     * to HTML.
     * 
     * @see \Indal\Markdown\Parser::begin
     * @see \Indal\Markdown\Parser::end
     * @param  Closure  $callback
     * @return string
     */
    function markdown_capture(Closure $callback)
    {
        $parser = app('Indal\Markdown\Parser');
        $parser->begin();
        $callback();
        return $parser->end();
    }
}

