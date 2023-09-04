<?php

declare(strict_types=1);


namespace App\Tests\Application;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

abstract class ApplicationTestCase extends KernelTestCase
{
    protected const MILK = 'p-64abe79bdf370';
    protected const WHEY_PROTEIN = 'p-64ac15aa30df8';

    protected HttpClientInterface $client;
    protected EntityManagerInterface $em;

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
}
