<?php

declare(strict_types=1);

namespace App\Metric\Controller;

use App\Metric\Dto\FindMetricDto;
use App\Metric\Repository\FindMetricsInterface;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use function date;

#[AsController]
#[Route('/api/metric/metrics', methods: ['GET'])]
final class FindMetricController extends AbstractController
{
    public function __invoke(Request $request, ValidatorInterface $validator, FindMetricsInterface $findUngrouped): JsonResponse
    {
        $dto = new FindMetricDto(
            $request->query->all('types'),
            $request->query->get('from', (new DateTimeImmutable())->modify('-1 week')->format('Y-m-d')),
            $request->query->get('to', date('Y-m-d')),
            $request->query->getBoolean('avg'),
        );

        if (!$dto->avg) {
            return $this->json([
                'collection' => $findUngrouped->findByTypesTimeAscOrdered(
                    from: $dto->getFrom(),
                    to: $dto->getTo(),
                    types: $dto->getTypes())
            ]);
        }

        return $this->json([
            'collection' => $findUngrouped->findAverageByTypesTimeAscOrdered(
                from: $dto->getFrom(),
                to: $dto->getTo(),
                types: $dto->getTypes())
        ]);
    }
}