<?php
declare(strict_types=1);

namespace App\ValueObject;

final readonly class CardExpiration
{
    public function __construct(
        public string $month,
        public int    $year,
    )
    {
        assert($this->year >= 0);
    }
}