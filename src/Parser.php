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
        if (empty($markdown)) {
            return '';
        }

        return $this->parsedown->text(
            static::removeLeadingWhitespace($this->escape($markdown))
        );
    }

    /**
     * Parses a single line of markdown to HTML.
     *
     * @param  string  $markdown
     * @return string
     */
    public function line($markdown)
    {
        return $this->parsedown->line($this->escape($markdown));
    }

    /**
     * Escape any XSS attempts related to injecting JavaScript in
     * anchor tags. Will only escape the string if the escape
     * option is set to true in the config.
     *
     * @param  string  $markdown
     * @return string
     */
    public function escape($markdown)
    {
        if (config('markdown.xss')) {
            return preg_replace('/(\[.*\])\(javascript:.*\)/', '$1(#)', $markdown);
        }

        return $markdown;
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

    /**
     * Removes indentation according to the indentation of the first
     * line, of the given markdown text. This prevents markdown
     * from being rendered as code in unwanted places. Credit of
     * this goes to Mohamed Said (@themsaid).
     * 
     * @param  string  $markdown
     * @return string
     */
    public static function removeLeadingWhitespace($markdown)
    {
        $i = 0;

        while (! $firstLine = explode("\n", $markdown)[$i]) {
            $i++;
        }

        preg_match('/^( *)/', $firstLine, $matches);
        return preg_replace('/^[ ]{'.strlen($matches[1]).'}/m', '', $markdown);
    }
}