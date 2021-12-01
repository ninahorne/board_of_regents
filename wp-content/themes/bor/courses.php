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
                            <div class="course__categories">
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
                                            <a id="currentPosition" class="distance__location" href="">Current location <img src="<?php echo get_template_directory_uri(); ?>/images/location-light.svg"></a>
                                        </div>
                                    </div>
                                    <div class="distance__slider">
                                        <input id="distanceSlider" class="slider" step="25" type="range" min="0" max="100" value="50">
                                        <div class="slider__values">
                                            <p>0</p>
                                            <p>25</p>
                                            <p>50</p>
                                            <p>75</p>
                                            <p>100</p>
                                        </div>
                                    </div>
                                    <div class="refinements__select">
                                        <div id="institutionsLabel" class="refinements__label">
                                            <p>All Institutions</p>
                                            <span>x</span>
                                        </div>
                                        <div id="institutionsDropdown" class="refinements__dropdown">
                                            <div id="institutionMenu"></div>

                                        </div>

                                    </div>
                                    <div class="refinements__select">
                                        <div id="subjectAreasLabel" class="refinements__label">
                                            <div class="refinements__title">
                                                <p>Subject Areas</p> &nbsp;
                                                <span>Ex: Human Services, Marketing</span>
                                            </div>
                                            <span>x</span>
                                        </div>
                                        <div id="subjectAreasDropdown" class="refinements__dropdown">
                                            <div id="subjectAreasMenu"></div>

                                        </div>

                                    </div>
                                    <div class="refinements__select">
                                        <div id="typeLabel" class="refinements__label">
                                            <div class="refinements__title">
                                                <p>Type</p> &nbsp;
                                                <span>Ex: College - On Campus</span>
                                            </div>
                                            <span>x</span>
                                        </div>
                                        <div id="typeDropdown" class="refinements__dropdown">
                                            <div id="typeMenu"></div>

                                        </div>

                                    </div>
                                    <hr>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-7">
                        <div class="results__heading">
                            <h2 class="page__title">Search Results</h2>
                            <div id="sortBy"></div>
                            <img src="<?php echo get_template_directory_uri(); ?>/images/search-illustration.svg" alt="">
                        </div>
                        <hr class="results__hr">
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
    let algLatLng;
    let geocoder = new google.maps.Geocoder();

    const zipCodeInput = document.querySelector('#zipCode');
    zipCodeInput.addEventListener('change', (e) => setQueryForAroundLatLng(e))
    const distanceSlider = document.querySelector('#distanceSlider');
    distanceSlider.addEventListener('change', (e) => setQueryForAroundRadius(e))
    const currentPosition = document.querySelector('#currentPosition');
    currentPosition.addEventListener('click', (e) => getCurrentLocation(e))

    const institutionsLabel = document.querySelector('#institutionsLabel');
    const institutionsDropdown = document.querySelector("#institutionsDropdown");
    institutionsLabel.addEventListener('click', () => {
        institutionsDropdown.classList.toggle('open');
        institutionsLabel.classList.toggle('open');

    });

    const typeLabel = document.querySelector('#typeLabel');
    const typeDropdown = document.querySelector("#typeDropdown");
    typeLabel.addEventListener('click', () => {
        typeLabel.classList.toggle('open');
        typeDropdown.classList.toggle('open');

    })

    function getDistanceInMiles(item) {
        if (algLatLng) {
            const itemLatLng = item._geoloc;
            const [lat, lng] = algLatLng.split(',');
            const userLatLng = {
                lat: parseFloat(lat),
                lng: parseFloat(lng)
            };
            const miles = getDistanceBetweenTwoPointsInMiles(itemLatLng, userLatLng);
            return miles;
        }


    }

    function getDistanceBetweenTwoPointsInMiles(mk1, mk2) {
        let R = 3958.8; // Radius of the Earth in miles
        let rlat1 = mk1.lat * (Math.PI / 180); // Convert degrees to radians
        let rlat2 = mk2.lat * (Math.PI / 180); // Convert degrees to radians
        let difflat = rlat2 - rlat1; // Radian difference (latitudes)
        let difflon = (mk2.lng - mk1.lng) * (Math.PI / 180); // Radian difference (longitudes)

        let d = 2 * R * Math.asin(Math.sqrt(Math.sin(difflat / 2) * Math.sin(difflat / 2) + Math.cos(rlat1) * Math.cos(rlat2) * Math.sin(difflon / 2) * Math.sin(difflon / 2)));
        return Math.round(d);
    }

    function setQueryForAroundRadius(e) {
        const miles = parseInt(e.target.value)
        const meters = getMetersFromMiles(miles) || 1;
        courses_search.helper.setQueryParameter('aroundRadius', meters);
        courses_search.helper.search();
    }

    function setQueryForAroundLatLng(e) {
        const zipCode = e.target.value;
        let lat = '';
        let lng = '';
        if (zipCode) {
            geocoder.geocode({
                address: zipCode
            }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    lat = results[0].geometry.location.lat();
                    lng = results[0].geometry.location.lng();
                    algLatLng = `${lat}, ${lng}`;

                    courses_search.helper.setQueryParameter('aroundLatLng', algLatLng);
                    courses_search.helper.setQueryParameter('aroundRadius', getMetersFromMiles(parseInt(distanceSlider.value)));
                    courses_search.helper.search();

                }
            });

        }


    }

    function getMetersFromMiles(miles) {
        return Math.ceil(miles * 1609.34);
    }

    function getMilesFromKilometers(km) {
        return km * 0.621371;
    }

    function getZipCodeFromLatLngAndTriggerChange(p) {
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

    function getCurrentLocation(e) {
        e.preventDefault();
        navigator.geolocation.getCurrentPosition(getZipCodeFromLatLngAndTriggerChange);

    }

    function initializeAlgolia() {

        const index = searchClient.initIndex('courses');

        courses_search = instantsearch({
            indexName: "courses",
            searchClient,
            aroundRadius: getMetersFromMiles(50),
            searchFunction(helper) {
                helper.search();
            },
        });

        // TODO initilze aroundRadius
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
                    return  `<div class='results__course'>
                        <div class="results__image">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/placeholder.svg" />
                        </div>
                        <div class="results__info">
                            <p class="results__distance ${document.querySelector('#zipCode').value ? '' : 'hidden'}"><img src="<?php echo get_template_directory_uri(); ?>/images/biking-solid.svg" />&nbsp; ${getDistanceInMiles(item)} miles from ${document.querySelector('#zipCode').value} </p>
                            <p>${item.course_full_title}</p>
                        </div>
                        <div class="results__chevron">
                            >
                         </div>
                    </div>`

                }).join("")}`;
        };

        // Create the custom widget
        const coursesCustomHits = instantsearch.connectors.connectHits(renderHits);




        const latLng = new google.maps.LatLng(30.4515, -91.1871);

        courses_search.addWidgets([

            instantsearch.widgets.searchBox({
                container: "#coursesSearchBox",
                placeholder: "Search",
                showSubmit: true
            }),
            instantsearch.widgets.pagination({
                container: '#pagination',
            }),
            instantsearch.widgets.refinementList({
                container: document.querySelector('#institutionMenu'),
                attribute: 'institution',
                title: 'All Institutions',
                sortBy: ["name:asc"]
            }),
            instantsearch.widgets.refinementList({
                container: document.querySelector('#institutionMenu'),
                attribute: 'institution',
                sortBy: ["name:asc"]
            }),
            // instantsearch.widgets.refinementList({
            //     container: document.querySelector('#subjectAreaMenu'),
            //     attribute: 'subjectArea',
            //     sortBy: ["name:asc"]
            // }),
            instantsearch.widgets.refinementList({
                container: document.querySelector('#typeMenu'),
                attribute: 'modality',
                sortBy: ["name:asc"]
            }),
            instantsearch.widgets.sortBy({
                container: '#sortBy',
                items: [{
                        label: 'Default',
                        value: 'courses'
                    },
                    {
                        label: 'A-Z',
                        value: 'courses_full_title_asc'
                    },
                    {
                        label: 'Price (asc)',
                        value: 'courses_cost_per_course_asc'
                    },
                    {
                        label: 'Price (desc)',
                        value: 'courses_cost_per_course_desc'
                    },


                ],
            }),
            coursesCustomHits({
                container: document.querySelector("#coursesHits"),
            }),

        ]);


        courses_search.start();

    }
</script>

<?php include('footer.php'); ?>