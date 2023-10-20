<?php

declare(strict_types=1);

namespace App\Application\Command;

use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class TelegramStart extends Command
{
    protected static $defaultName = 'telegram:start';


    protected function configure(): void
    {
        $this->setDescription('start telegram');
    }

    /**
     *
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {


            return Command::SUCCESS;
        } catch (Exception $e) {
            $output->writeln($e->getMessage());
            $output->writeln($e->getTraceAsString());

            return Command::FAILURE;
        }
    }
}
