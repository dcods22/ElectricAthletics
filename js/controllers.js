blogApp.controller('modalController', function($scope, $modal){
    $scope.openLogin = function(){
        window.loginModal = $modal.open({
            templateUrl: 'loginForm.html',
            controller: 'loginController',
            size: 'lg'
        });
    };

    $scope.openRegister = function(){
        window.registerModal = $modal.open({
            templateUrl: 'registerForm.html',
            controller: 'loginController',
            size: 'lg'
        });
    };

    $scope.setLoggedIn = function(){
        $scope.logURL = 'notloggedin.html';
        window.logURL = 'notloggedin.html';
    };

    setInterval(function(){
        $scope.loggedin = window.loggedin;
        $scope.logURL = window.logURL;
        $scope.username = window.username;
        $scope.avatar = window.avatar;
        $scope.ID = window.ID;
    }, 1000)
});

blogApp.controller('loginController', function($scope, $http, $location){

    $scope.loginNow = function(login){

        if(!angular.isUndefined(login.username) && !angular.isUndefined(login.password)){
            $http.get("../php/login.php?user=" + login.username + "&pass=" + login.password).success(function(data){
                if(data.error){
                    $scope.loggedin = false;
                    $scope.error = data.error;
                }else if(data[0].id){
                    window.loggedin = true;
                    window.ID = data[0].id;
                    window.username = data[0].username;
                    window.logURL = 'loggedin.html';
                    window.avatar = data[0].avatar;
                    window.loginModal.dismiss();
                    $location.path("/profile/" + window.ID);
                }
            });
        }else{
            $scope.error = "Username or Password are not filled out";
        }
    };

    $scope.registerNow = function(register){
        if(!angular.isUndefined(register.username) && !angular.isUndefined(register.password1) && !angular.isUndefined(register.email)){
            if( $scope.usernameCheck(register.username)){
                $scope.error = "Username is taken";
            }else if( $scope.emailCheck(register.email)){
                $scope.error = "Email is already used";
            }else if( register.password1 != register.password2){
                $scope.error = "Passwords do not match";
            }else{
                console.log("entered");
                $http.get("../php/register.php?user=" + register.username + "&pass=" + register.password1 + "&email=" + register.email).success(function(data){
                    $scope.error = "";
                    $scope.profileID = data.ID;
                    window.ID = data.ID;
                    window.username = data.username;
                    window.logURL = "loggedin.html";
                    window.avatar = data.avatar;
                    window.registerModal.dismiss();
                    $location.path("/validate/" + data.ID);
                });
            }
        }
    };

    $scope.usernameCheck = function(username){
        $http.get("../php/usernameCheck.php?username=" + username).success(function(data){
            if(data == false)
                return true;
            else
                return false;
        });

        return false;


    };

    $scope.emailCheck = function(email){
        return false;
    };

});

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

    $scope.ID = id;
    $scope.userID = window.ID;
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

    $scope.getComments = function(){
        $http.get("../php/commentController.php?type=article&id=" + id).success(function(data){
            $scope.comments = data;
        });
    };

    $scope.getTagName = function(tagID){
        if($scope.tagList){
            return $scope.tagList[tagID];
        }
    };

    $http.get("../php/profileController.php").success(function(data){
        var newData = new Object();
        for(var i=0; i < data.length; i++){
            var ID = data[i].ID;
            var info = {'username': data[i].username, 'avatar': data[i].avatar};
            newData[ID] = info;
        }

        $scope.userinfo = newData;

    });

    $scope.getUserName = function(userID){
        if(userID && $scope.userinfo){
            return $scope.userinfo[userID].username;
        }
    };

    $scope.getUserAvatar = function(userID){
        if(userID && $scope.userinfo){
            return $scope.userinfo[userID].avatar;
        }
    };

    setInterval(function(){
        $scope.getComments();
    }, 1000);
});

blogApp.controller('commentController', function($scope, $http, $routeParams){

    $scope.ID = window.ID;
    $scope.articleID = $routeParams.id;

    $scope.checkComment = function(){
        if(window.loggedin == true){
            $scope.commentURL = "comments.html";
        }else{
            $scope.commentURL = "nocomments.html";
        }
    };

    $scope.addComment = function(comment){

        var commentData = {
            'userID' : $scope.ID,
            'articleID' : $scope.articleID,
            'comment' : comment.commentText
        };

        $http.post('../php/addComment.php', commentData).success(function(data){
            angular.element("#commentText").val('');
        });
    };

    setInterval(function(){
        if(window.loggedin == true){
            $scope.commentURL = "comments.html";
        }else{
            $scope.commentURL = "nocomments.html";
        }
    }, 1000);

});

