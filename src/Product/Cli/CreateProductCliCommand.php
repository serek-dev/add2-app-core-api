<?php

declare(strict_types=1);


namespace App\Product\Cli;


use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

#[AsCommand('app:product:create', 'Creates in an interactive mode a product')]
final class CreateProductCliCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');

        $question = new Question('Product name: ');
        $name = $helper->ask($input, $output, $question);

        $question = new Question('Product producer name: ', null);
        $producerName = $helper->ask($input, $output, $question);

        return Command::SUCCESS;
    }
}
