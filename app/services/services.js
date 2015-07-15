(function() {
var app = angular.module('App.Services', ['ngResource', 'base64', 'ui.tinymce']);

app.service('Session', ['$rootScope', function($rootScope) {
	this.create = function(data) {
		$rootScope.loggedin = true;
		$rootScope.firstname = data.firstname;
		$rootScope.isCollapsed = true;
		$rootScope.userid = data.id;
		this.session = data.session;
		this.role = data.role;
		this.firstname = data.firstname;
	};

	this.destroy = function() {
		$rootScope.loggedin = false;
		$rootScope.firstname = false;
		this.session = null;
		this.role = null;
		this.firstname = null;
	};
}]);

app.factory('User', ['$resource', '$base64', function($resource, $base64) {
	return {
		resource: function(username, password) {
			return $resource('user', {}, {
				login: {
					method: 'GET',
				}
			});
		},
		events: $resource('user/events'),
		rsos: $resource('user/rsos')
	};
}]);

app.factory('University', ['$resource', function($resource) {
	return {
		resource: $resource('university/:id'),
		image: $resource('university/image'),
		events: $resource('university/events'),
		rso: $resource('university/:universityid/rso/:member')
	};
}]);

//app.factory('GetAllUsers', ['$resource', function($resource) {
//	return $resource('getAllUsers');
//}]);

app.factory('Rso', ['$resource', function($resource) {
	return $resource('rso/:rsoid', null, {
	});
}]);

app.factory('Event', ['$resource', function($resource) {
	return {
		resource: $resource('event'),
		comment: $resource('event/:eventid/comment/:commentid', null, {
		})
	};
}]);
})();