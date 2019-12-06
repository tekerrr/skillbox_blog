<?php


namespace App\Controller\Form;


use App\Controller\Checker\ChainOfResponsibility\EmptyField;
use App\Controller\Form;

class AddComment extends Form
{
    public function __construct()
    {
        $this->setCheckableItem(new EmptyField('comment'));
    }
}