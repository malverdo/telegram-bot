<?php

namespace App\Application\Service;

use App\Application\UseCase\Callback\TimeOutCommand;
use App\Application\UseCase\Command\NotFoundCommand;
use App\Application\UseCase\Command\QuizMathsCommand;
use App\Application\UseCase\Command\StartCommand;
use App\Domain\Entity\Message\Update;
use App\Infrastructure\Bus\CommandBus;
use App\Infrastructure\Client\PredisClient;

class CallbackQueryService
{
    public const MATHS = 'maths';

    private CommandBus $commandBus;

    private PredisClient $client;

    public function __construct( CommandBus $commandBus, PredisClient $client)
    {
        $this->commandBus = $commandBus;
        $this->client = $client;

    }

    public function handlerSelection(Update $update): void
    {
        $callback = $update->getCallbackQuery();
        $messageId = $callback->getMessage()->getMessageId();
        $values = $this->client->get(PredisClient::REDIS_KEY_MESSAGE_ID . $messageId);

        if ($values) {
            $array = json_decode($values, true);

            $command = match ($array['handler']) {
                self::MATHS => new QuizMathsCommand($update)
            };

        } else {
            $command = new TimeOutCommand($update);
        }



        $this->commandBus->handle($command);

    }
}