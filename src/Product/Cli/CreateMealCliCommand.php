<?php

declare(strict_types=1);


namespace App\Product\Cli;


use App\Product\Command\CreateMealCommand;
use App\Product\View\ProductView;
use App\Product\ViewQuery\Product\FindProductsInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand('app:meal:create', 'Creates in an interactive mode a meal')]
final class CreateMealCliCommand extends Command
{
    public function __construct(private readonly FindProductsInterface $query, private readonly MessageBusInterface $bus)
    {
        parent::__construct();
        $this->addArgument(name: 'name', default: null);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');

        $addedProducts = [];

        $question = new Question('Meal name: ');
        $name = $helper->ask($input, $output, $question);

        $results = $this->query->findAll($input->getArgument('name'));

        for (; ;) {
            $table = new Table($output);
            $table
                ->setHeaders(['#', 'Name', 'Producer', 'P', 'F', 'W', 'Kcal'])
                ->setRows(array_map(fn(ProductView $v) => $v->jsonSerialize(), $results));
            $table->render();

            $question = new Question('Add product: ', '');
            $productId = $helper->ask($input, $output, $question);

            $question = new Question('Add product weight: ', 0.0);
            $productWeight = (float)$helper->ask($input, $output, $question);

            $addedProducts[] = [
                'id' => $productId,
                'weight' => $productWeight,
            ];

            $question = new ConfirmationQuestion('Add another?', false);
            if (!$helper->ask($input, $output, $question)) {
                break;
            }
        }

        $this->bus->dispatch(
            new CreateMealCommand(
                $name,
                $addedProducts,
            )
        );

        return Command::SUCCESS;
    }
}
