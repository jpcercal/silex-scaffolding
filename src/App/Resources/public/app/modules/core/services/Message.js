(function() {

    var core = angular.module("modules.core");

    core.factory('Message', ['$mdToast', function($mdToast) {
        return {
            success: function (message) {
                var optionsOrPreset = $mdToast
                    .simple()
                    .content(message)
                    .position('top right')
                ;

                return $mdToast.show(optionsOrPreset);
            },
            error: function (message) {

            }
        };
    }]);

})();