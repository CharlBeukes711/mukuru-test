<?php namespace App\Console\Commands;

use App\Models\Entities\Currency;
use App\Models\Repositories\CurrencyRepository;

class ExchangeRateComposite {
    private $currencyRepo;

    public function __construct(CurrencyRepository $currencyRepo)
    {
        $this->currencyRepo = $currencyRepo;
    }

//    private function loadCurrencies() {
//        $this->currencyCollection = $this->currencyRepo->getAll();
//    }

    public function updateExchangeRates() {
//        $this->loadCurrencies();

//        $currencyCodeArray = [];

//        /** @var \App\Models\Entities\Currency $currency */
//        foreach ($this->currencyCollection as $currency) {
//            $currencyCodeArray[] = $currency->code;
//        }
        $currency = new Currency();
        $currency->updateExchangeRate($this->currencyRepo->getAll());
    }
}