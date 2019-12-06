<?php


namespace App\Sender;


use App\Model\Recipient;

class Sender
{
    private $recipientClassName;
    /** @var Sendable */
    private $message;

    public function __construct(string $recipientClassName, Sendable $message)
    {
        $this->recipientClassName = $recipientClassName;
        $this->message = $message;
    }


    public function sendAll(): void
    {
        if ($recipients = call_user_func_array([$this->recipientClassName, 'all'], ['conditions' => ['active' => true]])) {
            foreach ($recipients as $recipient) {
                if ($recipient instanceof Recipient) {
                    $this->message->sendTo($recipient);
                }
            }
        }
    }
}