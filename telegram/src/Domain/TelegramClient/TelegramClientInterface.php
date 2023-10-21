<?php

namespace App\Domain\TelegramClient;

interface TelegramClientInterface
{
    public function setWebhook(): void;

    public function deleteWebhook(): void;

    public function sendMessage(int $chatId, string $text);

    public function sendMessageKeyboard(int $chatId, string $text, array $keyboard);

    public function sendMessageInlineKeyboard(int $chatId, string $text, array $keyboard);

    public function sendPhoto(int $chatId, string $photo, string $caption);
}