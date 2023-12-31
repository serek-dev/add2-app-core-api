<?php

declare(strict_types=1);


namespace App\Catalog\Controller;


use App\Catalog\Command\UploadProductsCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/api/catalog/products/xls/upload', methods: 'POST')]
final class UploadProductsController extends AbstractController
{
    public function __invoke(Request $request, MessageBusInterface $bus): JsonResponse
    {
        try {
            $bus->dispatch(
                new UploadProductsCommand(
                    $request->files->get('file'),
                )
            );
        } catch (HandlerFailedException $e) {
            throw new BadRequestException($e->getMessage());
        }

        return $this->json(null, Response::HTTP_ACCEPTED);
    }
}
