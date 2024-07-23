// Get a reference to the search form and search results div
var searchInput = document.getElementById('searchInput');

// Add an event listener to the search form's submit button
searchInput.addEventListener('input', function() {
    // make an AJAX request to retrieve the search results
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var results = JSON.parse(xhr.responseText);
            // console.log(results[1].address1);            // Testing code to see data within variables

            // display the search results
            var searchResults = document.getElementById('chargersTableBody');
            searchResults.innerHTML = '';

            // Table appending code to display final results
            for (let i = 0; i < results.length; i++) {
                var chargePoint = results[i];
                searchResults.innerHTML += "<tr><td>" + chargePoint.chargerID + "</td><td>" + chargePoint.address1 + "</td><td>" + chargePoint.address2 + "</td><td>" + chargePoint.postcode + "</td><td>" + chargePoint.lat + "</td><td>" + chargePoint.lng + "</td><td>" + chargePoint.cost + "</td><td>" + "||" + "</td><td>" + chargePoint.ownerUsername + "</td><td>" + chargePoint.ownerFullname + "</td><td>" + '<img src="' + chargePoint.ownerPhoto + '" alt="EV Charge-point Owner Profile Picture">' + "</td><td>" + chargePoint.ownerPhoneNumber + "</td></tr>";
            }
        }
    };

    // Error handling in the event of the AJAX request - for easier debugging
    xhr.onerror = function() {
        console.error('An error has occurred during the AJAX request');
        console.error('Return status of ' + xhr.status);
    };

    xhr.open('GET', 'search.php?action=requestLiveSearch&searchInput=' + searchInput.value, true);
    xhr.send();
});