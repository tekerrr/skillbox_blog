<?php


namespace App\Controller\Form;


use App\Controller\Checker\ChainOfResponsibility\EmptyFile;

class AddArticle extends EditArticle
{
    public function __construct()
    {
        parent::__construct();

        $imageChecker = (new EmptyFile('article'))->setErrorMessage('Выберите изображение');
        $this->setCheckableItem($imageChecker);
    }
}