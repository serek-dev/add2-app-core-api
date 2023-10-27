<?php

declare(strict_types=1);


namespace App\Tests\Application;


use App\Catalog\Builder\MealBuilder;
use App\Catalog\Entity\Meal;
use App\Catalog\Entity\Product;
use App\Catalog\Persistence\Product\FindProductByIdInterface;
use App\Catalog\Value\NutritionalValues;
use App\Catalog\Value\Weight;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use function json_decode;

abstract class ApplicationTestCase extends KernelTestCase
{
    protected const MILK = 'p-64abe79bdf370';
    protected const WHEY_PROTEIN = 'p-64ac15aa30df8';
    protected const EGG = 'p-64abe7897e3c8';
    protected const OLIVE = 'p-sa23asda123';
    protected const OAT_BRAN = 'p-sa23asda321';

    protected const PANCAKE = 'M-64f6031add8ee';

    protected HttpClientInterface $client;
    protected EntityManagerInterface $em;
    protected MessageBusInterface $bus;

    protected array $headers = [
        'Content-Type' => 'application/json',
        'Accept' => 'application/json',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        static::bootKernel([
            'environment' => 'test',
        ]);
        $container = static::getContainer();

        $this->em = $container->get(EntityManagerInterface::class);

        $this->bus = $container->get(MessageBusInterface::class);

        $this->client = HttpClient::createForBaseUri(baseUri: 'http://web', defaultOptions: [
            'headers' => $this->headers,
        ]);
    }

    protected function iAmAuthenticated(): self
    {
        $this->headers['authentication'] = '';
        return $this;
    }

    protected function iCallPostApi(string $endpoint, array $payload): ResponseInterface
    {
        return $this->client->request('POST', $endpoint, [
            'json' => $payload,
        ]);
    }

    protected function iCallPutApi(string $endpoint, array $payload): ResponseInterface
    {
        return $this->client->request('PUT', $endpoint, [
            'json' => $payload,
        ]);
    }

    protected function iCallGetApi(string $endpoint, array $queryParams = []): ResponseInterface
    {
        return $this->client->request('GET', $endpoint . '?' . http_build_query($queryParams));
    }

    protected function iCallDeleteApi(string $endpoint, array $queryParams = []): ResponseInterface
    {
        return $this->client->request('DELETE', $endpoint . '?' . http_build_query($queryParams));
    }

    protected function assertCollectionFormat(ResponseInterface $response): void
    {
        $body = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('collection', $body);
        $this->assertArrayHasKey('metadata', $body);
        $this->assertArrayHasKey('count', $body['metadata']);
    }

    protected function assertItemFormat(ResponseInterface $response): void
    {
        $body = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('item', $body);
    }

    protected function withMilk(): self
    {
        if ($this->productExists(self::MILK)) {
            return $this;
        }

        $milk = new Product(
            self::MILK,
            new NutritionalValues(
                new Weight(3.40),
                new Weight(2.0),
                new Weight(4.90),
                51.0,
            ),
            'Milk',
            null,
        );

        $this->em->persist($milk);
        $this->em->flush();

        return $this;
    }

    protected function withWheyProtein(): self
    {
        if ($this->productExists(self::WHEY_PROTEIN)) {
            return $this;
        }

        $wheyProtein = new Product(
            self::WHEY_PROTEIN,
            new NutritionalValues(
                new Weight(80.0),
                new Weight(3.0),
                new Weight(2.20),
                356.0,
            ),
            'Whey Protein',
            'Olimp',
        );

        $this->em->persist($wheyProtein);
        $this->em->flush();

        return $this;
    }

    protected function withEgg(): self
    {
        if ($this->productExists(self::EGG)) {
            return $this;
        }

        $wheyProtein = new Product(
            self::EGG,
            new NutritionalValues(
                new Weight(12.50),
                new Weight(9.7),
                new Weight(0.6),
                140.0,
            ),
            'Egg',
            null,
        );

        $this->em->persist($wheyProtein);
        $this->em->flush();

        return $this;
    }

    protected function withOlive(): self
    {
        if ($this->productExists(self::OLIVE)) {
            return $this;
        }

        $wheyProtein = new Product(
            self::OLIVE,
            new NutritionalValues(
                new Weight(0.0),
                new Weight(99.6),
                new Weight(0.2),
                897.0,
            ),
            'Olive',
            null,
        );

        $this->em->persist($wheyProtein);
        $this->em->flush();

        return $this;
    }

    private function productExists(string $id): bool
    {
        /** @var ObjectRepository $repo */
        $repo = $this->em->getRepository(Product::class);

        return !empty($repo->find($id));
    }

    private function mealExists(string $name): bool
    {
        /** @var ObjectRepository $repo */
        $repo = $this->em->getRepository(Meal::class);

        return !empty($repo->findOneBy(['name' => $name]));
    }

    protected function withOatBran(): self
    {
        if ($this->productExists(self::OAT_BRAN)) {
            return $this;
        }

        $wheyProtein = new Product(
            self::OAT_BRAN,
            new NutritionalValues(
                new Weight(17.0),
                new Weight(7.0),
                new Weight(66.0),
                425.0,
            ),
            'Oat bran',
            'Sante',
        );

        $this->em->persist($wheyProtein);
        $this->em->flush();

        return $this;
    }

    protected function withPancakeMeal(): self
    {
        if ($this->mealExists('Pancake')) {
            return $this;
        }

        $this->withOatBran()
            ->withMilk()
            ->withOlive()
            ->withWheyProtein()
            ->withEgg();

        /** @var MealBuilder $builder */
        $builder = self::getContainer()->get(MealBuilder::class);

        /** @var FindProductByIdInterface $repo */
        $repo = self::getContainer()->get(FindProductByIdInterface::class);

        $builder->addProduct(
            new Weight(10.0),
            $repo->findById(self::OAT_BRAN)
        );
        $builder->addProduct(
            new Weight(35.0),
            $repo->findById(self::WHEY_PROTEIN)
        );
        $builder->addProduct(
            new Weight(5.0),
            $repo->findById(self::OLIVE)
        );
        $builder->addProduct(
            new Weight(56.0),
            $repo->findById(self::EGG)
        );
        $builder->addProduct(
            new Weight(100.0),
            $repo->findById(self::MILK)
        );

        $meal = $builder->withId(self::PANCAKE)->build('Pancake');

        $this->em->persist($meal);
        $this->em->flush();

        return $this;
    }

    protected function assertNotFoundFormat(ResponseInterface $response)
    {
        $body = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('message', $body);
    }
}
