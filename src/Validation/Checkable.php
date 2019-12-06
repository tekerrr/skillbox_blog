<?php


namespace App\Validation;


interface Checkable
{
    public function __construct(string $fieldName = '');

    public function check(): bool;

    public function getFieldName(): string;
    public function getErrorMessage(): string;

    public function setFieldName(string $name);
    public function setErrorMessage(string $message);
}