(function() {
var app = angular.module('App.Services', ['ngResource', 'base64', 'ui.tinymce']);

app.service('Session', ['$rootScope', function($rootScope) {
	this.create = function(data) {
		$rootScope.loggedin = true;
		$rootScope.firstname = data.firstname;
		$rootScope.isCollapsed = true;
		$rootScope.userid = data.s_id;
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

app.factory('User', ['$resource', '$base64', function($resource) {
	return {
        resource: $resource('api.php/user/:username/:password', {}, {
            login: {
                method: 'GET'
            }
        }),
		events: $resource('api.php/user/events'),
		rsos: $resource('api.php/user/rsos')
	};
}]);

app.factory('University', ['$resource', function($resource) {
	return {
		resource: $resource('api.php/university/:id'),
		image: $resource('api.php/university/image'),
		events: $resource('api.php/university/events'),
		rso: $resource('api.php/university/:universityid/rso/:member')
	};
}]);

app.factory('Rso', ['$resource', function($resource) {
	return $resource('api.php/rso/:rsoid', null, {
	});
}]);

app.factory('Event', ['$resource', function($resource) {
	return {
		resource: $resource('api.php/event'),
		comment: $resource('api.php/event/:eventid/comment/:commentid', null, {
		})
	};
}]);
})();