<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\CurrencyHistory;
use Illuminate\Support\Facades\Cache;

class CurrencyHistoryRepository
{
    public function find(int $currency_code, \Illuminate\Support\Carbon $date): ?CurrencyHistory
    {
        $cache_key = $currency_code . '_' . $date->toDateString();
        $history = Cache::get($cache_key);
        if ($history instanceof CurrencyHistory) {
            return $history;
        }

        $history = CurrencyHistory::where([
            'currency_code' => $currency_code,
            'date'          => $date->toDateString()
        ])->first();
        if ($history !== null) {
            Cache::put($cache_key, $history, now()->addMinutes(60));
            return $history;
        }

        $command = new \App\Command\UpdateCurrencyHistoryCommand($date);
        $collection = $command->execute();
        if ($collection === null) {
            return null;
        }
        $history = $collection->firstWhere('currency_code', $currency_code);
        if ($history === null) {
            return null;
        }
        Cache::put($cache_key, $history, now()->addMinutes(60));
        return $history;
    }

    public function hasRateForDate(\Illuminate\Support\Carbon $date): bool
    {
        $count = CurrencyHistory::where([
            'date' => $date->toDateString()
        ])->count();
        return $count > 0;
    }
}
