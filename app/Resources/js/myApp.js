'use strict';

var jQuery = require('jquery');
const angular = require('angular');

var myApp = angular.module('myApp', [
  require('angular-route'),
  require('angular-ui-bootstrap')
]);

myApp.constant('ROUTES', (function () {
  return {
    ORDER: '/',
    AMENITIES: '/amenities',
    REQUIREMENTS: '/requirements',
    REQUIREMENT: '/requirement/'
  }
})()).run(['$rootScope', 'ROUTES', function ($rootScope, ROUTES) {
  $rootScope.ROUTES = ROUTES;
}]).config(['$routeProvider', 'ROUTES', function($routeProvide, ROUTES){
  $routeProvide
    .when(ROUTES.ORDER, {
      templateUrl:'template/order.html',
      controller:'orderCtrl'
    })
    .when(ROUTES.AMENITIES,{
      templateUrl:'template/amenities.html',
      controller:'amenitiesCtrl'
    })
    .when(ROUTES.REQUIREMENTS,{
      templateUrl:'template/requirements.html',
      controller:'requirementsCtrl'
    })
    .when(ROUTES.REQUIREMENT + ':requirementId', {
      templateUrl:'template/requirement.html',
      controller:'requirementCtrl'
    })
    .otherwise({
      redirectTo: '/'
    });
}]);









module.exports = myApp;