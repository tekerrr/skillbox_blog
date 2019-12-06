<?php


namespace App\Controller\Form;


use App\Controller\Checker\ChainOfResponsibility\EmptyField;
use App\Controller\Checker\ChainOfResponsibility\NaturalNumber;
use App\Controller\Form;

class EditAdminSettings extends Form
{
    public function __construct()
    {
        $articlesPerPageChecker = (new EmptyField('articles_per_page'))->setErrorMessage('Введите число');
        $articlesPerPageChecker->setNext(new NaturalNumber());

        $this->setCheckableItem($articlesPerPageChecker);
    }
}