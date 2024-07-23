<?php

$view = new stdClass();
$view->pageTitle = 'Register';
require_once('Models/UsersDataSet.php');

//if registerBtn has been set, the code will proceed to run the class method to register, with sanitised parameters
if (isset($_POST['registerBtn'])) {
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $fullname = filter_var($_POST['fullname'], FILTER_SANITIZE_STRING);
    $password = strip_tags($_POST['password']);
    $photo = strip_tags($_POST['photo']);
    $phoneNumber = filter_var($_POST['phoneNumber'], FILTER_SANITIZE_NUMBER_INT);

    $register = new UsersDataSet();
    //pass values to register method after being lowered and or trimmed for whitespace
    $response = $register->register(strtolower(trim($username)), trim($fullname), trim($password), trim($photo), trim($phoneNumber));

    //below statement used for testing purposes
    //echo "$response";
}

require_once('Views/register.phtml');