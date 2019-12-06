<?php


namespace App\Controller\Checker\ChainOfResponsibility;


class Length extends AbstractChainChecker
{
    protected $errorMessage = 'Не более 60 символов';

    private $length = 60;

    protected function isValid(): bool
    {
        return (strlen($_POST[$this->getFieldName()]) <= $this->length);
    }

    public function setLength(int $length): self
    {
        $this->length = $length;
        return $this;
    }
}