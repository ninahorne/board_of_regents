
// Globals
let courses_search;
let zipCode;
let aroundRadius = 50;
let algLatLng;
let geocoder = new google.maps.Geocoder();

// Form Inputs
const zipCodeInput = document.querySelector("#zipCode");
const zipCodeClear = document.querySelector(".search__zip span");
const distanceSlider = document.querySelector("#distanceSlider");
const currentPosition = document.querySelector("#currentPosition");

// Filter Labels and dropdowns
const institutionsLabel = document.querySelector("#institutionsLabel");
const institutionsDropdown = document.querySelector("#institutionsDropdown");
const typeLabel = document.querySelector("#typeLabel");
const typeDropdown = document.querySelector("#typeDropdown");

// Initialize
document.addEventListener("DOMContentLoaded", initializeAlgolia);
document.addEventListener("DOMContentLoaded", setInitialStateFromQueryParams);

// Event listeners
zipCodeInput.addEventListener("change", (e) => setQueryForAroundLatLng(e));
zipCodeClear.addEventListener("click", clearZipCode);

distanceSlider.addEventListener("change", (e) => setQueryForAroundRadius(e));
currentPosition.addEventListener("click", (e) => getCurrentLocation(e));
institutionsLabel.addEventListener("click", () => {
  institutionsDropdown.classList.toggle("open");
  institutionsLabel.classList.toggle("open");
});
typeLabel.addEventListener("click", () => {
  typeLabel.classList.toggle("open");
  typeDropdown.classList.toggle("open");
});

// Algolia Config
function initializeAlgolia() {
  const index = searchClient.initIndex("courses");

  courses_search = instantsearch({
    indexName: "courses",
    searchClient,
    hitsPerPage: 4,
    searchFunction(helper) {
      setQueryParams(helper.state);
      helper.search();
    },
  });

  // Create the render function
  const renderHits = (renderOptions, isFirstRender) => {
    const { hits, widgetParams } = renderOptions;

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
                            <img src="<?php echo get_template_directory_uri(); ?>/images/placeholder.svg" />
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
                        
                    </div>
                    <div class="results__info second">
                        <p class="results__description">${item.description.substring(
                          0,
                          100
                        )}</p>

                        <label>${item.semester}</label>
                        <label>Subject Area</label>
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
            };
        
        }`;
  };

  // Create the custom widget
  const coursesCustomHits = instantsearch.connectors.connectHits(renderHits);

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
    instantsearch.widgets.pagination({
      container: "#pagination",
    }),
    instantsearch.widgets.refinementList({
      container: document.querySelector("#institutionMenu"),
      attribute: "institution",
      title: "All Institutions",
      sortBy: ["name:asc"],
    }),
    instantsearch.widgets.refinementList({
      container: document.querySelector("#institutionMenu"),
      attribute: "institution",
      sortBy: ["name:asc"],
    }),

    instantsearch.widgets.refinementList({
      container: document.querySelector("#typeMenu"),
      attribute: "modality",
      sortBy: ["name:asc"],
    }),
    instantsearch.widgets.sortBy({
      container: "#sortBy",
      items: [
        {
          label: "Default",
          value: "courses",
        },
        {
          label: "A-Z",
          value: "courses_full_title_asc",
        },
        {
          label: "Price (asc)",
          value: "courses_cost_per_course_asc",
        },
        {
          label: "Price (desc)",
          value: "courses_cost_per_course_desc",
        },
      ],
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

  if (institution) {
    const valArray = institution.split(",");
    courses_search.helper.addDisjunctiveFacetRefinement(
      "institution",
      valArray
    );
  }

  if (modality) {
    const valArray = modality.split(",");
    courses_search.helper.addDisjunctiveFacetRefinement("modality", valArray);
  }

  if (aroundRadius) {
    courses_search.helper.setQueryParameter("aroundRadius", aroundRadius);
    // const miles = getMilesFromMeters(aroundRadius);
    distanceSlider.value = 75;
  }

  if (aroundLatLng) {
    courses_search.helper.setQueryParameter("aroundLatLng", aroundLatLng);
    // const zipCode = getZipCodeFromLatLng(aroundLatLng);
    zipCodeInput.value = 70131;
  }
  if (query) {
    courses_search.helper.query = query;
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
  let queryParamString = "?";
  const aroundLatLng =
    state.aroundLatLng != "30.4515,-91.1871" ? state.aroundLatLng : "";
  if (aroundLatLng) {
    queryParamString = `${queryParamString}aroundLatLng=${aroundLatLng}&`;
  }
  const aroundRadius = state.aroundRadius;
  if (aroundLatLng) {
    queryParamString = `${queryParamString}aroundRadius=${aroundRadius}&`;
  }
  const institutions = state.disjunctiveFacetsRefinements.institution.join(",");
  if (institutions) {
    queryParamString = `${queryParamString}institution=${institutions}&`;
  }
  const modalities = state.disjunctiveFacetsRefinements.modality.join(",");
  if (modalities) {
    queryParamString = `${queryParamString}modality=${modalities}&`;
  }

  const query = state.query;
  if (query) {
    queryParamString = `${queryParamString}query=${query}&`;
  }

  if (queryParamString != "?") {
    window.history.replaceState(null, null, queryParamString);
  }
}

function setQueryForAroundRadius(e) {
  const miles = parseInt(e.target.value);
  const meters = getMetersFromMiles(miles) || 1;
  courses_search.helper.setQueryParameter("aroundRadius", meters);
  courses_search.helper.search();
}
function setQueryForAroundLatLng(e) {
  const zipCode = e.target.value;
  let lat = "";
  let lng = "";
  if (zipCode) {
    geocoder.geocode(
      {
        address: zipCode,
      },
      function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          lat = results[0].geometry.location.lat();
          lng = results[0].geometry.location.lng();
          algLatLng = `${lat}, ${lng}`;

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
    initQueries();
    const times = document.querySelector(".search__zip span");
    times.classList.add("hidden");
  }
}
function setAroundLatLngQueryFromCurrentPosition(p) {
  const lat = p.coords.latitude;
  const lng = p.coords.longitude;
  latLngCenter = new google.maps.LatLng(lat, lng);

  geocoder.geocode(
    {
      latLng: latLngCenter,
    },
    function (results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        if (results[0]) {
          for (j = 0; j < results[0].address_components.length; j++) {
            if (results[0].address_components[j].types[0] == "postal_code")
              zipCode = results[0].address_components[j].short_name;
            // Set the value in the zipCode input box
            zipCodeInput.value = zipCode;
            // Trigger the event
            var event = new Event("change");
            zipCodeInput.dispatchEvent(event);
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
  return Math.ceil(miles * 1609.34);
}

function getMilesFromKilometers(km) {
  return km * 0.621371;
}

function getMilesFromMeter(meters) {
  return Math.ceil(meters / 1609.34);
}
