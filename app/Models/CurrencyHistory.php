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
 * @mixin \Eloquent
 */
class CurrencyHistory extends Model
{
    use HasFactory;

    public int $id;
    public string $date;
    public int $currency_code;
    public int $nominal;
    public string $value;

    protected $table = 'currency_history';
}
