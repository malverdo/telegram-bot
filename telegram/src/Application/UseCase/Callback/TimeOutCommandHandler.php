<?php

namespace App\Application\UseCase\Callback;

use App\Application\UseCase\Command\NotFoundCommand;
use App\Application\UseCase\CommandHandler;
use App\Domain\TelegramClient\TelegramClientInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class TimeOutCommandHandler implements CommandHandler
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
    public function __invoke(TimeOutCommand $command): void
    {
        $update = $command->update;
        $chat = $update->getCallbackQuery()->getMessage()->getChat()->getId();
        $template = $this->twig->render('callback/time_out_callback_message.twig');

        $this->client->sendMessage($chat, $template);
    }
}