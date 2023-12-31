<?php

namespace App\Application\UseCase\Command;

use App\Domain\Entity\Message\Update;
use App\Infrastructure\Bus\Command;

class StartCommand implements Command
{
    const START = '/start';

    public Update $update;

    public function __construct(Update $update)
    {
        $this->update = $update;
    }
}