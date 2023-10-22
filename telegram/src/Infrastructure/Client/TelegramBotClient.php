<?php

namespace App\Infrastructure\Client;

use App\Application\UseCase\Command\QuizMathsCommand;
use App\Application\UseCase\Command\StartCommand;
use App\Domain\TelegramClient\TelegramClientInterface;
use TelegramBot\Entities\Response;
use TelegramBot\Request;
use TelegramBot\Telegram;

class TelegramBotClient implements TelegramClientInterface
{

    private int $adminId;

    private string $botToken;

    private string $webhook;

    public function __construct(int $adminId, string $botToken, string $webhook)
    {
        $this->adminId = $adminId;
        $this->botToken = $botToken;
        $this->webhook = $webhook;
        Telegram::setToken($this->botToken);
    }

    public function setWebhook(): void
    {
         Request::setWebhook([
                'url' => $this->webhook . $this->botToken
         ]);
    }

    public function deleteWebhook(): void
    {
        Request::deleteWebhook([
            'url' => $this->webhook . $this->botToken
        ]);
    }

    public function setMyCommands(): Response
    {
        $commands = [
            [
                "command" => substr(StartCommand::START,1),
                "description" => "Запуск бота"
            ],
            [
                "command" => substr(QuizMathsCommand::QUIZ,1),
                "description" => "Викторина по математике"
            ],
        ];

        $data = [
            'commands' => $commands
        ];

        return Request::setMyCommands($data);
    }

    public function deleteMessage(int $chatId, int $messageId): Response
    {
        return Request::deleteMessage([
            'chat_id' => $chatId,
            'message_id' => $messageId,
        ]);
    }

    public function sendMessage(int $chatId, string $text): Response
    {
        return Request::sendMessage([
            'chat_id' => $chatId,
            'text' => $text,
        ]);
    }


    /**
     * @param int $chatId
     * @param string $text
     * @param array $keyboard
     * @return Response
     *
     * 'keyboard' => [
     *      ['/start', 'Кнопка 2'],
     *      ['/stsdt', 'Кнопка 3'],
     * ],
     */
    public function sendMessageKeyboard(int $chatId, string $text,array $keyboard): Response
    {
        return Request::sendMessage([
            'chat_id' => $chatId,
            'text' => $text,
            'reply_markup' => $this->buildKeyboard($keyboard)
        ]);
    }


    /**
     * @param int $chatId
     * @param string $text
     * @param array $keyboard
     * @return Response
     *
     * $inlineKeyboard = [
     *      [
     *          ['text' => 'Кнопка 1', 'callback_data' => '88'],
     *          ['text' => 'Кнопка 2', 'callback_data' => '22']
     *      ],
     *      [
     *          ['text' => 'Кнопка 1', 'callback_data' => '88'],
     *          ['text' => 'Кнопка 2', 'callback_data' => '22']
     *      ]
     * ];
     *
     */
    public function sendMessageInlineKeyboard(
        int $chatId,
        string $text,
        array $keyboard
    ): Response {

        return Request::sendMessage([
            'chat_id' => $chatId,
            'text' => $text,
            'reply_markup' => json_encode([
                'inline_keyboard' => $keyboard
            ])
        ]);
    }


    /**
     * @param int $chatId
     * @param string $photo
     * @param string $caption
     * @param array $keyboard
     * @return Response
     *
     *  $this->kernel->getProjectDir() . '/welcome.jpg'
     */
    public function sendPhoto(
        int $chatId,
        string $photo,
        string $caption,
        array $keyboard = []
    ): Response {

        $request = [
            'chat_id' => $chatId,
            'photo' => $photo,
            'caption' => $caption,
            'reply_markup' => ''
        ];

        if ($keyboard) {
            $request['reply_markup'] =  $this->buildKeyboard($keyboard);
        }

        return Request::sendPhoto($request);
    }


    public function buildKeyboard(array $keyboard): bool|string
    {
        $keyboard = [
            'keyboard' => $keyboard,
            'resize_keyboard' => true
        ];

        return json_encode($keyboard);
    }
}