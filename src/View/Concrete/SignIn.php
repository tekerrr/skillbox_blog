<?php


namespace App\View\Concrete;

use App\View\View;

/**
 * optional config:
 *      $status, $message: email, password
 *      $error
 *
 * Class SignIn
 * @package App\View\Concrete
 */
class SignIn extends AbstractConcreteView
{
    public function __construct()
    {
        $this->setView(new View('sign_in', ['title' => 'Авторизация']));
    }
}