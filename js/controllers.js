blogApp.controller('articlesController', function($scope, $routeParams, $http){
    var type = $routeParams.type || "all";
    var id = $routeParams.type || 0;

    $scope.blogs = {};


    if(type == "all" || id == 0){

        $scope.type = "Sports and Technology";

        $scope.title = "Home";

        $http.get("../php/blogFetch.php?type=all").success(function(data){
            $scope.blogs = data;
        });

    }else if(type == "sports" || type == 2){
        $scope.type = "Sports";

        $scope.title = "Sports";

        $http.get("../php/blogFetch.php?type=sports").success(function(data){
            $scope.blogs = data;
        });

    }else if(type == "technology" || type == 1){
        $scope.type = "Technology";

        $scope.title = "Technology";

        $http.get("../php/blogFetch.php?type=technology").success(function(data){
            $scope.blogs = data;
        });
    }

    angular.element('title').html("Electric Athletics - " + $scope.title);

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

        angular.element('title').html("Electric Athletics - " + $scope.title);

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
        //$http.get("../php/profileController.php?id=" + id).success(function(data){
            //username = data.username;
        //});

        return userID;
    };



});

blogApp.controller('profileController', function($scope, $routeParams, $http){
    var id = $routeParams.id;

    $scope.id = id;

    $http.get("../php/profileController.php?type=info&id=" + id).success(function(data){
        $scope.user = data;

        $scope.title = data.username;

        angular.element('title').html("Electric Athletics - " + $scope.title);
    });

    $http.get("../php/commentController.php?id=" + id).success(function(data){
        $scope.comments = data;
    });



});

blogApp.controller('changeController', function($scope, $routeParams, $http){
    var id = $routeParams.id;

    if(id == 1){
        $scope.status = "An email has been sent with a link to change your password. \n If you need it resent";

        $scope.title = "Change Password";

        angular.element('title').html("Electric Athletics - " + $scope.title);

        angular.element("#changeLink").html("If you need it reset <a href='changePassword.php'>Click Here</a>");
    }else if(id == 2){
        $scope.status = "Your Password has been successfully changed";

        $scope.title = "Successful!";

        angular.element('title').html("Electric Athletics - " + $scope.title);
    }



});

blogApp.controller('editController', function($scope, $routeParams, $http){
    var id = $routeParams.id;

    $http.get("../php/blogFetch.php?type=article&id=" + id).success(function(data){
        $scope.blog = data;

        $scope.title = "Edit" + $scope.blog.title;

        angular.element('title').html("Electric Athletics - " + $scope.title);

        if(data.typeID == 2){
            angular.element("#addSports").attr("checked", "checked");
        }else if(data.typeID == 1){
            angular.element("#addTech").attr("checked", "checked");
        }

    });

    $http.get("../php/tagNames.php").success(function(data){
        $scope.tags = data;
    });

    $http.get("../php/tagController.php?id=" + id).success(function(data){
        var newData = new Object();
        for(var i=0; i < data.length; i++){
            var tagID = data[i].tagID;
            newData[tagID] = data[i].tagID;
        }
        $scope.tagList = newData;
    });

    $scope.tagCheck = function(tagID){

        if($scope.tagList){
            if($scope.tagList[tagID]){
                angular.element("#tag" + tagID).attr("selected", "selected");
                console.log(tagID);
            }
        }

        return tagID;
    }

});

blogApp.controller('validateController', function($scope, $routeParams, $http){
    var id = $routeParams.id;

    $scope.title = "Validate";

    angular.element('title').html("Electric Athletics - " + $scope.title);

});

blogApp.controller('addPostController', function($scope, $routeParams, $http){

    $scope.title = "Add Post";

    $http.get("../php/tagNames.php").success(function(data){
        $scope.tags = data;
    });

    angular.element('title').html("Electric Athletics - " + $scope.title);

});