<?php


namespace App\View\Concrete;

use App\Router;
use App\View\View;

/**
 * optional config:
 *
 * Class Message
 * @package App\View\Concrete
 */
class Message extends AbstractConcreteView
{
    public function __construct(string $title, string $header, string $message)
    {
        $this->setView(new View('message', [
            'title'     => $title,
            'header'    => $header,
            'message'   => $message,
        ]));
    }

    public function setPathToReturn(string $path, string $name = 'Вернуться'): void
    {
        $this->addToConfig([
            'pathName'  => $name,
            'path'      => $path,
        ]);
    }

    public function setAdminHeader(): void
    {
        $this->addToConfig(['admin_header' => true]);
    }
}