<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Command\GetCurrencyRateCommand;
use App\Dictionary\CurrencyDictionary;
use App\Models\CurrencyHistory;
use Illuminate\Console\Command;

class GetRateCommand extends Command
{
    protected $signature = 'app:get-rate {date} {currency} {base_currency=RUB}';

    protected $description = 'Get currency rate for date';

    public function handle(): void
    {
        $date = \Illuminate\Support\Facades\Date::createFromFormat(
            CurrencyHistory::DATE_FORMAT,
            (string)$this->argument('date')
        );
        $currency = CurrencyDictionary::getDigitalCode(
            (string)$this->argument('currency')
        );
        $base_currency = CurrencyDictionary::getDigitalCode(
            (string)$this->argument('base_currency')
        );

        if (
            $currency === null
            || $base_currency === null
        ) {
            $this->error('Wrong currency code!');
            return;
        }

        $rate = (new GetCurrencyRateCommand(
            $date,
            $currency,
            $base_currency
        ))->execute();
        if ($rate === null) {
            $this->error('Something went wrong!');
            return;
        }

        $this->line('Rate: ' . $rate->getRate()->getDecimalAmount());
        if ($rate->getDiff() !== null) {
            $this->line('Diff: ' . $rate->getDiff()->getDecimalAmount());
        } else {
            $this->warn('Не удалось получить разницу');
        }
    }
}
