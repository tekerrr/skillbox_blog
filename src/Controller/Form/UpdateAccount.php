<?php


namespace App\Controller\Form;


use App\Controller\Form;
use App\Validation\Rules\EmptyField;
use App\Validation\Rules\Length;
use App\Validation\Rules\UniqueFieldContent;
use App\Validation\Rules\ValidEmail;

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