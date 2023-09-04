<?php

declare(strict_types=1);


namespace App\Catalog\Cli;


use App\Catalog\Command\CreateProductCommand;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand('app:product:create', 'Creates in an interactive mode a product')]
final class CreateProductCliCommand extends Command
{
    public function __construct(private readonly MessageBusInterface $bus)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');

        $question = new Question('Product name: ');
        $name = $helper->ask($input, $output, $question);

        $question = new Question('Product producer name (null): ', null);
        $producerName = $helper->ask($input, $output, $question);

        $question = new Question('Proteins (0.0): ', 0.0);
        $proteins = (float)$helper->ask($input, $output, $question);

        $question = new Question('Fats (0.0): ', 0.0);
        $fats = (float)$helper->ask($input, $output, $question);

        $question = new Question('Carbs (0.0): ', 0.0);
        $carbs = (float)$helper->ask($input, $output, $question);

        $expectedKcal = ($proteins * 4) + ($fats * 9) + ($carbs * 4);
        $question = new Question("Kcal ($expectedKcal): ", $expectedKcal);
        $kcal = (float)$helper->ask($input, $output, $question);

        $this->bus->dispatch(
            new CreateProductCommand(
                $name,
                $proteins,
                $fats,
                $carbs,
                $kcal,
                $producerName
            )
        );

        return Command::SUCCESS;
    }
}
