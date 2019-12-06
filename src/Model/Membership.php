<?php


namespace App\Model;


class Membership extends AbstractModel
{
    // ActiveRecord table name
    static $table_name = 'group_user';

    // ActiveRecord Association
    static $belongs_to = [
        ['user'],
        ['group'],
    ];
}