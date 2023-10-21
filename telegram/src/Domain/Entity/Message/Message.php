<?php

namespace App\Domain\Entity\Message;

class Message
{
    private int $messageId;
    private From $from;
    private Chat $chat;
    private int $date;

    private string $text = '';



    public function getMessageId(): int
    {
        return $this->messageId;
    }

    public function setMessageId(int $messageId): void
    {
        $this->messageId = $messageId;
    }

    public function getFrom(): From
    {
        return $this->from;
    }

    public function setFrom(From $from): void
    {
        $this->from = $from;
    }

    public function getChat(): Chat
    {
        return $this->chat;
    }

    public function setChat(Chat $chat): void
    {
        $this->chat = $chat;
    }

    public function getDate(): int
    {
        return $this->date;
    }

    public function setDate(int $date): void
    {
        $this->date = $date;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

}