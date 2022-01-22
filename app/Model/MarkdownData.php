<?php

namespace App\Model;

class MarkdownData
{
    const TAG_H          = '#';
    const TAG_BOLD       = '*';
    const TAG_ITALICS    = '**';
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
            self::TAG_H . $spacer,
            self::TAG_BOLD . $spacer,
            self::TAG_ITALICS . $spacer,
            self::TAG_BLOCKQUOTE . $spacer,
            self::TAG_CODE . $spacer
        ];
    }
}