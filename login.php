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
            header('Location: /callCenter');
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

if($method == 'GET'){

    $currentUser = ParseUser::getCurrentUser();
    
    //check if user have sign in before
    if ($currentUser) {
        // do stuff with the user
        redirectUser($currentUser);
        //redirect them to correct index page

    } else {
        // show the signup or login page
        ?>

<!-- create a form -->
<form action="/login.php" method="post" id="login-form">

    <label class="required">Username:</label> 
    <input id="username" maxlength="254" name="username" type="text">
    
    <label class="required">Password:</label> 
    <input id="password" name="password" type="password">
    <!-- <input type="hidden" name="next" value="/admin/"> -->

    <label>&nbsp;</label>
    <input type="submit" value="Log in">
</form>
<!-- end of create a form -->

        <?php
    }

}

//else if it is a POST request
else{
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $user = ParseUser::logIn($username, $password);
        echo('Loged in');
        // redirect user to correct page
        redirectUser($user);
         
    } catch (ParseException $error) {
        // The login failed. Check error to see why.
        echo('Failed');
    }   
}



?>

