<?php

require 'vendor/autoload.php';
 
use Parse\ParseClient;
 
ParseClient::initialize('qjArPWWC0eD8yFmAwRjKkiCQ82Dtgq5ovIbD5ZKW', '9Yl2TD1DcjR6P1XyppzQ9NerO6ZwWBQnpQiM0MkL', 'MjYJYsSjr5wZVntUFxDvv0VpXGqhPOT8YFpULNB2');


use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParseUser;
use Parse\ParseRole;

$method = $_SERVER['REQUEST_METHOD'];

function redirectUser($user) {
    $query = new ParseQuery("_Role");
    $query->equalTo("users",$user);
    $result = $query->find();

    if(count($result)>0){
        $object = $result[0];
        $roleName = $object->get('name');

        if($roleName == "CallCenter"){
            echo('CallCenter');
            header('Location: /CallCenter');
        }
        else if($roleName == "Operator"){
            echo('Operator');
            header('Location: /operator');
        } 
    }
    else{
        echo('No Role');
    }  
}

$message = '';
if($method == 'GET'){

    $currentUser = ParseUser::getCurrentUser();
    
    //check if user have sign in before
    if ($currentUser) {
        // do stuff with the user
        redirectUser($currentUser);
        //redirect them to correct index page

    } else {
        $message = '';
    }

}

//else if it is a POST request
else{
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $user = ParseUser::logIn($username, $password);
        // redirect user to correct page
        if($user!=null){
            redirectUser($user);
            $message = 'Login successfully';
        }
        else{
            $message = 'Login failed';
        }
         
    } catch (Exception $error) {
        // The login failed. Check error to see why.
        $message = 'Login Failed';
    }
}



?>

<html>
    <head>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.2/angular.min.js"></script>
        <title>Login</title>  
    </head>
    <body>
        
        <div class="container">
            <nav class="navbar navbar-default" role="navigation">
                <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">Crisis Management System</a>
                </div>
            </nav>

            <div class="row">
                <!-- create a form -->
                <div class="col-md-3"></div>
                <form role="form" class="col-md-6 form-horizontal" action="/login.php" method="post" id="login-form">
                    <div class="form-group">

                        <div class="panel panel-info">
                            <div class="panel-heading">
                                Login
                            </div>
                        </div>
                        <div class="panel-body">
                            <label class="col-sm-3 control-label required" for="username">Username:</label>
                            <div class="col-sm-8 input-group">
                                <span class="input-group-addon">*</span>
                                <input type="text" maxlength="254" class="form-control" id="username" name="username" placeholder="Username" required="required">
                            </div>
                            <br/>
                           <label class="col-sm-3 control-label required" for="password">Password:</label>
                            <div class="col-sm-8 input-group">
                                <span class="input-group-addon">*</span>
                                <input type="password" maxlength="254" class="form-control" id="password" name="password" placeholder="Password" required="required">
                            </div>
                            <div class="col-sm-3"></div><p class="col-sm-8"><?php echo $message?></p>
                            <br/>
                            <div class="col-md-3"></div>
                            <input class="col-sm-8 btn btn-primary btn-md" type="submit" value="Log in">
                        </div>
                    </div>
                </form>
                <!-- end of create a form -->
                <div class="col-md-3"></div>
            </div>  
        </div>
    </body> 
</html>