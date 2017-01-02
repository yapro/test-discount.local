var jQuery = require('jquery');
var myApp = require("./myApp");
const dateFormatter = require("./dateFormatter");

myApp.controller('orderCtrl',['$scope', '$http', function($scope, $http) {
  $scope.discount = 0;
  $scope.order = {};
  $scope.order.gender = 0;
  $scope.order.birth_date = new Date();
  $http.get('api/amenity/').then(function successCallback(response) {
    $scope.order.amenities = response.data;
    $scope.httpError = '';
  }, function errorCallback(response) {
    $scope.httpError = response.status + " : " + response.statusText + " : " + response.config.method + " : " + response.config.url;
  });

  $scope.format = 'dd.MM.yyyy';
  $scope.dateOptions = {
    maxDate: new Date(),
    minDate: new Date(1917, 5, 22),
    startingDay: 1
  };
  $scope.popup = {
    opened: false
  };
  $scope.openDataPicker = function() {
    $scope.popup.opened = true;
  };

  $scope.getDiscount = function () {

    var copyOrder = Object.assign({}, $scope.order);

    $scope.isFioError = false;
    $scope.isBirthDateError = false;

    if (jQuery.trim(copyOrder.fio) === "") {
      jQuery("#fio").focus();
      $scope.isFioError = true;
      return;
    }

    copyOrder.birth_date = typeof copyOrder.birth_date === "object" && copyOrder.birth_date !== null ?
      dateFormatter.getDateByTimestamp(copyOrder.birth_date) : null;
    if (copyOrder.birth_date === null) {
      $scope.isBirthDateError = true;
      return;
    }

    $http.post('api/order', copyOrder).then(function successCallback(response) {
      $scope.discount = response.data.discount;
      $scope.httpError = '';
    }, function errorCallback(response) {
      $scope.httpError = response.status + " : " + response.statusText + " : " + response.config.method + " : " + response.config.url;
    });
  };
}]);