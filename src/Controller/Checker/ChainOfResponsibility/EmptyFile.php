<?php


namespace App\Controller\Checker\ChainOfResponsibility;


class EmptyFile extends AbstractChainChecker
{
    protected $errorMessage = 'Выберите файл';

    protected function isValid(): bool
    {
        return ($_FILES && $_FILES[$this->getFieldName()]['error'] !== UPLOAD_ERR_NO_FILE);
    }
}