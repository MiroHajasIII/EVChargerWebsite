<?php

$view = new stdClass();
$view->pageTitle = 'Chargers Database System';
require_once('Models/ChargersDataSet.php');

/**
 * Redirect the user to the login page, if they are not logged in.
 */
if (!isset($_SESSION['username'])) {
    header("location: index.php");
}

/**
 * Instantiate new ChargersDataSet to hold data queried by the website.
 * Display sought after results and display all the information present if
 * nothing has specific been sought after.
 */
$chargersDataSet = new ChargersDataSet();

if (isset($_REQUEST['searchBtn'])) {
    $view->chargersDataSet = $chargersDataSet->searchChargers($_REQUEST['searchData']);
} else {
    $view->chargersDataSet = $chargersDataSet->fetchTenChargers();
}

require_once('Views/chargersData.phtml');