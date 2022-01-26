// Globals
let courses_search;
let zipCode;
let aroundRadius = 25;
let algLatLng;
let geocoder = new google.maps.Geocoder();
let isFirstRender = true;

// Form Inputs
const zipCodeInput = document.querySelector("#zipCode");
const zipCodeButton = document.querySelector("#zipCodeButton");

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
document.addEventListener("DOMContentLoaded",()=> {
  initializeAlgolia();
  setInitialStateFromQueryParams();
  activateTooltips()
  activateRefinementsLabels();
} );



// Event listeners
zipCodeButton.addEventListener("click", setQueryForAroundLatLng);
zipCodeClear.addEventListener("click", clearZipCode);
distanceSlider.addEventListener("change", (e) => setQueryForAroundRadius(e));
currentPosition.addEventListener("click", (e) => getCurrentLocation(e));


function activateRefinementsLabels(){
  const refinementsLabels = document.querySelectorAll('[data-refinementslabel]');
  refinementsLabels.forEach(label => {
    label.addEventListener('click',toggleRefinementsLabel);
  
  })
}

function toggleRefinementsLabel() {
  const label = this;
  const dropdown = document.querySelector(label.dataset.dropdown);
  dropdown?.classList.toggle('open');
  label?.classList.toggle('open');
}
document.addEventListener('click', controlDisplayOfRefinementsDropdowns);

// TODO add custom widget for semeste

function controlDisplayOfRefinementsDropdowns(e) {
  const isRefinement = e.target.className.includes('ais-RefinementList');
  if (isRefinement) return;
  const refinementContainers = document.querySelectorAll('[data-refinement]');
  refinementContainers.forEach(
    container => {
        const isInside = container.contains(e.target);
        if(!isInside){
          closeRefinements(container);
        }
    }
  )
}



function closeRefinements(container){
  const dropdown = container.querySelector('.refinements__dropdown');
  const label = container.querySelector('.refinements__label');
  dropdown.classList.remove('open');
  label.classList.remove('open');

}



