<?php
declare(strict_types=1);

namespace App\Domain\External\ACI;

use App\Domain\CreateChargeRequest;
use App\Domain\CreateChargeResponse;
use App\Service\ChargeCreationFailer;
use App\Service\CreateChargeInterface;
use Money\Currency;
use Money\Money;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final readonly class OppwaChargeCreator implements CreateChargeInterface
{
    public function __construct(private HttpClientInterface $oppwaClient, private SerializerInterface $serializer)
    {
    }

    #[\Override]
    public function createCharge(CreateChargeRequest $request): CreateChargeResponse
    {
        $response = $this->oppwaClient->request(
            'POST',
            'v1/payments',
            [
                'query' => [
                    'entityId' => '8ac7a4c79394bdc801939736f17e063d',
                    'amount' => $request->amount->getAmount(),
                    'currency' => $request->amount->getCurrency()->getCode(),
                    'paymentBrand' => 'VISA',
                    'paymentType' => 'DB',
                    'card.number' => $request->card->number,
                    'card.holder' => 'Jane Jones',
                    'card.expiryMonth' => $request->card->expiration->month,
                    'card.expiryYear' => $request->card->expiration->year,
                    'card.cvv' => $request->card->cvv,
                ]
            ]
        );
        if ($response->getStatusCode() !== 200) {
            throw new ChargeCreationFailer(
                $response->getContent(false)
            );
        }

        $paymentResponse = $this->serializer->deserialize(
            $response->getContent(false),
            PerformPaymentResponse::class,
            'json'
        );

        return new CreateChargeResponse(
            $paymentResponse->id,
            $paymentResponse->timestamp,
            new Money(
                $paymentResponse->amount,
                new Currency($paymentResponse->currency)
            ),
            $paymentResponse->card->bin,
        );

    }
}