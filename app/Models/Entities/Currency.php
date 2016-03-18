<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    const CURRENCY_CODE_USD = 'USD';
    const CURRENCY_CODE_GBP = 'GBP';
    const CURRENCY_CODE_EUR = 'EUR';
    const CURRENCY_CODE_KES = 'KES';

    // should be in the .env file for protection but had issues accessing it
    const END_POINT = 'live';
    const CURRENCY_LAYER_API = 'c8925fcdb7aa8ef51bd108188d276516';
    const SOURCE_CURRENCY = 'USD'; // the API free plan doesn't allow for calls other than USD so for the purpose of exercise I'll use USD exchange rates

    /**
     * Applies the relevant surcharge calculations and updates the order fields accordingly
     * @param Order $order
     */
    public function applySurcharge(Order $order) {
        $order->surcharge_percentage = $this->surcharge;
        $order->surcharge_amount = round($order->zar_amount * ($this->surcharge / 100), 2);
        $order->total_amount = $order->zar_amount + $order->surcharge_amount;
    }

    /**
     * Applies the relevant discount calculations and updates the order fields accordingly
     * @param Order $order
     */
    public function applyDiscount(Order $order) {
        $order->discount_percentage = $this->discount_percentage;
        $order->discount_amount = round($order->total_amount * ($this->discount_percentage / 100), 2);
        $order->total_amount = $order->total_amount - $order->discount_amount;
    }

    /**
     * Update the currencies exchange rates retrieved via the API
     * @param $currencyCollection
     */
    public function updateExchangeRate($currencyCollection) {
        $codeString = '';

        foreach ($currencyCollection as $currency) {
            $codeString .= $currency->code . ',';
        }

        // initialize CURL:
        $ch = curl_init("http://apilayer.net/api/live?access_key=" . self::CURRENCY_LAYER_API ."&currencies=" . rtrim($codeString, ',') . "&source=" . self::SOURCE_CURRENCY . "&format=1");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // store the data:
        $json = curl_exec($ch);
        curl_close($ch);

        // decode JSON response:
        $exchangeRates = json_decode($json, true);

        // loop throug the returned exchange rate values and update only the ones that changed
        foreach ($currencyCollection as $currency) {
            $freshExchangeRate = $exchangeRates['quotes'][self::SOURCE_CURRENCY . $currency->code];

            if ($currency->exchange_rate != $freshExchangeRate) {
                echo "Updated {$currency->code}: from " . $currency->exchange_rate ." to " . $freshExchangeRate. "\r\n";
                $currency->exchange_rate = $freshExchangeRate;
                $currency->update();
            }
        }
    }
}
