(function() {
var app = angular.module('Super.Controller', []);
app.controller('SuperController', ['$scope', 'Rso',
  function($scope, Rso) {
		$scope.rsorequestMessage = false;
		$scope.accept = function(rso) {
			var rsoIndex = $scope.rsorequests.indexOf(rso);
			var update = {};
			update.id = rso.id;
			update.update = 'accept';
			update.adminid = rso.adminid; // promote student to admin 
			Rso.update(update, function(response) {
				$scope.rsorequestMessage = response.data.message;
				if(response.status == 200) {
					// splice array and show success message
					$scope.rsorequests.splice(rsoIndex, 1);
				}
			});
		};

		$scope.reject = function(rso) {
			var rsoIndex = $scope.rsorequests.indexOf(rso);
			var update = {};
			update.id = rso.id;
			update.update = 'reject';
			// simply delete the request
			Rso.update(update, function(response) {
				$scope.rsorequestMessage = response.data.message;
				if(response.status == 200) {
					// splice array and show success message
					$scope.rsorequests.splice(rsoIndex, 1);
				}
			});
		};
	}
]);

app.directive('addimage', function() {
	return {
		restrict: 'E',
		templateUrl: 'partials/super/addimage.html',
		controller: ["University", "$scope", function(University, $scope) {
			$scope.create = function() {
				var image = {};
				image.name = this.name;
				image.url = this.url;
				image.universityid = $scope.university.id;
				//TODO add callbacks
				University.image.save(image).$promise.then(function(response) {
				}, function (response) {
				});
			};
		}]
	};
});

app.directive('createProfile', function() {
	return {
		restrict: 'E',
		templateUrl: 'partials/super/createProfile.html',
		controller: function($scope, University) {
			$scope.errorMessage_createprofile = false;

			$scope.createProfile = function(school) {
				University.resource.save(school, function(response) {
					if(response.status == 200) {
						$scope.noProfile = false;
						$scope.university = response.data;
						$scope.errorMessage_createprofile = false;
					} else {
						$scope.errorMessage_createprofile = response.data.message;
					}
				});
			};
		}
	};
});
})();