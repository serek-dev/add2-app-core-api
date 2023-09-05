<?php

declare(strict_types=1);


namespace App\NutritionLog\Cli;


use App\NutritionLog\ViewQuery\Day\FindDayViewInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('app:diary:show-day', 'Adds product to nutrition day')]
final class ShowDay extends Command
{
    public function __construct(private readonly FindDayViewInterface $findDay)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $day = $this->findDay->findDay('2023-07-06');

        $table = new Table($output);

        $table
            ->setHeaders(array_map(fn(string $k) => ucfirst($k), array_keys($day->getStats())))
            ->setRows([array_map(fn($v) => $v, $day->getStats())]);
        $table->render();

        $table = new Table($output);

        $rows = [];

        $data = $day->getProducts();

        foreach ($data as $product) {
            $rows[] = $product;
            $next = next($data);

            if (isset($next['consumption_time']) && $next['consumption_time'] !== $product['consumption_time']) {
                $rows[] = new TableSeparator();
            }
        }

        $table
            ->setHeaders([
                'Time',
                'Id',
                'Product',
                'Name',
                'Producer',
                'Weight',
                'Proteins',
                'Fats',
                'Carbs',
                'Kcal'
            ])
            ->setRows($rows);
        $table->render();

        return Command::SUCCESS;
    }
}
