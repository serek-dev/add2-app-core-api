<?php

declare(strict_types=1);

namespace App\Shared\DataFixtures;

use App\Metric\Dto\CreateMetricDto;
use App\Metric\Factory\MetricFactoryDirector;
use App\Metric\Value\MetricType;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use function rand;
use function range;

final class MetricFixtures extends Fixture implements FixtureGroupInterface
{
    public function __construct(private readonly MetricFactoryDirector $factory)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $now = new DateTimeImmutable();
        $dates = [];

        $range = range(0, 2);

        foreach ($range as $value) {
            $dates[] = $now->modify("-{$value} day");
        }

        foreach ($dates as $date) {
            $max = rand(1, 15);
            for ($c = 0; $c !== $max; $c++) {
                // random time within the same day
                $date = $date->setTime(rand(0, 23), rand(0, 59), rand(0, 59));

                $manager->persist(
                    $this->factory->create(
                        new CreateMetricDto(
                            type: MetricType::HUNGER->value,
                            value: rand(1, 10),
                            date: $date->format('Y-m-d H:i'),
                        )
                    )
                );
            }
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['metrics'];
    }
}
