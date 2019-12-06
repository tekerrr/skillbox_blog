<?php


namespace App\Sender;


use App\Model\Recipient;

interface Sendable
{
    public function sendTo(Recipient $recipient);
}