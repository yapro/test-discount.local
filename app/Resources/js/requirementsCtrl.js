var myApp = require("./myApp");

myApp.controller('requirementsCtrl',['$scope','$http', function($scope, $http) {
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