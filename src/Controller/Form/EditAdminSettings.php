<?php


namespace App\Controller\Form;


use App\Controller\Form;
use App\Validation\Rules\EmptyField;
use App\Validation\Rules\NaturalNumber;

class EditAdminSettings extends Form
{
    public function __construct()
    {
        $articlesPerPageChecker = (new EmptyField('articles_per_page'))->setErrorMessage('Введите число');
        $articlesPerPageChecker->setNext(new NaturalNumber());

        $this->setCheckableItem($articlesPerPageChecker);
    }
}