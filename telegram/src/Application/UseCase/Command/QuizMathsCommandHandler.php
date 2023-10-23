<?php

namespace App\Application\UseCase\Command;

use App\Application\UseCase\CommandHandler;
use App\Domain\TelegramClient\TelegramClientInterface;
use App\Infrastructure\Client\PredisClient;
use Exception;
use Symfony\Component\HttpKernel\KernelInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class QuizMathsCommandHandler implements CommandHandler
{


    private TelegramClientInterface $client;

    private Environment $twig;
    private PredisClient $pclient;


    public function __construct(TelegramClientInterface $client, Environment $twig, PredisClient $pclient)
    {
        $this->client = $client;
        $this->twig = $twig;
        $this->pclient = $pclient;

    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function __invoke(QuizMathsCommand $command): void
    {
        $update = $command->update;
        $message = $update->getMessage() ?? $update->getCallbackQuery()->getMessage();
        $chat = $message->getChat()->getId();
        $messageId = $message->getMessageId();
        $redisKey = PredisClient::REDIS_KEY_MESSAGE_ID . $messageId;


        $values = $this->pclient->get($redisKey);

        if ($values) {
            $array = json_decode($values, true);
            $data = $update->getCallbackQuery()->getData();
            $correct = $array['value'];
            $isAnswer = $correct == $data;
            $this->answer($chat, $isAnswer, $correct);
            $this->pclient->delete($redisKey);
        } else {
            $this->oneCommand($chat);
        }

        $this->randomMathOperation($chat);


    }

    public function answer(int $chat, bool $isAnswer, $data): void
    {
        $template = $this->twig->render('callback/answer_callback_message.twig', [
            'isAnswer' => $isAnswer,
            'data' => $data,
        ]);
        $this->client->sendMessage($chat, $template);
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     * @throws Exception
     */
    public function randomMathOperation(int $chat): void
    {
        $operations = ['+', '-'];
        $chosenOperation = $operations[array_rand($operations)];

        switch ($chosenOperation) {
            case '+':
                list($number1, $number2, $correctAnswer, $templateName) = $this->generateAddition();
                break;
            case '-':
                list($number1, $number2, $correctAnswer, $templateName) = $this->generateSubtraction();
                break;
            default:
                throw new Exception('Unknown operation');
        }

        $templatePlay = $this->twig->render($templateName, [
            'number1' => $number1,
            'number2' => $number2
        ]);

        $this->sendMessageWithKeyboard($chat, $templatePlay, $correctAnswer);
    }

    private function generateAddition(): array
    {
        $number1 = rand(1, 50);
        $number2 = rand(1, 50);
        $correctAnswer = $number1 + $number2;
        $templateName = 'calculate/addition_calculate_command_message.twig';

        return [$number1, $number2, $correctAnswer, $templateName];
    }

    private function generateSubtraction(): array
    {
        $number1 = rand(1, 50);
        $number2 = rand(1, $number1);  // чтобы результат был положительным
        $correctAnswer = $number1 - $number2;
        $templateName = 'calculate/subtraction_calculate_command_message.twig';

        return [$number1, $number2, $correctAnswer, $templateName];
    }

    private function sendMessageWithKeyboard(int $chat, string $templatePlay, int $correctAnswer): void
    {
        $incorrectAnswer1 = $correctAnswer + rand(1, 5);
        $incorrectAnswer2 = $correctAnswer - rand(1, 5);

        $keyboard = [
            ['text' => $correctAnswer, 'callback_data' => $correctAnswer],
            ['text' => $incorrectAnswer1, 'callback_data' => $incorrectAnswer1],
            ['text' => $incorrectAnswer2, 'callback_data' => $incorrectAnswer2]
        ];
        shuffle($keyboard);

        $response = $this->client->sendMessageInlineKeyboard($chat, $templatePlay, [
            $keyboard
        ]);
        $messageId = $response->getRawData(true)['result']['message_id'];

        $values = [
            'handler' => 'maths',
            'value' => $correctAnswer
        ];

        $this->pclient->setex(PredisClient::REDIS_KEY_MESSAGE_ID . $messageId, json_encode($values), 120);
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function oneCommand(int $chat): void
    {
        $template = $this->twig->render('calculate/welcome_calculate_command_message.twig');
        $this->client->sendMessage($chat, $template);
    }
}