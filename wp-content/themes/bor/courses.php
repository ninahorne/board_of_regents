<?php

/**
 * Template Name: Courses Page
 */
?>
<?php include('header.php'); ?>
<div id="content">
    <div class="background__blue">
        <div class="container">
            <div class="p-2">
                <h1 class="color-white">Courses Search</h1>
                <div class="row">
                    <div class="col-md-5">
                        <div class="courses__search">
                            <div class="faq__categories">
                                <div class="m-2">
                                    <div id="coursesTags"></div>

                                </div>
                                <div>
                                    <h3>Search by Keyword</h3>
                                    <div id="coursesSearchBox"></div>


                                </div>
                                <div class="mt-3 mb-3">
                                    <h6>Filters</h6>
                                    <hr>
                                    <div class="row">
                                        <div class="col-6">
                                            <h6>Distance</h6>
                                        </div>
                                        <div class="col-6">
                                            <input id="zipCode" type="text" placeholder="Enter Zipcode">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-7">
                        <div id="geo-search"></div>

                        <div id="coursesHits">
                        </div>
                        <div id="pagination"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', initializeAlgolia)
    let courses_search;
    let zipCode;
    let aroundRadius = 50;
    let latLngCenter;
    let geocoder = new google.maps.Geocoder();

    const zipCodeInput = document.querySelector('#zipCode');
    zipCodeInput.addEventListener('change', (e) => setQueryForGeoLoc(e))

    function setQueryForGeoLoc(e) {
        const zipCode = e.target.value;
        var lat = '';
        var lng = '';
        if (zipCode) {
            geocoder.geocode({
                address: zipCode
            }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    lat = results[0].geometry.location.lat();
                    lng = results[0].geometry.location.lng();
                    const algLatLng = `${lat}, ${lng}`;
                    console.log({algLatLng})
                    courses_search.helper.setQueryParameter('aroundLatLng', algLatLng);
                    courses_search.helper.setQueryParameter('aroundRadius', getMetersFromMiles(20));
                    courses_search.helper.search();

                }
            });

        }


    }
    
    function getMetersFromMiles(miles){
        return Math.ceil(miles * 1609.34);
    }

    function calculateDistanceBetweenPoints(latLngA, latLngB) {
        google.maps.geometry.spherical.computeDistanceBetween(latLngA, latLngB);
    }

    function getMilesFromKilometers(km) {
        return km * 0.621371;
    }

    function getZipCodeFromLatLng(p) {
        const lat = p.coords.latitude;
        const lng = p.coords.longitude;
        latLngCenter = new google.maps.LatLng(lat, lng);

        geocoder.geocode({
            'latLng': latLngCenter
        }, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    for (j = 0; j < results[0].address_components.length; j++) {
                        if (results[0].address_components[j].types[0] == 'postal_code')
                            zipCode = results[0].address_components[j].short_name;
                        // Set the value in the zipCode input box
                        zipCodeInput.value = zipCode;
                        // Trigger the event
                        var event = new Event('change');
                        zipCodeInput.dispatchEvent(event);
                    }
                }
            }
        });
    }

    function triggerAlgoliaSearch(input) {
        courses_search.helper.state.query = input;
        courses_search.helper.search();
    }

    function initializeAlgolia() {

        // navigator.geolocation.getCurrentPosition(getZipCodeFromLatLng);
        const index = searchClient.initIndex('courses');

        courses_search = instantsearch({
            indexName: "courses",
            searchClient,
            searchFunction(helper) {
                console.log('here');
                helper.search();
            },
        });

        // Create the render function
        const renderHits = (renderOptions, isFirstRender) => {
            const {
                hits,
                widgetParams
            } = renderOptions;

            widgetParams.container.innerHTML = `
                ${hits
                .map(
                (item) => {

                    return `Course: ${item.course_full_title}`;
                }).join("")}`;
        };

        // Create the custom widget
        const coursesCustomHits = instantsearch.connectors.connectHits(renderHits);


        // Create the render function
        // TODO create render menu
        const renderMenu = (renderOptions, isFirstRender) => {
            const {
                items,
                refine
            } = renderOptions;

            const container = document.querySelector('#coursesTags');
            container.innerHTML = `
                <div class="row">
                    ${items.map(item => `
                                return <p>${item}</p>`
                            )
                            .join('')}

                 </div>`;

        };

        const latLng = new google.maps.LatLng(30.4515, -91.1871);
        // var placesWidget = {
        //   init: function(opts) {
        //     var autocomplete = new google.maps.places.Autocomplete(/* ... */);
        //     autocomplete.addListener('place_changed', onPlaceChanged);

        //     function onPlaceChanged() {
        //       var location = autocomplete.getPlace().geometry.location;
        //       var lat = location.lat();
        //       var lng = location.lng();
        //       opts.helper.setQueryParameter('aroundLatLng', lat + ',' + lng);
        //       opts.helper.search();
        //     }
        //   }
        // };

        courses_search.addWidgets([

            instantsearch.widgets.searchBox({
                container: "#coursesSearchBox",
                placeholder: "Search",
                showSubmit: true
            }),
            instantsearch.widgets.pagination({
                container: '#pagination',
            }),

            coursesCustomHits({
                container: document.querySelector("#coursesHits"),
            }),

        ]);


        courses_search.start();

    }
</script>

<?php include('footer.php'); ?>