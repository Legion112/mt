<?php
declare(strict_types=1);

namespace App\ValueObject;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class CardExpiration
{
    public function __construct(
        #[Assert\Type('string')]
        public string $month,
        public int    $year,
    )
    {
        assert($this->year >= 0);
    }
}