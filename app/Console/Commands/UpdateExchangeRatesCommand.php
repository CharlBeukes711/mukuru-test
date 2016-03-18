<?php

namespace App\Console\Commands;

use App\Models\Repositories\CurrencyRepository;
use Illuminate\Console\Command;
use App\Console\Commands\ExchangeRateComposite;

class UpdateExchangeRatesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchange_rates:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calls the Currency Layer API and updates the exchange rates in the currencies table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $updateExchangeRate = new ExchangeRateComposite(new CurrencyRepository());
        $updateExchangeRate->updateExchangeRates();
    }
}
