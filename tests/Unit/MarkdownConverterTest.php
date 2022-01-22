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
    public function testReturnsString() {
        $this->assertIsString($this->markdownConverter->convert('test'));
    }

    /**
     * @test
     */
    public function testParagraphWrap() {
        $this->assertEquals('<p>test</p>', $this->markdownConverter->convert('test'));
    }

    /**
     * @test
     */
    public function testH1WithoutSpace() {
        $this->assertEquals('<h1>H1 Tag</h1>', $this->markdownConverter->convert('#H1 Tag'));
    }

    /**
     * @test
     */
    public function testH1WithSpace() {
        $this->assertEquals('<h1>H1 Tag</h1>', $this->markdownConverter->convert('# H1 Tag'));
    }
    /**
     * @test
     */
    public function testAllHTags() {
        for ($i = 1; $i < 7; $i++) {
            $markdown = str_repeat('#', $i);
            $this->assertEquals('<h' . $i . '>HeaderTags</h' . $i . '>', $this->markdownConverter->convert($markdown . ' HeaderTags'));
        }
    }

    /**
     * @test
     */
    public function testHyperlink() {
        $googleMarkdown = '[Google](https://google.com)';
        $googleHtml = '<a href="https://google.com">Google</a>';
        $this->assertEquals('<p>' . $googleHtml . '</p>', $this->markdownConverter->convert($googleMarkdown));
    }

    /**
     * @test
     */
    public function testInlineHyperlink() {
        $googleMarkdown = '[Google](https://google.com)';
        $googleHtml = '<a href="https://google.com">Google</a>';
        $this->assertEquals('<p>Search for it on ' . $googleHtml . ' to find out more information.</p>', $this->markdownConverter->convert('Search for it on ' . $googleMarkdown . ' to find out more information.'));
    }

    /**
     * @test
     */
    public function testHeaderwithLink() {
        $googleMarkdown = '# Check us out with [Google](https://google.com)';
        $googleHtml = '<h1>Check us out with <a href="https://google.com">Google</a></h1>';
        $this->assertEquals($googleHtml, $this->markdownConverter->convert($googleMarkdown));
    }

    /**
     * @test
     */
    public function testMailchimpFirstInput() {
        $mailchimpMarkdown = <<<EOD
            # Sample Document

            Hello!

            This is sample markdown for the [Mailchimp](https://www.mailchimp.com) homework assignment.
        EOD;
        $mailchimpHtml = <<<EOD
            <h1>Sample Document</h1>

            <p>Hello</p>

            <p>This is sample markdown for the <a href="https://www.mailchimp.com">Mailchimp</a> homework assignment</p>
        EOD;
        $this->assertEquals($mailchimpHtml, $this->markdownConverter->convert($mailchimpMarkdown));
    }
}