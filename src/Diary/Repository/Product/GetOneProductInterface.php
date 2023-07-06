<?php

declare(strict_types=1);


namespace App\Diary\Repository\Product;

use App\Diary\Entity\Product;
use App\Diary\Exception\NotFoundException;

interface GetOneProductInterface
{
    /**
     * @throws NotFoundException
     */
    public function getOne(string $productId): Product;
}
