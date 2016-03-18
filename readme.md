## Mukuru Foreign Currencies ##

**Mukuru Foreign Currencies Test** is a practical test based on a provided document specification.

### Installation ###

* `navigate to your www root directory `
* `git clone https://github.com/CharlBeukes711/mukuru.git`
* `composer install`
* create database called mukuru (username and password should both be root)
* Run php artisan migrate
* `php artisan serve` to start the app on http://localhost:8000/currency
* to run the exchange rate update command, run php artisan exchange_rates:update
Please note: the free API only allows to use USD as a source so ZAR couldn't be used