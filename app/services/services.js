(function() {
var app = angular.module('App.Services', ['ngResource', 'base64', 'ui.tinymce']);

app.service('Session', ['$rootScope', function($rootScope) {
	this.create = function(data) {
		$rootScope.loggedin = true;
		$rootScope.firstname = data.firstname;
		$rootScope.isCollapsed = true;
		$rootScope.userid = data.s_id;
		$rootScope.role = data.role;
		this.session = data.session;
		this.role = data.role;
		this.firstname = data.firstname;
		this.u_id = data.u_id;
	};

	this.destroy = function() {
		$rootScope.loggedin = false;
		$rootScope.firstname = false;
		$rootScope.role = null;
		this.session = null;
		this.role = null;
		this.firstname = null;
	};
}]);

app.factory('User', ['$resource', '$base64', function($resource) {
	return {
        resource: $resource('api.php/user/auth/:username/:password', {}, {
            login: {
                method: 'GET'
            }
        }),
		events: $resource('api.php/user/events'),
		rsos: $resource('api.php/user/rsos/:s_id')
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
	return {
		resource: $resource('api.php/rso/:s_id')
	};
}]);

app.factory('Event', ['$resource', function($resource) {
	return {
		resource: $resource('api.php/event'),
		comment: $resource('api.php/event/comment/:e_id')
	};
}]);
})();