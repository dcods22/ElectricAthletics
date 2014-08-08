var blogApp = new angular.module('blogApp', []);

blogApp.config(['$routeProvider',
    function($routeProvider){
        $routeProvider.
            when('/home', {
                templateUrl: 'home.php',
                controller: 'aboutController'
            }).when('/about', {
                templateUrl: 'about.php',
                controller: 'aboutController'
            }).
            otherwise({
                redirectTo: '/home'
            })


}]);