<?php

declare(strict_types=1);


namespace App\Tests\Application;


use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

abstract class ApplicationTestCase extends KernelTestCase
{
    protected HttpClientInterface $client;

    protected array $headers = [
        'Content-Type' => 'application/json',
        'Accept' => 'application/json',
    ];

    protected function setUp(): void
    {
        parent::setUp();

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
        return $this->client->request('POST', '/api/products', [
            'json' => $payload,
        ]);
    }
}
