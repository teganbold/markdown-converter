<?php

namespace App\Model;

class MarkdownData
{
    const TAG_H1         = '#';
    const TAG_H2         = '##';
    const TAG_H3         = '###';
    const TAG_H4         = '####';
    const TAG_H5         = '#####';
    const TAG_H6         = '######';
    const TAG_STRONG     = '*';
    const TAG_EMPHASIS   = '**';
    const TAG_CODE       = '`';

    /**
     *  Manually collect all markdown tags from the constants decalred
     *  in the class
     *
     * @param  $includeSpacer: optional flag to include a space. This is a bit
     *         hacky but useful for account for user inputs, to account for the
     *         edge case that user use or do no use the space.
     * @return array
     */
    public function getAllMarkdownTags($includeSpacer = false): array {
        $spacer = '';
        if ($includeSpacer) {
            $spacer = ' ';
        }

        return [
            'h1' => self::TAG_H1 . $spacer,
            'h2' => self::TAG_H2 . $spacer,
            'h3' => self::TAG_H3 . $spacer,
            'h4' => self::TAG_H4 . $spacer,
            'h5' => self::TAG_H5 . $spacer,
            'h6' => self::TAG_H6 . $spacer,
            'strong' =>self::TAG_STRONG . $spacer,
            'em' => self::TAG_EMPHASIS . $spacer,
            'pre' => self::TAG_CODE . $spacer
        ];
    }
}