<?php

declare(strict_types=1);


namespace App\Catalog\Entity;


use App\Catalog\Exception\InvalidArgumentException;
use App\Catalog\Exception\NotFoundException;
use App\Catalog\Value\Weight;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;
use Generator;
use function array_values;
use function round;

#[Entity]
#[Table('catalog_meal')]
class Meal
{
    #[OneToMany(mappedBy: 'meal', targetEntity: MealProduct::class, cascade: ['PERSIST', 'REMOVE'], fetch: "EAGER")]
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
        return array_values($this->products->toArray());
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
    public function removeProducts(string ...$ids): Generator
    {
        /** @var MealProduct[] $filtered */
        $filtered = $this->products->filter(
            fn(MealProduct $p) => empty($ids) || in_array($p->getId(), $ids)
        );
        foreach ($filtered as $p) {
            $this->products->removeElement($p);
            $p->setMeal(null);
            yield $p;
        }
    }

    public function hasProduct(string $id): bool
    {
        return $this->products->filter(fn(MealProduct $p) => $p->getId() === $id)->count() > 0;
    }

    /**
     * @throws NotFoundException
     */
    public function changeProductWeight(string $productId, Weight $newWeight): void
    {
        $product = $this->products->filter(fn(MealProduct $p) => $p->getId() === $productId);
        /** @var MealProduct|Collection $product */
        $product = $product->count() > 0 ? $product->first() : throw new NotFoundException('Product: ' . $productId . ' does not exist');

        $product->changeWeight($newWeight);
    }

    public function replaceProduct(string $productId, Product $product): void
    {
        $replacedProduct = $this->products->filter(fn(MealProduct $p) => $p->getId() === $productId);

        /** @var MealProduct|Collection $replacedProduct */
        $replacedProduct = $replacedProduct->count() > 0 ? $replacedProduct->first() : throw new NotFoundException('Product: ' . $productId . ' does not exist');

        $desiredKcal = $replacedProduct->getKcal();

        $caloriesPer100g = $product->getNutritionValues()->getKcal();

        $amountNeeded = round(($desiredKcal) / ($caloriesPer100g) * 100, 2);

//        $this->products->add(
//            new MealProduct(
//                $newId = uniqid('MP-'),
//                new Weight(100),
//                new NutritionalValues(
//                    new Weight($product->getNutritionValues()->getProteins()),
//                    new Weight($product->getNutritionValues()->getProteins()),
//                    new Weight($product->getNutritionValues()->getProteins()),
//                    $product->getNutritionValues()->getKcal(),
//                ),
//                $product->getName(),
//                $product->getId(),
//                $product->getProducerName(),
//            )
//        );

        $replacedProduct->replaceByProduct($product);
        $replacedProduct->changeWeight(new Weight($amountNeeded));

        $this->changeProductWeight($productId, new Weight($amountNeeded));
    }
}
