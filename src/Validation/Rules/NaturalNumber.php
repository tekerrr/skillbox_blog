<?php


namespace App\Validation\Rules;


use App\Validation\AbstractChainChecker;

class NaturalNumber extends AbstractChainChecker
{
    protected $errorMessage = 'Введите натуральное число';

    protected function isValid(): bool
    {
        return is_numeric($i = $_POST[$this->getFieldName()]) && $i > 0 && ($i == round($i));
    }
}