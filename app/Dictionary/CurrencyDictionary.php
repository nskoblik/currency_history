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
    public const CODE_ZT = 398; // казахский тенге ₸
    public const CODE_BDT = 50;  // бангладешская така
    public const CODE_EGP = 818; // египетский фунт
    public const CODE_IRR = 364; // иранский риал

    public array $currency_codes = [
        self::CODE_RUB,
        self::CODE_USD,
        self::CODE_EUR,
        self::CODE_GBP,
    ];
}
