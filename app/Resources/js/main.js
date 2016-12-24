'use strict';

const angular = require('angular');

var myApp = angular.module('myApp', [
  require('angular-route'),
  require('angular-ui-bootstrap')
]);

myApp.config(['$routeProvider', function($routeProvide){
  // https://youtu.be/TDSUd1K5Mhw?list=PLY4rE9dstrJxWEX3fCPjFpmcnoU_3GRWW - 6:40
  $routeProvide
    .when('/', {
      templateUrl:'template/order.html',
      controller:'orderCtrl'
    })
    .when('/amenity',{
      templateUrl:'template/amenity.html',
      controller:'Amenity'
    })
    .when('/discount-terms',{
      templateUrl:'template/discount-terms.html',
      controller:'DiscountTermsCtrl'
    })
    .otherwise({
      redirectTo: '/'
    });
}]);

myApp.controller('orderCtrl',['$scope','$http', '$location', function($scope, $http, $location) {
  $scope.amenities = [
    {'id' : 1, 'name' : 'Услуга 1'},
    {'id' : 2, 'name' : 'Услуга 2'}
  ];
/*
  $http.get('api/order').success(function(data, status, headers, config) {
    $scope.amenities = data;
  });
*/

  $scope.format = 'dd.MM.yyyy';

  $scope.dateOptions = {
    maxDate: new Date(),
    minDate: new Date(1917, 5, 22),
    startingDay: 1
  };
  $scope.dt = new Date();
  $scope.popup = {
    opened: false
  };
  $scope.openDataPicker = function() {
    $scope.popup.opened = true;
  };
}]);

myApp.controller('AmenityCtrl',['$scope','$http', '$location', function($scope, $http, $location) {

}]);

myApp.controller('DiscountTermsCtrl',['$scope','$http', '$location', function($scope, $http, $location) {

}]);
