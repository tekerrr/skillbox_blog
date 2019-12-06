<?php


namespace App\Controller;


use App\Validation\Checkable;

class  Form
{
    private $checkableItems = [];
    private $fields = [];

    public function check(): bool
    {
        $success = true;
        $fields = $this->getFieldValuesFromPost();

        foreach ($this->checkableItems as $item) {
            $name = $item->getFieldName();

            if (! $result = $item->check()) {
                $fields[$name]['message'] = $fields[$name]['message'] ?? $item->getErrorMessage();
                $success = false;
            }

            if (empty($fields[$name]['status']) || $fields[$name]['status'] == 'is-valid') {
                $fields[$name]['status'] = $result ? 'is-valid' : 'is-invalid';
            }
        }

        $this->fields = $fields;

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

    private function getFieldValuesFromPost(): array
    {
        $fieldValues = [];

        foreach ($_POST as $name => $value) {
            $fieldValues[$name]['value'] = htmlentities($_POST[$name] ?? '');
        }

        return $fieldValues;
    }

    public function getFields(): array
    {
        return $this->fields;
    }
}