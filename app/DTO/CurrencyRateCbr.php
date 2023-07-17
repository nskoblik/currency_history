<?php

declare(strict_types=1);

namespace App\DTO;

use App\VO\Money;

final class CurrencyRateCbr
{
    public function __construct(
        private readonly int $currency_code,
        private readonly int $nominal,
        private readonly Money $value
    ) {
    }

    public function getCurrencyCode(): int
    {
        return $this->currency_code;
    }

    public function getNominal(): int
    {
        return $this->nominal;
    }

    public function getValue(): Money
    {
        return $this->value;
    }
}


