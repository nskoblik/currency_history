<?php

declare(strict_types=1);

namespace App\Command;

use App\Client\GetCurrencyClient;
use App\Models\CurrencyHistory;

final class UpdateCurrencyHistoryCommand
{
    public function execute(\Illuminate\Support\Carbon $date): void
    {
        //$date = new \DateTime();
        $currencies_curs = (new GetCurrencyClient())
            ->getCurrency($date);
        if (empty($currencies_curs)) {
            return;
        }
        foreach ($currencies_curs as $curs) {
            $history = new CurrencyHistory();

            $history->currency_code = $curs->getCode();
            $history->nominal = $curs->getNominal();
            $history->value = $curs->getValue();
            $history->date = $date;
            $history->save();
        }
    }
}
