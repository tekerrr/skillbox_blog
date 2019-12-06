<?php


namespace App\Exception;


use App\Renderable;
use App\View\Concrete\NotFound;

class NotFoundException extends HttpException implements Renderable
{
    public function render()
    {
        http_response_code(404);
        (new NotFound())->render();
    }
}