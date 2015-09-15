angular.module('contactForm', [])
	.controller('ContactController', ['$scope', function($scope) {
		$scope.master = {};

		$scope.submitForm = function(user) {
			$scope.master.user = user;
			console.log($scope.master.user.firstname);
			console.log($scope.master.user.lastname);
		};

		$scope.reset = function() {
			$scope.user = angular.copy($scope.master);
		};

		$scope.reset();
}]);