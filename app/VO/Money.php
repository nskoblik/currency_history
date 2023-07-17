<?php

declare(strict_types=1);

namespace App\VO;

final class Money
{
    public const SCALE = 4;

    public function __construct(
        private readonly int $amount
    ) {
    }

    public static function getFromDecimal(float $decimal_amount): self
    {
        $amount = (int)\floor($decimal_amount * (10 ** self::SCALE));
        return new self($amount);
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getDecimalAmount(): string
    {
        return (string)($this->amount / (10 ** self::SCALE));
    }

    public function subtract(Money $money): Money
    {
        return new Money(
            $this->amount - $money->getAmount()
        );
    }

    public function divide(float $divisor, int $rounding_mode = PHP_ROUND_HALF_UP): Money
    {
        if ($divisor === 0.0) {
            $divisor = 1.0;
        }
        $amount = \round($this->getAmount() / $divisor, 0, $rounding_mode);
        return new Money((int)$amount);
    }

    public function multiply(float $multiplier, int $rounding_mode = PHP_ROUND_HALF_UP): Money
    {
        $amount = \round($this->getAmount() * $multiplier, 0, $rounding_mode);
        return new Money((int)$amount);
    }

}
