<?php


namespace App\Formatter;


class Paragraph
{
    public function format(string $text): string
    {
        $text = trim($text);

       if (strpos($text, '<p>') !== 0) {
            $text = '<p>' . $text;
        }

        if (strpos($text, '</p>') !== (strlen($text) - strlen('</p>'))) {
            $text = $text . '</p>';
        }

        return str_replace(PHP_EOL, '<p>' . PHP_EOL . '<p>', $text);
    }
}