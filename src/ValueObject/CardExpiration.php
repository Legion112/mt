<?php
declare(strict_types=1);

namespace App\ValueObject;

final readonly class CardExpiration
{
    public function __construct(
        /** @int-range<1,12> */
        public int $month,
        /** @positive-int */
        public int $year,
    )
    {
    }
}