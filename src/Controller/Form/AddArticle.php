<?php


namespace App\Controller\Form;


use App\Validation\Form\ChainOfResponsibility\EmptyFile;

class AddArticle extends EditArticle
{
    public function __construct()
    {
        parent::__construct();

        $imageChecker = (new EmptyFile('img_article'))->setErrorMessage('Выберите изображение');
        $this->setCheckableItem($imageChecker);
    }
}