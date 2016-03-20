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
}

function config() { return true; }