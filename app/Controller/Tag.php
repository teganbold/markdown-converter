<?php

namespace App\Controller;

class Tag
{
    const LINK_REGEX = "/\[([^]]*)\] *\(([^)]*)\)/i";

    /**
     * Check if string has hyperlink, with url prefixed with 'https://'
     * 
     * @param  string $snippet
     * @return boolean
     */
    public function hasHyperlink(string $snippet): bool {
        $linkMatch = preg_match(self::LINK_REGEX, $snippet);

        if($linkMatch) {
            return true;
        }

        return false;
    }

    /**
     * Use regex to convert markdown link to a href tag
     * 
     * @param  string @snippet
     * @return string
     */
    public function convertHyperlinkToHtml(string $snippet): string {
        if (!$this->hasHyperlink($snippet)) {
            return $snippet;
        }

        return preg_replace(self::LINK_REGEX, '<a href="$2">$1</a>', $snippet);
    }
}
