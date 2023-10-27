<?php

namespace App\Catalog\Dto;

interface RemoveMealProductDtoInterface
{
    public function getProductId(): string;

    public function getMealId(): string;
}