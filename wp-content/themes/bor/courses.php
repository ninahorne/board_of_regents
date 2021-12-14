<?php

/**
 * Template Name: Courses Page
 */
?>
<?php include('header.php'); ?>
<div id="content">
    <div class="background__blue">
        <div id="courses" class="container">
            <div class="p-2">
                <h1 class="color-white">Courses Search</h1>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="courses__search">
                            <div class="course__categories">
                                <div>
                                    <h3>Search by Keyword</h3>
                                    <div id="coursesSearchBox"></div>


                                </div>
                                <div class="mt-3 mb-3">
                                    <h6 class="align-center closed" id="filterToggle"><img src="<?php echo get_template_directory_uri(); ?>/images/sliders-h-solid.svg">&nbsp;&nbsp;&nbsp;Filters&nbsp;&nbsp;&nbsp;<img class="filter__arrow" src="<?php echo get_template_directory_uri(); ?>/images/sort-down-solid.svg"></h6>
                                    <div id="filterOptions" class="closed">
                                        <hr>
                                        <div class="row">
                                            <div class="col-6">
                                                <h6 class="mt-2">Distance</h6>
                                            </div>
                                            <div class="col-6">
                                                <div class="search__zip">
                                                    <input id="zipCode" type="text" placeholder="Enter Zipcode">
                                                    <span class="hidden">&times;</span>
                                                </div>
                                                <a id="currentPosition" class="distance__location" href="">Current location <img src="<?php echo get_template_directory_uri(); ?>/images/location-light.svg"></a>

                                            </div>
                                        </div>
                                        <div class="distance__slider">
                                            <label for="distanceSlider">Radius (in miles)</label>
                                            <input id="distanceSlider" class="slider" step="5" type="range" min="0" max="50" value="25">

                                            <div class="slider__values">
                                                <p>0</p>
                                                <p>5</p>
                                                <p>10</p>
                                                <p>15</p>
                                                <p>20</p>
                                                <p>25</p>
                                                <p>30</p>
                                                <p>35</p>
                                                <p>40</p>
                                                <p>45</p>
                                                <p>50</p>
                                            </div>
                                        </div>
                                        <div id="currentRefinements"></div>
                                        <div id="institutionsRefinements" class="refinements__select">
                                            <div id="institutionsLabel" class="refinements__label">
                                                <p>All Institutions</p>
                                                <span><img src="<?php echo get_template_directory_uri(); ?>/images/sort-down-solid.svg" /></span>

                                            </div>
                                            <div id="institutionsDropdown" class="refinements__dropdown">
                                                <div tabindex="0" id="institutionMenu"></div>

                                            </div>

                                        </div>
                                        <div id="subjectAreaRefinements" class="refinements__select">
                                            <div id="subjectAreaLabel" class="refinements__label">
                                                <div class="refinements__title">
                                                    <p>Subject Areas</p> &nbsp;
                                                    <span>Ex: Marketing</span>
                                                </div>
                                                <span><img src="<?php echo get_template_directory_uri(); ?>/images/sort-down-solid.svg" /></span>

                                            </div>
                                            <div id="subjectAreaDropdown" class="refinements__dropdown">
                                                <div tabindex="0" id="subjectAreaMenu"></div>

                                            </div>

                                        </div>
                                        <div id="typeRefinements" class="refinements__select">
                                            <div id="typeLabel" class="refinements__label">
                                                <div class="refinements__title">
                                                    <p>Type</p> &nbsp;
                                                    <span>Ex: College - On Campus</span>
                                                </div>
                                                <span><img src="<?php echo get_template_directory_uri(); ?>/images/sort-down-solid.svg" /></span>
                                            </div>
                                            <div id="typeDropdown" class="refinements__dropdown">
                                                <div tabindex="0" id="typeMenu"></div>

                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-8">
                        <div class="results__heading">
                            <h2 class="page__title">Search Results</h2>
                            <div id="sortBy"></div>
                            <img src="<?php echo get_template_directory_uri(); ?>/images/search-illustration.svg" alt="">
                        </div>
                        <hr class="results__hr">
                        <div id="coursesHits">
                        </div>
                        <div class="results__footer">
                            <div id="pagination"></div>
                            <div class="results__share">
                                <h6 class="results__share-text hidden-sm">Share these results</h6>
                                <div class="results__icon">
                                    <a id="emailShare" href="mailto:?subject=LA Board of Regents - Dual Enrollment Courses&body=Check out these Louisiana Dual Enrollment Courses!  <?php echo 'https://' . getenv('HTTP_HOST') . $_SERVER['REQUEST_URI'] ?>">
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/envelope-solid.svg" alt="">
                                    </a>
                                </div>
                                <div id='pdfShare' class="results__icon">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/file-pdf-solid.svg" alt="">
                                </div>
                                <div id='csvShare' class="results__icon">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/file-csv-solid.svg" alt="">

                                </div>
                                <div id='qrShare' class="results__icon">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/qrcode-solid.svg" alt="">
                                </div>
                            </div>

                            <h6 class="results__share-text visible-sm">Share these results</h6>

                        </div>
                        <div id="qrCode"></div>

                    </div>
                </div>
                <div class="p-5">
                    <h2 class="page__title text-center">Have more questions about courses?</h2>
                    <h2 class="page__title text-center">Try these resources.</h2>
                    <div class="row pt-5">
                        <div class="col-lg-4">
                            <div class="course__links">
                                <p>See how courses transfer <br /> between institutions.
                                </p>
                                <a href="./index.php/courses" class="cta unformatted">
                                    Articulation Matrix &nbsp;&nbsp;<i class="fa fa-long-arrow-alt-right"></i>
                                </a>
                            </div>

                        </div>
                        <div class="col-lg-4">
                            <div class="course__links">
                                <p>All your <br /> questions answered.
                                </p>
                                <a href="./index.php/faqs" class="cta unformatted">
                                    FAQs &nbsp;&nbsp;<i class="fa fa-long-arrow-alt-right"></i>
                                </a>
                            </div>

                        </div>
                        <div class="col-lg-4">
                            <div class="course__links">
                                <p>See what types of careers <br /> each field of study may lead to.
                                </p>
                                <a href="./index.php/fields-of-study" class="cta unformatted">
                                    Fields of Study &nbsp;&nbsp;<i class="fa fa-long-arrow-alt-right"></i>
                                </a>
                            </div>

                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
    <div id="shareResults"></div>
