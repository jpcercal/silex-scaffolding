(function() {

    var core = angular.module("modules.core");

    core.controller('CoreController', ['$scope', 'Message', function($scope, Message) {

        $scope.title = 'CoreController';

        Message.success('The project is working!');

    }]);

})();
