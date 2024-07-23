<?php

$view = new stdClass();
$view->pageTitle = 'Assessment 2 Criteria';
require_once('Models/UsersDataSet.php');

/**
 * Redirect the user to the login page, if they are not logged in
 */
if (!isset($_SESSION['username'])) {
    header("location: index.php");
}

require_once('Views/assessmentCriteria2.phtml');