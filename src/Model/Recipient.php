<?php


namespace App\Model;


interface Recipient
{
    public function getAddress(): string;
}