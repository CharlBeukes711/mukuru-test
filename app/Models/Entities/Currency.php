<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    const CURRENCY_CODE_USD = 'USD';
    const CURRENCY_CODE_GBP = 'GBP';
    const CURRENCY_CODE_EUR = 'EUR';
    const CURRENCY_CODE_KES = 'KES';

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
}
