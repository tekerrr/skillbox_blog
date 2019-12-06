<?php


namespace App\Formatter;


class RusDate
{
    public function format(\DateTime $dateTime, bool $withHours = true): string
    {
        $date = $dateTime->format('Y-m-d H:i:s');
        $yy = (int) substr($date, 0,4);
        $mm = (int) substr($date, 5,2);
        $dd = (int) substr($date, 8,2);

        if ($withHours) {
            $hours = ' ' . substr($date,11,5);
        }

        $month =  ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня',
            'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'];

        return $dd . ' ' . $month[$mm - 1]. ' ' . $yy . ' г.' . $hours;
    }
}