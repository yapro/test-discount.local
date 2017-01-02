var myApp = require("./myApp");
const dateFormatter = require("./dateFormatter");

myApp.controller('requirementCtrl',['$scope','$http', '$location', '$routeParams', 'ROUTES', function($scope, $http, $location, $routeParams, ROUTES) {
  $scope.successMessage = '';
  $scope.httpError = '';
  $scope.isDateFromError = false;
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

  $scope.requirement.id = $routeParams.requirementId;
  $http.get('api/amenity/').then(function successCallback(response) {
    $scope.requirement.amenities = response.data;
    $scope.httpError = '';
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
        $scope.requirement.discount = response.data.discount;
        $scope.httpError = '';
      }, function errorCallback(response) {
        $scope.httpError = response.status + " : " + response.statusText + " : " + response.config.method + " : " + response.config.url;
      });
    }

  }, function errorCallback(response) {
    $scope.httpError = response.status + " : " + response.statusText + " : " + response.config.method + " : " + response.config.url;
  });

  $scope.saveRequirement = function () {

    var copyRequirement = Object.assign({}, $scope.requirement);

    $scope.isDateFromError = false;
    var dateFromType = typeof copyRequirement.date_from;
    copyRequirement.date_from = (dateFromType === "object" || dateFromType === "number") &&
      copyRequirement.date_from !== null ? dateFormatter.getDateByTimestamp(copyRequirement.date_from) : null;
    if (copyRequirement.date_from === null) {
      $scope.isDateFromError = true;
      return;
    }
    
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