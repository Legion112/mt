<?php
declare(strict_types=1);

namespace App\Domain;

use App\ValueObject\Card;
use Money\Money;

final readonly class CreateChargeRequest
{
    public function __construct(
        public Money $amount,
        public Card $card,
    )
    {
    }
}