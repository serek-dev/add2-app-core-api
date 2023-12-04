<?php

declare(strict_types=1);


namespace App\Catalog\Exception;


use DomainException;
use Throwable;

final class NotFoundException extends DomainException
{
    public function __construct(string $message = "", int $code = 404, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
