<?php

namespace App\Model;

class MarkdownData
{
    const TAG_H          = '#';
    const TAG_H2         = '##';
    const TAG_H3         = '###';
    const TAG_H4         = '####';
    const TAG_H5         = '#####';
    const TAG_H6         = '######';
    const TAG_STRONG     = '*';
    const TAG_EMPHASIS   = '**';
    const TAG_BLOCKQUOTE = '>';
    const TAG_CODE       = '`';

    const TAG_UNORDEREDLIST = ['-', '*', '_'];

    /**
     *  Manually collect all markdown tags from the constants decalred
     *  in the class
     *
     * @param  $includeSpacer: optional flag to include a space. This is a bit
     *         hacky but useful for account for user inputs
     * @return array
     */
    public function getAllMarkdownTags($includeSpacer = false) {
        $spacer = '';
        if ($includeSpacer) {
            $spacer = ' ';
        }

        return [
            'h1' => self::TAG_H . $spacer,
            'h2' => self::TAG_H . $spacer,
            'h3' => self::TAG_H . $spacer,
            'h4' => self::TAG_H . $spacer,
            'h5' => self::TAG_H . $spacer,
            'h6' => self::TAG_H . $spacer,
            'strong' =>self::TAG_STRONG . $spacer,
            'em' => self::TAG_EMPHASIS . $spacer,
            'blockquote' => self::TAG_BLOCKQUOTE . $spacer,
            'pre' => self::TAG_CODE . $spacer
        ];
    }
}