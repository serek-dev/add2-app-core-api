<?php

namespace App\Shared\Event;

interface ProductCreatedInterface
{
    public function getId(): string;

    public function getName(): string;

    public function getProteins(): float;

    public function getFats(): float;

    public function getCarbs(): float;

    public function getKcal(): float;

    public function getProducerName(): ?string;
}
