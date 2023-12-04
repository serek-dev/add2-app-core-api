<?php

declare(strict_types=1);


namespace App\Catalog\Exception;


use DomainException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class DuplicateException extends DomainException
{
    public function __construct(string $message = "", int $code = Response::HTTP_CONFLICT, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
