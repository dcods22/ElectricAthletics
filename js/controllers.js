blogApp.controller('modalController', function($scope, $modal, $cookies){

    if($cookies.loggedin == true){
        window.loggedin = true;
        $scope.loggedin = true;
        window.ID = $cookies.ID;
        $scope.ID = $cookies.ID;
        window.username = $cookies.username;
        $scope.username = $cookies.username;
        window.logURL = 'loggedin.html';
        $scope.logURL = 'loggedin.html';
        window.avatar = $cookies.avatar;
        $scope.avatar = $cookies.avatar;
        console.log($cookies);
    }else{
        $scope.logURL = 'notloggedin.html';
        window.logURL = 'notloggedin.html';
    }

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
        $scope.$apply();
    }, 1000)
});

blogApp.controller('loginController', function($scope, $http, $location, $cookies){

    $scope.alerts = [];

    $scope.loginNow = function(login){
        $scope.alerts = [];
        if(!angular.isUndefined(login.username) && !angular.isUndefined(login.password)){
            $http.get("../php/login.php?user=" + login.username + "&pass=" + login.password).success(function(data){
                if(data.error){
                    $scope.loggedin = false;
                    $scope.alerts.push({type: 'danger', msg: data.error});
                }else if(data[0].id){
                    window.loggedin = true;
                    window.ID = data[0].id;
                    window.username = data[0].username;
                    window.logURL = 'loggedin.html';
                    window.avatar = data[0].avatar;
                    window.loginModal.dismiss();
                }

                if(login.remember){
                    $cookies.loggedin = true;
                    $cookies.ID = data[0].id;
                    $cookies.username = data[0].username;
                    $cookies.avatar = data[0].avatar;
                }
            });
        }else{
            $scope.alerts.push({type: 'danger', msg: 'Username or Password are not filled out!'});
        }
    };

    $scope.registerNow = function(register){
        $scope.alerts = [];
        if(!angular.isUndefined(register.username) && !angular.isUndefined(register.password1) && !angular.isUndefined(register.email)){
            if( $scope.usernameCheck(register.username)){
                $scope.alerts.push({type: 'danger', msg: 'Username is taken!'});
            }else if( $scope.emailTest(register.email)){
                $scope.alerts.push({type: 'danger', msg: 'Email is not valid!'});
            }else if( $scope.emailCheck(register.email)){
                $scope.alerts.push({type: 'danger', msg: 'Email has already been used!'});
            }else if( register.password1 != register.password2){
                $scope.alerts.push({type: 'danger', msg: 'Passwords do not match!'});
            }else if( register.password1.length < 6 || $scope.passwordTest(register.password1)){
                $scope.alerts.push({type: 'danger', msg: 'Passwords is not valid, it must contain 6 letters and atleast 1 number!'});
            }else{
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

    $http.get("../php/usernameCheck.php").success(function(data){
        $scope.usernames = data;
    });

    $http.get("../php/emailCheck.php").success(function(data){
        $scope.emails = data;
    });

    $scope.usernameCheck = function(username){
        for(var x=0; x < $scope.usernames.length; x++){
            if($scope.usernames[x].username == username)
                return true;
        }

        return false;
    };

    $scope.emailCheck = function(email){
        for(var x=0; x < $scope.emails.length; x++){
            if($scope.emails[x].email == email)
                return true;
        }

        return false;
    };

    $scope.emailTest = function(email) {
        var regExp = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return !regExp.test(email);
    };

    $scope.passwordTest = function(password){
        var regExp = "/^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,16}$/";
        var rE = new RegExp(regExp);
        return rE.test(password);
    };

    $scope.closeAlert = function(index) {
        $scope.alerts.splice(index, 1);
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
    $scope.alerts = [];


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
        if($scope.comments.length == 0){
            $scope.commentError = "There are no comments";
        }
    });

    $scope.isThereComments = function(){
        $http.get("../php/commentController.php?type=article&id=" + id).success(function(data){
            if(data.length == 0){
                $scope.commentError = "There are no comments";
            }
        });
    };

    $scope.delete = function(ID, userID){

        if(window.loggedin && window.ID == userID){
            $http.get("../php/deleteComment.php?id=" + ID);
            $scope.getComments();
        }else{
            $scope.alerts = [];
            $scope.alerts.push({type: 'danger', msg: 'This is not your comment!'});
        }

    };

    $scope.edit = function(ID){
        $scope.getComments();
    };

    $scope.getComments = function(){
        $http.get("../php/commentController.php?type=article&id=" + id).success(function(data){
            $scope.comments = data;
        });
    };

    $scope.checkComments = function(){
        $http.get("../php/commentController.php?type=article&id=" + id).success(function(data){
            $scope.newComments = data;
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

    $scope.closeAlert = function(index) {
        $scope.alerts.splice(index, 1);
    };

    $scope.isThereComments();
    $scope.getComments();
    $scope.checkComments();

    setInterval(function(){
        $scope.isThereComments();
        $scope.checkComments();
        if(! angular.equals($scope.comments, $scope.newComments)){
            $scope.getComments();
        }
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

        angular.element(".noComments").remove();

        var commentData = {
            'userID' : window.ID,
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

    $scope.alerts = [];

    $scope.sendEmail = function(email){

        $scope.alerts = [];

        if( $scope.emailTest(email.email)){
            $scope.alerts.push({type: 'danger', msg: 'Email is not valid!'});
        }else{
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
        }

    };

    $scope.emailTest = function(email) {
        var regExp = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return !regExp.test(email);
    };

    $scope.closeAlert = function(index) {
        $scope.alerts.splice(index, 1);
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
    });

    $scope.updateArticle = function(article, articleTags, newTags){

        $http.post("../php/updateArticle.php", article);

        var newTag = {
            'ID' : $scope.ID,
            'tags' : newTags
        };

        $http.post("../php/addNewTags.php", newTag);

        var articleTag = {
            'ID' : $scope.ID,
            'tags' : articleTags
        };

        $http.post("../php/updateTags.php", articleTag);

        $location.path("/article/id/" + $scope.ID);


    };

});

blogApp.controller('validateController', function($scope, $routeParams, $http){
    var id = $routeParams.id;

    $scope.title = "Validate";

    angular.element('title').html("Electric Athletics - " + $scope.title);

});

blogApp.controller('addPostController', function($scope, $routeParams, $http, $location){

    $scope.title = "Add Post";

    $http.get("../php/tagNames.php").success(function(data){
        $scope.tags = data;
    });

    $scope.addArticle = function(article, articleTags, newTags){

        $http.post("../php/addArticle.php", article).success(function(data){

            $scope.ID = data;

            var newTag = {
                'ID' : data,
                'tags' : newTags
            };

            $http.post("../php/addNewTags.php", newTag);

            var articleTag = {
                'ID' : data,
                'tags' : articleTags
            };

            $http.post("../php/addTags.php", articleTag);

            $location.path("/article/id/" + $scope.ID);
        });
    };

    angular.element('title').html("Electric Athletics - " + $scope.title);

});

blogApp.controller('searchFixController', function($scope, $location){
    $scope.search = function(query){
        $location.path("/search/" + query.search);
        angular.element("#searchBar").val('');
    };
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

    $scope.getType = function(ID){
        if(ID == 2){
            return "Sports";
        }else if(ID == 1){
            return "Technology";
        }
    };

});

blogApp.controller('logoutController', function($scope, $routeParams, $cookies){

    $scope.ID = $routeParams.id;

    if($scope.ID == window.ID){
        window.loggedin = false;
        window.ID = 0;
        window.username = "";
        window.logURL = 'notloggedin.html';
        window.avatar = "";
        $cookies.loggedin = false;
        $cookies.ID = "";
        $cookies.username = "";
        $cookies.avatar = "";
        $scope.message = "You have been successfully logged out!";
    }else{
        $scope.message = "An error happened when you tried to log out!";
    }

    $scope.title = "Log Out";

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
    });

});

blogApp.controller('editProfileController' , function($scope, $routeParams, $http, $location, $cookies){

    $scope.ID = $routeParams.id;

    if(window.loggedin && window.ID == $scope.ID){

        $http.get("../php/profileController.php?id=" + $scope.ID).success(function(data){
            $scope.user = data;
        });

    }else{
        $location.path("/profile/" + $scope.ID);
    }

    $scope.updateProfile = function(user){

        $scope.alerts = [];

        window.username = user.username;
        window.avatar = user.avatar;
        window.email = user.email;

        if($cookies.loggedin){
            $cookies.ID = user.id;
            $cookies.username = user.username;
            $cookies.avatar = user.avatar;
        }

        var finalUser = {
            'ID' : $scope.ID,
            'email' : user.email,
            'avatar' : user.avatar,
            'username' : user.username
        };
        if($scope.usernameCheck(user.username)){
            $scope.alerts.push({type: 'danger', msg: 'Username has already been used!'});
        }else if($scope.emailCheck(user.email)){
            $scope.alerts.push({type: 'danger', msg: 'Email has already been used!'});
        }else{
            $http.post("../php/updateProfile.php", finalUser).success(function(data){
                $scope.alerts.push({type: 'success', msg: 'Profile Successfully Changed!'});
            });
        }
    };

    $http.get("../php/usernameCheck.php").success(function(data){
        $scope.usernames = data;
    });

    $http.get("../php/emailCheck.php").success(function(data){
        $scope.emails = data;
        console.log(data);
    });

    $scope.usernameCheck = function(username){
        for(var x=0; x < $scope.usernames.length; x++){
            if($scope.usernames[x].username == username)
                return true;
        }

        return false;
    };

    $scope.emailCheck = function(email){
        for(var x=0; x < $scope.emails.length; x++){
            if($scope.emails[x].email == email)
                return true;
        }

        return false;
    };

    $scope.closeAlert = function(index) {
        $scope.alerts.splice(index, 1);
    };
});


