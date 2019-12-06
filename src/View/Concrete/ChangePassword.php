<?php


namespace App\View\Concrete;

use App\View\View;

/**
 * optional config:
 *
 * Class ChangePassword
 * @package App\View\Concrete
 */
class ChangePassword extends AbstractConcreteView
{
    public function __construct()
    {
        $this->setView(new View('change_password', ['title' => 'Смена пароля']));
    }
}