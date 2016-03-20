# Laravel-Markdown

A small, lightweight and easy-to-use Laravel package for handling markdown. It comes with a facade, a helper function and a Blade directive to make life easier for you.

This package utilizes the [Parsedown-package](http://parsedown.org/) by @erusev.

## Installation

To install it, simply pull it down with Composer. Run the `php artisan vendor:publish` command to publish the configuration file.

    composer require andreasindal/laravel-markdown

All you have to do is to reference the service provider under the `'providers'` array in your `config/app.php` file. If you want to use the facade as well, include a reference under the `'aliases'` array in the same file.

```php
// config/app.php

'providers' => [
    // ...
    
    Indal\Markdown\MarkdownServiceProvider::class,

    // ...
];

'aliases' => [
    // ...
    
    'Markdown' => Indal\Markdown\Facade::class,

    // ...
];
```

## Configuration

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

## License

Licensed under MIT. For more information, see the [LICENSE-file](https://github.com/andreasindal/laravel-markdown/blob/master/LICENSE).