<?php

namespace App\Domain\Entity\Message;

use Symfony\Component\Serializer\Annotation\SerializedName;

class Message
{
    #[SerializedName("message_id")]
    private int $messageId;

    #[SerializedName("from")]
    private From $from;

    #[SerializedName("chat")]
    private Chat $chat;

    #[SerializedName("date")]
    private int $date;

    #[SerializedName("text")]
    private string $text ;

    #[SerializedName("reply_markup")]
    private ?ReplyMarkup $replyMarkup;

    /**
     * @param int $messageId
     * @param From $from
     * @param Chat $chat
     * @param int $date
     * @param string $text
     */
    public function __construct(int $messageId, From $from, Chat $chat, int $date, string $text = '', ?ReplyMarkup $replyMarkup = null)
    {
        $this->messageId = $messageId;
        $this->from = $from;
        $this->chat = $chat;
        $this->date = $date;
        $this->text = $text;
        $this->replyMarkup = $replyMarkup;
    }


    public function getMessageId(): int
    {
        return $this->messageId;
    }


    public function getFrom(): From
    {
        return $this->from;
    }


    public function getChat(): Chat
    {
        return $this->chat;
    }


    public function getDate(): int
    {
        return $this->date;
    }


    public function getText(): string
    {
        return $this->text;
    }


}