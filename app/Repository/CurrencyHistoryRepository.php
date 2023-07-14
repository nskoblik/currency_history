<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\CurrencyHistory;
use App\VO\Money;

class CurrencyHistoryRepository
{
    public function find(int $currency_code, \Illuminate\Support\Carbon $date): ?Money
    {
        $history = CurrencyHistory::where([
            'currency_code' => $currency_code,
            'date' => $date->toDateString()
        ])->first();
        if ($history === null) {
            return null;
        }

        return Money::getFromDecimal((float)$history->value);
    }
}
