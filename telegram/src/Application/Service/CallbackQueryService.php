<?php

namespace App\Application\Service;

use App\Domain\Entity\Message\Update;

class CallbackQueryService
{
    public function handlerSelection(Update $update): void
    {
        $message = $update->getCallbackQuery();

    }
}