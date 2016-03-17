<?php namespace App\Models\Repositories;

use App\Models\Entities\Currency;

class CurrencyRepository implements CurrencyRepositoryInterface {

    protected $currency;

    public function __construct()
    {
        $this->currency = new Currency();
    }

    public function getByCode($code)
    {
        return $this->currency->where('code', $code)->first();
    }

    public function getAll()
    {
        return $this->currency->all();
    }
}