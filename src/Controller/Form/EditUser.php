<?php


namespace App\Controller\Form;


use App\Controller\Form;
use App\Validation\Rules\EmptyField;
use App\Validation\Rules\Length;
use App\Validation\Rules\UniqueFieldContent;
use App\Validation\Rules\ValidEmail;

class EditUser extends Form
{
    public function __construct($id)
    {
        $emailChecker = (new EmptyField('email'))->setErrorMessage('Введите email');
        $emailChecker->setNext(new Length())->setNext(new ValidEmail());
        $uniqueEmail = (new UniqueFieldContent())->setErrorMessage('Данный email уже используется');
        $uniqueEmail->setForAnotherUser($id);
        $emailChecker->setNext($uniqueEmail);

        $nameChecker = (new EmptyField('name'))->setErrorMessage('Введи имя');
        $nameChecker->setNext(new Length());
        $uniqueName = (new UniqueFieldContent())->setErrorMessage('Данное имя уже используется');
        $uniqueName->setForAnotherUser($id);
        $nameChecker->setNext($uniqueName);

        $this->setCheckableItems([
            $emailChecker,
            $nameChecker,
        ]);
    }
}