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

use Blade;
use Parsedown;
use Indal\Markdown\Parser;
use Illuminate\Support\ServiceProvider;

class MarkdownServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the Markdown Blade directives and publish
     * the config file.
     * 
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/markdown.php' => config_path('markdown.php'),
        ]);

        Blade::directive('markdown', function($markdown) {
            if (! is_null($markdown)) {
                return "<?php echo app('Indal\Markdown\Parser')->parse($markdown); ?>";
            }

            return "<?php app('Indal\Markdown\Parser')->begin() ?>";
        });

        Blade::directive('endmarkdown', function () {
            return "<?php echo app('Indal\Markdown\Parser')->end() ?>";
        });
    }

    /**
     * Bind the Markdown facade and the parser class to
     * the container.
     * 
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Parser::class, function ($app) {
            $parsedown = new Parsedown;

            $parsedown->setUrlsLinked(config('markdown.urls'));

            return new Parser($parsedown);
        });

        $this->app->bind('markdown', Parser::class);
    }
}
