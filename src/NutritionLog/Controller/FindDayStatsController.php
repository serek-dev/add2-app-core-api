<?php

declare(strict_types=1);


namespace App\NutritionLog\Controller;


use App\NutritionLog\ViewQuery\Day\FindDayStatsViewInterface;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/api/nutrition-log/stats', methods: 'GET')]
final class FindDayStatsController extends AbstractController
{
    public function __invoke(Request $request, FindDayStatsViewInterface $query): JsonResponse
    {
        $from = $request->query->get('from');
        $to = $request->query->get('to');

        return $this->json([
            'collection' => $query->findStats(new DateTimeImmutable($from), new DateTimeImmutable($to))
        ]);
    }
}
