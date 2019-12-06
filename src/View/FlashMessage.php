<?php


namespace App\View;


use App\Controller\Session;

class FlashMessage
{
    public function __construct(string $title, string $text, bool $error = false)
    {
        (new Session())->pushFlash('messages', ['title' => $title, 'text' => $text, 'error' => $error]);
    }
}