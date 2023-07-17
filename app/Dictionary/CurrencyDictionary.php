<?php

declare(strict_types=1);

namespace App\Dictionary;

final class CurrencyDictionary
{
    public const CODE_RUB = 643; // рубпь ₽
    public const CODE_USD = 840; // доллар $
    public const CODE_EUR = 978; // евро €
    public const CODE_GBP = 826; // фунт £
    public const CODE_BYR = 974; // белорусский рупь Br (до деноменации 01.07.2016)
    public const CODE_BYN = 933; // белорусский рупь Br (после деноменации 01.07.2016)
    public const CODE_UAH = 980; // гривна ₴
    public const CODE_TRY = 949; // турецкая лира ₺
    public const CODE_KGS = 417; // киргизский сом
    public const CODE_KZT = 398; // казахский тенге ₸
    public const CODE_BDT = 50;  // бангладешская така
    public const CODE_EGP = 818; // египетский фунт
    public const CODE_IRR = 364; // иранский риал

    public static array $all_codes = [
        self::CODE_RUB,
        self::CODE_USD,
        self::CODE_EUR,
        self::CODE_GBP,
    ];

    public static array $mapping_codes = [
        self::CODE_RUB => 'RUB',
        self::CODE_TRY => 'TRY',
        self::CODE_USD => 'USD',
        self::CODE_EUR => 'EUR',
        self::CODE_GBP => 'GBP',
        self::CODE_BYR => 'BYR',
        self::CODE_BYN => 'BYN',
        self::CODE_UAH => 'UAH',
        self::CODE_KGS => 'KGS',
        self::CODE_KZT => 'KZT',
        self::CODE_BDT => 'BDT',
        self::CODE_EGP => 'EGP',
        self::CODE_IRR => 'IRR',
    ];

    public static function getDigitalCode(string $literal_code): ?int
    {
        $mapping = \array_flip(self::$mapping_codes);
        return $mapping[$literal_code] ?? null;
    }

}
