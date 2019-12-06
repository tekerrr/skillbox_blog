<?php


namespace App\Http\Exception;


use App\Http\Exception;
use App\Http\NotFoundResponse as NotFoundResponse    ;
use App\Renderable;

class NotFound extends Exception implements Renderable
{
    public function render()
    {
        (new NotFoundResponse())->render();
    }
}