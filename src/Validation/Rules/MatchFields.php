<?php


namespace App\Validation\Rules;


use App\Validation\AbstractChainChecker;

class MatchFields extends AbstractChainChecker
{
    protected $errorMessage = 'Данные не совпадают';

    private $referenceFieldName;

    public function setReferenceFieldName($name)
    {
        $this->referenceFieldName = $name;
        return $this;
    }

    public function isValid(): bool
    {
        return (isset($_POST[$this->referenceFieldName]) && $_POST[$this->getFieldName()] === $_POST[$this->referenceFieldName]);
    }
}