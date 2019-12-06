<?php


namespace App\Controller\Controller;


use App\Controller\Form;

abstract class AbstractController
{
    private $additionalConfig = [];

    protected function setAdditionalConfig(array $config): void
    {
        $this->additionalConfig = $config;
    }

    protected function getAdditionalConfig(): array
    {
        return $this->additionalConfig;
    }

    protected function getFormConfig(Form $form): array
    {
        return [
            'status'    => $form->getFieldValidStatuses(),
            'message'   => $form->getFieldErrorMessages(),
        ];
    }

    protected function checkForm(Form $form, AbstractController $controller): bool
    {
        if ($form->check()) {
            return true;
        }

        $controller->setAdditionalConfig($this->getFormConfig($form));
        return false;
    }

    protected function getFieldValues(array $keys, array $loadedValues = []): array
    {
        $fieldValues = [];

        foreach ($keys as $key) {
            $fieldValues[$key] = $this->getHtmlSavePost($key) ?? $loadedValues[$key] ?? '';
        }

        return $fieldValues;
    }

    protected function getHtmlSavePost(string $key): ?string
    {
        if (isset($_POST[$key])) {
            return htmlentities($_POST[$key]);
        }

        return null;
    }
}