<?php namespace App\Console\Commands;

use App\Models\Entities\Currency;
use App\Models\Repositories\CurrencyRepository;

class ExchangeRateComposite {
    private $currencyRepo;

    public function __construct(CurrencyRepository $currencyRepo)
    {
        $this->currencyRepo = $currencyRepo;
    }

    /**
     * Updates the exchanges rates retrieved from an API call
     */
    public function updateExchangeRates() {
        $currency = new Currency();
        $currency->updateExchangeRate($this->currencyRepo->getAll());
    }
}