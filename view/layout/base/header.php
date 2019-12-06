<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

        <title><?=$title ?? 'Title'?></title>
    </head>
    <body>
        <div class="container">
            <p><a href="?/">Ссылка: ?/ - callback вида: return 'index'</a></p>
            <p><a href="?/indexString">Ссылка: ?/indexString - class_name@method</a></p>
            <p><a href="?/aboutString">Ссылка: ?/aboutString - class_name@method</a></p>
            <p><a href="?/wrongAboutString">Ссылка: ?/wrongAboutString - class_name@method (метод не существует)</a></p>
            <p><a href="?/index">Ссылка: ?/index - callback вида: return new View/View(index)</a></p>
            <p><a href="?/test">Ссылка: ?/test - callback вида: return new View/View(test.index)</a></p>
            <p><a href="?/test2">Ссылка: ?/test 2- callback вида: return new View/View(test.test2.index)</a></p>
            <p><a href="?/404">Ссылка: ?/404 - путь к несуществующей странице</a></p>
            <p><a href="?/test404">Ссылка: ?/test404 - несуществующий путь</a></p>
            <p><a href="?/test3/12331Abc/">Ссылка: ?/test3/*/</a></p>
            <p><a href="?/test4/12331Abc/aaa">Ссылка: ?/test4/*/*</a></p>
            <p><a href="?/test5/12331Abc/aaa">Ссылка: ?/test5/*/* - Test Page With param</a></p>
            <p><a href="?/book">Ссылка: ?/book - библиотека ActiveRecord</a></p>
