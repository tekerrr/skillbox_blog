<?php


namespace App\Validation\Form;


abstract class AbstractChecker implements Checkable
{
    protected $fieldName;
    protected $errorMessage  = 'Ошибка';

    public function __construct(string $fieldName = '')
    {
        $this->setFieldName($fieldName);
    }

    abstract function check(): bool;

    public function getFieldName(): string
    {
        return $this->fieldName;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    public function setErrorMessage(string $message)
    {
        $this->errorMessage = $message;
        return $this;
    }

    public function setFieldName(string $name)
    {
        $this->fieldName = $name;
        return $this;
    }
}