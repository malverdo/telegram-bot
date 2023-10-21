<?php

namespace App\Domain\Entity\Message;

use Symfony\Component\Serializer\Annotation\SerializedName;

class ReplyMarkup
{
    #[SerializedName("inline_keyboard")]
    private array $inlineKeyboard;

    public function __construct(array $inlineKeyboard = [])
    {
        foreach ($inlineKeyboard as $key => $row) {
            foreach ($row as $buttonData) {
                $this->inlineKeyboard[$key][] = new InlineKeyboardButton($buttonData['text'], $buttonData['callback_data']);
            }
        }
    }

    public function getInlineKeyboard(): array
    {
        return $this->inlineKeyboard;
    }

}