<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/bootstrap.php';

$router = new \App\Router();

// Задание пути с помощью простой callback функции
$router->get('/', function() {
    return 'index';
});

// Задание пути с помощью вызова метода класса Controller
$router->get('/indexString',      \App\Controller::class . '@index');
$router->get('/aboutString',      \App\Controller::class . '@about');
$router->get('/wrongAboutString',      \App\Controller::class . '@wrongAbout');

// Задание пути с помощью callback функции, создающей экземпляр класса View
$router->get('/index', function() {
    return new \App\View\View('index', ['title' => 'Index Page']);
});
$router->get('/test', function() {
    return new \App\View\View('test.index', ['title' => 'Test']);
});
$router->get('/test2', function() {
    return new \App\View\View('test.test2.index', ['title' => 'Test2']);
});
$router->get('/404', function() {
    return new \App\View\View('unknown_page', ['title' => 'Unknown Page']);
});
$router->get('/test3/*/', function() {
    return new \App\View\View('test.index', ['title' => 'Test3']);
});
$router->get('/test4/*/*', function() {
    return new \App\View\View('test.index', ['title' => 'Test4']);
});
$router->get('/test5/*/*', function($param1, $param2) {
    return "Test Page With param1=$param1 param2=$param2";
});

// ActiveRecord
$router->get('/book', function() {
    ?><pre><?php
    // find and create
    $book = \App\DB\Book::find_by_name('Лабиринт отражений')
        ?? \App\DB\Book::create(['name' => 'Лабиринт отражений', 'author' => 'Лукьяненко']);
    echo 'Вывод одной записи:' . PHP_EOL;
    print_r($book->attributes());

    $book2 = \App\DB\Book::find_by_name('Фальшивые зеркала')
        ?? \App\DB\Book::create(['name' => 'Фальшивые зеркала', 'author' => 'Лукьяненко',]);

    echo PHP_EOL . 'Вывод всех записей:' . PHP_EOL;
    foreach (\App\DB\Book::all() as $book) {
        print_r($book->attributes());
    }

    // update
    $book->author = 'Лукьяненко С.В.';
    $book->year = '2000';
    $book->save();
    echo PHP_EOL . 'Вывод одной записи после update:' . PHP_EOL;
    print_r($book->attributes());

    // delete
    $book->delete();
    echo PHP_EOL . 'После удаления' . PHP_EOL;
    echo 'obj is still alive:' . PHP_EOL;
    print_r($book->attributes()); // obj is still alive
    echo 'but record is die:' . PHP_EOL;
    print_r(\App\DB\Book::find_by_name('Лабиринт отражений')); //null
    ?></pre><?php
});

//// tmp for 7.1
//$router->get('/index_test', function() {
//    return new \App\View\View('blog.index_test', ['title' => 'Index Page']);
//});
//$router->get('/auth', function() {
//    return new \App\View\View('blog.auth', ['title' => 'Авторизация']);
//});
//$router->get('/main', function() {
//    return new \App\View\View('blog.main', ['title' => 'Главная']);
//});
//$router->get('/article', function() {
//    return new \App\View\View('blog.article', ['title' => 'Статья']);
//});

$application = new \App\Application($router);

$application->run();
