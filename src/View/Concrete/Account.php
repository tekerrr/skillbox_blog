<?php


namespace App\View\Concrete;


use App\Controller\Auth;
use App\View\View;

/**
 * optional config:
 *      $errorAlerts
 *      $status, $message: email, name
 *
 * Class Account
 * @package App\View\Concrete
 */
class Account extends AbstractConcreteView
{
    public function __construct()
    {
        $this->setView(new View('account', [
            'title' => 'Личный кабинет',
            'user' => Auth::getInstance()->get('user'),
            'sub'  => Auth::getInstance()->get('sub'),
        ]));
    }
}