<?php


namespace App\View\Concrete;

use App\View\View;

/**
 * optional config:
 *      $status, $message: email, name, password, password2, rules_agree
 *
 * Class SignUp
 * @package App\View\Concrete
 */
class SignUp extends AbstractConcreteView
{
    public function __construct()
    {
        $this->setView(new View('sign_up', ['title' => 'Регистарция']));
    }
}