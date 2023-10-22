<?php

namespace App\Application\Service;

use App\Application\UseCase\Command\NotFoundCommand;
use App\Application\UseCase\Command\QuizMathsCommand;
use App\Application\UseCase\Command\StartCommand;
use App\Domain\Entity\Message\Update;
use App\Infrastructure\Bus\CommandBus;
use App\Infrastructure\Client\TelegramBotClient;
use Throwable;

class CommandService
{
    private CommandBus $commandBus;

    public function __construct( CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;

    }

    /**
     * @throws Throwable
     */
    public function handlerSelection(Update $update): void
    {
        $message = $update->getMessage();
        $commandText = $message->getText();

        $command = match ($commandText) {
            StartCommand::START => new StartCommand($update),
            QuizMathsCommand::QUIZ => new QuizMathsCommand($update),
            default => new NotFoundCommand($update),
        };

        $this->commandBus->handle($command);
    }
}