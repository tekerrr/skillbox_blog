<?php


namespace App\Controller\Controller;


use App\Controller\Form;
use App\Controller\Session;

abstract class AbstractController
{
    protected function checkForm(Form $form): bool
    {
        if ($form->check()) {
            return true;
        }

        $this->saveFieldsForFlashSession($form->getFields());
        return false;
    }

    protected function getFields(array $loadedValues = []): array
    {
        return (new Session())->get('fields', []) ?: $this->getFieldLoadedValues($loadedValues);
    }

    protected function getFieldLoadedValues(array $loadedValues): array
    {
        $fieldValues = [];

        foreach ($loadedValues as $key => $value) {
            $fieldValues[$key]['value'] = $value;
        }

        return $fieldValues;
    }

    protected function saveFieldsForFlashSession(array $fields): void
    {
        (new Session())->flash('fields', $fields);
    }
}