<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Entity\Message\Chat;
use App\Domain\Entity\Message\Test;
use App\Domain\Entity\Message\Update;
use App\Infrastructure\Client\TelegramBotClient;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

#[AsCommand(name: 'telegram:set:webhook')]
final class TelegramWebhook extends Command
{

    private TelegramBotClient $client;

    public function __construct(TelegramBotClient $client)
    {
        parent::__construct();
        $this->client = $client;
    }

    protected function configure(): void
    {
        $this->setDescription('telegram set webhook');
    }

    /**
     *
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {

            $this->client->deleteWebhook();
            $this->client->setWebhook();

            return Command::SUCCESS;
        } catch (Exception $e) {
            $output->writeln($e->getMessage());
            $output->writeln($e->getTraceAsString());

            return Command::FAILURE;
        }
    }
}
