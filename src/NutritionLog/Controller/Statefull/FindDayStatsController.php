<?php

declare(strict_types=1);


namespace App\NutritionLog\Controller\Statefull;


use App\NutritionLog\ViewQuery\Day\FindDayStatsViewInterface;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/api/nutrition-log/users/{userId}/days/stats', methods: 'GET')]
final class FindDayStatsController extends AbstractController
{
    public function __invoke(
        Request                      $request,
        FindDayStatsViewInterface    $query,
        string                       $userId,
        #[MapQueryParameter] ?string $from = null,
        #[MapQueryParameter] ?string $to = null,
    ): JsonResponse
    {
        return $this->json([
            'collection' => $query->findStats(
                DateTimeImmutable::createFromFormat('Y-m-d', $from),
                DateTimeImmutable::createFromFormat('Y-m-d', $to),
                $userId,
            )
        ]);
    }
}
