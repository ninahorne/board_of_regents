var map;
var markers = [];
var lastWindow;

function initialize(collegeLinks) {
  var colleges = collegeLinks.colleges;
  var bounds = new google.maps.LatLngBounds();
  var mapOptions = {
    mapTypeId: "roadmap",
    mapId: "3b4f0b682ef60cbe",
  };

  // Display a map on the page
  map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
  map.setTilt(45);


  // Loop through our array of markers & place each one on the map
  for (i = 0; i < colleges.length; i++) {
    var position = new google.maps.LatLng(colleges[i].lat, colleges[i].long);
    bounds.extend(position);
    marker = new google.maps.Marker({
      position: position,
      map: map,
      title: colleges[i].campus,
      icon: '../../wp-content/themes/bor/images/map-icon.svg'
    });
    markers.push(marker);

    // Allow each marker to have an info window
    google.maps.event.addListener(
      marker,
      "click",
      (function (marker, i) {
        return function () {
          if (lastWindow) {
            lastWindow.close();
          }
          var infoWindow = new google.maps.InfoWindow();
          lastWindow = infoWindow;
          infoWindow.setContent(`<h3>${colleges[i].campus}</h3>`);

          infoWindow.open({
            anchor: marker,
            map,
            shouldFocus: false,
          });

          onClick(
            colleges[i].objectId,
            colleges[i].lat,
            colleges[i].long,
            colleges[i].campus,
            colleges[i].system
          );
        };
      })(marker, i)
    );
    google.maps.event.addListener(
      markers[i],
      "click",
      (function (marker, i) {
        return function () {
          if (lastWindow) {
            lastWindow.close();
          }
          var infoWindow = new google.maps.InfoWindow();
          lastWindow = infoWindow;

          infoWindow.setContent(`<h3>${colleges[i].campus}</h3>`);

          infoWindow.open({
            anchor: marker,
            map,
            shouldFocus: false,
          });

        };
      })(marker, i)
    );

    // Automatically center the map fitting all markers on the screen
    map.fitBounds(bounds);
  }


  // Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
  var boundsListener = google.maps.event.addListener(
    map,
    "bounds_changed",
    function (event) {
      this.setZoom(6.5);
      google.maps.event.removeListener(boundsListener);
    }
  );
}

function changeMarker(lat, long, campus, system) {
  var bounds = new google.maps.LatLngBounds();
  var position = new google.maps.LatLng(lat, long);
  bounds.extend(position);
  map.fitBounds(bounds);
  map.setZoom(9.5);
}

function clickMarker(campus) {
  var marker = markers.find((mark) => mark.title === campus);

  new google.maps.event.trigger(marker, "click");
}
