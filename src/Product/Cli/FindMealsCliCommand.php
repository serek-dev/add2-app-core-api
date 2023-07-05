<?php

declare(strict_types=1);


namespace App\Product\Cli;


use App\Product\View\MealView;
use App\Product\ViewQuery\Meal\FindMealsInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('app:meal:find', 'Find meals by requested name')]
final class FindMealsCliCommand extends Command
{
    public function __construct(private readonly FindMealsInterface $query)
    {
        parent::__construct();
        $this->addArgument(name: 'name', default: null);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $results = $this->query->findAll($input->getArgument('name'));

        $table = new Table($output);
        $table
            ->setHeaders(['#', 'Name', 'P', 'F', 'W', 'Kcal'])
            ->setRows(array_map(fn(MealView $v) => $v->jsonSerialize(), $results));
        $table->render();

        return Command::SUCCESS;
    }
}
