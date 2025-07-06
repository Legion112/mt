<?php
declare(strict_types=1);

namespace App\ValueObject;

final readonly class Card
{
    public function __construct(
        public string         $number,
        public CardExpiration $expiration,
        public string         $cvv,
    )
    {
        assert(is_numeric($this->number));
        assert(is_numeric($this->cvv));
    }
}