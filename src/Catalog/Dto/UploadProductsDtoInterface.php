<?php

namespace App\Catalog\Dto;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface UploadProductsDtoInterface
{
    public function getFile(): UploadedFile;

    public function getUserId(): string;
}