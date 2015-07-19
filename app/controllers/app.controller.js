(function() {
var app = angular.module('App.Controller', ['App.Services']);

app.controller('AppController', ['$rootScope', '$scope', 'Session',
	function($rootScope, $scope, Session) {
		$rootScope.loggedin = null;
		$rootScope.firstname = null;
		$rootScope.homepage = null;
		$rootScope.isCollapsed = true;
		$scope.logout = function() {
            Session.destroy();
		};
	}
]);

app.directive('navigation', [function() {
	return {
		restrict: 'E',
		templateUrl: 'partials/app/navigation.html'
	};
}]);

app.directive('login', [function() {
	return {
		restrict: 'E',
		templateUrl: 'partials/app/login.html',
		controller: function($rootScope, $scope, User, Session, $location) {
			$scope.login = function(loginUser) {
				User.resource.login({username: loginUser.username, password: loginUser.password}, function(data) {
                    Session.destroy(); // Clear out any old data
                    Session.create(data);
                    $scope.loginUser = {};
                    $scope.errorMessage_login = false;
                    $rootScope.isCollapsed = true;
                    $rootScope.loggedin = true;
                    // Redirect user to respective page
                    switch(Session.role) {
                        case 'super':
                            $location.url('/superHomepage');
                            break;
                        case 'admin':
                            $location.url('/adminHomepage');
                            break;
                        case 'student':
                            $location.url('/studentHomepage');
                            break;
                        default:
                            $location.url('/public');
                            break;
                    }
					//} else {
					//	$rootScope.loggedin = false;
					//	$scope.errorMessage_login = data.data.message;
					//	$location.url("/public");
					//}
				});
			};
		}
	};
}]);

app.directive('createAccount', [function() {
	return {
		restrict: 'E',
		templateUrl: 'partials/app/create.html',
		controller: function($rootScope, $scope, User, Session, $location, University) {
			$scope.universities = [];
			$scope.register = {};
			$scope.register.role = 'student'; // default

			University.resource.query(function(response) {
				$scope.universities = response;
				$scope.register.school = $scope.universities[0];
			});

			$scope.create = function(user) {
				var email = (user.role == 'student') ? user.studentemail + user.school.email_domain : user.adminemail;
				user.email = email;
				if(user.role == 'student') {
					user.universityid = user.school.id;
				}

				User.resource.save(user, function(response) {
                    Session.destroy(); // Clear out any old data / sessions
                    Session.create(response.data);

                    // General clean up and reset form
                    $scope.errorMessage_create = false;
                    $scope.register = {};
                    $scope.register.school = $scope.universities[0];
                    $scope.register.role = 'student';

                    // Redirect newly created user to their homepage
                    switch(Session.role) {
                        case 'super': $location.url('/superHomepage'); break;
                        case 'admin': $location.url('/adminHomepage'); break;
                        case 'student': $location.url('/studentHomepage'); break;
                        default: $location.url('/public'); break;
                    }
					//} else {
					//	$scope.errorMessage_create = response.data.message;
					//	$scope.create.submitted = true;
					//}
				});
			};
		}
	};
}]);

app.directive("imagecarousel", function() {
	return {
		templateUrl: 'partials/app/imagecarousel.html'
	};
});
})();