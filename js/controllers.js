blogApp.controller('articlesController', function($scope, $routeParams, $http){
    var type = $routeParams.type || "all";

    $scope.blogs = {};


    if(type == "all"){

        $scope.type = "Sports and Technology";

        $scope.title = "Home";

        $http.get("../php/blogFetch.php?type=all").success(function(data){
            $scope.blogs = data;
        });
    }else if(type == "sports"){
        $scope.type = "Sports";

        $scope.title = "Sports";

        $http.get("../php/blogFetch.php?type=sports").success(function(data){
            $scope.blogs = data;
        });
    }else if(type == "technology"){
        $scope.type = "Technology";

        $scope.title = "Technology";

        $http.get("../php/blogFetch.php?type=technology").success(function(data){
            $scope.blogs = data;
        });
    }

    angular.element('.logo').html("Electric Athletics - " + $scope.title);


});

blogApp.controller('articleController', function($scope, $routeParams, $http){
    var id = $routeParams.id;

    $scope.id = id;
    $scope.userID = id;
    $scope.article = {};
    $scope.tags = {};
    $scope.comments = {};


    $http.get("../php/blogFetch.php?type=article&id=" + id).success(function(data){

        $scope.title = data.title;

        $scope.article = data;
    });

    $http.get("../php/tagController.php?id=" + id).success(function(data){
        $scope.tags = data;
    });

    $http.get("../php/tagNames.php").success(function(data){
        var newData = new Object();
        for(var i=0; i < data.length; i++){
            var tagID = data[i].tagID;
            newData[tagID] = data[i].tag;
        }
        $scope.tagList = newData;
    });

    $http.get("../php/commentController.php?type=article&id=" + id).success(function(data){
        $scope.comments = data;
    });

    $scope.getTagName = function(tagID){
        if($scope.tagList){
            return $scope.tagList[tagID];
        }
    };

    $scope.getUserName = function(userID){
        var username;
        $http.get("../php/profileController.php?id=" + id).success(function(data){
            username = data.username;
        });

        return username;
    };

    angular.element('#title').html("Electric Athletics - " + $scope.title);

});

blogApp.controller('profileController', function($scope, $routeParams, $http){
    var id = $routeParams.id;

    $scope.id = id;

    $http.get("../php/profileController.php?type=info&id=" + id).success(function(data){
        $scope.user = data;

        $scope.title = data.username;
    });

    $http.get("../php/commentController.php?id=" + id).success(function(data){
        $scope.comments = data;
    });

    angular.element('#title').html("Electric Athletics - " + $scope.title);

});