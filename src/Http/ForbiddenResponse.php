<?php


namespace App\Http;


use App\View\View;

class ForbiddenResponse extends Response
{
    public function __construct()
    {
        $this->code = 403;
        $this->view = new View('403', ['title' => 'Ошибка 403']);
    }
}