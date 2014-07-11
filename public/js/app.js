var app = angular.module('app',[
	"ngRoute",
	"ngTouch",
	"mobile-angular-ui"
]);

app.controller('MainCtrl', function($rootScope, $scope){

	$rootScope.$on("$routeChangeStart", function(){
		$rootScope.loading = true;
	});

	$rootScope.$on("$routeChangeSuccess", function(){
		$rootScope.loading = false;
	});
});