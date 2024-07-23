// Variables found below
var status = document.getElementById("resultText");
var searchInput = document.getElementById('searchInput');
// console.log(searchInput.value);      // For testing purposes only

/*
 * Code to pull the coordinates of the users device
 */
if(!navigator.geolocation) {
    status.textContent = 'Geolocation is not supported by your browser';
    // Code to do something if no geolocation support
} else {
    var map = L.map('map'); //map initialisation code

    // Button for the user to zoom in on their location if needed
    var findMeBtn = L.DomUtil.create('button', 'leaflet-control custom-button');
    findMeBtn.innerHTML = 'Current<br>Location';
    findMeBtn.addEventListener('click', function() {
        map.locate({setView: true, zoom: 15}); // Focuses on the users location and sets the zoom level to 15
    });
    map.getContainer().appendChild(findMeBtn);

    // Open Street Map layer found below
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        noWrap: true // noWrap option added to prevent the map from wrapping around itself - helps markers functionality
    }).addTo(map);

    status.textContent = 'Locating Coordinates...';
    navigator.geolocation.getCurrentPosition(success, error);
}

// Method which will implement changes, if the geolocation is successful
function success(position) {
    var lat = position.coords.latitude;
    var long = position.coords.longitude;
    displayResult(lat, long);

    map.setView([lat, long], 13);   // Users location code
    var redMarkerIcon = L.icon({    // Code for a custom red marker
        iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41]
    });
    // Users location marker found below, implementing custom red marker
    var marker = L.marker([lat, long], {id: 'UsersLocation', icon: redMarkerIcon}).addTo(map);
    marker.bindPopup("This is your current location").openPopup();  // Marker pop-up messages

    // Code below for creating markers for pulled Chargers object locations and ensures
    // markers ae updated in a live manner, instead of needing a button / action to be taken
    searchInput.addEventListener('input', function() {

        // Remove all markers except for the users location marker
        map.eachLayer(function (layer) {
            if (layer instanceof L.Marker && layer.options.id !== 'UsersLocation') {
                map.removeLayer(layer);
            }
        });

        // Make an AJAX request to retrieve markers data
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var markersData = JSON.parse(xhr.responseText);

                // add the markers to the map
                for (let i = 0; i < markersData.length; i++) {
                    var markerData = markersData[i];
                    var marker = L.marker([markerData.lat, markerData.lng]).addTo(map);
                    marker.bindPopup(
                        "<strong>City:</strong> " + markerData.address2 +
                        "<br><strong>Location:</strong> " + markerData.address1 +
                        "<br><strong>Postcode:</strong> " + markerData.postcode +
                        "<br><strong>Charger Cost:</strong> £" + markerData.cost + "/pm" +
                        "<br>-------------------------" +
                        "<br><strong>Owner Name:</strong> " + markerData.ownerFullname +
                        "<br><strong>Owner Email:</strong> " + markerData.ownerUsername +
                        "<br><strong>Owner Phone number:</strong> " + markerData.ownerPhoneNumber
                    );
                    map.setView([lat, long], 5);                                   // users location code
                }
            }
        };

        // Error handling in the event of the AJAX request - for easier debugging
        xhr.onerror = function () {
            console.error('An error has occurred during the AJAX request');
            console.error('Return status of ' + xhr.status);
        };

        xhr.open('GET', 'search.php?action=requestLiveSearch&searchInput=' + searchInput.value, true);
        xhr.send();
    });
}

// Method which will implement changes, if the geolocation is unsuccessful
function error() {
    status.textContent = 'Unable to retrieve your location';
    //code below used for testing only
    // alert('ERROR(' + error.code + '): ' + error.message);
}

// Method which displays the result of the geolocation lat and long data of the user
function displayResult(lat,long)
{
    var result = document.getElementById("resultText");
    result.innerHTML = "Latitude: " + lat + "<br>Longitude: " + long;
}