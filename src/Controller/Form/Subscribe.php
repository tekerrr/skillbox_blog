<?php


namespace App\Controller\Form;


use App\Controller\Checker\ChainOfResponsibility\EmptyField;
use App\Controller\Checker\ChainOfResponsibility\Length;
use App\Controller\Checker\ChainOfResponsibility\ValidEmail;
use App\Controller\Form;

class Subscribe extends Form
{
    public function __construct()
    {
        $emailChecker = (new EmptyField('email'))->setErrorMessage('Введите email');
        $emailChecker->setNext(new Length())->setNext(new ValidEmail());

        $this->setCheckableItem($emailChecker);
    }
}