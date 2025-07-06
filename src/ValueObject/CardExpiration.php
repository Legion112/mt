<?php
declare(strict_types=1);

namespace App\ValueObject;

final readonly class CardExpiration
{
    public function __construct(
        public int $month,
        public int $year,
    )
    {
        assert($this->month >= 1 && $this->month <= 12);
        assert($this->year >= 0);
    }
}