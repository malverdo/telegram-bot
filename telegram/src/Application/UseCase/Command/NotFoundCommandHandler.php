<?php

namespace App\Application\UseCase\Command;

use App\Application\UseCase\CommandHandler;
use App\Domain\TelegramClient\TelegramClientInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class NotFoundCommandHandler implements CommandHandler
{

    private TelegramClientInterface $client;
    private Environment $twig;


    public function __construct(TelegramClientInterface $client, Environment $twig)
    {
        $this->client = $client;
        $this->twig = $twig;

    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function __invoke(NotFoundCommand $command): void
    {
        $update = $command->update;
        $chat = $update->getMessage()->getChat()->getId();
        $template = $this->twig->render('not_found_command_message.twig');

        $this->client->sendMessage($chat, $template);
    }
}