blogApp.controller('articlesController', function($scope, $routeParams, $http){
    var type = $routeParams.type || "all";

    $scope.blogs = {};


    if(type == "all"){

        $scope.type = "Sports and Technology"

        $http.get("../php/blogFetch.php?type=all").success(function(data){
            $scope.blogs = data;
            console.log(data);
        });
    }else if(type == "sports"){
        $scope.type = "Sports"

        $http.get("../php/blogFetch.php?type=sports").success(function(data){
            $scope.blogs = data;
        });
    }else if(type == "technology"){
        $scope.type = "Technology"

        $http.get("../php/blogFetch.php?type=technology").success(function(data){
            $scope.blogs = data;
        });
    }


});

blogApp.controller('articleController', function($scope, $routeParams, $http){
    var id = $routeParams.id;

    $scope.id = id;
    $scope.userID = id;
    $scope.article = {};
    $scope.tags = {};
    $scope.comments = {};


    $http.get("../php/blogFetch.php?type=article&id=" + id).success(function(data){
        $scope.article = data;
    });

    $http.get("../php/tagController.php?id=" + id).success(function(data){
        $scope.tags = data;
    });

    $http.get("../php/tagNames.php").success(function(data){
        $scope.tagList = data;
    });

    $http.get("../php/commentController.php?id=" + id).success(function(data){
        $scope.comments = data;
    });

});