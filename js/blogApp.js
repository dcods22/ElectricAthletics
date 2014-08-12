var blogApp = new angular.module('blogApp', ['ngRoute']);

blogApp.config(['$routeProvider',
    function($routeProvider){
        $routeProvider.
            when('/', {
                templateUrl: 'articles.html',
                controller: 'articlesController'
            }).
            when('/articles', {
                templateUrl: 'articles.html',
                controller: 'articlesController'
            }).
            when('/articles/:type', {
                templateUrl: 'articles.html',
                controller: 'articlesController'
            }).
            when('/articles/id/:id', {
                templateUrl: 'article.html',
                controller: 'articleController'
            }).
            when('/type/:type', {
                templateUrl: 'type.html',
                controller: 'typeController'
            }).
            when('/user/:id', {
                templateUrl: 'profile.html',
                controller: 'userController'
            }).
            when('/signuporin', {
                templateUrl: 'signuporin.html',
                controller: 'signinController'
            }).
            when('/about', {
                templateUrl: 'about.html'
            }).
            when('/contact', {
                templateUrl: 'contact.html'
            }).
            when('/thanks', {
                templateUrl: 'thanks.html'
            }).
            otherwise({
                redirectTo: '/'
            });

}]);

blogApp.filter('dateToISO', function() {
    return function(input) {
        input = new Date(input).toISOString();
        return input;
    };
});

blogApp.filter('getType', function(){
    return function(input){
        if(input == "1"){
            return "technology";
        }else if(input == "2"){
            return "Sports";
        }
    }
})


