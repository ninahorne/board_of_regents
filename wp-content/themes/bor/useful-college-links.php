<section id="usefulCollegeLinks" class="useful-college-links">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="flex-center">
                    <h1>Useful College Links</h1>
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
    var useful_links_search;
    window.addEventListener('DOMContentLoaded', initializeMapData)
    window.addEventListener('DOMContentLoaded', initializeUsefulLinkSearch);
    window.addEventListener('DOMContentLoaded', checkForCollegeQueryParams);

    function checkForCollegeQueryParams() {
        const queryParams = window.location.search;
        if (queryParams) {
            const college = decodeURI(queryParams.replace('?college=', ''));

            const usefulCollegeLinksEl = document.getElementById('usefulCollegeLinks');
            setTimeout(
                () => {
                    usefulCollegeLinksEl.scrollIntoView({
                        behavior: 'smooth'
                    });
                }, 100
            )


            setTimeout(
                () => {
                    const input = document.querySelector('#usefulCollegeLinksSearchBox .ais-SearchBox-input');
                    console.log(input);
                    input.value = college
                    useful_links_search.helper.state.query = college;
                    useful_links_search.helper.search();
                    setTimeout(
                        () => {
                            const results = document.querySelector(`.ais-Hits label`);
                            results.click();
                        }, 100
                    )
                }, 1000

            )

        }
    }

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

    function initializeMapData() {

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.responseText) {
                console.log({
                    from_api: this.responseText
                })
                initialize(JSON.parse(this.responseText));
            }

        };

        try {
            xhttp.open("GET", "../index.php/wp-json/bor/colleges");
            xhttp.send();
        } catch {
            console.log('error');
        }

    };



    function onClick(objectId, lat, long, campus, system) {
        hideResults();
        changeMarker(lat, long, campus, system);

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            const selectedCollege = document.querySelector('#selectedCollege');
            console.log(this.responseText);

            const college = JSON.parse(this.responseText);
            console.log(college);
            console.log(college.campus)
            selectedCollege.innerHTML = `
            <div class="useful-college-links__selected-result">
                <i onclick="clearSelectedCollege()" class="far fa-times-circle"></i>
                <div class="row">
                    <div class="col-md-5">
                        <h2>${college.campus}</h2>
                        <a target="_blank" class="unformatted" href="${college.dualEnrollmentApplication}">
                            <i class="fas fa-external-link-alt"></i>&nbsp;Go to Dual Enrollment Application*
                        </a>
                        <p class="footnote">*Note: Some postsecondary institutions require account creation for application.<p>
                    </div>
                    <div class="col-md-7">
                        <h3>Dual Enrollment Contact</h3>
                        <div class="row">
                            <div class="col-lg-6"> 
                                <p>${college.departmentContactName}</p>
                                <a class="unformatted" href="mailto:${college.departmentContactEmail}">${college.departmentContactEmail}</a>                         
                            </div>           
                            <div class="col-lg-6">
                                <a target="_blank" class="d-block unformatted" href="${college.transferForm}"><i class="fas fa-external-link-alt"></i>&nbsp;Request information on transcript/transfer</a>
                                ${college.registrarEmail ? `<a class="unformatted" href="mailto:${college.registrarEmail}"><i class="far fa-envelope"></i>&nbsp;&nbsp;Contact the Registrar </a>` : ''}
                         </div>
            </div>`;
        };
        var body = {
            objectId
        };

        xhttp.open("GET", "../index.php/wp-json/bor/colleges?id=" + objectId, false);
        xhttp.send('id=' + encodeURIComponent(objectId));
    };



    function initializeUsefulLinkSearch() {
        useful_links_search = instantsearch({
            indexName: "colleges_asc",
            searchClient,
            searchFunction(helper) {
                // Ensure we only trigger a search when there's a query
                const container = document.querySelector("#usefulCollegeLinksResults");
                container.style.display = helper.state.query === "" ? "none" : "";

                helper.search();
            },
        });
        // Create the render function
        const renderHits = (renderOptions, isFirstRender) => {
            const {
                hits,
                widgetParams
            } = renderOptions;
            console.log(hits);
            widgetParams.container.innerHTML = `
            <form class="ais-Hits" method="POST">
            ${hits
                .map(
                (item) =>
                    `<label onclick="clickMarker( \`${
                    item.campus
                    }\`)" class="useful-college-links__search-result">
                    ${instantsearch.highlight({ attribute: "campus", hit: item })}
                    </label>
                    <input class="d-none" type="radio" name="postID" value="${
                    item.objectID
                    }" />
                    `
                )
                .join("")}
            </form>
     `;
        };

        // Create the custom widget
        const customHits = instantsearch.connectors.connectHits(renderHits);

        useful_links_search.addWidgets([
            instantsearch.widgets.searchBox({
                container: "#usefulCollegeLinksSearchBox",
                placeholder: "Search for a college",
            }),

            instantsearch.widgets.refinementList({
                container: "#usefulCollegeLinksTagsList",
                attribute: "tags",
                limit: 5,
                showMore: true,
            }),

            customHits({
                container: document.querySelector("#usefulCollegeLinksHits"),
            }),
        ]);

        useful_links_search.start();
    }
</script>