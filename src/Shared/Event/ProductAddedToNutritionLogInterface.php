<?php

declare(strict_types=1);

namespace App\Shared\Event;

use DateTimeInterface;

/**
 *  Don't think to change this class name as it will break the removal method!
 */
interface ProductAddedToNutritionLogInterface
{
    public const NAME = 'ProductAddedToNutritionLog';

    public function getDayProductId(): string;

    public function getDate(): DateTimeInterface;

    public function getKcal(): float;

    public function getUserId(): string;
}