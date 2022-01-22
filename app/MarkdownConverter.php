<?php

namespace App;

use App\Api\MarkdownConverterInterface as Converter;

class MarkdownConverter implements Converter
{
    const TAG_H          = '#';
    const TAG_BOLD       = '*';
    const TAG_ITALICS    = '**';
    const TAG_BLOCKQUOTE = '>';
    const TAG_CODE       = '`';

    const TAG_UNORDEREDLIST = ['-', '*', '_'];

    public $htmlMarkupOutput = '';

    /**
     * Takes any string and will convert it to html. If there is nothing
     * that the app sees as markdown, it will wrap the entire string in a
     * paragraph html entity.
     * 
     * @param  string $markdown: String to be converted to html
     * @return html output
     */
    public function convert(string $markdown): string {
        if (strpos($markdown, self::TAG_H) !== false) {
            $this->htmlMarkupOutput .= $this->toHtml($this->removeMarkdown($markdown), 'h1');
        } else {
            $this->htmlMarkupOutput .= $this->toHtml($markdown, 'p');
        }

        return $this->htmlMarkupOutput;
    }

    /**
     *  Convert string to html snippet
     * 
     * @param  string $value: text to be wrapped inside the html tags
     * @param  string $htmlEntity: entity to use for the html tags
     * @param  string $htmlOptions:  [optional]
     * @return html snippet
     */
    public function toHtml(string $value, string $htmlEntity, string $htmlOptions = '') {
        return '<' . $htmlEntity . '>' . $value . '</' . $htmlEntity . '>';
    }

    /**
     *  Remove all instances of markdown code from a specified string. Along
     *  with logic in the tag getter, this method will account for markdown that
     *  both does and does not have the space after the tag.
     *  
     * @param  string $markdown: String to be stripped of tags
     * @return string
     */
    public function removeMarkdown(string $markdown) {
        $markDownTags =  '';

        //First Pass - Remove Tags with Spaces
        $markdown = str_replace($this->getAllMarkdownTags(true), '', $markdown);

        //First Pass - Remove Tags without Spaces
        $markdown = str_replace($this->getAllMarkdownTags(), '', $markdown);

        return $markdown;
    }

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