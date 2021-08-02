<section class="useful-college-links">
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
            const myObj = JSON.parse(this.responseText);
            console.log(myObj);
            initialize(myObj);

            // const selectedCollege = document.querySelector('#selectedCollege');
            // selectedCollege.innerHTML = this.responseText;
        };
     

        xhttp.open("GET", "./wp-content/themes/bor/get_colleges.php");
        xhttp.send();
    };

    initializeMapData();

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

        xhttp.open("GET", "./wp-content/themes/bor/get_college.php?objectId=" + objectId, false);
        xhttp.send('objectId=' + encodeURIComponent(objectId));
    };
</script>