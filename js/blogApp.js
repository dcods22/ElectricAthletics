var blogApp = new angular.module('blogApp', ['ngRoute', 'ui.bootstrap']);

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
                templateUrl: 'articles.html',
                controller: 'articlesController'
            }).
            when('/profile/:id', {
                templateUrl: 'profile.html',
                controller: 'profileController'
            }).
            when('/changed/:id', {
                templateUrl: 'changed.html',
                controller: 'changeController'
            }).
            when('/addpost', {
                templateUrl: 'addPost.html',
                controller: 'addPostController'
            }).
            when('/validate/:id', {
                templateUrl: 'validate.html',
                controller: 'validateController'
            }).
            when('/editpost/:id', {
                templateUrl: 'editArticle.html',
                controller: 'editController'
            }).
            when('/search/:query', {
                templateUrl: 'search.html',
                controller: 'searchController'
            }).
            when('/tags/:tag', {
                templateUrl: 'tags.html',
                controller: 'tagController'
            }).
            when('/logout/:id', {
                templateUrl: 'logout.html',
                controller: 'logoutController'
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
        input = new Date(input);
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
});


