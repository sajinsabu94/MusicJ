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

}]);

myApp.controller('songController',function($scope,$http){
//  function init(){
  $http({              
            method: 'POST',
            url: 'playsing.php'
        }).then(function (response) {
                     // alert(response.data);
            $scope.listsinger = response.data;

            console.log(response.data);
        }, function (response) {
          //alert(response.data);
            console.log(response.data,response.status);
        });
 //     }
 // init();
 $scope.songexp = function($singerid){
    var fd = new FormData();
    fd.append('singid', $singerid);
    $retr = $http.post('playlist.php', fd, {
     transformRequest: angular.identity,
     headers: {'Content-Type': undefined,'Process-Data': false}
   })
    .then(function (response){
      $scope.listsong = response.data;
      console.log(response);
    },function (response) {
            console.log(response.data,response.status);
    });

 };
 
});