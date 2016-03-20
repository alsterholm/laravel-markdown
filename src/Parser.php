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

namespace Indal\Markdown;

use Parsedown;
use Indal\Markdown\Exceptions\InvalidTagException;

class Parser
{
    /**
     * Indicates if the parser is currently
     * capturing input.
     * 
     * @var boolean
     */
    protected $capturing = false;

    /**
     * Create a new Parser object, used for
     * parsing markdown strings to HTML.
     * 
     * @param  \Parsedown  $parsedown
     */
    public function __construct(Parsedown $parsedown)
    {
        $this->parsedown = $parsedown;
    }

    /**
     * Parses a markdown string to HTML.
     * 
     * @param  string  $markdown
     * @return string
     */
    public function parse($markdown)
    {
        if (config('markdown.xss')) {
            // Escape any XSS attempts
            $markdown = preg_replace('/(\[.*\])\(javascript:.*\)/', '$1(#)', $markdown);
        }

        return $this->parsedown->text($markdown);
    }

    /**
     * Start capturing output to be parsed.
     * 
     * @return void
     */
    public function begin()
    {
        $this->capturing = true;

        ob_start();
    }

    /**
     * Stop capturing output, parse the string from
     * markdown to HTML and return it. Throws an exception
     * if outpout capturing hasn't been started yet.
     * 
     * @throws \Indal\Markdown\Exceptions\InvalidTagException
     * @return string
     */
    public function end()
    {
        if ($this->capturing === false) {
            throw new InvalidTagException("Markdown capturing have not been started.");
        }

        $this->capturing = false;

        $markdown = ob_get_clean();

        return $this->parse($markdown);
    }
}