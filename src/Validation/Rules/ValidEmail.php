<?php


namespace App\Validation\Rules;


use App\Validation\AbstractChainChecker;

class ValidEmail extends AbstractChainChecker
{
    protected $errorMessage = 'Введите корректный email';

    protected function isValid(): bool
    {
        return filter_var($_POST[$this->getFieldName()], FILTER_VALIDATE_EMAIL);
    }
}