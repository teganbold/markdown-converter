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
    public function testsReturnsString() {
        $this->assertIsString($this->markdownConverter->convert('test'));
    }
}