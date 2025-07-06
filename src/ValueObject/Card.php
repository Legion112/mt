<?php
declare(strict_types=1);

namespace App\ValueObject;

use JetBrains\PhpStorm\Immutable;

final readonly class Card
{
    public function __construct(
        public string $number,
        public CardExpiration $expiration,
        public string $cvv,
    )
    {
    }
}