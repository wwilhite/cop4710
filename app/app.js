(function() {
var app = angular.module('App', ['ngRoute', 'App.Services', 'App.Controller', 'Public.Controller', 'Super.Controller', 'Home.Controller', 'ui.tinymce', 'ui.bootstrap']);

app.config(['$routeProvider', function($routeProvider) {
	// Used to preload session data on refreshes and browser window closes
	// NOTE: must resolve to either true or false, reject will block the view from displaying.
	var authorized = function($rootScope, $q, Session, Cookie, $location) {
		var deferred = $q.defer();
		if($rootScope.loggedin) {
			deferred.resolve(true);
		} else {
			deferred.resolve(false);
		}
		return deferred.promise;
	};

	$routeProvider.when('/public',{
		templateUrl: 'partials/public/public.html',
		controller: 'PublicController'
	}).when('/adminHomepage',{
		templateUrl: 'partials/home.html',
		controller: 'HomeController',
		resolve: {
			authorized: authorized,
			role: "super"
		}
	}).when('/leaderHomepage', {
		templateUrl: 'partials/home.html',
		controller: 'HomeController',
		resolve: {
			authorized: authorized,
			role: "admin"
		}
	}).when('/studentHomepage',{
		templateUrl: 'partials/home.html',
		controller: 'HomeController',
		resolve: {
			authorized: authorized,
			role: "student"
		}
	}).otherwise({
		redirectTo: '/public'
	});
}]);
})();