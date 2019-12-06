<?php


namespace App\Validation\Rules;


use App\Controller\Auth;
use App\Model\User;
use App\Validation\AbstractChainChecker;

class UniqueFieldContent extends AbstractChainChecker
{
    protected $errorMessage = 'Данное содержимое уже используется';
    private $userId = null;

    protected function isValid(): bool
    {
        $value = $_POST[$this->getFieldName()];

        $user = $this->userId ? User::findById($this->userId) : Auth::getInstance()->getUser();

        if ($user && $user->attributes()[$this->getFieldName()] == $value) {
            return true;
        }

        return ! User::exists(['conditions' => [$this->getFieldName() => $value]]);
    }

    public function setForAnotherUser($id): void
    {
        $this->userId = $id;
    }
}