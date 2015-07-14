(function() {
var app = angular.module('App', ['ngRoute', 'App.Services', 'App.Controller', 'Public.Controller', 'Super.Controller', 'Home.Controller', 'ui.tinymce', 'ui.bootstrap']);

app.config(['$routeProvider', function($routeProvider) {
	// Used to preload session data on refreshes and browser window closes
	// NOTE: must resolve to either true or false, reject will block the view from displaying.
	var authorized = function($rootScope, $q, Session, Cookie, SessionAPI, $location) {
		var deferred = $q.defer();
		if($rootScope.loggedin) {
			deferred.resolve(true);
		} else if(Cookie.get('session')) {
			SessionAPI.get(function(response) {
				if(response.status == 200) {
					Session.create(response.data);
					deferred.resolve(true);
				} else {
					Session.destroy();
					deferred.resolve(false);
				}
			});
		} else {
			deferred.resolve(false);
		}
		return deferred.promise;
	};

	$routeProvider.when('/public',{
		templateUrl: 'partials/public/public.php',
		controller: 'PublicController'
	}).when('/adminHomepage',{
		templateUrl: 'partials/home.php',
		controller: 'HomeController',
		resolve: {
			authorized: authorized,
			role: "super"
		}
	}).when('/leaderHomepage', {
		templateUrl: 'partials/home.php',
		controller: 'HomeController',
		resolve: {
			authorized: authorized,
			role: "admin"
		}
	}).when('/studentHomepage',{
		templateUrl: 'partials/home.php',
		controller: 'HomeController',
		resolve: {
			/*authorized: authorized,*/
			role: "student"
		}
	}).otherwise({
		redirectTo: '/public'
	});
}]);
})();