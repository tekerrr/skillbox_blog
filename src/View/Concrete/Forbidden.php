<?php


namespace App\View\Concrete;


use App\View\View;

class Forbidden extends AbstractConcreteView
{
    public function __construct()
    {
        $this->setView(new View('403', ['title' => 'Ошибка 403']));
    }
}