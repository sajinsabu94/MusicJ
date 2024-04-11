var myApp = angular.module('MusicJ', []);
myApp.directive('fileModel', ['$parse', function ($parse) {
  return {
    restrict: 'A',
    link: function(scope, element, attrs) {
      var model = $parse(attrs.fileModel);
      var modelSetter = model.assign;
      element.bind('change', function(){
        scope.$apply(function(){
          modelSetter(scope, element[0].files[0]);
        });
      });
    }
  };
}]);

// We can write our own fileUpload service to reuse it in the controller
myApp.service('fileUpload', ['$http', function ($http) {
  this.uploadFileToUrl = function(file, uploadUrl, name){
    var fd = new FormData();
    fd.append('file', file);
    fd.append('name', name);
    $retr = $http.post(uploadUrl, fd, {
     transformRequest: angular.identity,
     headers: {'Content-Type': undefined,'Process-Data': false}
   })
    .then(function (response){
      console.log(response);
    });
  }
}]);

myApp.controller('myCtrl', ['$scope', 'fileUpload','$window', function($scope, fileUpload, $window){

  $scope.uploadFile = function(){
    var file = $scope.myFile;
    console.log('file is ' );
    var uploadUrl = "upload.php";
    var vtext = $scope.myFile.name;
    fileUpload.uploadFileToUrl(file, uploadUrl, vtext);
    setTimeout(location.reload.bind(location), 3000);
  };
}]);

myApp.controller('songController',function($scope,$http){
//  function init(){
  $http({              
            method: 'POST',
            url: 'playlist.php'
        }).then(function (response) {
            $scope.songs = response.data;
            console.log(response.data);
        }, function (response) {
            //console.log(response.data,response.status);
        });
 //     }
 // init();
});