<?php


namespace App\Model;


class Group extends AbstractModel
{
    // ActiveRecord Association
    static $has_many = [
        ['memberships'],
        ['users', 'through' => 'memberships'],
    ];

    // ActiveRecord Validation
    static $validates_uniqueness_of = [
        ['name'],
    ];
}