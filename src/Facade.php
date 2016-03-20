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

use Illuminate\Support\Facades\Facade as BaseFacade;

class Facade extends BaseFacade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'markdown';
    }
}
