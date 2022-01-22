<?php

namespace App\Controller;

use App\Model\MarkdownData as Model;

class Markdown
{
    /**
     * @param \App\Model\MarkdownData
     */
    public function __construct(\App\Model\MarkdownData $model) {
        $this->model = $model;
    }

    /**
     *  Convert string to html snippet
     * 
     * @param  string $value: text to be wrapped inside the html tags
     * @param  string $htmlEntity: entity to use for the html tags
     * @param  string $htmlOptions:  [optional]
     * @return html snippet
     */
    public function toHtml(string $value, string $htmlEntity, string $htmlOptions = ''): string {
        return '<' . $htmlEntity . '>' . $value . '</' . $htmlEntity . '>';
    }

    /**
     * Search the string for potential markdown, and return the html entity and markdown tag.
     * 
     * @param  array $tags: \app\Model\MarkdownData
     * @param  string $snippet: string to search
     * @return array
     */
    public function findMarkdown(array $tags, string $snippet): array {
        $matchedMarkdown = [];
        foreach($tags as $htmlEntity => $tag) {
            if(strpos($snippet, $tag) !== false) {
                $matchedMarkdown['htmlEntity'] = $htmlEntity;
                $matchedMarkdown['markdownTag'] = $tag;
            }
        }

        return $matchedMarkdown;
    }

    /**
     *  Remove all instances of markdown code from a specified string. Along
     *  with logic in the tag getter, this method will account for markdown that
     *  both does and does not have the space after the tag.
     *  
     * @param  string $markdown: String to be stripped of tags
     * @return string
     */
    public function removeMarkdown(string $markdown): string {
        $markDownTags =  '';

        //First Pass - Remove Tags with Spaces
        $markdown = str_replace($this->model->getAllMarkdownTags(true), '', $markdown);

        //First Pass - Remove Tags without Spaces
        $markdown = str_replace($this->model->getAllMarkdownTags(), '', $markdown);

        return $markdown;
    }
}