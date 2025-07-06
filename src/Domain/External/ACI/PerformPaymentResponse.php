<?php
declare(strict_types=1);

namespace App\Domain\External\ACI;

final readonly class PerformPaymentResponse
{
    public function __construct(
        public string $id,
        public string $amount,
        public string $currency,
        public \DateTimeImmutable $timestamp,
        public Card $card,
    ) {

    }
}