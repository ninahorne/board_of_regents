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



                }, 2000

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
                const myObj = JSON.parse(this.responseText);
                initialize(myObj);
            }


            // const selectedCollege = document.querySelector('#selectedCollege');
            // selectedCollege.innerHTML = this.responseText;
        };

        try {
            xhttp.open("GET", "../../wp-content/themes/bor/get_colleges.php");
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
            console.log(this.responseText);
            const selectedCollege = document.querySelector('#selectedCollege');
            selectedCollege.innerHTML = this.responseText;
        };
        var body = {
            objectId
        };

        xhttp.open("GET", "../../wp-content/themes/bor/get_college.php?objectId=" + objectId, false);
        xhttp.send('objectId=' + encodeURIComponent(objectId));
    };



    function initializeUsefulLinkSearch() {
        useful_links_search = instantsearch({
            indexName: "useful-college-links",
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