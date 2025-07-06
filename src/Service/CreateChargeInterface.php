<?php
declare(strict_types=1);

namespace App\Service;

use App\Domain\CreateChargeRequest;
use App\Domain\CreateChargeResponse;

interface CreateChargeInterface
{
    /**
     * @throws ChargeCreationFailer
     */
    public function createCharge(CreateChargeRequest $request): CreateChargeResponse;
}