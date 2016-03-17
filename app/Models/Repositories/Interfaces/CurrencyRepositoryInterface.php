<?php namespace App\Models\Repositories;

interface CurrencyRepositoryInterface {
    public function getByCode($code);
}