<section class="useful-college-links">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="flex-center">
                    <h1 onclick="changeMarkers()">Useful College Links</h1>
                    <div id="usefulCollegeLinksSearchBox">
                        <span onclick="showResults()" class="useful-college-links__dropdown"></span>
                    </div>
                    <div id="usefulCollegeLinksResults">
                        <div id="usefulCollegeLinksTagsList"></div>
                        <div id="usefulCollegeLinksHits">

                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-6">
                <div id="map_wrapper">
                    <div id="map_canvas" class="mapping"></div>
                </div>
            </div>
        </div>
        <div>
            <div class="container">
                <div id="selectedCollege">

                </div>

            </div>


        </div>
    </div>
</section>

<script>
    function clearSelectedCollege() {
        const selectedCollege = document.querySelector('#selectedCollege');
        selectedCollege.innerHTML = '';
    }

    function showResults() {
        const results = document.getElementById('usefulCollegeLinksResults');
        results.style.display = 'block';
    };
    function hideResults() {
        const results = document.getElementById('usefulCollegeLinksResults');
        results.style.display = 'none';
    };

    function onClick(objectId, lat, long, campus, system) {
        hideResults();
        changeMarkers(lat, long, campus, system);
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            console.log(this.responseText);
            const selectedCollege = document.querySelector('#selectedCollege');
            selectedCollege.innerHTML = this.responseText;
        };
        var body = {
            objectId
        };

        xhttp.open("GET", "./wp-content/themes/bor/get_college.php?objectId=" + objectId, false);
        xhttp.send('objectId=' + encodeURIComponent(objectId));
    };
    jQuery(function($) {
        // Asynchronously Load the map API 
        var script = document.createElement('script');
        script.src = "//maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyDmpMknHZCk19dfAumNHIRMIziQb6Ny5Y4&callback=initialize";
        document.body.appendChild(script);
    });

    function changeMarkers(lat, long, campus, system) {
        var map;
        var bounds = new google.maps.LatLngBounds();
        var mapOptions = {
            mapTypeId: 'roadmap',
            mapId: '3b4f0b682ef60cbe'
        };
        map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
        var markers = [
            [`${campus} - ${system}`, lat, long]
        ];

        // Info Window Content
        var infoWindowContent = [
            ['<div class="info_content">' +
                `<h3>${campus}</h3>` +
                `<h6>${system}</h6></div>` 
            ]
        ];

        // Display multiple markers on a map
        var infoWindow = new google.maps.InfoWindow(),
            marker, i;

        // Loop through our array of markers & place each one on the map  
        for (i = 0; i < markers.length; i++) {
            var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
            bounds.extend(position);
            marker = new google.maps.Marker({
                position: position,
                map: map,
                title: markers[i][0],
                icon: '/board of regents/wp-content/themes/bor/images/yellow-brush-stroke.svg'

            });

            // Allow each marker to have an info window    
            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    infoWindow.setContent(infoWindowContent[i][0]);
                    infoWindow.open(map, marker);
                }
            })(marker, i));

            // Automatically center the map fitting all markers on the screen
            map.fitBounds(bounds);
        }

        // Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
        var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
            this.setZoom(14);
            google.maps.event.removeListener(boundsListener);
        });
    }
</script>