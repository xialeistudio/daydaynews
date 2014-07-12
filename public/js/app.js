var app = angular.module('app', [
	"ngRoute",
	"ngTouch",
	"mobile-angular-ui",
	"angular-loading-bar"
]);
app.directive('whenScrolled', function() {
	return function(scope, elm, attr) {
		var raw = elm[0];
		elm.bind('scroll', function() {
			if (raw.scrollTop+raw.offsetHeight >= raw.scrollHeight) {
				scope.$apply(attr.whenScrolled);
			}
		});
	};
});
app.config(function($routeProvider, $locationProvider) {
	$routeProvider.when('/', {templateUrl: '/templates/index.html'});
	$routeProvider.when('/about', {templateUrl: '/templates/about.html'});
	$routeProvider.when('/category', {templateUrl: '/templates/category.html'});
	$routeProvider.when('/category/:id', {templateUrl: '/templates/list.html', controller: 'CategoryCtrl'});
	$routeProvider.when('/news/:id', {templateUrl: '/templates/news.html', controller: 'NewsCtrl'});
	$locationProvider.html5Mode(true);
});
app.controller('MainCtrl', function($rootScope, $scope, $http) {
	$rootScope.$on("$routeChangeStart", function() {
		$rootScope.loading = true;
	});
	$rootScope.$on("$routeChangeSuccess", function() {
		$rootScope.loading = false;
	});
	$scope.busy = false;
	$scope.currentPage = 1;
	$scope.limit = 20;
	$scope.pages = 1;
	//loading加载新闻列表
	$scope.load = function() {
		if ($scope.busy) {
			return false;
		}
		$scope.busy = true;
		$http.get('/api.php?r=site/list/page/'+$scope.currentPage+'/limit/'+$scope.limit).success(function(data) {
			$scope.busy = false;
			$scope.newses = data.data;
			$scope.pages = Math.ceil(data.total/$scope.limit);
			$rootScope.title = '首页 - 微文章';
		});
	};
	$scope.loadMore = function() {
		if ($scope.currentPage < $scope.pages) {
			$scope.currentPage++;
			if ($scope.busy) {
				return false;
			}
			$scope.busy = true;
			$http.get('/api.php?r=site/list/page/'+$scope.currentPage+'/limit/'+$scope.limit).success(function(data) {
				$scope.busy = false;
				for (var i in data.data) {
					$scope.newses.push(data.data[i]);
				}
				$scope.pages = Math.ceil(data.total/$scope.limit);
				$rootScope.title = '首页 - 微文章';
			});
		}
	};
	//关于
	$scope.about = function() {
		$rootScope.title = '关于 - 微文章';
	};
	//分类
	$scope.load_category = function() {
		$rootScope.title = '文章分类 - 微文章';
		$http.get('/api.php?r=site/categories').success(function(data) {
			$scope.categories = data;
		});
	};
});
app.controller('CategoryCtrl', function($routeParams, $http, $scope, $rootScope) {
	var category_id = $routeParams.id;
	$scope.busy = false;
	$scope.currentPage = 1;
	$scope.limit = 20;
	$scope.pages = 1;
	//读取分类详情
	$http.get('/api.php?r=site/category/id/'+category_id).success(function(data) {
		$scope.category = data;
		$rootScope.title = data.title+' - 微文章';
	});
	//读取文章列表
	$scope.load = function() {
		if ($scope.busy) {
			return false;
		}
		$scope.busy = true;
		$http.get('/api.php?r=site/list/id/'+category_id+'/page/'+$scope.currentPage+'/size/'+$scope.limit).success(function(data) {
			$scope.busy = false;
			$scope.newses = data.data;
			$scope.pages = Math.ceil(data.total/$scope.limit);
		});
	};
	$scope.loadMore = function() {
		if ($scope.currentPage < $scope.pages) {
			$scope.currentPage++;
			if ($scope.busy) {
				return false;
			}
			$scope.busy = true;
			$http.get('/api.php?r=site/list/id/'+category_id+'/page/'+$scope.currentPage+'/size/'+$scope.limit).success(function(data) {
				$scope.busy = false;
				for (var i in data.data) {
					$scope.newses.push(data.data[i]);
				}
				$scope.pages = Math.ceil(data.total/$scope.limit);
				$rootScope.title = '首页 - 微文章';
			});
		}
	};
});
app.controller('NewsCtrl', function($routeParams, $http, $scope, $rootScope, $location) {
	var news_id = $routeParams.id;
	$http.get('/api.php?r=site/news/id/'+news_id).success(function(data) {
		$rootScope.title = data.title.substr(0, 18);
		$scope.news = data;
		try {
			window.dataForWeixin = {
				MsgImg: data.thumb,
				TLImg: data.thumb,
				link: $location.absUrl(),
				title: data.title,
				desc: data.description,
				callback: function() {
					$http.get('/api.php?r=site/share/id/'+news_id).success(function(data) {
					});
				}
			}
		}
		catch (e) {
			window.dataForWeixin = {};
		}
	});
	$scope.showAuthor = function(author) {
		alert('请关注公众号:"'+author+'"');
	}
});
app.filter('html', [
	'$sce', function($sce) {
		return function(text) {
			return $sce.trustAsHtml(text);
		}
	}
]);