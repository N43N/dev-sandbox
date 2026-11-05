<?php

namespace App\Helpers;

use League\CommonMark\GithubFlavoredMarkdownConverter;

class MarkdownHelper
{
    /**
     * Convert raw markdown text into safe HTML strings.
     */
    public static function parse(?string $text): string
    {
        if (empty($text)) {
            return '';
        }

        // Uses GitHub-Flavored Markdown guidelines (tables, task lists, auto-linking)
        $converter = new GithubFlavoredMarkdownConverter([
            'html_input' => 'strip', // 🛡️ Security Gate: Strips raw HTML tags to prevent XSS attacks
            'allow_native_attributes' => false,
        ]);

        return $converter->convert($text)->getContent();
    }
}
