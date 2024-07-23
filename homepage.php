<?php

$view = new stdClass();
$view->pageTitle = 'Homepage';
require_once('Models/UsersDataSet.php');

/**
 * Redirect the user to the login page, if they are not logged in
 */
if (!isset($_SESSION['username'])) {
    header("location: index.php");
}
require_once('Views/homepage.phtml');
