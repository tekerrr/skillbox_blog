<?php


namespace App\Formatter;


class Paragraph
{
    public function format(string $string): string
    {
        $string = trim($string);

       if (strpos($string, '<p>') !== 0) {
            $string = '<p>' . $string;
        }

        if (strpos($string, '</p>') !== (strlen($string) - strlen('</p>'))) {
            $string = $string . '</p>';
        }

        return str_replace(PHP_EOL, '<p>' . PHP_EOL . '<p>', $string);
    }
}