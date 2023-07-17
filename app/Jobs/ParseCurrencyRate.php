<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Command\UpdateCurrencyHistoryCommand;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ParseCurrencyRate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Количество попыток выполнения задания.
     * @var int
     */
    public $tries = 1;

    public function __construct(
        private \Illuminate\Support\Carbon $date
    ) {
    }

    public function handle(): void
    {
        (new UpdateCurrencyHistoryCommand($this->date, false))->execute();
    }
}
