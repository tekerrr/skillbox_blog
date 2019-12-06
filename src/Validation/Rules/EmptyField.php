<?php


namespace App\Validation\Rules;


use App\Validation\AbstractChainChecker;

class EmptyField extends AbstractChainChecker
{
    protected $errorMessage = 'Заполните поле';

    protected function isValid(): bool
    {
        return (isset($_POST[$this->getFieldName()]) && $_POST[$this->getFieldName()] !== '');
    }
}