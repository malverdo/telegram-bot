<?php

declare(strict_types=1);

namespace App\Application\UseCase\Request;

use App\Domain\Entity\Message\Update;

final class StartRequest
{
    public Update $update;

    public function __construct(Update $update)
    {
        $this->update = $update;
    }
}
