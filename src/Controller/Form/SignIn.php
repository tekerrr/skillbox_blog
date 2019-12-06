<?php


namespace App\Controller\Form;


use App\Controller\Checker\ChainOfResponsibility\EmptyField;
use App\Controller\Checker\ChainOfResponsibility\Length;
use App\Controller\Checker\ChainOfResponsibility\ValidEmail;
use App\Controller\Form;

class SignIn extends Form
{
    public function __construct()
    {
        $emailChecker = (new EmptyField('email'))->setErrorMessage('Введите email');
        $emailChecker->setNext(new Length())->setNext(new ValidEmail());

        $passwordChecker = (new EmptyField('password'))->setErrorMessage('Введите пароль');

        $this->setCheckableItem($emailChecker);
        $this->setCheckableItem($passwordChecker);
    }
}