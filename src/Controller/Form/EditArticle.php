<?php


namespace App\Controller\Form;


use App\Controller\Form;
use App\Validation\Form\ChainOfResponsibility\EmptyField;
use App\Validation\Form\ChainOfResponsibility\Length;

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