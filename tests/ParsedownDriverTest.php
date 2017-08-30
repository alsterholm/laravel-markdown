<?php

use PHPUnit\Framework\TestCase;
use Indal\Markdown\Drivers\ParsedownDriver;

class ParsedownDriverTest extends TestCase
{
    /** @test */
    public function it_transforms_markdown_into_html()
    {
        $parser = new ParsedownDriver([]);

        $html = $parser->text("# Hello");
        $this->assertEquals("<h1>Hello</h1>", $html);
    }

    /** @test */
    function it_can_transform_inlined_markdown_to_html()
    {
        $parser = new ParsedownDriver([]);

        $html = $parser->line("**Hello**");
        $this->assertEquals("<strong>Hello</strong>", $html);
    }

    /** @test */
    function it_returns_an_empty_string_when_trying_to_parse_an_empty_string()
    {
        $parser = new ParsedownDriver([]);
        
        $this->assertEquals('', $parser->text(''));
    }
}