<?php

namespace App\Catalog\Utils;

interface XlsToArrayInterface
{
    public function normalize(string $content): array;
}