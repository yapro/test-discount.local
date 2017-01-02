var myApp = require("./myApp");

myApp.controller('amenitiesCtrl',['$scope', '$http', function($scope, $http) {
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