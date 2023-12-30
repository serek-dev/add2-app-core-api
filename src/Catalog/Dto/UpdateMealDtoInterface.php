<?php

declare(strict_types=1);


namespace App\Catalog\Dto;

interface UpdateMealDtoInterface
{
    public function getName(): string;

    public function getId(): string;

    public function getUserId(): string;

    public function getDescription(): ?string;
}
