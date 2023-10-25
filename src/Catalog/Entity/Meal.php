<?php

declare(strict_types=1);


namespace App\Catalog\Entity;


use App\Catalog\Exception\InvalidArgumentException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;
use Generator;

#[Entity]
#[Table('catalog_meal')]
class Meal
{
    #[OneToMany(mappedBy: 'meal', targetEntity: MealProduct::class, cascade: ['PERSIST'], fetch: "EAGER")]
    private mixed $products;

    /**
     * @param MealProduct[] $products
     */
    public function __construct(
        #[Id]
        #[GeneratedValue(strategy: "NONE")]
        #[Column]
        private readonly string $id,
        #[Column]
        private readonly string $name,
        array $products,
    ) {
        foreach ($products as $p) {
            if (!$p instanceof MealProduct) {
                throw new InvalidArgumentException('Argument must be a: ' . MealProduct::class . ' instance');
            }
            $p->setMeal($this);
        }

        $this->products = new ArrayCollection($products);
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return MealProduct[]
     */
    public function getProducts(): array
    {
        return $this->products->toArray();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function addProduct(MealProduct $mealProduct): void
    {
        $this->products->add($mealProduct->setMeal($this));
    }

    /** @internal */
    public function removeProducts(): Generator
    {
        // todo: handle it in a better way
        foreach ($this->products as $p) {
            $this->products->removeElement($p);
            yield $p;
        }
    }
}
