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
}