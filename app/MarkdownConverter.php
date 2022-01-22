<?php

namespace App;
use App\Api\MarkdownConverterInterface as Converter;

class MarkdownConverter implements Converter
{
    public function convert(string $markdown): string {
        return $markdown;
    }

}