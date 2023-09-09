<?php

declare(strict_types=1);


namespace App\NutritionLog\Entity;


use App\NutritionLog\Exception\InvalidArgumentException;
use App\NutritionLog\Value\ConsumptionTime;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table('nutrition_log_day_meal')]
final class DayMeal
{
    #[OneToMany(mappedBy: 'meal', targetEntity: DayMealProduct::class, cascade: ['PERSIST', 'remove'], fetch: "EAGER")]
    private mixed $products;

    #[ManyToOne(targetEntity: Day::class, inversedBy: 'meals')]
    private Day $day;

    #[Column]
    private string $consumptionTime;

    /**
     * @param DayMealProduct[] $products
     */
    public function __construct(
        #[Id]
        #[GeneratedValue(strategy: "NONE")]
        #[Column]
        private readonly string $id,
        #[Column]
        private readonly string $name,
        ConsumptionTime $consumptionTime,
        array $products,
    ) {
        foreach ($products as $p) {
            if (!$p instanceof DayMealProduct) {
                throw new InvalidArgumentException('Argument must be a: ' . DayMealProduct::class . ' instance');
            }
            $p->setMeal($this);
        }

        $this->products = new ArrayCollection($products);

        $this->consumptionTime = (string)$consumptionTime;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return DayMealProduct[]
     */
    public function getProducts(): array
    {
        return $this->products->toArray();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setDay(Day $value): void
    {
        $this->day = $value;
    }

    public function getConsumptionTime(): ConsumptionTime
    {
        return new ConsumptionTime(new DateTimeImmutable($this->consumptionTime));
    }
}
