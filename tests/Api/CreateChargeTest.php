<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class CreateChargeTest extends ApiTestCase
{

    public static function providers(): \Generator
    {
        yield 'Shift4' => ['Shift4'];
        yield 'ACI' => ['ACI'];
    }

    #[DataProvider('providers')]
    public function testSomething(string $provider): void
    {
        $client = static::createClient();
        $response = $client->request('POST', "/charge/$provider", [
            'json' => [
                'amount' => [
                    'currency' => ['code' => 'EUR'],
                    'amount' => '1000',
                ],
                'card' => [
                    'number' => '4242424242424242',
                    'expiration' => [
                        'month' => '01',
                        'year' => 2026
                    ],
                    'cvv' => '123',
                ]
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
                'amount' => [
                    'currency' => 'EUR',
                    'amount' => '1000',
                ],
                'cardBin' => '424242'
            ]
        );
        $json = $response->toArray();
        self::assertArrayHasKey('transactionId', $json);
        self::assertArrayHasKey('createdAt', $json);
    }
}
