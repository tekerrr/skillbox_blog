<?php


namespace App\Controller\Form;


use App\Controller\Form;
use App\Validation\Rules\EmptyField;
use App\Validation\Rules\Length;
use App\Validation\Rules\ValidEmail;

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