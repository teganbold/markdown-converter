<?php

namespace App\Api;

interface MarkdownConverterInterface
{
    public function convert(string $markdown);
}