<?php


namespace App\Http\Exception;


use App\Http\Response;
use App\Renderable;

class NotFound extends \App\Http\Exception implements Renderable
{
    public function render()
    {
        Response::notFound()->render();
    }
}