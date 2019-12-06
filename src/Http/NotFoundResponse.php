<?php


namespace App\Http;


use App\View\View;

class NotFoundResponse extends Response
{
    public function __construct()
    {
        $this->code = 404;
        $this->view = new View('404', ['title' => 'Ошибка 404']);
    }
}