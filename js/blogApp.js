var blogApp = new angular.module('blogApp', ['ngRoute', 'ngCookies', 'ui.bootstrap']);

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
            when('/editprofile/:id', {
                templateUrl: 'editProfile.html',
                controller: 'editProfileController'
            }).
            when('/changepassword', {
                templateUrl: 'changePasword.html',
                controller: 'changeController'
            }).
            when('/about', {
                templateUrl: 'about.html',
                controller: 'aboutController'
            }).
            when('/contact', {
                templateUrl: 'contact.html',
                controller: 'contactController'
            }).
            when('/thanks', {
                templateUrl: 'thanks.html',
                controller: 'thanksController'
            }).
            otherwise({
                redirectTo: '/'
            });


}]);

blogApp.filter('dateFormat', function() {
    return function(input) {
        if(input){
            return new Date(input.replace(/-/g, "/"));
        }
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


