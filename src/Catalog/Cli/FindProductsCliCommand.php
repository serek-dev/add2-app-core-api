<?php

declare(strict_types=1);


namespace App\Catalog\Cli;


use App\Catalog\View\MealProductView;
use App\Catalog\ViewQuery\Product\FindProductsInterface;
use App\Product\Query\FindProductsCommand;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('app:product:find', 'Find products by requested name')]
final class FindProductsCliCommand extends Command
{
    public function __construct(private readonly FindProductsInterface $query)
    {
        parent::__construct();
        $this->addArgument(name: 'name', default: null);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $results = $this->query->findAll($input->getArgument('name'));

        $table = new Table($output);
        $table
            ->setHeaders(['#', 'Name', 'Producer', 'P', 'F', 'W', 'Kcal'])
            ->setRows(array_map(fn(MealProductView $v) => $v->jsonSerialize(), $results));
        $table->render();

        return Command::SUCCESS;
    }
}
