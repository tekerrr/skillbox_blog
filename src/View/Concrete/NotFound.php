<?php


namespace App\View\Concrete;


use App\View\View;

class NotFound extends AbstractConcreteView
{
    public function __construct()
    {
        $this->setView(new View('404', ['title' => 'Ошибка 404']));
    }
}