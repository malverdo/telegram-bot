<?php

namespace App\Domain\Entity\Message;

use Symfony\Component\Serializer\Annotation\SerializedName;

class Update
{
    #[SerializedName("update_id")]
    private int $updateId;
    #[SerializedName("message")]
    private ?Message $message = null;

    #[SerializedName("callback_query")]
    private ?CallbackQuery $callbackQuery = null;

    /**
     * @param int $updateId
     * @param Message|null $message
     * @param CallbackQuery|null $callbackQuery
     */
    public function __construct(int $updateId, ?Message $message, ?CallbackQuery $callbackQuery)
    {
        $this->updateId = $updateId;
        $this->message = $message;
        $this->callbackQuery = $callbackQuery;
    }


    public function getCallbackQuery(): ?CallbackQuery
    {
        return $this->callbackQuery;
    }

    public function getUpdateId(): int
    {
        return $this->updateId;
    }


    public function getMessage(): ?Message
    {
        return $this->message;
    }

}