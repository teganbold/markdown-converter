<?php

namespace App;

use App\Api\MarkdownConverterInterface as Converter;
use App\Controller\MarkdownLogic as Controller;
use App\Model\MarkdownData as Model;

class MarkdownConverter implements Converter
{
    public $htmlMarkupOutput = '';

    /**
     * Manually instantiate Model and Controller (with model as a dependency)
     */
    public function __construct() {
        $this->model = new Model();
        $this->controller = new Controller($this->model);
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
        if (strpos($markdown, Model::TAG_H) !== false) {
            $this->htmlMarkupOutput .= $this->controller->toHtml($this->controller->removeMarkdown($markdown), 'h1');
        } else {
            $this->htmlMarkupOutput .= $this->controller->toHtml($markdown, 'p');
        }

        return $this->htmlMarkupOutput;
    }
}