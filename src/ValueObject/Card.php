<?php
declare(strict_types=1);

namespace App\ValueObject;

use JetBrains\PhpStorm\Immutable;

#[Immutable]
class Card
{
    public function __construct(
        public string $number,
        public string $expMonth,
        public string $expYear,
        public string $cvv,
    )
    {
    }
}