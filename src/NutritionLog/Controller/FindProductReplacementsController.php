<?php

declare(strict_types=1);


namespace App\NutritionLog\Controller;


use App\NutritionLog\Presenter\FindProductReplacementsPresenter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/api/nutrition-log/{day}/products/{productId}/replacements', methods: 'GET')]
final class FindProductReplacementsController extends AbstractController
{


    public function __invoke(Request $request, FindProductReplacementsPresenter $presenter): JsonResponse
    {
        return $this->json(
            $presenter->render(
                $request->get('day'),
                $request->get('productId'),
            ),
            Response::HTTP_OK
        );
    }
}
