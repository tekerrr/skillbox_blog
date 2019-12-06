<?php


namespace App\Controller;


use App\Validation\Form\Checkable;

class  Form
{
    private $checkableItems = [];

    private $fieldValidStatuses = [];
    private $fieldErrorMessages = [];

    public function check(): bool
    {
        $success = true;

        foreach ($this->checkableItems as $item) {
            if (! $result = $item->check()) {
                $this->setFieldErrorMessage($item);
                $success = false;
            }

            $this->setFieldValidStatus($item, $result);
        }

        return $success;
    }

    public function setCheckableItem(Checkable $checkableItem): void
    {
        $this->checkableItems[] = $checkableItem;
    }

    public function setCheckableItems(array $items): void
    {
        foreach ($items as $item) {
            if($item instanceof Checkable) {
                $this->checkableItems[] = $item;
            }
        }
    }

    public function getFieldValidStatuses(): array
    {
        return $this->fieldValidStatuses;
    }

    public function getFieldErrorMessages(): array
    {
        return $this->fieldErrorMessages;
    }

    private function setFieldValidStatus(Checkable $checkable, $result): void
    {
        $fieldName = $checkable->getFieldName();

        if (isset($this->fieldValidStatuses[$fieldName]) && $this->fieldValidStatuses[$fieldName] == 'is-invalid') {
            return;
        }

        $this->fieldValidStatuses[$fieldName] = $result ? 'is-valid' : 'is-invalid';
    }

    private function setFieldErrorMessage(Checkable $checkable): void
    {
        $this->fieldErrorMessages[$checkable->getFieldName()] =
            $this->fieldErrorMessages[$checkable->getFieldName()] ?? $checkable->getErrorMessage();
    }
}