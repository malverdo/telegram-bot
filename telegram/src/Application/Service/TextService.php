<?php

namespace App\Application\Service;

use App\Domain\Entity\Message\Update;
use App\Infrastructure\Bus\CommandBus;

class TextService
{
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;

    }

    public function handlerSelection(Update $update)
    {
        $message = $update->getMessage();
    }
}