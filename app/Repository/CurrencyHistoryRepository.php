<?php

declare(strict_types=1);

namespace App\Repository;

class CurrencyHistoryRepository
{
    public function find(int $currency_code, int $date)
    {
        $flight = \App\Models\CurrencyHistory::find();
    }
}
