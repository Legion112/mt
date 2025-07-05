<?php
declare(strict_types=1);

namespace App\Service;

use App\Domain\External\Shift4\Shift4Charge;

final readonly class ChargeFactory
{
    public function __construct(private Shift4Charge $shift4Charge)
    {
    }

    public function createChargeProvider(string $provider): CreateChargeInterface
    {
        switch ($provider) {
            case "Shift4":
                return $this->shift4Charge;
        }
        throw new \DomainException(sprintf('Provider "%s" is not supported.', $provider));
    }
}