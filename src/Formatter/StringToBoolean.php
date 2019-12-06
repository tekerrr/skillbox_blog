<?php


namespace App\Formatter;


class StringToBoolean
{
    public function format(string $string): bool
    {
        return $string == 'true';
    }
}