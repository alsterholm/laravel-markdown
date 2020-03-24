# Laravel-Markdown

[![Build Status](https://travis-ci.org/andreasindal/laravel-markdown.svg?branch=master)](https://travis-ci.org/andreasindal/laravel-markdown)

A small, lightweight and easy-to-use Laravel package for handling markdown. It comes with a facade, a helper function and a Blade directive to make life easier for you.

| Laravel version | Laravel-Markdown version                                              |
| --------------- | --------------------------------------------------------------------  |
| 5.8, 6.*, 7.*   | [3.1.1](https://github.com/andreasindal/laravel-markdown/tree/3.1.1)  |
| 5.7             | [3.0.1](https://github.com/andreasindal/laravel-markdown/tree/3.0.1)  |
| 5.6             | [3.0](https://github.com/andreasindal/laravel-markdown/tree/3.0)      |
| 5.5             | [2.0](https://github.com/andreasindal/laravel-markdown/tree/2.0)      |
| 5.3, 5.4        | [1.1](https://github.com/andreasindal/laravel-markdown/tree/1.1)      |
| 5.2             | [1.0](https://github.com/andreasindal/laravel-markdown/tree/1.0)      |

## Installation

To install it, simply pull it down with Composer. Run the `php artisan vendor:publish` command to publish the configuration file.

    composer require andreasindal/laravel-markdown:"3.2.1"

Laravel 5.5 and above use Package Auto-Discovery, so you do not have to manually add the MarkdownServiceProvider.

## Usage

### Blade-directive

The markdown parser may be used in your Blade templates by using the `@markdown` directive.

```html
<article>
    <h1>{{ $post->title }}</h1>

    <section class="content">
        @markdown($post->body)
    </section>
</article>
```

You can also use a block-style syntax:

```markdown
@markdown
# Hello world

This *text* will be **parsed** to [HTML](http://laravel.com).
@endmarkdown
```

### Facade

If you registered the Markdown facade as shown above, you can easily parse markdown using it.

```php
$markdown = "# Hello";

$html = Markdown::parse($markdown) // <h1>Hello</h1>
```

### Helper-functions

```php
$html = markdown('# Hello'); // <h1>Hello</h1>
```

```php
$html = markdown_capture(function () {
    echo "# Hello";
    echo "\n\n";
    echo "So **cool**!"
});

// <h1>Hello</h1>
// <p>So <b>cool</b>!</p>
```

---

Of course, you could also resolve the parser from the service container and use it yourself.

```php
$parser = app('Indal\Markdown\Parser');
$html = $parser->parse('# Hello'); // <h1>Hello</h1>

```

### Drivers (NEW!)

Laravel-Markdown allows you to add custom markdown drivers. In order to use a custom markdown driver, you need to create a class that implements the `Indal\Markdown\Drivers\MarkdownDriver` interface. The interface contains two methods: `text` and `line`. `text` is used to convert a block of markdown to HTML, while `line` is used to convert a single line.

Laravel-Markdown ships with a `ParsedownDriver` using the [Parsedown-package](http://parsedown.org/) by @erusev.


## Credits

* Mohamed Said [(@themsaid)](https://github.com/themsaid)

## License

Licensed under MIT. For more information, see the [LICENSE-file](https://github.com/andreasindal/laravel-markdown/blob/master/LICENSE).
