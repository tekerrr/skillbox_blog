<?php


namespace App\Controller\Controller\Admin;


use App\Model;

abstract class AbstractController extends \App\Controller\Controller\AbstractController
{
    protected function getClassName(string $type, bool $singular = false): string
    {
        $classes = [
            'articles'      => Model\Article::class,
            'comments'      => Model\Comment::class,
            'static_pages'  => Model\StaticPage::class,
            'users'         => Model\User::class,
            'subscribers'   => Model\Subscriber::class,
        ];

        if ($singular) {
            $type .= 's';
        }

        return $classes[$type] ?? '';
    }

    protected function getTitle(string $className): string
    {
        $titles = [
            Model\Article::class    => 'Статьи',
            Model\Comment::class    => 'Комментарии',
            Model\StaticPage::class => 'Статичные страницы',
            Model\User::class       => 'Пользователи',
            Model\Subscriber::class => 'Подсписчики',
        ];

        return $title[$className] ?? '';
    }
}