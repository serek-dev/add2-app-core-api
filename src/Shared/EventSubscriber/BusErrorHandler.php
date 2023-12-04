<?php

declare(strict_types=1);

namespace App\Shared\EventSubscriber;

use App\Catalog\Exception\DuplicateException;
use App\Catalog\Exception\NotFoundException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Messenger\Exception\HandlerFailedException;

final class BusErrorHandler implements EventSubscriberInterface
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

        if (!$exception instanceof HandlerFailedException) {
            return;
        }

        if (!in_array(get_class($exception->getPrevious()), self::SUPPORTED_EXCEPTIONS, true)) {
            return;
        }

        $response = new JsonResponse(
            [
                'error' => $exception->getPrevious()->getMessage(),
                'code' => $exception->getPrevious()->getCode(),
            ],
            $exception->getPrevious()->getCode(),
        );

        $event->setResponse($response);
    }
}