(function() {
var app = angular.module('App.Services', ['ngResource', 'base64', 'ui.tinymce']);

app.service('Session', ['$rootScope', 'Cookie', function($rootScope, Cookie) {
	this.create = function(data) {
		$rootScope.loggedin = true;
		$rootScope.firstname = data[0].s_fname;
		$rootScope.isCollapsed = true;
		$rootScope.userid = data[0].s_id;
		Cookie.put('session', data.session, null);
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
		Cookie.put('session', '', -1);
	};
}]);

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

app.factory('SessionAPI', ['$resource', function($resource) {
	return $resource('api/session');
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

app.service('Cookie', function() {
	this.put = function (cname, cvalue, exdays) {
		if(exdays !== null) {
			var d = new Date();
			d.setTime(d.getTime() + (exdays*24*60*60*1000));
			var expires = "expires="+d.toUTCString();
			document.cookie = cname + "=" + cvalue + "; " + expires;
		} else {
			document.cookie = cname + "=" + cvalue;
		}
	};

	this.get = function (cname) {
		var name = cname + "=";
		var ca = document.cookie.split(';');
		for(var i=0; i<ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1);
			if (c.indexOf(name) === 0) 
				return c.substring(name.length,c.length);
		}
		return "";
	};
});
})();