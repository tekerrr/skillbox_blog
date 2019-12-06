<?php


namespace App\Model;


use ActiveRecord\Model;
use App\Formatter\RusDate;

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
            $attributes['create_time'] = (new RusDate())->format($attributes['create_time']);
        }

        return $attributes;
    }
}