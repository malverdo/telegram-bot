<?php

namespace App\Application\UseCase\Callback;

use App\Domain\Entity\Message\Update;
use App\Infrastructure\Bus\Command;

class TimeOutCommand implements Command
{
    public Update $update;

    public function __construct(Update $update)
    {
        $this->update = $update;
    }
}