<?php
declare(strict_types=1);

namespace App\Domain\External\Shift4;

use App\Domain\CreateChargeRequest;
use App\Domain\CreateChargeResponse;
use App\Service\CreateChargeInterface;
use Money\Money;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class Shift4Charge implements CreateChargeInterface
{
    public function __construct(private HttpClientInterface $shift4Client)
    {
    }

    public function createCharge(CreateChargeRequest $request): CreateChargeResponse
    {

        return new CreateChargeResponse(
            "abc",
            new \DateTimeImmutable(),
            Money::EUR(10_00),
            "88888888"
        );
    }
}