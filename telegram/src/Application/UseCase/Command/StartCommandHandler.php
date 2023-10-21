<?php

namespace App\Application\UseCase\Command;

use App\Application\UseCase\CommandHandler;
use App\Domain\TelegramClient\TelegramClientInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class StartCommandHandler implements CommandHandler
{

    private TelegramClientInterface $client;
    private KernelInterface $kernel;

    private Environment $twig;


    public function __construct(TelegramClientInterface $client, KernelInterface $kernel, Environment $twig)
    {
        $this->client = $client;
        $this->kernel = $kernel;
        $this->twig = $twig;

    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function __invoke(StartCommand $command): void
    {
        $update = $command->update;
        $chat = $update->getMessage()->getChat()->getId();
        $photo = $this->kernel->getProjectDir() . '/welcome.jpg';
        $template = $this->twig->render('welcome_message.twig');

        $this->client->sendPhoto($chat, $photo, $template);
    }
}