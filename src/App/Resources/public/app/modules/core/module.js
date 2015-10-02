(function() {

    var core = angular.module("modules.core", []);

    core.config(['cfpLoadingBarProvider', function(cfpLoadingBarProvider) {
        cfpLoadingBarProvider.includeSpinner = false;
        cfpLoadingBarProvider.includeBar     = true;
    }]);

})();
