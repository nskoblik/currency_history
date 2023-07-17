<?php

declare(strict_types=1);

namespace App\Command;

use App\DTO\CurrencyCrossRate;
use App\Service\GetRateService;

final class GetCurrencyRateCommand
{
    private GetRateService $rate_service;

    public function __construct(
        private \Illuminate\Support\Carbon $date,
        private int                        $currency_code,
        private int                        $base_currency_code
    ) {
        $this->rate_service = new GetRateService();
    }

    public function execute(): ?CurrencyCrossRate
    {
        $rate = $this->rate_service->getRate(
            $this->date,
            $this->currency_code,
            $this->base_currency_code
        );
        if ($rate === null) {
            return null;
        }

        $prev_rate = $this->rate_service->getRate(
            $this->date->sub('1 day'),
            $this->currency_code,
            $this->base_currency_code
        );
        return new CurrencyCrossRate(
            $rate,
            $prev_rate !== null ? $rate->subtract($prev_rate) : null
        );
    }
}
