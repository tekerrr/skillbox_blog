<?php


namespace App\Exception;


use App\Renderable;
use App\View\View;

class NotFoundException extends HttpException implements Renderable
{
    public function render()
    {
        http_response_code(404);
        (new View(HTTP_PAGE_404, ['title' => 'Страница не найдена']))->render();
    }
}