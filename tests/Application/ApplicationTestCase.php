<?php

declare(strict_types=1);


namespace App\Tests\Application;


use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class ApplicationTestCase extends KernelTestCase
{
    protected HttpClientInterface $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = HttpClient::createForBaseUri(baseUri: 'http://web', defaultOptions: [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ]
        ]);
    }
}
