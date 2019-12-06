<?php


namespace App\Controller\Form;


use App\Controller\Form;
use App\Validation\Form\ChainOfResponsibility\EmptyField;
use App\Validation\Form\ChainOfResponsibility\Length;
use App\Validation\Form\ChainOfResponsibility\ValidEmail;

class Subscribe extends Form
{
    public function __construct()
    {
        $emailChecker = (new EmptyField('email'))->setErrorMessage('Введите email');
        $emailChecker->setNext(new Length())->setNext(new ValidEmail());

        $this->setCheckableItem($emailChecker);
    }
}