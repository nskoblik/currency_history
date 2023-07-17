<?php

declare(strict_types=1);

namespace App\Command;

use App\Client\GetCurrencyClient;
use App\Models\CurrencyHistory;
use App\Repository\CurrencyHistoryRepository;

final class UpdateCurrencyHistoryCommand
{
    public function __construct(
        private \Illuminate\Support\Carbon $date,
        private bool                       $with_collection = true
    ) {
    }

    public function execute(): ?\Illuminate\Support\Collection
    {
        if (!$this->canUpdateCurrency()) {
            return null;
        }
        try {
            $currencies_curs = (new GetCurrencyClient())->getCurrency($this->date);
        } catch (\Exception) {
            return null;
        }

        if (empty($currencies_curs)) {
            return null;
        }

        $collection = $this->with_collection ? collect() : null;
        foreach ($currencies_curs as $curs) {
            $history = new CurrencyHistory();
            $history->currency_code = $curs->getCurrencyCode();
            $history->nominal = $curs->getNominal();
            $history->value = $curs->getValue()->getAmount();
            $history->date = $this->date;
            $history->save();
            if ($collection) {
                $collection->add($history);
            }
        }
        return $collection;
    }

    private function canUpdateCurrency(): bool
    {
        $currency_repository = new CurrencyHistoryRepository();
        return !$currency_repository->hasRateForDate($this->date);
    }
}
