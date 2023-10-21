<?php

declare(strict_types=1);

namespace App\Application\UseCase\Request;

final class StartRequest
{
    public array $update;

    public function __construct(array $update)
    {
        $this->update = $update;
    }
}
