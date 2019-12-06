<?php


namespace App\Controller\Form;


use App\Controller\Checker\ChainOfResponsibility\EmptyField;
use App\Controller\Checker\ChainOfResponsibility\MatchFields;
use App\Controller\Form;

class ChangePassword extends Form
{
    public function __construct()
    {
        $passwordChecker = (new EmptyField('password'))->setErrorMessage('Введите старый пароль');
        $newPasswordChecker = (new EmptyField('new_password'))->setErrorMessage('Введите новый пароль');

        $newPassword2Checker = (new EmptyField('new_password2'))->setErrorMessage('Повторите пароль');
        $matchChecker = (new MatchFields())->setErrorMessage('Пароль не совпадает');
        $matchChecker->setReferenceFieldName('new_password');
        $newPassword2Checker->setNext($matchChecker);

        $this->setCheckableItems([
            $passwordChecker,
            $newPasswordChecker,
            $newPassword2Checker,
        ]);
    }
}