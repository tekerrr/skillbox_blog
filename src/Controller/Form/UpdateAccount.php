<?php


namespace App\Controller\Form;


use App\Controller\Checker\ChainOfResponsibility\EmptyField;
use App\Controller\Checker\ChainOfResponsibility\Length;
use App\Controller\Checker\ChainOfResponsibility\UniqueFieldContent;
use App\Controller\Checker\ChainOfResponsibility\ValidEmail;
use App\Controller\Form;

class UpdateAccount extends Form
{
    public function __construct()
    {
        $emailChecker = (new EmptyField('email'))->setErrorMessage('Введите email');
        $emailChecker->setNext(new Length())->setNext(new ValidEmail());
        $emailChecker->setNext((new UniqueFieldContent())->setErrorMessage('Данный email уже используется'));

        $nameChecker = (new EmptyField('name'))->setErrorMessage('Введи имя');
        $nameChecker->setNext(new Length());
        $nameChecker->setNext((new UniqueFieldContent())->setErrorMessage('Данное имя уже используется'));

        $this->setCheckableItems([
            $emailChecker,
            $nameChecker,
        ]);
    }
}