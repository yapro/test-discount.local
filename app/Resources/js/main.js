'use strict';

const angular = require('angular');

var myApp = angular.module('myApp', [
  require('angular-route'),
  require('angular-ui-bootstrap')
]);

myApp.config(['$routeProvider', function($routeProvide){
  $routeProvide
    .when('/', {
      templateUrl:'template/order.html',
      controller:'orderCtrl'
    })
    .when('/amenities',{
      templateUrl:'template/amenities.html',
      controller:'AmenitiesCtrl'
    })
    .when('/discount-terms',{
      templateUrl:'template/discount-terms.html',
      controller:'DiscountTermsCtrl'
    })
    .otherwise({
      redirectTo: '/'
    });
}]);

var httpHost = "http://test-discount.local";
var httpError = "The service " + httpHost + " has problems";

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

myApp.controller('AmenitiesCtrl',['$scope', '$http', '$location', function($scope, $http, $location) {
  $scope.httpError = '';
  var maxIntNumber = 9007199254740991;
  $scope.amenities = [{'addNew':true,'id':maxIntNumber, 'name':''}];

  $http.get(httpHost + '/api/amenity/').then(function successCallback(response) {
    $scope.amenities = $scope.amenities.concat(response.data);
  }, function errorCallback(response) {
    $scope.httpError = httpError;
  });

  $scope.add = function (item) {
    $http.put(httpHost + '/api/amenity/', item).then(function successCallback(response) {
      $scope.amenities.push(response.data);
      item.name = '';
    }, function errorCallback(response) {
      $scope.httpError = httpError;
    });
  };

  $scope.update = function (item) {
    $http.post(httpHost + '/api/amenity/' + item.id, item).then(function successCallback(response) {
      item = response.data;
    }, function errorCallback(response) {
      $scope.httpError = httpError;
    });
  };

  $scope.delete = function (item) {
    $http.delete(httpHost + '/api/amenity/'+item.id).then(function successCallback(response) {
      var itemIndex = $scope.amenities.indexOf(item);
      var scopeItem = $scope.amenities.splice(itemIndex, 1);
      scopeItem = null;
    }, function errorCallback(response) {
      $scope.httpError = httpError;
    });
  };


}]);

myApp.controller('DiscountTermsCtrl',['$scope','$http', '$location', function($scope, $http, $location) {

}]);
