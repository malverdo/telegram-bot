<?php

declare(strict_types=1);

namespace App\Application\Command;

use Exception;
use Handler;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TelegramBot\Entities\Keyboard;
use TelegramBot\Entities\KeyboardButton;
use TelegramBot\Entities\Update;
use TelegramBot\Telegram;
use TelegramBot\UpdateHandler;

#[AsCommand(name: 'telegram:start')]
final class TelegramStart extends Command
{



    protected function configure(): void
    {
        $this->setDescription('start telegram');
    }

    /**
     *
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {





            $admin_id = 1374675059;
            $bot_token = '6409552485:AAF1sTyMBiIi47qZFn3Xm826zlAUGo1iTf8';
            \TelegramBot\Telegram::setToken($bot_token);


            \TelegramBot\Telegram::setToken($bot_token);
//            \TelegramBot\CrashPad::setDebugMode($admin_id);



            $result = \TelegramBot\Request::getUpdates([]);

            $data = $result->getRawData()['result'];
            $message = $data[array_key_last($data)];






            if ($message['message']['text'] == '/start' ) {
                $keyboard = [
                    'keyboard' => [
                        ['кнопка 3', 'Кнопка 2']
                    ],
                    'resize_keyboard' => true
                ];

                // отправка сообщения
                $result = \TelegramBot\Request::sendMessage([
                    'chat_id' => $message['message']['chat']['id'],
                    'text' => 'Выберите одну из кнопок:',
                    'reply_markup' => json_encode($keyboard)
                ]);
            } else {
                $keyboard = [
                    'keyboard' => [
                        ['/start', 'Кнопка 2']
                    ],
                    'resize_keyboard' => true
                ];

                // отправка фото
                $response = \TelegramBot\Request::sendPhoto([
                    'chat_id' => $message['message']['chat']['id'],
                    'photo' => './57733c4a106f4cc4b505a0ba4baf.jpg',
                    'caption' => 'Описание вашего фото (необязательно)'
                ]);

                // отправка сообщения с кнопками
                $result = \TelegramBot\Request::sendMessage([
                    'chat_id' => $message['message']['chat']['id'],
                    'text' => 'Выберите одну из кнопок:',
                    'reply_markup' => json_encode($keyboard)
                ]);
            }

            dd($message['message']);
            return Command::SUCCESS;
        } catch (Exception $e) {
            $output->writeln($e->getMessage());
            $output->writeln($e->getTraceAsString());

            return Command::FAILURE;
        }
    }
}
