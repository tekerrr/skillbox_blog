<?php


namespace App\Controller\Controller\Special;


use App\Controller\Controller\AbstractController;
use App\Renderable;
use App\View\View;

class Message extends AbstractController
{
    /*** @var View */
    private $view;


    public function __construct(string $title, string $header, string $message)
    {
        $this->view = new View('message', [
            'title'     => $title,
            'header'    => $header,
            'message'   => $message,
        ]);
    }

    public function getMessagePage(): Renderable
    {
        return $this->view;
    }

    public function setReturnPath(string $path, string $name = 'Вернуться'): void
    {
        $this->getMessagePage()->addToConfig([
            'pathName'  => $name,
            'path'      => $path,
        ]);
    }

    public function setAdminHeader(): void
    {
        $this->getMessagePage()->addToConfig(['admin_header' => true]);
    }
}