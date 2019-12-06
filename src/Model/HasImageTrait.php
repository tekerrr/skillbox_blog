<?php


namespace App\Model;


trait HasImageTrait
{
    abstract public function save();

    public function getId(): string
    {
        return $this->id ?? '';
    }

    public function getImageName(): string
    {
        return $this->image ?? '';
    }

    public function addImage(string $name): void
    {
        $this->image = $name;
        $this->save();
    }

    public function deleteImage(): void
    {
        $this->image = null;
        $this->save();
    }

}