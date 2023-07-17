<?php

declare(strict_types=1);

namespace App\DTO;

use App\VO\Money;

final class CurrencyCrossRate
{
    public function __construct(
        private readonly Money $rate,
        private readonly ?Money $diff
    ) {
    }

    public function getRate(): Money
    {
        return $this->rate;
    }

    public function getDiff(): ?Money
    {
        return $this->diff;
    }
}


