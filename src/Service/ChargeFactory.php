<?php
declare(strict_types=1);

namespace App\Service;

use App\Domain\External\ACI\OppwaChargeCreator;
use App\Domain\External\Shift4\Shift4ChargeCreator;

final readonly class ChargeFactory
{
    public function __construct(
        private Shift4ChargeCreator $shift4Charge,
        private OppwaChargeCreator $oppwaChargeCreator,
    ) {
    }

    public function createChargeProvider(string $provider): CreateChargeInterface
    {
        switch ($provider) {
            case 'Shift4':
                return $this->shift4Charge;
            case 'ACI':
                return $this->oppwaChargeCreator;
        }
        throw new \DomainException(sprintf('Provider "%s" is not supported.', $provider));
    }
}