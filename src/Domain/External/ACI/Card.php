<?php
declare(strict_types=1);

namespace App\Domain\External\ACI;

final readonly class Card
{
    public function __construct(
        public string $bin,
    )
    {
    }
}