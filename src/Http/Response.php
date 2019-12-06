<?php


namespace App\Http;


use App\Renderable;
use App\View\View;

class Response implements Renderable
{
    private $code;
    private $redirect = '';

    /*** @var Renderable */
    private $view;


    public static function notFound(): Renderable
    {
        $response = new self();
        $response->code = 404;
        $response->view = new View('404', ['title' => 'Ошибка 404']);

        return $response;
    }

    public static function forbidden(): Renderable
    {
        $response = new self();
        $response->code = 403;
        $response->view = new View('403', ['title' => 'Ошибка 403']);

        return $response;
    }

    public static function redirect(string $path = '')
    {
        $response = new self();
        $response->code = 303;
        $response->redirect = $path;

        return $response;
    }

    public function render()
    {
        if ($this->code) {
            http_response_code($this->code);
        }

        if ($this->view instanceof Renderable) {
            $this->view->render();
        } else {
            header('Location: /?' . $this->redirect);
        }
    }
}