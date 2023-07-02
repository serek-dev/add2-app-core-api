<?php

declare(strict_types=1);


namespace App\Product\Entity;


use App\Product\Value\NutritionalValues;

final class Product
{
    public function __construct(NutritionalValues $nutritionalValues)
    {
    }
}
