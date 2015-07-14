(function() {
var app = angular.module('App.Controller', ['App.Services']);

app.controller('AppController', ['$rootScope', '$scope', 'SessionAPI', 'Session', '$location',
	function($rootScope, $scope, SessionAPI, Session, $location) {
		$rootScope.loggedin = null;
		$rootScope.firstname = null;
		$rootScope.homepage = null;
		$rootScope.isCollapsed = true;
		$scope.logout = function() {
			SessionAPI.remove({}, function(data) {
				Session.destroy();
				$location.url('/university');
			});
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
		controller: function($rootScope, $scope, Session, $location, $http) {
			$scope.login = function(loginUser) {
				/*User.resource(loginUser.username, loginUser.password).login({}, function(data)*/ 

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
							case 3: $location.url('/superHomepage'); break;
							case 2: $location.url('/adminHomepage'); break;
							case 1: $location.url('/studentHomepage'); break;
							case 0: $location.url('/public'); break;
							default: $location.url('/public'); break;
						}
					//if(data == 200) {
						/*Session.destroy(); // Clear out any old data
						Session.create(data);
						$scope.loginUser = {};
						$scope.errorMessage_login = false;
						$rootScope.isCollapsed = true;
						$rootScope.loggedin = true;*/
						// Redirect user to respective page
						// TODO: remove the switch and create if statements to determine user role
						
					/*} else {
						$rootScope.loggedin = false;
						$scope.errorMessage_login = data.data.message;
						$location.url("/superHomepage");
					}*/

				});
			};
		}
	};
}]);

app.directive('createAccount', [function() {
	return {
		restrict: 'E',
		templateUrl: 'partials/app/create.php',
		controller: function($rootScope, $scope, Session, $location, $http) {
			$scope.universities = [];
			$scope.register = {};
			$scope.register.role = 'student'; // default
			$http.get('./backend/university.php').success(function(data){
				$scope.universities = data;
				$scope.register.school - $scope.universities[0];
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