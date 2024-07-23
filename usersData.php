<?php

require_once('Models/UsersDataSet.php');

//This page has been excluded from the website and was only used for testing purposes
//and to check the connection between the database and the website.

/**
 * Redirect the user to the login page, if they are not logged in
 */
if (!isset($_SESSION['username'])) {
    header("location: index.php");
}

$view = new stdClass();
$view->pageTitle = 'Users Database System';

$usersDataSet = new UsersDataSet();
$view->usersDataSet = $usersDataSet->fetchAllUsers();

require_once('Views/usersData.phtml');