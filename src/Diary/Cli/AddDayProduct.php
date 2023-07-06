<?php

declare(strict_types=1);


namespace App\Diary\Cli;


use App\Diary\Command\AddDayProductCommand;
use DateTimeImmutable;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand('app:diary:add-product', 'Adds product to nutrition day')]
final class AddDayProduct extends Command
{
    public function __construct(private readonly MessageBusInterface $bus)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $command = new AddDayProductCommand(
            (new DateTimeImmutable())->format('Y-m-d'),
            '10:45',
            'p-64a466b4e03c1',
            150
        );

        $this->bus->dispatch($command);

        return Command::SUCCESS;
    }
}
