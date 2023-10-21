<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Entity\Message\Chat;
use App\Domain\Entity\Message\Test;
use App\Domain\Entity\Message\Update;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

#[AsCommand(name: 'telegram:start')]
final class TelegramStart extends Command
{

    private DenormalizerInterface $serializer;

    public function __construct(DenormalizerInterface $serializer)
    {
        parent::__construct();
        $this->serializer = $serializer;
    }

    protected function configure(): void
    {
        $this->setDescription('test telegram');
    }

    /**
     *
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {





            $admin_id = 1374675059;
            $bot_token = '6753324315:AAE6KrNTe_0ONQj2Gf-Wve_7XCG9dQOCFUo';


            \TelegramBot\Telegram::setToken($bot_token);


            \TelegramBot\Telegram::setToken($bot_token);
//            \TelegramBot\CrashPad::setDebugMode($admin_id);



//            $result = \TelegramBot\Request::getUpdates([]);

//            \TelegramBot\Request::setWebhook([
//                'url' => 'https://webhook.site/64f12eed-6fc2-4080-8bd6-20ffdc48ecd8/' . $bot_token
////                'url' => ''
//            ]);

//            \TelegramBot\Request::deleteWebhook(['url' => 'https://webhook.site/64f12eed-6fc2-4080-8bd6-20ffdc48ecd8/' . $bot_token]);

            $inlineKeyboard = [
                [
                    ['text' => 'Кнопка 1', 'callback_data' => '88'],
                    ['text' => 'Кнопка 2', 'callback_data' => '22']
                ]
            ];

            $response = \TelegramBot\Request::sendMessage([
                'chat_id' => 1374675059,
                'text' => 'Выберите одну из кнопок:',
                'reply_markup' => json_encode([
                    'inline_keyboard' => $inlineKeyboard
                ])
            ]);


            dd($response);


            $data = $result->getRawData();
            dd($data);

            $dataResult = $data['result'];
            $message = $dataResult[array_key_last($dataResult)];


//            dd($message);
            try {
                $denormalize = $this->serializer->denormalize($message, Update::class);
            } catch (\Exception $e) {
                echo $e->getMessage();
            } catch (ExceptionInterface $e) {
                echo $e->getMessage();
            }
//            dd($denormalize->getMessage()->getText());





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
//                    'reply_markup' => json_encode($keyboard)
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

//                // отправка сообщения с кнопками с наружи
//                $result = \TelegramBot\Request::sendMessage([
//                    'chat_id' => $message['message']['chat']['id'],
//                    'text' => 'Выберите одну из кнопок:',
//                    'reply_markup' => json_encode($keyboard)
//                ]);





            }

            return Command::SUCCESS;
        } catch (Exception $e) {
            $output->writeln($e->getMessage());
            $output->writeln($e->getTraceAsString());

            return Command::FAILURE;
        }
    }
}
