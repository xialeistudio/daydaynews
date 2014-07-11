var app = angular.module('app', [
	"ngRoute",
	"ngTouch",
	"mobile-angular-ui",
  "angular-loading-bar"
]);
app.config(function($routeProvider, $locationProvider) {
	$routeProvider.when('/', {templateUrl: '/templates/index.html'});
	$routeProvider.when('/user',{templateUrl:'/templates/user.html'});
	$routeProvider.when('/category',{templateUrl:'/templates/category.html'});
	$routeProvider.when('/news/:id',{templateUrl:'/templates/news.html'});
	$locationProvider.html5Mode(true);
});
app.controller('MainCtrl', function($rootScope, $scope,$http) {
	$rootScope.$on("$routeChangeStart", function() {
		$rootScope.loading = true;
	});
	$rootScope.$on("$routeChangeSuccess", function() {
		$rootScope.loading = false;
	});

	$scope.title = '首页 - 微新闻';

	//loading加载新闻列表
	$scope.load = function(){
		$http.get('/api.php?r=site/index').success(function(data){
			console.log(data);
		});
	};
});