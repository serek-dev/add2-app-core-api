<?php

declare(strict_types=1);

namespace App\Metric\Controller;

use App\Metric\Dto\CreateMetricDto;
use App\Metric\Factory\Factory;
use App\Metric\Repository\CreateMetricInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use function count;

#[AsController]
#[Route('/api/metric/metrics', name: 'metrics_create', methods: ['POST'])]
final class CreateMetricController extends AbstractController
{
    public function __invoke(Request $request, CreateMetricInterface $persist, Factory $factory, ValidatorInterface $validator): JsonResponse
    {
        $dto = new CreateMetricDto(
            type: $request->getPayload()->get('type'),
            value: $request->getPayload()->get('value'),
            date: $request->getPayload()->get('date'),
        );

        $errors = $validator->validate($dto);

        if (count($errors) > 0) {
            return $this->json([
                'errors' => (string)$errors,
            ], Response::HTTP_BAD_REQUEST);
        }

        $metric = $factory->create($dto);

        $persist->store($metric);

        return $this->json(null, Response::HTTP_CREATED);
    }
}