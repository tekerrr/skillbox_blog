<?php


namespace App\Validation\Form\ChainOfResponsibility;


class EmptyField extends AbstractChainChecker
{
    protected $errorMessage = 'Заполните поле';

    protected function isValid(): bool
    {
        return (isset($_POST[$this->getFieldName()]) && $_POST[$this->getFieldName()] !== '');
    }
}