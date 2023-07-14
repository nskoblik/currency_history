<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CurrencyHistory
 *
 * @method static \Illuminate\Database\Eloquent\Builder|CurrencyHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CurrencyHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CurrencyHistory query()
 * @property int                        $id
 * @property \Illuminate\Support\Carbon $date
 * @property int                        $currency_code
 * @property int                        $nominal
 * @property string                     $value
 * @mixin \Eloquent
 */
class CurrencyHistory extends Model
{
    use HasFactory;

    public const DATE_FORMAT = 'Y-m-d';

    protected $table = 'currency_history';

    protected $casts = [
        'date' => 'datetime:Y-m-d',
    ];
}
