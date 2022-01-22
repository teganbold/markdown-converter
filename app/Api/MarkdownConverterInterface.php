<?php

namespace App\Api;

interface MarkdownConverterInterface
{
    /**
     * @param  string $markdown
     */
    public function convert(string $markdown);
}