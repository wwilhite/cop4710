(function() {
var app = angular.module('App', ['ngRoute', 'App.Services', 'App.Controller', 'Events.Controller', 'Super.Controller', 'Student.Controller', 'ui.tinymce', 'ui.bootstrap']);

app.config(['$routeProvider', function($routeProvider) {
	// Used to preload session data on refreshes and browser window closes
	// NOTE: must resolve to either true or false, reject will block the view from displaying.
	var authorized = function($rootScope, $q, Session, Cookie, SessionAPI, $location) {
		var deferred = $q.defer();
		if($rootScope.loggedin) {
			// User is already logged in, we don't need to refresh data or anything!
			deferred.resolve(true);
		} else if(Cookie.get('session')) {
			SessionAPI.get(function(response) {
				if(response.status == 200) {
					Session.create(response.data);
					deferred.resolve(true);
				} else {
					console.log('Key no longer valid');
					Session.destroy();
					deferred.resolve(false);
				}
			});
		} else {
			console.log('no cookie!');
			deferred.resolve(false);
		}
		return deferred.promise;
	};

	// All pages get authorized because we want data on everypage!, if something must be restricted place it
	// in the if(authorized) {} block in the controller
	// Routing routes
	$routeProvider.when('/events',{
		templateUrl: 'partials/events/events.html',
		controller: 'EventsController'
	}).when('/adminHomepage',{
		templateUrl: 'partials/home.html',
		controller: 'HomepageController',
		resolve: {
			authorized: authorized,
			role: "super"
		}
	}).when('/leaderHomepage', {
		templateUrl: 'partials/home.html',
		controller: 'HomepageController',
		resolve: {
			authorized: authorized,
			role: "admin"
		}
	}).when('/studentHomepage',{
		templateUrl: 'partials/home.html',
		controller: 'HomepageController',
		resolve: {
			authorized: authorized,
			role: "student"
		}
	}).otherwise({
		redirectTo: '/events'
	});
}]);
})();