<?php

declare(strict_types=1);

namespace App\Shared\EventSubscriber;

use App\Catalog\Exception\DuplicateException;
use App\Catalog\Exception\NotFoundException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class DomainErrorHandler implements EventSubscriberInterface
{
    private const SUPPORTED_EXCEPTIONS = [
        NotFoundException::class,
        DuplicateException::class,
    ];

    public static function getSubscribedEvents()
    {
        return [KernelEvents::EXCEPTION => 'handleException'];
    }

    public function handleException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if (!in_array(get_class($exception), self::SUPPORTED_EXCEPTIONS, true)) {
            return;
        }

        $response = new JsonResponse(
            [
                'error' => $exception->getMessage(),
                'code' => $exception->getCode(),
            ],
            $exception->getCode(),
        );

        $event->setResponse($response);
    }
}