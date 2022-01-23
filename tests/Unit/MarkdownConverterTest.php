<?php

namespace Tests\Unit;

use App\MarkdownConverter;
use PHPUnit\Framework\TestCase;

class MarkdownConverterTest extends TestCase
{
    protected function setUp():void {
        $this->markdownConverter = new MarkdownConverter();
    }
    /**
     * @test
     */
    public function testReturnsString(): void {
        $this->assertIsString($this->markdownConverter->convert('test'));
    }

    /**
     * @test
     */
    public function testParagraphWrap(): void {
        $this->assertEquals('<p>test</p>', $this->markdownConverter->convert('test'));
    }

    /**
     * @test
     */
    public function testH1WithoutSpace(): void {
        $this->assertEquals('<h1>H1 Tag</h1>', $this->markdownConverter->convert('#H1 Tag'));
    }

    /**
     * @test
     */
    public function testH1WithSpace(): void {
        $this->assertEquals('<h1>H1 Tag</h1>', $this->markdownConverter->convert('# H1 Tag'));
    }
    /**
     * @test
     */
    public function testAllHTags(): void {
        for ($i = 1; $i < 7; $i++) {
            $markdown = str_repeat('#', $i);
            $this->assertEquals('<h' . $i . '>HeaderTags</h' . $i . '>', $this->markdownConverter->convert($markdown . ' HeaderTags'));
        }
    }

    /**
     * @test
     */
    public function testHyperlink(): void {
        $googleMarkdown = '[Google](https://google.com)';
        $googleHtml = '<a href="https://google.com">Google</a>';
        $this->assertEquals('<p>' . $googleHtml . '</p>', $this->markdownConverter->convert($googleMarkdown));
    }

    /**
     * @test
     */
    public function testInlineHyperlink(): void {
        $googleMarkdown = '[Google](https://google.com)';
        $googleHtml = '<a href="https://google.com">Google</a>';
        $this->assertEquals('<p>Search for it on ' . $googleHtml . ' to find out more information.</p>', $this->markdownConverter->convert('Search for it on ' . $googleMarkdown . ' to find out more information.'));
    }

    /**
     * @test
     */
    public function testHeaderwithLink(): void {
        $googleMarkdown = '# Check us out with [Google](https://google.com)';
        $googleHtml = '<h1>Check us out with <a href="https://google.com">Google</a></h1>';
        $this->assertEquals($googleHtml, $this->markdownConverter->convert($googleMarkdown));
    }

    /**
     * @test
     */
    public function testMailchimpFirstInput(): void {
        $mailchimpMarkdown = <<<EOD
        # Sample Document

        Hello!

        This is sample markdown for the [Mailchimp](https://www.mailchimp.com) homework assignment.
        EOD;
        $mailchimpHtml = <<<EOD
        <h1>Sample Document</h1>

        <p>Hello!</p>

        <p>This is sample markdown for the <a href="https://www.mailchimp.com">Mailchimp</a> homework assignment.</p>
        EOD;
        $this->assertEquals($mailchimpHtml, $this->markdownConverter->convert($mailchimpMarkdown));
    }

    /**
     * @test
     */
    public function testMailchimpSecondInput(): void {
        $mailchimpMarkdown = <<<EOD
        # Header one

        Hello there

        How are you?
        What's going on?

        ## Another Header

        This is a paragraph [with an inline link](http://google.com). Neat, eh?

        ## This is a header [with a link](http://yahoo.com)
        EOD;
        $mailchimpHtml = <<<EOD
        <h1>Header one</h1>

        <p>Hello there</p>

        <p>How are you?
        What's going on?</p>

        <h2>Another Header</h2>

        <p>This is a paragraph <a href="http://google.com">with an inline link</a>. Neat, eh?</p>

        <h2>This is a header <a href="http://yahoo.com">with a link</a></h2>
        EOD;
        $this->assertEquals($mailchimpHtml, $this->markdownConverter->convert($mailchimpMarkdown));
    }
}