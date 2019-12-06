<?php


namespace App\Controller\Form;


use App\Controller\Form;
use App\Validation\Form\ChainOfResponsibility\EmptyField;
use App\Validation\Form\ChainOfResponsibility\Length;
use App\Validation\Form\ChainOfResponsibility\ValidEmail;

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