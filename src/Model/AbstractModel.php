<?php


namespace App\Model;


use ActiveRecord\Model;

abstract class AbstractModel extends Model
{
    public static function getModelsAttributes($models): array
    {
        if (! is_array($models)) {
            return [];
        }

        $result = [];

        foreach ($models as $model) {
            if ($model instanceof AbstractModel) {
                $result[] = $model->attributes();
            }
        }

        return $result;
    }

    /**
     * @param string $id
     * @return mixed
     */
    public static function findById(string $id)
    {
        return static::first(['conditions' => ['id' => $id]]);
    }

    public function attributes(): array
    {
        $attributes = parent::attributes();

        if (isset($attributes['create_time']) && $attributes['create_time'] instanceof \DateTime) {
            $attributes['create_time'] = $this->getRusDate($attributes['create_time']);
        }

        return $attributes;
    }

    private function getRusDate(\DateTime $dateTime, bool $withHours = true)
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