<?php


namespace App\Formatter;


class Path
{
    public function format(string $string): string
    {
        return '/' . trim($string, ' /');
    }
}