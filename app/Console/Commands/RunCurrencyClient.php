<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\CurrencyHistory;
use Illuminate\Console\Command;

class RunCurrencyClient extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:run-currency-client {date}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $date = \Illuminate\Support\Facades\Date::createFromFormat(
            CurrencyHistory::DATE_FORMAT,
            (string)$this->argument('date')
        );
        $command = new \App\Command\UpdateCurrencyHistoryCommand();
        $command->execute($date);
    }
}
