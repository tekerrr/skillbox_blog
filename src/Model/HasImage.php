<?php


namespace App\Model;


interface HasImage
{
    public function getId(): string;
    public function getImageName(): string;

    public function addImage(string $name): void;
    public function deleteImage(): void;
    public function delete();
}