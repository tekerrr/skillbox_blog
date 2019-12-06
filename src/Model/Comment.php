<?php


namespace App\Model;


use ActiveRecord\DateTime;

class Comment extends AbstractModel
{
    use CanBeListed;

    // ActiveRecord Association
    static $belongs_to = [
        ['user'],
        ['article'],
    ];

    public static function add(string $user_id, string $article_id, string $text, bool $active = false): self
    {
        return self::create([
            'user_id'       => $user_id,
            'article_id'    => $article_id,
            'text'          => $text,
            'active'        => $active,
            'create_time'   => (new DateTime()),
        ]);
    }
}