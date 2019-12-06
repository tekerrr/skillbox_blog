<?php


namespace App\Controller\Form;


use App\Controller\Checker\ChainOfResponsibility\EmptyField;
use App\Controller\Checker\ChainOfResponsibility\Length;
use App\Controller\Form;

class EditArticle extends Form
{
    public function __construct()
    {
        $titleChecker = (new EmptyField('title'))->setErrorMessage('Введите заговолок статьи');
        $titleChecker->setNext((new Length())->setLength(100)->setErrorMessage('Не более 100 символов'));

        $abstractChecker = (new EmptyField('abstract'))->setErrorMessage('Ввыедите краткое описание статьи');
        $textChecker = (new EmptyField('text'))->setErrorMessage('Введите текст статьи');

        $this->setCheckableItems([
            $titleChecker,
            $abstractChecker,
            $textChecker,
        ]);
    }
}