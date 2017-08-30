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

namespace Indal\Markdown\Drivers;

interface MarkdownDriver
{
    /**
     * Parses a markdown string to HTML.
     * 
     * @param  string  $text
     * @return string
     */
    function text($text);

    /**
     * Parses a single line of markdown to HTML.
     *
     * @param  string  $text
     * @return string
     */
    function line($text);
}