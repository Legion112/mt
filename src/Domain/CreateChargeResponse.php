<?php
declare(strict_types=1);

namespace App\Domain;

use Money\Money;

final readonly class CreateChargeResponse
{
    public function __construct(
        public string             $transactionId,
        public \DateTimeImmutable $createdAt,
        public Money              $amount,
        public string             $cardBin,
    )
    {
    }
}