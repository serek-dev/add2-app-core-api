<?php

declare(strict_types=1);

namespace App\Catalog\Command;

use App\Catalog\Dto\UploadProductsDtoInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class UploadProductsCommand implements UploadProductsDtoInterface
{
    public function __construct(private readonly UploadedFile $file)
    {
    }

    public function getFile(): UploadedFile
    {
        return $this->file;
    }
}