<?php

declare(strict_types=1);


namespace App\Product\Controller;


use App\Product\Exception\NotFoundException;
use App\Product\ViewQuery\Product\FindProductsInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/api/products/{id}', methods: 'GET')]
final class GetProductController extends AbstractController
{
    public function __invoke(Request $request, FindProductsInterface $query): JsonResponse
    {
        try {
            $results = $query->getOne($request->get('id'));
        } catch (NotFoundException $e) {
            throw $this->createNotFoundException($e->getMessage());
        }

        return $this->json(['item' => $results]);
    }
}
