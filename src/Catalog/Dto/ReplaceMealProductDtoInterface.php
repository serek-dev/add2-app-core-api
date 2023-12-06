<?php

namespace App\Catalog\Dto;

interface ReplaceMealProductDtoInterface
{
    public function getMealId(): string;

    public function getProductId(): string;

    public function getNewProductId(): string;

    public function getUserId(): string;
}