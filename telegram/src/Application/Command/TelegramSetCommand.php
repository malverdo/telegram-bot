<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Infrastructure\Client\TelegramBotClient;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'telegram:set:command')]
final class TelegramSetCommand extends Command
{

    private TelegramBotClient $client;

    public function __construct(TelegramBotClient $client)
    {
        parent::__construct();
        $this->client = $client;
    }

    protected function configure(): void
    {
        $this->setDescription('telegram set command');
    }

    /**
     *
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $response = $this->client->setMyCommands();

            if ($response->isOk()) {
                echo "Команды успешно установлены!";
            } else {
                echo "Произошла ошибка: " . $response->getDescription() . "\n";
            }
            return Command::SUCCESS;
        } catch (Exception $e) {
            $output->writeln($e->getMessage());
            $output->writeln($e->getTraceAsString());

            return Command::FAILURE;
        }
    }
}
