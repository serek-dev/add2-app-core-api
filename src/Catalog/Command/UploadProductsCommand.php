<?php

declare(strict_types=1);

namespace App\Catalog\Command;

use App\Catalog\Dto\UploadProductsDtoInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final readonly class UploadProductsCommand implements UploadProductsDtoInterface
{
    public function __construct(private UploadedFile $file, private string $userId)
    {
    }

    public function getFile(): UploadedFile
    {
        return $this->file;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}