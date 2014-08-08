var blogApp = new angular.module('blogApp', ['ngRoute']);

blogApp.config(['$routeProvider',
    function($routeProvider){
        $routeProvider.
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
                redirectTo: '/articles'
            });

}]);


