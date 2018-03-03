<?php

use Indal\Markdown\Parser;
use PHPUnit\Framework\TestCase;
use Indal\Markdown\Drivers\MarkdownDriver;

class ParserTest extends TestCase
{
    /** @test */
    public function it_transforms_markdown_into_html()
    {
        $mock = Mockery::mock(MarkdownDriver::class);
        $parser = new Parser($mock);

        $mock->shouldReceive('text')->with('# Hello')->andReturn("<h1>Hello</h1>");

        $html = $parser->parse("# Hello");
        $this->assertEquals("<h1>Hello</h1>", $html);
    }

    /** @test */
    function it_can_transform_inlined_markdown_to_html()
    {
        $mock = Mockery::mock(MarkdownDriver::class);
        $parser = new Parser($mock);

        $mock->shouldReceive('line')->with("**Hello**")->andReturn("<strong>Hello</strong>");
        $html = $parser->line("**Hello**");
        $this->assertEquals("<strong>Hello</strong>", $html);
    }

    /** @test */
    function it_returns_an_empty_string_when_trying_to_parse_an_empty_string()
    {
        $mock = Mockery::mock(MarkdownDriver::class);
        $parser = new Parser($mock);

        $mock->shouldNotReceive('text');
        $mock->shouldNotReceive('line');
        
        $this->assertEquals('', $parser->parse(''));
    }

    /** @test */
    public function it_transforms_a_block_of_markdown_into_html()
    {
        $mock = Mockery::mock(MarkdownDriver::class);
        $parser = new Parser($mock);

        $mock->shouldReceive('text')->with("# Hello\nThis text is **bold**!")
                ->andReturn("<h1>Hello</h1>\n<p>This text is <strong>bold</strong>!</p>");

        $parser->begin();
        echo "# Hello\n";
        echo "This text is **bold**!";
        $html = $parser->end();

        $this->assertEquals("<h1>Hello</h1>\n<p>This text is <strong>bold</strong>!</p>", $html);
    }

    /** @test */
    public function it_removes_javascript_from_links()
    {
        $mock = Mockery::mock(MarkdownDriver::class);
        $parser = new Parser($mock);

        $mock->shouldReceive('text')->with("[Link](#)")->andReturn("<p><a href=\"#\">Link</a></p>");

        $html = $parser->parse("[Link](javascript:alert('xss'))");

        $this->assertEquals("<p><a href=\"#\">Link</a></p>", $html);
    }

    /** @test */
    function it_removes_leading_white_space()
    {
        $mock = Mockery::mock(MarkdownDriver::class);
        $parser = new Parser($mock);

        $markdown = "
            This is **not** code.

                This is code.
        ";

        $mock->shouldReceive('text')->with("\nThis is **not** code.\n\n    This is code.\n        ")
                ->andReturn("<p>This is <strong>not</strong> code.</p>\n<pre><code>This is code.</code></pre>");

        $html = $parser->parse($markdown);

        $this->assertEquals(
            "<p>This is <strong>not</strong> code.</p>\n<pre><code>This is code.</code></pre>",
            $html
        );
    }

    /** @test */
    function driver_can_be_changed()
    {
        $mock = Mockery::mock(MarkdownDriver::class);
        $parser = new Parser($mock);

        $mock->shouldReceive('text')->with('# Hello')->andReturn("<h1>Hello</h1>");

        $html = $parser->parse("# Hello");
        $this->assertEquals("<h1>Hello</h1>", $html);

        $parser->setDriver(new class implements \Indal\Markdown\Drivers\MarkdownDriver {
            function text($text) {
                return "<p>$text :)</p>";
            }
            function line($text) {
                return "$text :)";
            }
        });

        $lolText = $parser->parse("Hello");
        $this->assertEquals("<p>Hello :)</p>", $lolText);

        $lolText = $parser->line("Hello");
        $this->assertEquals("Hello :)", $lolText);
    }
}

function config() { return true; }