// Algolia Config
function initializeAlgolia() {

  courses_search = instantsearch({
    indexName: "courses_full_title_asc",
    searchClient,
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
           ${hits.length
        ? hits
          .map((item) => {
            return `<a class='results__link' href='${item.url
              }'><div class='results__course'>
                   <div class="results__image">
                       <div class="results__image__background">
                           <img src="${item.subject_area_icon}" />
                       </div>
                   </div>
                   <div class="results__info first">
                        <div class="d-flex">
                           <p class="results__distance">
                               ${item.institution}
                           </p>
                       <p class="results__distance ${document.querySelector("#zipCode").value
                ? ""
                : "hidden"
              }"> &nbsp;&nbsp;&nbsp;<img src="../../wp-content/themes/bor/images/biking-solid.svg" />&nbsp; ${getDistanceInMiles(
                item
              )} miles from ${document.querySelector("#zipCode").value
              } </p>
                     </div>

                       <p class="results__title">${item.course_full_title}</p>
                       ${item.satellite_campus && item.satellite_campus != 'none' ? `<p class="results__satellite">${item.satellite_campus}</p>` : ''}
                   </div>
                   <div class="results__info second">
                       <p class="results__description">${item.description}...</p>
                       <label class="green">Cost: $${item.minimum_cost && item.maximum_cost ? `$${item.minimum_cost}-$${item.maximum_cost}` : item.cost_per_course
              }</label>
                       <label>${item.semester}</label>
                       <label>${item.course_subject}</label>
                      
                   </div>
                   
                   <div class="results__chevron">
                   <img src="../../wp-content/themes/bor/images/chevron-right-regular.svg" />
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
               ${getQueryParamsObjectFromString(window.location.search).query != undefined ?
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
  const renderPagination = (renderOptions, isFirstRender) => {
    const {
      currentRefinement,
      isLastPage,
      widgetParams,
      refine,
    } = renderOptions;

    let page = currentRefinement == 0 ? 1 : currentRefinement;

    document.querySelector('#pagination').innerHTML = `
               <ul class="results__pagination">
               ${page != 1
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
               ${!isLastPage
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

  // Custom stats Widget
  const renderStats = (renderOptions, isFirstRender) => {
    const {
      nbHits,
      widgetParams
    } = renderOptions;

    widgetParams.container.innerHTML = `
               <p class="results__stats">Showing ${nbHits} results</p>
               `
  };

  const customStats = instantsearch.connectors.connectStats(
    renderStats
  );



  courses_search.addWidgets([
    instantsearch.widgets.configure({
      hitsPerPage: 10,
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
    instantsearch.widgets.refinementList({
      container: document.querySelector("#semesterMenu"),
      attribute: "semester",
      sortBy: ["name:asc"],
      limit: 100
    }),
    instantsearch.widgets.sortBy({
      container: "#sortBy",
      items: [{
        label: "Most Relevant",
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
    customStats({
      container: document.querySelector('#nbHits')
    })
  ]);


  courses_search.start();
}


// Functions for handling state
function setInitialStateFromQueryParams() {
  const queryParamsString = window.location.search;
  const queryObject = getQueryParamsObjectFromString(queryParamsString);
  const institution = queryObject["institution"];
  const modality = queryObject["modality"];
  const aroundRadius = queryObject["aroundRadius"];
  const aroundLatLng = queryObject["aroundLatLng"];
  const query = queryObject["query"];
  const courseSubject = queryObject["course_subject"];
  const semester = queryObject["semester"];
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

  if (semester) {
    const valArray = semester.split(";");
    const formattedArray = valArray.map(item => decodeURI(item).replace(/%26/g, '&'));

    formattedArray.forEach(facet => {
      courses_search.helper.addDisjunctiveFacetRefinement(
        "semester",
        facet
      );
    });

  }

  if (aroundRadius) {
    courses_search.helper.setQueryParameter("aroundRadius", aroundRadius);
    const miles = getMilesFromMeters(aroundRadius);

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

// Functions for manually setting state/queries
function setQueryParams(state) {
  let queryParamString = '?';

  const page = state.page;

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

  const facets = state.disjunctiveFacets;
  facets.forEach(
    facet => {
      const refinements = state.disjunctiveFacetsRefinements[facet];
      if(refinements.length){
        queryParamString = `${queryParamString}${facet}=${encodeURI(refinements.join(';').replace(/&/g, '%26'))}&`
      }
    }
  )


  const query = state.query;
  if (query) {
    queryParamString = `${queryParamString}query=${query}&`;
  }

  window.history.replaceState(null, null, queryParamString);
}

function setQueryForAroundRadius(e) {
  const miles = parseInt(e.target.value);
  const meters = getMetersFromMiles(miles) || 1;

  courses_search.helper.setQueryParameter("aroundRadius", meters);
  courses_search.helper.search();
}

function clearSearch() {

  courses_search.helper.setQuery('');
  courses_search.helper.search();
}

function setQueryForAroundLatLng() { 
  const zipCode = document.querySelector("#zipCode")?.value;
  let lat = "";
  let lng = "";
  if (zipCode && zipCode != 'undefined') {
    geocoder.geocode({
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
          distanceSlider.disabled = false;
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
  console.log(p);
  const lat = p.coords.latitude;
  const lng = p.coords.longitude;

  latLngCenter = new google.maps.LatLng(lat, lng);
  geocoder.geocode({
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
            setQueryForAroundLatLng();
          }
        }
      }
    }
  );
}

function getCurrentLocation(e) {
  e.preventDefault();
  console.log('get current location')
  navigator.geolocation.getCurrentPosition(
    setAroundLatLngQueryFromCurrentPosition, ()=> {
      alert('You have disabled location services for this website. Please change the settings in your browser to use this feature.')
    }
  );
}

function setSearchQuery(query) {
  courses_search.helper.state.query = query;
  courses_search.helper.search();
}

// Zip code functions
function clearZipCode() {
  zipCodeInput.value = "";
  distanceSlider.disabled = true;
  setQueryForAroundLatLng();

}

function triggerZipCodeChangeEvent() {
  var event = new Event("change");
  zipCodeInput.dispatchEvent(event);
}

// Unit conversion functions
function getDistanceInMiles(item) {
  if (algLatLng) {
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
  const qrCode = document.querySelector('#qrCode');
  const paragraph = document.createElement('p');

  paragraph.innerText = 'This QR code can be downloaded and shared to bring people directly to these search results from their cellphone\'s camera.';
  qrCode.appendChild(paragraph)
}
async function generatePDF() {
  const results = await getSearchResultsForSharing();
  const html = await convertResultsIntoHTML(results);

  const container = document.createElement('div');
  const h2 = document.createElement('h2');
  h2.innerText = "Louisiana Dual Enrollment Courses";
  container.appendChild(h2);

  let worker = html2pdf()
    .set({
      margin: 5,
      pagebreak: {
        mode: ['css', 'legacy']
      }
    })
    .from(container);

  if (html.length > 1) {
    worker = worker.toPdf() // worker is now a jsPDF instance

    // add each element/page individually to the PDF render process
    html.slice(1).forEach((element, index) => {
      worker = worker
        .get('pdf')
        .then(pdf => {
          pdf.addPage()
        })
        .from(element)
        .toContainer()
        .toCanvas()
        .toPdf()
    })
  }

  worker = worker.save('LA-Dual-Enrollment-Courses-Results')


}

async function generateCSV() {
  const results = await getSearchResultsForSharing();
  const csv = convertResultsIntoCSV(results);
  let csvContent = "data:text/csv;charset=utf-8,";
  csv.forEach(function (rowArray) {
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


  const html = [];
  hits.forEach(hit => {
    const container = document.createElement('div');
    const ul = document.createElement('ul');
    ul.style.padding = "3rem";
    ul.style.listStyle = 'circle';
    container.style.padding = "2rem";
    container.classList.add('pdf__results')
    hit.forEach(
      list => {
        const li = document.createElement('li');
        const div = document.createElement('div');
        const h3 = document.createElement('h3');
        h3.innerText = `${list.course_full_title} at ${list.institution}`;
        const h6 = document.createElement('h6');
        h6.innerText = `${list.semester} | Subject Area | Cost: $${list.cost_per_course}`
        const p = document.createElement('p');
        p.innerText = list.description;
        li.style.pageBreakInside = 'avoid';
        div.appendChild(h3);
        div.appendChild(h6);
        div.appendChild(p);
        li.appendChild(div);
        ul.appendChild(li);
      }
    )
    container.appendChild(ul);
    html.push(container);
  });
  return Promise.resolve(html);
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
      `institution:${institution}`, `modality:${modality}`,
    ]
  });
  nbPages = hits.nbPages;


  for (let i = 0; i < nbPages; i++) {
    const page_of_hits = await index.search(query, {
      page: i + 1,
      aroundRadius: aroundRadius,
      aroundLatLng: aroundLatLng,
      facetFilters: [`institution:${institution}`, `modality:${modality}`,]
    });
    let actHits = page_of_hits.hits;
    results.push(page_of_hits.hits);
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


// Initiate Tool Tips

function activateTooltips() {
  const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
  tooltips.forEach(
    tooltip => {
      var tooltip = new bootstrap.Tooltip(tooltip)
    }
  )
}

function format(input) {

  const formatted = input.replaceAll(/&nbsp;/gi, ' ').replaceAll('&#160', ' ').replaceAll('&NonBreakingSpace', ' ').replace(/\s/g, ' ');

  return formatted;
}