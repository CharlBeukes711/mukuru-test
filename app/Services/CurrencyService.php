<?php namespace App\Services;

use App\Models\Repositories\CurrencyRepository;
use App\Models\Entities\Currency;

class CurrencyService
{
    private $currencyRepo;

    public function __construct() {
        $this->currencyRepo = new CurrencyRepository();
    }

    /**
     * Return all the currencies from the db
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getCurrencies () {
        return $this->currencyRepo->getAll();
    }
}