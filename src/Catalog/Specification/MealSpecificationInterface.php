<?php

declare(strict_types=1);

namespace App\Catalog\Specification;

use App\Catalog\Entity\Meal;
use Throwable;

interface MealSpecificationInterface
{
    /** @throws Throwable - on false */
    public function isSatisfiedBy(Meal $meal): bool;
}