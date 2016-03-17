<?php namespace App\Services;

use App\Models\Entities\Currency;
use Services\Facades\OrderServiceFacade;

class CurrencyStrategy {

    /**
     * Check if an email should be sent for a currency
     * @param Currency $currency
     */
    public static function sendEmail(Currency $currency) {
        switch ($currency->code) {
            case Currency::CURRENCY_CODE_GBP:
                OrderServiceFacade::sendOrderEmail();
                break;
            default:
                break;
        }
    }
}
