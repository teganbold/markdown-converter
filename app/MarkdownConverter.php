<?php

namespace App;

use App\Api\MarkdownConverterInterface as Converter;
use App\Controller\Markdown;
use App\Controller\Tag;
use App\Model\MarkdownData as Model;

class MarkdownConverter implements Converter
{
    private $markdownTags;

    /**
     * Manually instantiate Model and Controller (with model as a dependency)
     */
    public function __construct() {
        $this->model = new Model();
        $this->markdown = new Markdown($this->model);
        $this->tag = new Tag($this->model);
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

        $htmlMarkupOutput = '';

        if ($this->hasMarkdown($markdown) === false) {
            return $this->markdown->toHtml($markdown, 'p');
        }

        if($this->tag->hasHyperlink($markdown)) {
            $htmlMarkupOutput .= $this->tag->convertHyperlinkToHtml($markdown);
        } else {
            $markdownTags = $this->getMarkdownTagDataset();
            $foundTags = $this->markdown->findMarkdown($markdownTags, $markdown);
            $htmlMarkupOutput .= $this->markdown->toHtml($this->markdown->removeMarkdown($markdown), $foundTags['htmlEntity']);
        }

        return $htmlMarkupOutput;
    }

    /**
     * Check to see if the given string has any markdown tags.
     *
     * @param  string $markdown
     * @return boolean
     */
    public function hasMarkdown(string $markdown): bool {
        $markdownTags = $this->getMarkdownTagDataset();
        $count = 0;
        str_replace($markdownTags, '', $markdown, $count);

        if($count > 0 || $this->tag->hasHyperlink($markdown)) {
            return true;
        }

        return false;
    }

    /**
     * Get the cached dataset of markdown tags
     *
     * @return App\Model\MarkdownData::Array
     */
    private function getMarkdownTagDataset() {
        if(!$this->markdownTags) {
            $this->markdownTags = $this->model->getAllMarkdownTags();
        }

        return $this->markdownTags;
    }

}