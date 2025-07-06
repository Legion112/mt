<?php
declare(strict_types=1);

namespace App\Domain\External\Shift4;

use App\Domain\CreateChargeRequest;
use App\Domain\CreateChargeResponse;
use App\Service\CreateChargeInterface;
use Money\Currency;
use Money\Money;
use Shift4\Exception\MappingException;
use Shift4\Request\ChargeRequest;
use Shift4\Shift4Gateway;

final class Shift4ChargeCreator implements CreateChargeInterface
{
    public function __construct(
        private readonly Shift4Gateway $shift4Gateway
    )
    {
    }

    /**
     * @throws MappingException
     */
    #[\Override]
    public function createCharge(CreateChargeRequest $request): CreateChargeResponse
    {
        $charge = $this->shift4Gateway->createCharge(
            new ChargeRequest(
                [
                    'amount' => $request->amount->getAmount(),
                    'currency' => $request->amount->getCurrency()->getCode(),
                    'card' => [
                        'number' => $request->card->number,
                        'expMonth' => $request->card->expiration->month,
                        'expYear' => $request->card->expiration->year,
                        'cvc' => $request->card->cvv
                    ],
                ]
            )
        );

        return new CreateChargeResponse(
            $charge->getId(),
            \DateTimeImmutable::createFromTimestamp($charge->getCreated()),
            new Money($charge->getAmount(), new Currency($charge->getCurrency())),
            $charge->getCard()->getFirst6()
        );
    }
}