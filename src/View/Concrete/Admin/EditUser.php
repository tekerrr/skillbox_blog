<?php


namespace App\View\Concrete\Admin;


use App\Model\User;
use App\View\Concrete\AbstractConcreteView;
use App\View\View;

/**
 * optional config:
 *      $errorAlerts
 *      $status, $message: email, name
 *
 * Class EditUser
 * @package App\View\Concrete\Admin
 */
class EditUser extends AbstractConcreteView
{
    public function __construct($id)
    {
        $this->setView(new View('admin.edit.user', [
            'title' => 'Редактирование пользователя',
            'user' => User::findById($id)->attributes(),
        ]));
    }
}