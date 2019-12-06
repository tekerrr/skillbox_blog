<?php


namespace App\Controller\Form;


use App\Controller\Form;
use App\Validation\Rules\EmptyField;

class AddComment extends Form
{
    public function __construct()
    {
        $this->setCheckableItem(new EmptyField('comment'));
    }
}