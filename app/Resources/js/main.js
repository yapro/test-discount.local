'use strict';

const angular = require('angular');
const dateFormatter = require("./dateFormatter");

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
      controller:'AmenitiesCtrl'
    })
    .when(ROUTES.REQUIREMENTS,{
      templateUrl:'template/requirements.html',
      controller:'RequirementsCtrl'
    })
    .when(ROUTES.REQUIREMENT + ':requirementId', {
      templateUrl:'template/requirement.html',
      controller:'RequirementCtrl'
    })
    .otherwise({
      redirectTo: '/'
    });
}]);

myApp.controller('orderCtrl',['$scope','$http', function($scope, $http) {
  $scope.amenities = [
    {'id' : 1, 'name' : 'Услуга 1'},
    {'id' : 2, 'name' : 'Услуга 2'}
  ];
  $http.get('api/amenity/').then(function successCallback(response) {
    $scope.amenities = $scope.amenities.concat(response.data);
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
  $scope.dt = new Date();
  $scope.popup = {
    opened: false
  };
  $scope.openDataPicker = function() {
    $scope.popup.opened = true;
  };
}]);

myApp.controller('AmenitiesCtrl',['$scope', '$http', function($scope, $http) {
  $scope.httpError = '';
  var maxIntNumber = 9007199254740991;
  $scope.amenities = [{'addNew':true,'id':maxIntNumber, 'name':''}];

  $http.get('api/amenity/').then(function successCallback(response) {
    $scope.amenities = $scope.amenities.concat(response.data);
    $scope.httpError = '';
  }, function errorCallback(response) {
    $scope.httpError = response.status + " : " + response.statusText + " : " + response.config.method + " : " + response.config.url;
  });

  $scope.add = function (item) {
    $http.put('api/amenity/', item).then(function successCallback(response) {
      $scope.amenities.push(response.data);
      item.name = '';
      $scope.httpError = '';
    }, function errorCallback(response) {
      $scope.httpError = response.status + " : " + response.statusText + " : " + response.config.method + " : " + response.config.url;
    });
  };

  $scope.update = function (item) {
    $http.post('api/amenity/' + item.id, item).then(function successCallback(response) {
      item = response.data;
      $scope.httpError = '';
    }, function errorCallback(response) {
      $scope.httpError = response.status + " : " + response.statusText + " : " + response.config.method + " : " + response.config.url;
    });
  };

  $scope.delete = function (item) {
    $http.delete('api/amenity/'+item.id).then(function successCallback(response) {
      var itemIndex = $scope.amenities.indexOf(item);
      var scopeItem = $scope.amenities.splice(itemIndex, 1);
      scopeItem = null;
      $scope.httpError = '';
    }, function errorCallback(response) {
      $scope.httpError = response.status + " : " + response.statusText + " : " + response.config.method + " : " + response.config.url;
    });
  };
}]);

myApp.controller('RequirementsCtrl',['$scope','$http', function($scope, $http) {
  $scope.requirements = [];
  $http.get('api/requirement/').then(function successCallback(response) {
    $scope.requirements = response.data;
    $scope.httpError = '';
  }, function errorCallback(response) {
    $scope.httpError = response.status + " : " + response.statusText + " : " + response.config.method + " : " + response.config.url;
  });

  $scope.delete = function (item) {
    $http.delete('api/requirement/'+item.id).then(function successCallback(response) {
      var itemIndex = $scope.requirements.indexOf(item);
      var scopeItem = $scope.requirements.splice(itemIndex, 1);
      scopeItem = null;
      $scope.httpError = '';
    }, function errorCallback(response) {
      $scope.httpError = response.status + " : " + response.statusText + " : " + response.config.method + " : " + response.config.url;
    });
  };
}]);

myApp.controller('RequirementCtrl',['$scope','$http', '$location', '$routeParams', 'ROUTES', function($scope, $http, $location, $routeParams, ROUTES) {
  $scope.successMessage = '';
  $scope.httpError = '';
  $scope.requirement = {};
  // date picker
  $scope.format = 'dd.MM.yyyy';
  $scope.dateOptions = {
    startingDay: 1
  };
  $scope.requirement.date_from = new Date();
  $scope.popup = {
    opened: false
  };
  $scope.openDataPicker = function() {
    $scope.popup.opened = true;
  };
  $scope.requirement.date_to = null;
  $scope.popup2 = {
    opened: false
  };
  $scope.openDataPicker2 = function() {
    $scope.popup2.opened = true;
  };

  $http.get('api/amenity/').then(function successCallback(response) {
    $scope.requirement.amenities = response.data;
    $scope.httpError = '';
  }, function errorCallback(response) {
    $scope.httpError = response.status + " : " + response.statusText + " : " + response.config.method + " : " + response.config.url;
  });

  $scope.requirement.id = $routeParams.requirementId;
  if ($scope.requirement.id !== 'add') {
    $http.get('api/requirement/'+$scope.requirement.id).then(function successCallback(response) {
      if (response.data.amenities.length) {
        response.data.amenities.map(function(amenity) {
          $scope.requirement.amenities.forEach(function(item) {
            if (item.id === amenity.id) {
              item.isSelected = true;
            }
          });
        });
      }
      $scope.requirement.flag_birth_date_before = response.data.flag_birth_date_before;
      $scope.requirement.flag_birth_date_after = response.data.flag_birth_date_after;
      $scope.requirement.flag_phone_number = response.data.flag_phone_number;
      $scope.requirement.phone_number_end = response.data.phone_number_end;
      $scope.requirement.gender = response.data.gender;
      $scope.requirement.date_from = Date.parse(response.data.date_from);
      $scope.requirement.date_to = Date.parse(response.data.date_to);
      $scope.httpError = '';
    }, function errorCallback(response) {
      $scope.httpError = response.status + " : " + response.statusText + " : " + response.config.method + " : " + response.config.url;
    });
  }

  $scope.saveRequirement = function () {

    var copyRequirement = Object.assign({}, $scope.requirement);
    copyRequirement.date_from = dateFormatter.getDateByTimestamp(copyRequirement.date_from);
    copyRequirement.date_to = typeof copyRequirement.date_to === "object" && copyRequirement.date_to !== null ?
        dateFormatter.getDateByTimestamp(copyRequirement.date_to) : null;

    if (copyRequirement.id === 'add') {
      $http.put('api/requirement/', copyRequirement).then(function successCallback(response) {
        $location.path(ROUTES.REQUIREMENT + response.data.id);
        $scope.requirement.id = response.data.id;
        $scope.successMessage = 'Requirement was success added';
        $scope.httpError = '';
      }, function errorCallback(response) {
        $scope.httpError = response.status + " : " + response.statusText + " : " + response.config.method + " : " + response.config.url;
      });
    } else {// update
      $http.post('api/requirement/' + copyRequirement.id, copyRequirement).then(function successCallback(response) {
        $scope.successMessage = 'Requirement was success saved';
        $scope.httpError = '';
      }, function errorCallback(response) {
        $scope.httpError = response.status + " : " + response.statusText + " : " + response.config.method + " : " + response.config.url;
      });
    }
  };

}]);
