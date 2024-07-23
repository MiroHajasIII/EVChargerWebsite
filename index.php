<?php

$view = new stdClass();
$view->pageTitle = 'Sign in';
require_once('Models/UsersDataSet.php');

if (isset($_REQUEST['loginBtn'])) {
    //local variables concerning user input
    $username = filter_var($_REQUEST['username'], FILTER_SANITIZE_STRING);
    $password = strip_tags($_REQUEST['password']);

    //if statement concerning attempted user login
    if (empty($username) || empty($password)) {
        echo "Credentials Cannot Remain Empty!";
    } else {
        $login = new UsersDataSet();
        $login->login();
    }
}

//If the user wishes to log out using the form button
if (isset($_POST['logoutBtn'])) {
    session_unset();
    session_destroy();
}

/**
 * checking variable values by printing them onto screen temporarily
 * - used for debugging
 */
//commented out as only used for testing
//echo '-----==== DETAILS BELOW ARE FROM INDEX.PHP ====-----<br>';
//echo '<pre>REQUEST - ';
//print_r($_REQUEST);
//echo '<br>SESSION - ';
//print_r($_SESSION);
//echo '<br>POST - ';
//print_r($_POST);
//echo '</pre>';
//echo '<br><br><br><br>';

require_once('Views/index.phtml');