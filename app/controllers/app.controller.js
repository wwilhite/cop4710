(function() {
var app = angular.module('App.Controller', ['App.Services']);

app.controller('AppController', ['$rootScope', '$scope', '$location',
	function($rootScope, $scope) {
		$rootScope.loggedin = null;
		$rootScope.firstname = null;
		$rootScope.homepage = null;
		$rootScope.role = null;
		$rootScope.isCollapsed = true;
		$scope.logout = function() {
			//TODO do something here...
			//SessionAPI.remove({}, function(data) {
			//	Session.destroy();
			//});
		};
	}
]);

app.directive('navigation', [function() {
	return {
		restrict: 'E',
		templateUrl: 'partials/app/navigation.php'
	};
}]);

app.directive('login', [function() {
	return {
		restrict: 'E',
		templateUrl: 'partials/app/login.php',
		controller: function($rootScope, $scope, $location, $http) {
			$scope.login = function(loginUser) {
				var LoginFormData = {
					'username' : loginUser.username,
					'password' : loginUser.password
				};

				$http({
					method: 'POST',
					url: './backend/postLogin.php',
					data: LoginFormData,
					headers: {'Content-Type': 'application/x-www-form-urlencoded'}
				}).success(function(data){
					switch(parseInt(data)) {
                        case 3:
							$location.url('/super');
							$rootScope.role = "super";
							$rootScope.homepage = "super";
							$rootScope.loggedin = true;
							break;
                        case 2:
							$location.url('/admin');
							$rootScope.role = "admin";
							$rootScope.homepage = "admin";
							$rootScope.loggedin = true;
							break;
                        case 1:
							$location.url('/student');
							$rootScope.role = "student";
							$rootScope.homepage = "student";
							$rootScope.loggedin = true;
							break;
                        case 0:
							$location.url('/public');
							$rootScope.role = "public";
							break;
                        default:
							$location.url('/public');
							$rootScope.role = "public";
							break;
                    }
				});
			};
		}
	};
}]);

app.directive('createAccount', [function() {
	return {
		restrict: 'E',
		templateUrl: 'partials/app/create.php',
		controller: function($rootScope, $scope, $location, $http) {
			$scope.universities = [];
			$scope.register = {};
			$scope.register.role = 'student'; // default
			$http.get('./backend/university.php').success(function(data){
				$scope.universities = data;
				$scope.register.school = $scope.universities[0];
			});

			$scope.create = function(user) {
				var email = (user.role == 'student') ? user.studentemail : user.adminemail;
				user.email = email;
				if(user.role == 'student') {
					user.universityid = user.school;
				}

				var FormData = {
					'sid' : user.sid,
					'fname' : user.firstname,
					'lname' : user.lastname,
					'uname' : user.username,
					'pass' : user.password,
					'email' : user.email,
					'uid' : user.universityid
				};

				$http({
					method: 'POST',
					url: './backend/postStudent.php',
					data: FormData,
					headers: {'Content-Type': 'application/x-www-form-urlencoded'}
				}).success(function(response){
					$scope.message = response;
					if(response.status == 200) {
						// General clean up and reset form
						$scope.register = {};
						$scope.register.school = $scope.universities[0];
						$scope.register.role = 'student';

						// Redirect newly created user to their homepage
						//switch(Session.role) {
						//	case 'super': $location.url('/superHomepage'); break;
						//	case 'admin': $location.url('/adminHomepage'); break;
						//	case 'student': $location.url('/studentHomepage'); break;
						//	default: $location.url('/public'); break;
						//}
					} else {
						$scope.errorMessage_create = response.data;
						$scope.create.submitted = true;
					}
				});
			};
		}
	};
}]);

app.directive("imagecarousel", function() {
	return {
		templateUrl: 'partials/app/imagecarousel.php'
	};
});
})();