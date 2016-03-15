<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Buy Foreign Currency</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.0/angular.min.js"></script>
</head>
<body>
    <div class="container" ng-app="app" ng-controller="controllerName">
        <h1>Please select how you would like to purchase your foreign currency</h1>
        <hr />
        <h3>Select your prefered currency option:</h3><br />

        <form action="/currency" method="post" name="currencyForm">
            <select ng-model="selectedCurrency" ng-change="totalVal=''" ng-init="currencies={{ $currencies }}">
                @foreach ($currencies as $currency)
                    <option value="{{ $currency->code }}">{{ $currency->description }} - {{ $currency->code }}</option>
                @endforeach
            </select><br />
            <small><em>Select foreign currency you would like to buy</em></small><br /><br /><br />

            <input type="number" min="1" name="foreign_input" id="foreign_input" ng-model="foreignCurrencyVal" ng-focus="zarVal=''" /><br />
            <small><em>The foreign currency AMOUNT you would like to buy</em></small>

            <br /><br /><strong>OR</strong><br /><br />
            <input type="number" min="1" name="zar_input" id="zar_input" ng-model="zarVal" ng-focus="foreignCurrencyVal=''" /><br />
            <small><em>The ZAR AMOUNT you would like to buy</em></small>

            <div ng-if="selectedCurrency=='GBP'">
                <br /><br /><input ng-hide="selectedCurrency!='GBP'" placeholder="Enter your email" type="email" name="user_email" id="user_email" required /><br />
                <small><em>Please enter the email address you want your order to be mailed to</em></small><br />
            </div>

            <hr />
            <span>Total value in <strong>ZAR</strong></span>
            <input type="hidden" name="total_zar_value" id="total_zar_value" ng-model="totalVal" ng-value="totalVal" />
            <input type="hidden" name="total_foreign_buying_zar" id="total_foreign_buying_zar" ng-model="totalForeignBuyingZar" ng-value="totalForeignBuyingZar" />
            <label ng-bind="totalVal"></label><br />

            <div ng-if="zarVal">
                <span>Total value in </span>
                <label ng-bind="selectedCurrency"></label>
                <label ng-bind="totalForeignBuyingZar"></label>
            </div>

            <br /><button type="submit" ng-disabled="(!foreignCurrencyVal && !zarVal)">Purchase</button>
        </form>
    </div>
</body>
</html>
<script src="/js/app.js"></script>
