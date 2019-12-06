<?php


namespace App\Exception;


use App\Renderable;
use App\View\Concrete\Forbidden;

class ForbiddenException extends HttpException implements Renderable
{
    public function render()
    {
        http_response_code(403);
        (new Forbidden())->render();
    }
}