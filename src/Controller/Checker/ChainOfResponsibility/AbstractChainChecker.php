<?php


namespace App\Controller\Checker\ChainOfResponsibility;



use App\Controller\Checker\AbstractChecker;

abstract class AbstractChainChecker extends AbstractChecker
{
    /*** @var AbstractChainChecker */
    private $nextChecker;

    abstract protected function isValid(): bool;

    public function setNext(AbstractChainChecker $checker): AbstractChainChecker
    {
        $this->nextChecker = $checker;
        $checker->setFieldName($this->fieldName);
        return $checker;
    }

    public function check(): bool
    {
        if (! $this->isValid()) {
            return false;
        }

        if ($this->nextChecker) {
            $result = $this->nextChecker->check();
            $this->setErrorMessage($this->nextChecker->getErrorMessage());
            return $result;
        }

        return true;
    }

    public function setFieldName(string $name)
    {
        $this->fieldName = $name;
        if ($this->nextChecker) {
            $this->nextChecker->setFieldName($name);
        }

        return $this;
    }
}