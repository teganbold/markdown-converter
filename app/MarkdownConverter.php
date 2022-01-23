<?php
/**
 * Markdown to HTML conveter
 *
 * Simple converter to change markdown to html. It currently onlt account for links,
 * paragraphs, and headers, but it can easily be extended to account for more tags.
 *
 * @author     Tegan Bold
 * @author     tegan.bold@gmail.com
 */

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

        $htmlOutput = '';
        $activeParagraph = false;

        if ($this->hasMarkdown($markdown) === false) {
            return $this->markdown->toHtml($markdown, 'p');
        }

        $linedMarkdown = $this->markdown->sliceMultiLineMarkdown($markdown);
        $activeParagraph = false;

        foreach ($linedMarkdown as $index => $line) {
            if($index > 0) {
                $htmlOutput .= "\n";
            }

            if($line != '') {
                $linkStrippedLine = $this->tag->convertHyperlinkToHtml($line);
                $markdownTags = $this->getMarkdownTagDataset();
                $foundTags = $this->markdown->findMarkdown($markdownTags, $linkStrippedLine);
                if($foundTags) {
                    $htmlOutput .= $this->markdown->toHtml($this->markdown->removeMarkdown($linkStrippedLine), $foundTags['htmlEntity']);
                } else {
                    if($activeParagraph === false) {
                        $htmlOutput .= $this->markdown->addHtmlTag('p');
                         $activeParagraph = true;
                    }
                    $htmlOutput .= $linkStrippedLine;
                    if($line == end($linedMarkdown) || $linedMarkdown[$index + 1] == '') {
                        $htmlOutput .= $this->markdown->addHtmlTag('p', 'close');
                        $activeParagraph = false;
                    }
                }
            }
        }

        return $htmlOutput;
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
    private function getMarkdownTagDataset(): array {
        if(!$this->markdownTags) {
            $this->markdownTags = $this->model->getAllMarkdownTags();
        }

        return $this->markdownTags;
    }

}