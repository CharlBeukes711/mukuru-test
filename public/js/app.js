var app = angular.module("app", []);
app.controller('controllerName', ['$scope', function ($scope) {
    // set default values
    $scope.selectedCurrency = 'USD';

    var totalValue = 0;
    var formattedZarTotal = 0;
    var totalForeign = 0;
    var formattedForeign = 0;

    // calculate the ZAR value if foreign currency amount was entered
    $scope.$watch("foreignCurrencyVal", function(value) {
        // check if a value has been entered
        if (typeof value !== 'undefined') {
            calculateValue('foreign');
        }
    });

    // calculate the selected foreign currency amount for the ZAR that was entered
    $scope.$watch("zarVal", function(value) {
        // check if a value has been entered
        if (typeof value !== 'undefined') {
            calculateValue('zar');
        }
    });

    function calculateValue(currencyType) {
        angular.forEach($scope.currencies, function(currency) {
            if ($scope.selectedCurrency == currency.code) {
                // get the exchange rate and calculate value based on the amount type entered
                switch (currencyType) {
                    case 'foreign':
                        totalValue = $scope.foreignCurrencyVal / currency.exchange_rate;
                        break;
                    case 'zar':
                        totalValue = $scope.zarVal;
                        totalForeign = totalValue * currency.exchange_rate;
                        break;
                }
            }
        })
        if (totalValue) {
            formattedZarTotal = parseFloat(totalValue).toFixed(2);
            $scope.totalVal = parseFloat(formattedZarTotal);
        }

        if (totalForeign) {
            formattedForeign = parseFloat(totalForeign).toFixed(2);
            $scope.totalForeignBuyingZar = parseFloat(formattedForeign);
        }
    }
}]);