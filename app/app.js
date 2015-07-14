(function() {
var app = angular.module('App', ['ngRoute', 'App.Services', 'App.Controller', 'Public.Controller', 'Super.Controller', 'Home.Controller', 'ui.tinymce', 'ui.bootstrap']);

app.config(['$routeProvider', function($routeProvider) {
	var authorized = function($rootScope, $q) {
		var deferred = $q.defer();
		if($rootScope.loggedin) {
			deferred.resolve(true);
		} else {
			deferred.resolve(false);
		}
		return deferred.promise;
	};

	$routeProvider.when('/public',{
		templateUrl: 'partials/public/public.php',
		controller: 'PublicController'
	}).when('/super',{
		templateUrl: 'partials/home.php',
		controller: 'HomeController',
		resolve: {
			authorized: authorized
		}
	}).when('/admin', {
		templateUrl: 'partials/home.php',
		controller: 'HomeController',
		resolve: {
			authorized: authorized
		}
	}).when('/student',{
		templateUrl: 'partials/home.php',
		controller: 'HomeController',
		resolve: {
			authorized: authorized
		}
	}).otherwise({
		redirectTo: '/public'
	});
}]);
})();