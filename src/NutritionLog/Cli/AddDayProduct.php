<?php

declare(strict_types=1);


namespace App\NutritionLog\Cli;


use App\NutritionLog\Command\AddDayProductCommand;
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
            '2023-07-06',
            '12:00',
            'p-64a466b4e03c1',
            250
        );

        $this->bus->dispatch($command);

        return Command::SUCCESS;
    }
}
