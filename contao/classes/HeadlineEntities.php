<?php
namespace Cnctoolshop\Classes;

class HeadlineEntities
{
    public static function convertEntities($headline): string
    {
        if (!is_string($headline)) {
            return '';
        }

        // Map of custom tags to HTML
        $replacements = [
            '[br]' => '<br>',
        ];
        
        // Simple string replacements
        $headline = str_replace(
            array_keys($replacements), 
            array_values($replacements), 
            $headline
        );
        
        // Regex patterns for tags with content
        $patterns = [
            '/\[h\](.*?)\[\/h\]/is'    => '<span class="heading-highlight">$1</span>',
            '/\[bold\](.*?)\[\/bold\]/is' => '<strong>$1</strong>',
        ];
        
        foreach ($patterns as $pattern => $replacement) {
            $headline = preg_replace($pattern, $replacement, $headline);
        }
        
        return $headline;
    }
}