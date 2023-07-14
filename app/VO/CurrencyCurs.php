<?php

declare(strict_types=1);

namespace App\VO;

final class CurrencyCurs
{
    public function __construct(
        private int    $code,
        private int    $nominal,
        private string $value
    ) {
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function getNominal(): int
    {
        return $this->nominal;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}


