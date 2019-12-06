<?php


namespace App\Http;


use App\Formatter\Path;
use App\Renderable;
use App\View\View;

class Response implements Renderable
{
    protected $code;
    protected $redirect = '';

    /*** @var Renderable */
    protected $view;

    public static function redirect(string $path = ''): Renderable
    {
        $response = new self();
        $response->code = 303;
        $response->redirect = (new Path())->format($path);

        return $response;
    }

    public static function redirectBack(): Renderable
    {
        return self::redirect(Request::getRequestUri());
    }

    public function render()
    {
        if ($this->code) {
            http_response_code($this->code);
        }

        if ($this->view instanceof Renderable) {
            $this->view->render();
        } else {
            header('Location: ' . $this->redirect);
        }
    }
}