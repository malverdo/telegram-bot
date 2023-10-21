<?php

namespace App\Domain\Entity\Message;

use Symfony\Component\Serializer\Annotation\SerializedName;

class InlineKeyboardButton
{
    #[SerializedName("text")]
    private string $text;

    #[SerializedName("callback_data")]
    private string $callbackData;


    public function __construct(string $text, string $callbackData)
    {
        $this->text = $text;
        $this->callbackData = $callbackData;
    }


    public function getText(): string
    {
        return $this->text;
    }

    public function getCallbackData(): string
    {
        return $this->callbackData;
    }
}