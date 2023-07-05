<?php

declare(strict_types=1);


namespace App\Product\Cli;


use App\Product\ViewQuery\Meal\FindMealsInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableCellStyle;
use Symfony\Component\Console\Helper\TableSeparator;
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

        $rows = [];

        foreach ($results as $result) {
            if (!empty($rows)) {
                $rows[] = new TableSeparator();
            }
            $row = $result->jsonSerialize();
            unset($row['products']);

            $tableStyle = [
                'style' => new TableCellStyle([
                    'fg' => 'bright-white',
                ])
            ];
            $rows[] = array_map(fn($p) => new TableCell((string)$p, $tableStyle), $row);

            $rows[] = new TableSeparator();

            foreach ($result->jsonSerialize()['products'] as $p) {
                unset($p['producerName']);
                $tableStyle = [
                    'style' => new TableCellStyle([
                        'fg' => 'white',
                    ])
                ];
                $rows[] = array_map(fn($p) => new TableCell((string)$p, $tableStyle), $p);
            }
        }

        $table = new Table($output);

        $table
            ->setHeaders(['#', 'Name', 'P', 'F', 'W', 'Kcal', 'Weight (g)'])
            ->setRows($rows);

        $table->render();

        return Command::SUCCESS;
    }
}
