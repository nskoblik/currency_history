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

}