</div>
<script>
    // Globals
    let courses_search;
    let zipCode;
    let aroundRadius = 25;
    let algLatLng;
    let geocoder = new google.maps.Geocoder();
    let isFirstRender = true;

    // Form Inputs
    const zipCodeInput = document.querySelector("#zipCode");
    const zipCodeClear = document.querySelector(".search__zip span");
    const distanceSlider = document.querySelector("#distanceSlider");
    const currentPosition = document.querySelector("#currentPosition");


    // Filter Labels and dropdowns
    const institutionsLabel = document.querySelector("#institutionsLabel");
    const institutionsDropdown = document.querySelector("#institutionsDropdown");
    const institutionsRefinements = document.querySelector("#institutionsRefinements");

    const typeLabel = document.querySelector("#typeLabel");
    const typeDropdown = document.querySelector("#typeDropdown");
    const typeRefinements = document.querySelector("#typeRefinements");

    const subjectAreaLabel = document.querySelector("#subjectAreaLabel");
    const subjectAreaDropdown = document.querySelector("#subjectAreaDropdown");
    const subjectAreaRefinements = document.querySelector("#subjectAreaRefinements");

    // Initialize
    document.addEventListener("DOMContentLoaded", initializeAlgolia);
    document.addEventListener("DOMContentLoaded", setInitialStateFromQueryParams);

    // Event listeners
    zipCodeInput.addEventListener("change", (e) => setQueryForAroundLatLng(e));
    zipCodeClear.addEventListener("click", clearZipCode);
    distanceSlider.addEventListener("change", (e) => setQueryForAroundRadius(e));
    currentPosition.addEventListener("click", (e) => getCurrentLocation(e));

    institutionsLabel.addEventListener("click", toggleInstitutionRefinements);
    typeLabel.addEventListener("click", toggleTypeRefinements);
    subjectAreaLabel.addEventListener("click", toggleSubjectAreaRefinements);

    //I'm using "click" but it works with any event
    document.addEventListener('click', function(event) {
        const isRefinement = event.target.className.includes('ais-RefinementList');
        if (isRefinement) return;
        var isClickInsideSubjectArea = subjectAreaRefinements.contains(event.target);
        var isClickInsideType = typeRefinements.contains(event.target);
        var isClickInsideInstitutions = institutionsRefinements.contains(event.target);


        if (!isClickInsideSubjectArea) {
            closeSubjectAreaRefinements()
        }

        if (!isClickInsideInstitutions) {
            closeInstitutionRefinements();
        }
        if (!isClickInsideType) {
            closeTypeRefinements();
        }
    });

    function toggleInstitutionRefinements() {
        institutionsDropdown.classList.toggle("open");
        institutionsLabel.classList.toggle("open");

    }

    function openInstitutionRefinements() {
        institutionsDropdown.classList.add("open");
        institutionsLabel.classList.add("open");

    }

    function closeInstitutionRefinements() {
        institutionsDropdown.classList.remove("open");
        institutionsLabel.classList.remove("open");

    }

    function toggleSubjectAreaRefinements() {
        subjectAreaLabel.classList.toggle("open");
        subjectAreaDropdown.classList.toggle("open");
    }

    function openSubjectAreaRefinements() {
        subjectAreaLabel.classList.add("open");
        subjectAreaDropdown.classList.add("open");
    }

    function closeSubjectAreaRefinements() {
        subjectAreaLabel.classList.remove("open");
        subjectAreaDropdown.classList.remove("open");
    }

    function toggleTypeRefinements() {
        typeLabel.classList.toggle("open");
        typeDropdown.classList.toggle("open");
    }

    function openTypeRefinements() {
        typeLabel.classList.add("open");
        typeDropdown.classList.add("open");
    }

    function closeTypeRefinements() {
        typeLabel.classList.remove("open");
        typeDropdown.classList.remove("open");
    }
    // Algolia Config
    function initializeAlgolia() {
        const index = searchClient.initIndex("courses");

        courses_search = instantsearch({
            indexName: "courses",
            searchClient,
            hitsPerPage: 4,
            searchFunction(helper) {
                if (!isFirstRender) {
                    setQueryParams(helper.state);
                }
                helper.search();
                isFirstRender = false;
            },
        });

        // Custom Hits
        const renderHits = (renderOptions, isFirstRender) => {
            const {
                hits,
                widgetParams
            } = renderOptions;

            widgetParams.container.innerHTML = `
            ${
              hits.length
                ? hits
                    .map((item) => {
                      return `<a class='results__link' href='${
                        item.url
                      }'><div class='results__course'>
                    <div class="results__image">
                        <div class="results__image__background">
                            <img src="${item.subject_area_icon}" />
                        </div>
                    </div>
                    <div class="results__info first">
                        <p class="results__distance ${
                          document.querySelector("#zipCode").value
                            ? ""
                            : "hidden"
                        }"><img src="<?php echo get_template_directory_uri(); ?>/images/biking-solid.svg" />&nbsp; ${getDistanceInMiles(
                        item
                      )} miles from ${
                        document.querySelector("#zipCode").value
                      } </p>
                        <p class="results__title">${item.course_full_title}</p>
                        ${item.satellite_campus ? `<p class="results__satellite">${item.satellite_campus}</p>` : null}
                    </div>
                    <div class="results__info second">
                        <p class="results__description">${item.description.substring(
                          0,
                        150
                        )}...</p>

                        <label>${item.semester}</label>
                        <label>${item.course_subject}</label>
                        <label class="green">Cost: $${
                          item.cost_per_course
                        }</label>
                    </div>
                    
                    <div class="results__chevron">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/chevron-right-regular.svg" />
                     </div>
                </div>`;
                    })
                    .join("")
                : "<div class = 'results__empty'><h4> No results match your query. </h4> </div>"
            }`;
        };


        const coursesCustomHits = instantsearch.connectors.connectHits(renderHits);

        // Custom Refinements
        const createDataAttribtues = refinement =>
            Object.keys(refinement)
            .map(key => `data-${key}="${refinement[key]}"`)
            .join(' ');

        const renderListItem = item => `
                    ${item.refinements
                        .map(
                        refinement =>
                            `<li>
                            ${refinement.label}
                            <button ${createDataAttribtues(refinement)}>&times;</button>
                            </li>`
                        )
                        .join('')}
                `;

        const renderCurrentRefinements = (renderOptions, isFirstRender) => {
            const {
                items,
                refine,
                widgetParams
            } = renderOptions;

            widgetParams.container.innerHTML = `
                <ul class="courses__current-refinements">
                ${
                    getQueryParamsObjectFromString(window.location.search).query != undefined ?
                    `<li>${getQueryParamsObjectFromString(window.location.search).query}
                        <button id="clearSearch">&times;</button>
                    </li>` : ''
                }
                ${items.map(renderListItem).join('')}
                </ul>
            `;
            document.querySelector('#clearSearch')?.addEventListener("click", clearSearch);

            [...widgetParams.container.querySelectorAll('button')].forEach(element => {
                element.addEventListener('click', event => {
                    const item = Object.keys(event.currentTarget.dataset).reduce(
                        (acc, key) => ({
                            ...acc,
                            [key]: event.currentTarget.dataset[key],
                        }), {}
                    );

                    refine(item);
                });
            });

        };

        const customCurrentRefinements = instantsearch.connectors.connectCurrentRefinements(
            renderCurrentRefinements
        );


        // Custom pagination
        // 1. Create a render function
        const renderPagination = (renderOptions, isFirstRender) => {
            const {
                pages,
                currentRefinement,
                isFirstPage,
                isLastPage,
                widgetParams,
                refine,
            } = renderOptions;

            let page = isFirstPage ? 1 : currentRefinement;

            document.querySelector('#pagination').innerHTML = `
                <ul class="results__pagination">
                ${
                !isFirstPage
                ? `
                    <li class="pagination__prev">
                        <a href="" data-value="${page - 1}"><</a>
                    </li>
                    <li>
                        <a href="" data-value="${page - 1}">
                            ${page - 1}
                        </a>
                    </li>
                    `
                : ''
                }
                <li class="pagination__current">${page}</li>
                ${
                    !isLastPage
                    ? 
                    `<li>
                        <a href="" data-value="${page + 1}">
                            ${page + 1}
                        </a>
                    </li>
                    <li class="pagination__next">
                        <a  data-value="${page + 1}" href="#">></a>
                    </li>
                        `
                    : ''
                 }`;

            [...widgetParams.container.querySelectorAll('a')].forEach(element => {
                element.addEventListener('click', event => {
                    event.preventDefault();
                    refine(event.currentTarget.dataset.value);
                    widgetParams.scrollTo.scrollIntoView();
                });
            });

        };

        const customPagination = instantsearch.connectors.connectPagination(
            renderPagination
        );


        const latLng = new google.maps.LatLng(30.4515, -91.1871);

        courses_search.addWidgets([
            instantsearch.widgets.configure({
                hitsPerPage: 4,
            }),
            instantsearch.widgets.searchBox({
                container: "#coursesSearchBox",
                placeholder: "Search",
                showSubmit: true,
            }),
            customPagination({
                container: document.querySelector("#pagination"),
                scrollTo: document.querySelector('.results__heading')
            }),

            instantsearch.widgets.refinementList({
                container: document.querySelector("#institutionMenu"),
                attribute: "institution",
                title: "All Institutions",
                sortBy: ["name:asc"],
                limit: 100
            }),
            instantsearch.widgets.refinementList({
                container: document.querySelector("#subjectAreaMenu"),
                attribute: "course_subject",
                sortBy: ["name:asc"],
                limit: 100
            }),

            instantsearch.widgets.refinementList({
                container: document.querySelector("#typeMenu"),
                attribute: "modality",
                sortBy: ["name:asc"],
                limit: 100
            }),
            instantsearch.widgets.sortBy({
                container: "#sortBy",
                items: [
                    {
                        label: "Sort By:",
                        value: "courses",
                    },
                    {
                        label: "A-Z",
                        value: "courses_full_title_asc",
                    },
                    {
                        label: "Price (low to high)",
                        value: "courses_cost_per_course_asc",
                    },
                    {
                        label: "Price (high to low)",
                        value: "courses_cost_per_course_desc",
                    },
                ],
            }),
            customCurrentRefinements({
                container: document.querySelector('#currentRefinements')
            }),
            coursesCustomHits({
                container: document.querySelector("#coursesHits"),
            }),
        ]);


        courses_search.start();
    }


    function setInitialStateFromQueryParams() {
        const queryParamsString = window.location.search;
        const queryObject = getQueryParamsObjectFromString(queryParamsString);
        const institution = queryObject["institution"];
        const modality = queryObject["modality"];
        const aroundRadius = queryObject["aroundRadius"];
        const aroundLatLng = queryObject["aroundLatLng"];
        const query = queryObject["query"];
        const courseSubject = queryObject["course_subject"];
        const page = queryObject['refine'];

        if (institution) {
            const valArray = institution.split(";");
            valArray.forEach(facet => {
                courses_search.helper.addDisjunctiveFacetRefinement(
                    "institution",
                    facet
                );
            })

        }

        if (modality) {
            const valArray = modality.split(";");
            valArray.forEach(facet => {
                courses_search.helper.addDisjunctiveFacetRefinement(
                    "modality",
                    facet
                );
            })
        }
        if (courseSubject) {
            const valArray = courseSubject.split(";");
            const formattedArray = valArray.map(item => decodeURI(item).replace(/%26/g, '&'));

            formattedArray.forEach(facet => {
                courses_search.helper.addDisjunctiveFacetRefinement(
                    "course_subject",
                    facet
                );
            });

        }


        if (aroundRadius) {
            courses_search.helper.setQueryParameter("aroundRadius", aroundRadius);
            const miles = getMilesFromMeters(aroundRadius);
            console.log({
                miles
            })
            setQueryForAroundRadius({
                target: {
                    value: miles
                }
            });

            distanceSlider.value = miles
        }

        if (aroundLatLng) {
            const [lat, lng] = aroundLatLng.split(',');
            setAroundLatLngQueryFromCurrentPosition({
                coords: {
                    latitude: parseFloat(lat),
                    longitude: parseFloat(lng)
                }
            })
        }
        if (query) {
            courses_search.helper.setQuery(query);
        }

        console.log('set initial state');
        console.log({
            page
        });
        console.log(courses_search.helper)
        if (page) {
            courses_search.helper.setPage(page);
        }
        courses_search.helper.search();
    }

    function getQueryParamsObjectFromString(queryString) {
        const withoutQuestion = queryString.replace("?", "");
        const arrayOfProps = withoutQuestion.split("&");
        const obj = arrayOfProps.reduce((obj, prop) => {
            const [key, value] = prop.split("=");
            obj[key] = decodeURIComponent(value);
            return obj;
        }, {});
        return obj;
    }

    // Functions for manually setting queries
    function setQueryParams(state) {
        /** We set query paras based on algolia state so that a user
         * can share and return to this state.
         */

        let queryParamString = '?';

        console.log(state);
        const page = state.page;
        console.log({
            page
        })
        if (page) {
            queryParamString = `${queryParamString}refine=${page}&`;
        }

        const aroundLatLng =
            state.aroundLatLng;
        if (aroundLatLng) {
            queryParamString = `${queryParamString}aroundLatLng=${aroundLatLng}&`;
        }
        const aroundRadius = state.aroundRadius;
        if (aroundRadius) {
            queryParamString = `${queryParamString}aroundRadius=${aroundRadius}&`;
        }
        const institutions = state.disjunctiveFacetsRefinements.institution.join(";");
        if (institutions) {
            queryParamString = `${queryParamString}institution=${institutions}&`;
        }
        const modalities = state.disjunctiveFacetsRefinements.modality.join(";");
        if (modalities) {
            queryParamString = `${queryParamString}modality=${modalities}&`;
        }
        const courseSubjects = state.disjunctiveFacetsRefinements.course_subject.join(";").replace(/&/g, '%26');;
        if (courseSubjects) {
            queryParamString = `${queryParamString}course_subject=${encodeURI(courseSubjects)}&`;
        }


        const query = state.query;
        if (query) {
            queryParamString = `${queryParamString}query=${query}&`;
        }

        window.history.replaceState(null, null, queryParamString);
    }

    function setQueryForAroundRadius(e) {
        const miles = parseInt(e.target.value);
        const meters = getMetersFromMiles(miles) || 1;
        console.log({
            miles
        });
        console.log({
            meters
        });
        courses_search.helper.setQueryParameter("aroundRadius", meters);
        courses_search.helper.search();
    }

    function clearSearch() {

        courses_search.helper.setQuery('');
        courses_search.helper.search();
    }

    function setQueryForAroundLatLng(e) {
        const zipCode = e.target.value;
        let lat = "";
        let lng = "";
        if (zipCode && zipCode != 'undefined') {
            geocoder.geocode({
                    address: zipCode,
                },
                function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        lat = results[0].geometry.location.lat();
                        lng = results[0].geometry.location.lng();
                        algLatLng = `
                $ {
                    lat
                }, $ {
                    lng
                }
                `;
                        console.log({
                            lat,
                            lng
                        });
                        courses_search.helper.setQueryParameter("aroundLatLng", algLatLng);
                        courses_search.helper.setQueryParameter(
                            "aroundRadius",
                            getMetersFromMiles(parseInt(distanceSlider.value))
                        );
                        courses_search.helper.search();

                        const times = document.querySelector(".search__zip span");
                        times.classList.remove("hidden");
                    }
                }
            );
        } else {
            const times = document.querySelector(".search__zip span");
            times.classList.add("hidden");
            courses_search.helper.setQueryParameter('aroundLatLng', '');
            courses_search.helper.setQueryParameter('aroundRadius', '');
            courses_search.helper.search();

        }
    }

    function setAroundLatLngQueryFromCurrentPosition(p) {
        const lat = p.coords.latitude;
        const lng = p.coords.longitude;

        latLngCenter = new google.maps.LatLng(lat, lng);
        geocoder.geocode({
                latLng: latLngCenter,
            },
            function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        for (j = 0; j < results[0].address_components.length; j++) {
                            if (results[0].address_components[j].types[0] == "postal_code")
                                zipCode = results[0].address_components[j].short_name;
                            // Set the value in the zipCode input box
                            zipCodeInput.value = zipCode;
                            triggerZipCodeChangeEvent();
                        }
                    }
                }
            }
        );
    }

    function getCurrentLocation(e) {
        e.preventDefault();
        navigator.geolocation.getCurrentPosition(
            setAroundLatLngQueryFromCurrentPosition
        );
    }

    function setSearchQuery(query) {
        courses_search.helper.state.query = query;
        courses_search.helper.search();
    }

    // Zip code functions
    function clearZipCode() {
        zipCodeInput.value = "";
        triggerZipCodeChangeEvent();

    }

    function triggerZipCodeChangeEvent() {
        var event = new Event("change");
        zipCodeInput.dispatchEvent(event);
    }

    // Unit conversion functions
    function getDistanceInMiles(item) {
        if (algLatLng) {
            // TODO can i get rid of this?
            const itemLatLng = item._geoloc;
            const [lat, lng] = algLatLng.split(",");
            const userLatLng = {
                lat: parseFloat(lat),
                lng: parseFloat(lng),
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

        let d =
            2 *
            R *
            Math.asin(
                Math.sqrt(
                    Math.sin(difflat / 2) * Math.sin(difflat / 2) +
                    Math.cos(rlat1) *
                    Math.cos(rlat2) *
                    Math.sin(difflon / 2) *
                    Math.sin(difflon / 2)
                )
            );
        return Math.round(d);
    }

    function getMetersFromMiles(miles) {
        return Math.round(miles * 1609.34);
    }

    function getMilesFromKilometers(km) {
        return km * 0.621371;
    }

    function getMilesFromMeters(meters) {
        return Math.round(meters / 1609.34);
    }



    const pdfShare = document.querySelector('#pdfShare');
    pdfShare.addEventListener('click', generatePDF);
    const csvShare = document.querySelector('#csvShare');
    csvShare.addEventListener('click', generateCSV);
    const qrShare = document.querySelector('#qrShare');
    qrShare.addEventListener('click', generateQRCode);

    function generateQRCode() {
        new QRCode(document.getElementById("qrCode"), window.location.href);
    }
    async function generatePDF() {
        const results = await getSearchResultsForSharing();
        const html = convertResultsIntoHTML(results);
        html2pdf().set({
            margin: 5,
            pagebreak: {
                mode: ['css', 'legacy']
            }
        }).from(html).save('LA-Dual-Enrollment-Courses-Results');

    }

    async function generateCSV() {
        const results = await getSearchResultsForSharing();
        const csv = convertResultsIntoCSV(results);
        let csvContent = "data:text/csv;charset=utf-8,";
        csv.forEach(function(rowArray) {
            let row = rowArray.join(",");
            csvContent += row + "\r\n";
        });

        const encodedUri = encodeURI(csvContent);
        const link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "LA-Dual-Enrollment-Courses-Results.csv");
        document.body.appendChild(link);
        link.click();
    }

    function convertResultsIntoCSV(hits) {
        const csv = [];
        hits.forEach(
            hit => {
                const hitArray = [];
                Object.keys(hit).forEach(
                    key => {
                        if (key === 'course_full_title' || key === 'description' || key === 'semester' || key === 'subjectArea' || key === 'cost_per_course')
                            hitArray.push(hit[key]);
                    }
                )
                csv.push(hitArray);
            }
        )
        return csv;
    }

    function convertResultsIntoHTML(hits) {
        const container = document.createElement('div');
        const h2 = document.createElement('h2');
        h2.innerText = "Louisiana Dual Enrollment Courses";
        const ol = document.createElement('ol');
        ol.style.padding = "3rem";
        container.style.padding = "2rem";

        hits.forEach(hit => {
            const li = document.createElement('li');
            const div = document.createElement('div');
            const h3 = document.createElement('h3');
            h3.innerText = `
                $ {
                    hit.course_full_title
                }
                at $ {
                    hit.institution
                }
                `;
            const h6 = document.createElement('h6');
            h6.innerText = `
                $ {
                    hit.semester
                } | Subject Area | Cost: $$ {
                    hit.cost_per_course
                }
                `
            const p = document.createElement('p');
            p.innerText = hit.description;
            li.style.pageBreakInside = 'avoid';
            div.appendChild(h3);
            div.appendChild(h6);
            div.appendChild(p);
            li.appendChild(div);
            ol.appendChild(li);
        });
        container.appendChild(h2);
        container.appendChild(ol);
        return container;
    }

    async function getSearchResultsForSharing() {


        const results = [];
        const index = searchClient.initIndex('courses');
        const queryParamsString = window.location.search;
        const queryObject = getQueryParamsObjectFromString(queryParamsString);

        const institution = queryObject["institution"] || '';
        const modality = queryObject["modality"] || '';
        const aroundRadius = queryObject["aroundRadius"];
        const aroundLatLng = queryObject["aroundLatLng"];
        const query = queryObject["query"];

        let nbPages;
        const hits = await index.search(query, {

            aroundRadius: aroundRadius,
            aroundLatLng: aroundLatLng,
            facetFilters: [
                `
                institution: $ {
                    institution
                }
                `,
                `
                modality: $ {
                    modality
                }
                `,
            ]
        });

        nbPages = hits.nbPages;


        for (let i = 0; i < nbPages; i++) {
            const page_of_hits = await index.search(query, {
                page: i + 1,
                aroundRadius: aroundRadius,
                aroundLatLng: aroundLatLng,
                facetFilters: [`
                institution: $ {
                    institution
                }
                `, `
                modality: $ {
                    modality
                }
                `, ]
            });
            let actHits = page_of_hits.hits;
            results.push(...page_of_hits.hits);
        }
        return Promise.resolve(results);

    }
    // Show / Hide Filter
    const filterToggle = document.querySelector('#filterToggle');
    filterToggle.addEventListener('click', toggleFilter);
    const filterOptions = document.querySelector('#filterOptions');
    filterOptions.addEventListener('click', filterOptions);

    function toggleFilter() {
        filterToggle.classList.toggle('closed');
        filterOptions.classList.toggle('closed');
    }
</script>

<?php include('footer.php'); ?>