<?php

namespace App;

use App\Api\MarkdownConverterInterface as Converter;
use App\Controller\Markdown;
use App\Controller\Tag;
use App\Model\MarkdownData as Model;

class MarkdownConverter implements Converter
{
    public $htmlMarkupOutput = '';

    /**
     * Manually instantiate Model and Controller (with model as a dependency)
     */
    public function __construct() {
        $this->model = new Model();
        $this->markdown = new Markdown($this->model);
        $this->tag = new Tag();
    }

    /**
     * Takes any string and will convert it to html. If there is nothing
     * that the app sees as markdown, it will wrap the entire string in a
     * paragraph html entity.
     * 
     * @param  string $markdown: String to be converted to html
     * @return html output
     */
    public function convert(string $markdown): string {
        if ($markdown == '') {
            return 'Please enter text to be converted, nothing given.';
        }

        if ($this->hasMarkdown($markdown) === false) {
            $this->htmlMarkupOutput .= $this->markdown->toHtml($markdown, 'p');
            return $this->htmlMarkupOutput;
        }

        if($this->tag->hasHyperlink($markdown)) {
            $this->htmlMarkupOutput .= $this->tag->convertHyperlinkToHtml($markdown);
        } else {
            $this->htmlMarkupOutput .= $this->markdown->toHtml($this->markdown->removeMarkdown($markdown), 'h1');
        }

        return $this->htmlMarkupOutput;
    }

    /**
     * Check to see if the given string has any markdown tags.
     *
     * @param  string $markdown
     * @return boolean
     */
    public function hasMarkdown(string $markdown): bool {
        $markdownTags = $this->model->getAllMarkdownTags();
        $count = 0;
        str_replace($markdownTags, '', $markdown, $count);

        if($count > 0 || $this->tag->hasHyperlink($markdown)) {
            return true;
        }

        return false;
    }
}