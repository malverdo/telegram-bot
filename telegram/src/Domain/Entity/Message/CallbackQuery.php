<?php

namespace App\Domain\Entity\Message;

use Symfony\Component\Serializer\Annotation\SerializedName;

class CallbackQuery
{
    #[SerializedName("message")]
    private Message $message;

    #[SerializedName("data")]
    private string $data;

    #[SerializedName("from")]
    private From $from;

    #[SerializedName("id")]
    private string $id;

    #[SerializedName("chat_instance")]
    private string $chatInstance;

    #[SerializedName("reply_markup")]
    private ?ReplyMarkup $replyMarkup;


    /**
     * @param Message $message
     * @param string $chatInstance
     * @param string $data
     * @param From $from
     * @param string $id
     */
    public function __construct(
        Message $message,
        string $data,
        From $from,
        string $id,
        string $chatInstance)
    {
        $this->message = $message;
        $this->chatInstance = $chatInstance;
        $this->data = $data;
        $this->from = $from;
        $this->id = $id;
    }

    public function getFrom(): From
    {
        return $this->from;
    }


    public function getId(): string
    {
        return $this->id;
    }


    public function getMessage(): Message
    {
        return $this->message;
    }


    public function getChatInstance(): string
    {
        return $this->chatInstance;
    }


    public function getData(): string
    {
        return $this->data;
    }
}