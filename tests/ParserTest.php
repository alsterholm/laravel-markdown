<?php

use Indal\Markdown\Parser;

class ParserTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_transforms_markdown_into_html()
    {
        $parser = new Parser(new Parsedown);

        $html = $parser->parse("# Hello");
        $this->assertEquals("<h1>Hello</h1>", $html);
    }

    /** @test */
    function it_can_transform_inlined_markdown_to_html()
    {
        $parser = new Parser(new Parsedown);

        $html = $parser->line("**Hello**");
        $this->assertEquals("<strong>Hello</strong>", $html);
    }

    /** @test */
    function it_returns_an_empty_string_when_trying_to_parse_an_empty_string()
    {
        $parser = new Parser(new Parsedown);
        
        $this->assertEquals('', $parser->parse(''));
    }

    /** @test */
    public function it_transforms_a_block_of_markdown_into_html()
    {
        $parser = new Parser(new Parsedown);

        $parser->begin();
        echo "# Hello\n";
        echo "This text is **bold**!";
        $html = $parser->end();

        $this->assertEquals("<h1>Hello</h1>\n<p>This text is <strong>bold</strong>!</p>", $html);
    }

    /** @test */
    public function it_removes_javascript_from_links()
    {
        $parser = new Parser(new Parsedown);

        $html = $parser->parse("[Link](javascript:alert('xss'))");

        $this->assertEquals("<p><a href=\"#\">Link</a></p>", $html);
    }

    /** @test */
    function it_removes_leading_white_space()
    {
        $parser = new Parser(new Parsedown);

        $markdown = "
            This is **not** code.

                This is code.
        ";

        $html = $parser->parse($markdown);

        $this->assertEquals(
            "<p>This is <strong>not</strong> code.</p>\n<pre><code>This is code.</code></pre>",
            $html
        );
    }
}

function config() { return true; }