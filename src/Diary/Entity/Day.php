<?php

declare(strict_types=1);


namespace App\Diary\Entity;


use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table('diary_day')]
final class Day
{
    #[Id]
    #[GeneratedValue]
    #[Column]
    private readonly ?int $id;

    #[OneToMany(mappedBy: 'day', targetEntity: DayProduct::class, cascade: ['PERSIST'], fetch: "EAGER")]
    private mixed $products;

    #[Column]
    private readonly string $date;

    public function __construct(
        DateTimeInterface $date,
    ) {
        $this->date = $date->format('Y-m-d');

        $this->products = new ArrayCollection();
    }

    public function addProduct(DayProduct $dayProduct): void
    {
        $this->products->add($dayProduct);
        $dayProduct->setDay($this);
    }

    public function getDate(): string
    {
        return $this->date;
    }

    /** @return DayProduct[] */
    public function getProducts(): array
    {
        return $this->products->toArray();
    }
}
