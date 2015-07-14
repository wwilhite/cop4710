(function() {
var app = angular.module('App.Services', ['ngResource', 'base64', 'ui.tinymce']);

app.factory('User', ['$resource', '$base64', function($resource, $base64) {
	return {
		resource: function(username, password) {
			return $resource('user', {}, {
				login: {
					method: 'GET',
					// headers: {
					// 	'Authorization': 'Basic ' + $base64.encode(username + ':' + password)
					// }
				}
			});
		},
		// all events the user can attend
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

app.factory('GetAllUsers', ['$resource', function($resource) {
	return $resource('getAllUsers');
}]);

app.factory('Rso', ['$resource', function($resource) {
	return $resource('rso/:rsoid', null, {
		// update: {
		// 	method: 'PUT'
		// }
	});
}]);

app.factory('Event', ['$resource', function($resource) {
	return {
		resource: $resource('event'),
		comment: $resource('event/:eventid/comment/:commentid', null, {
			// update: { method: 'PUT' }
		})
	};
}]);
})();