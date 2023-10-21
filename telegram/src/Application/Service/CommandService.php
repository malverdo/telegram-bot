<?php

namespace App\Application\Service;

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
    public function handlerSelection(Update $update)
    {
        $message = $update->getMessage();
        $commandText = $message->getText();

        if ($commandText == '/start') {
            $this->commandBus->handle(new StartCommand($update));
        } else {

        }
        dd($message, 'sdf');



    }
}