<?php

namespace App\Domain\Entity\Message;

class Update
{
    private int $updateId;
    private Message $message;

    public function getUpdateId(): int
    {
        return $this->updateId;
    }

    public function setUpdateId(int $updateId): void
    {
        $this->updateId = $updateId;
    }

    public function getMessage(): Message
    {
        return $this->message;
    }

    public function setMessage(Message $message): void
    {
        $this->message = $message;
    }

}