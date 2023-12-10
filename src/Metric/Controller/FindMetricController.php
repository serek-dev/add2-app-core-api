<?php

declare(strict_types=1);

namespace App\Metric\Controller;

use App\Metric\Dto\FindMetricDto;
use App\Metric\Repository\FindMetricsInterface;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use function date;

#[AsController]
#[Route('/api/metric/users/{userId}/metrics', methods: ['GET'])]
final class FindMetricController extends AbstractController
{
    public function __invoke(Request $request, ValidatorInterface $validator, FindMetricsInterface $find, string $userId): JsonResponse
    {
        $dto = new FindMetricDto(
            $request->query->all('types'),
            $request->query->get('from', (new DateTimeImmutable())->modify('-1 week')->format('Y-m-d')),
            $request->query->get('to', date('Y-m-d')),
            $request->query->get('aggregation'),
        );

        if ($dto->getAggregation()) {
            return $this->json([
                'collection' => $find->findAggregatedByTypesTimeAscOrdered(
                    aggregation: $dto->getAggregation(),
                    from: $dto->getFrom(),
                    to: $dto->getTo(),
                    userId: $userId,
                    types: $dto->getTypes())
            ]);
        }

        return $this->json([
            'collection' => $find->findByTypesTimeAscOrdered(
                from: $dto->getFrom(),
                to: $dto->getTo(),
                userId: $userId,
                types: $dto->getTypes()
            )
        ]);
    }
}