blogApp.controller('aboutController', function($scope){
    $scope.title = "About Us";

    angular.element('title').html("Electric Athletics - " + $scope.title);
});

blogApp.controller('contactController', function($scope, $http, $location){
    $scope.title = "Contact Us";

    angular.element('title').html("Electric Athletics - " + $scope.title);

    $scope.sendEmail = function(email){

        var emailObject = {
            'name' : email.name,
            'email' : email.email,
            'message' : email.message
        };

        $http.post('../php/sendEmail.php', emailObject).success(function(data){
            angular.element("#contactEmail").val('');
            angular.element("#contactName").val('');
            angular.element("#contactMessage").val('');
            $location.path("/thanks");
        });

    };
});

blogApp.controller('thanksController', function($scope){
    $scope.title = "Thank You";

    angular.element('title').html("Electric Athletics - " + $scope.title);
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

    $scope.profileCheck = function(){
        if(window.ID == $scope.id){
            $scope.profileURL = "profileControl.html";
        }
    };

    $scope.addpostCheck = function(){
        if(window.ID == 1){
            $scope.addPostURL = "addPostCheck.html";
        }
    };

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

blogApp.controller('editController', function($scope, $routeParams, $http, $location){
    $scope.ID = $routeParams.id;

    $http.get("../php/blogFetch.php?type=article&id=" + $scope.ID).success(function(data){
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

    $http.get("../php/tags.php?id=" + $scope.ID).success(function(data){
        $scope.tagList = data;

        console.log(data);
    });

    $scope.updateArticle = function(article, articleTags, newTags){

        console.log(articleTags, newTags);

        var articleObject = {

        };

        //$location.path("/article/" + $scope.ID);


    };

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

blogApp.controller('searchController', function($scope, $routeParams, $http){
    angular.element("#loading").show();

    var query = $routeParams.query;

    $scope.query = $routeParams.query;

    $scope.title = "Search for" + query;

    $scope.progess = 25;

    angular.element('title').html("Electric Athletics - " + $scope.title);

    $http.get("../php/search.php?type=article&query=" + query).success(function(data){
        $scope.articles = data;
        $scope.progess += 25;

        if($scope.articles.length == 0){
            angular.element("#searchArticlesError").html("No Articles Found");
        }
    });

    $http.get("../php/search.php?type=tag&query=" + query).success(function(data){
        $scope.tags = data;
        $scope.progess += 25;

        if($scope.tags.length == 0){
            angular.element("#searchTagsError").html("No Tags Found");
        }
    });

    $http.get("../php/search.php?type=user&query=" + query).success(function(data){
        $scope.users = data;
        $scope.progess += 25;

        if($scope.users.length == 0){
            angular.element("#searchUsersError").html("No Users Found");
        }
    });

    $scope.getType = function(ID){
        if(ID == 2){
            return "Sports";
        }else if(ID == 1){
            return "Technology";
        }
    };

});

blogApp.controller('logoutController', function($scope, $routeParams){

    $scope.ID = $routeParams.id;

    if($scope.ID == window.ID){
        window.loggedin = false;
        window.ID = 0;
        window.username = "";
        window.logURL = 'notloggedin.html';
        window.avatar = "";
        $scope.message = "You have been successfully logged out!";
    }else{
        $scope.message = "An error happened when you tried to log out!";
    }

    $scope.title = "Log Out"

    angular.element('title').html("Electric Athletics - " + $scope.title);

});

blogApp.controller('tagController', function($scope, $routeParams, $http){

    $scope.tag = $routeParams.tag;

    $http.get("../php/getTagName.php?id=" + $scope.tag).success(function(data){
        $scope.tagName = data.tag;

        angular.element('title').html("Electric Athletics - " + $scope.tagName);
    });

    $http.get("../php/getTagArticles.php?id=" + $scope.tag).success(function(data){
        $scope.articles = data;
        console.log(data);
    });

});


