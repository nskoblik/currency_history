<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\CurrencyHistory;
use App\Repository\CurrencyHistoryRepository;
use Illuminate\Console\Command;

class GetCursCommand extends Command
{
    protected $signature = 'app:get-curs {date} {currency}';

    protected $description = 'Command description';

    public function handle(): void
    {
        $date = \Illuminate\Support\Facades\Date::createFromFormat(
            CurrencyHistory::DATE_FORMAT,
            (string)$this->argument('date')
        );
        $currency = (int)$this->argument('currency');
        $repository = new CurrencyHistoryRepository();
        $curs = $repository->find($currency, $date);
        if ($curs === null) {
            $this->error('Something went wrong!');
            return;
        }

        $this->line($curs->getDecimalAmount());
    }
}
