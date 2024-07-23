<?php

require_once('Models/ChargersDataSet.php');

function requestLiveSearch() {
    $searchCDSet = new ChargersDataSet();
    $searchInput = $_GET['searchInput'];    // Local variable
    $searchInputLength = strlen($searchInput);

    if($searchInputLength == 0){
        echo ($searchCDSet->fetchTenChargers());
    } else {
        $query = $_GET['searchInput'];

        // Sanitize user input before using it in queries
        $query = filter_var($query, FILTER_SANITIZE_STRING);

        $ajaxData = $searchCDSet->searchChargers($query);

        header('Content-Type: application/json');
        echo ($ajaxData);
    }
}

// Check if all valid arguments are in place before calling the method hosted within the if statement
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'requestLiveSearch') {
    requestLiveSearch(); //call function in here
}