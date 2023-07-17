<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\CurrencyHistory;
use Illuminate\Console\Command;

class ParseCurrencyRateHistoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:parse-history';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse rate history for last 180 days';

    public function handle(): void
    {
        $date_start = \Illuminate\Support\Facades\Date::now();
        $date_end = \Illuminate\Support\Facades\Date::now()->sub('180 day');
        $count = 0;
        while (
            $date_start->format(CurrencyHistory::DATE_FORMAT) !== $date_end->format(CurrencyHistory::DATE_FORMAT)
        ) {
            \App\Jobs\ParseCurrencyRate::dispatch($date_start);
            $date_start = $date_start->sub('1 day');
            $count++;
        }
        $this->line("Queued: $count messages");
    }
}
