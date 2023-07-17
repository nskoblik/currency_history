<?php

declare(strict_types=1);

namespace App\Service;

use App\Dictionary\CurrencyDictionary;
use App\Repository\CurrencyHistoryRepository;
use App\VO\Money;
use Illuminate\Support\Facades\Cache;

final class GetRateService
{
    private CurrencyHistoryRepository $currency_repository;

    public function __construct()
    {
        $this->currency_repository = new CurrencyHistoryRepository();
    }

    public function getRate(
        \Illuminate\Support\Carbon $date,
        int                        $currency_code,
        int                        $base_currency_code
    ): ?Money {
        $cache_key = implode('_', [
            $date->toDateString(),
            $currency_code,
            $base_currency_code
        ]);
        $rate = Cache::get($cache_key);
        if ($rate !== null) {
            return new Money((int)$rate);
        }

        $to_rub = $this->transferToRub(
            $currency_code,
            $date,
            Money::getFromDecimal(1.0)
        );
        if ($to_rub === null) {
            return null;
        }
        if ($base_currency_code === CurrencyDictionary::CODE_RUB) {
            Cache::put($cache_key, $to_rub->getAmount(), now()->addDay());
            return $to_rub;
        }

        $to_currency = $this->transferToCurrency(
            $base_currency_code,
            $date,
            $to_rub
        );
        if ($to_currency === null) {
            return null;
        }
        Cache::put($cache_key, $to_currency->getAmount(), now()->addDay());
        return $to_currency;
    }


    private function transferToRub(int $currency_code, $date, Money $value): ?Money
    {
        $currency_rate_model = $this->currency_repository->find($currency_code, $date);
        if ($currency_rate_model === null) {
            return null;
        }
        $currency_rate = new Money($currency_rate_model->value);
        $currency_to_rub = $currency_rate->divide((float)$currency_rate_model->nominal);
        return $value->multiply((float)$currency_to_rub->getDecimalAmount());
    }

    private function transferToCurrency(int $currency_code, $date, Money $value): ?Money
    {
        $currency_rate_model = $this->currency_repository->find($currency_code, $date);
        if ($currency_rate_model === null) {
            return null;
        }
        $currency_rate = new Money($currency_rate_model->value);
        return $value
            ->divide((float)$currency_rate->getDecimalAmount())
            ->multiply((float)$currency_rate_model->nominal);
    }
}
