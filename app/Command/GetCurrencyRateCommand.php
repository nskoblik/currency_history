<?php

declare(strict_types=1);

namespace App\Command;

use App\Dictionary\CurrencyDictionary;
use App\DTO\CurrencyCrossRate;
use App\Repository\CurrencyHistoryRepository;
use App\VO\Money;

final class GetCurrencyRateCommand
{
    private CurrencyHistoryRepository $currency_repository;

    public function __construct(
        private \Illuminate\Support\Carbon $date,
        private int                        $currency_code,
        private int                        $base_currency_code
    ) {
        $this->currency_repository = new CurrencyHistoryRepository();
    }

    public function execute(): ?CurrencyCrossRate
    {
        $to_rub = $this->transferToRub(
            $this->currency_code,
            $this->date,
            Money::getFromDecimal(1.0)
        );
        if ($to_rub === null) {
            return null;
        }
        $prev_to_rub = $this->transferToRub(
            $this->currency_code,
            $this->date->sub('1 day'),
            Money::getFromDecimal(1.0)
        );

        if ($this->base_currency_code === CurrencyDictionary::CODE_RUB) {
            return new CurrencyCrossRate(
                $to_rub,
                $prev_to_rub !== null ? $to_rub->subtract($prev_to_rub) : null
            );
        }

        $base_currency_rate = $this->transferToCurrency(
            $this->base_currency_code,
            $this->date,
            $to_rub
        );
        if ($base_currency_rate === null) {
            return null;
        }

        $prev_base_currency_rate = $this->transferToCurrency(
            $this->base_currency_code,
            $this->date->sub('1 day'),
            $prev_to_rub
        );
        return new CurrencyCrossRate(
            $base_currency_rate,
            $prev_base_currency_rate !== null ? $base_currency_rate->subtract($prev_base_currency_rate) : null
        );
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
