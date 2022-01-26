<script src='https://unpkg.com/axios/dist/axios.min.js'></script>
<style>
    .hidden {
        display: none;
    }

    .dual-enrollment-dashboard .button {
        margin: 5px !important;
    }

    .dual-enrollment-dashboard section {
        padding: 1rem 2rem;
        background-color: white;
        margin: 2rem;
        border: 1px solid black;
        border-radius: 4px;
    }

    .dual-enrollment-dashboard h2 {
        font-size: 25px;
        border-bottom: 1px solid black;
        padding: 1rem 0;
    }
</style>
<div class="dual-enrollment-dashboard">
    <h1>Dual Enrollment Data Management</h1>
    <section>
        <h2>Courses</h2>
        <p>Follow these instructions to update Dual Enrollment Courses:</p>
        <h3>1. Create a backup of the Website</h3>
        <p>Before making any changes to the course data, make a backup of the website using <a href='/wp-admin/options-general.php?page=updraftplus' target='_blank'>Updraft Plus
            </a>
            &nbsp;<img width='10px' src='../wp-content/plugins/algolia-custom-integration/external-link.svg' alt='open link in new window' />
            If for any reason something goes wrong in this process, you can restore the WordPress DB using this plugin.
        </p>
        <h3>2. Complete the data collection steps</h3>
        <p>Follow the instructions for Data Submission, Data Review, and Data Import explained in this
            <a href='https://docs.google.com/document/d/1ucCoORJRxoX6SFcX7ARdMAYFEokv4fLEo0zy7LrFUpI/edit?resourcekey=0-3r80FqtFjwlflBXHztJGNg' target='_blank'>Google Doc
            </a>
            &nbsp;<img width='10px' src='../wp-content/plugins/algolia-custom-integration/external-link.svg' alt='open link in new window' />&nbsp;
        </p>
        <h3>3. Import the course data from AirTable into WordPress</h3>
        <p><strong>**NOTE** Doing this will delete the current course data in WordPress and overwrite it with the data in the new table</strong>
        <p>
        <p>This process may take several minutes. Please do not refresh your browser or navigate away from this page. If anything goes wrong during this step and you are unable
            to complete this process, restore the website using the UpDraft backup.
        </p>
        <button data-action="courses" data-spinner="syncCoursesSpinner" data-status="syncCoursesStatus" data-path="airtable" class='button button-primary button-large'>Sync Courses Data with AirTable</button>
        <img width='30px' id='syncCoursesSpinner' class='hidden' src='./images/spinner-2x.gif' alt='loading..' />
        <p id='syncCoursesStatus'></p>
        <h3>4. Index the courses in Algolia</h3>
        <p><strong>**NOTE** Failure to do this will lead to inconsistent data across the site</strong>
        <p>
        <p>Algolia is a powerful search engine in use across the site. We need to send Algolia the updated data to display on the Courses Page and in the Sitewide Page Search Feature.</p>
        <button data-action="courses_and_site" data-spinner="indexCoursesAndSiteSpinner" data-status="indexCoursesAndSiteStatus" data-path="algolia" class='button button-primary button-large'>Index Courses and Sitewide Search in Algolia</button>
        <img width='30px' id='indexCoursesAndSiteSpinner' class='hidden' src='./images/spinner-2x.gif' alt='loading..' />
        <p id='indexCoursesAndSiteStatus'></p>


    </section>
    <section>
        <h2>Colleges</h2>
        <button data-action="colleges" data-spinner="syncCollegesSpinner" data-status="syncCollegesStatus" data-path="airtable" class='button button-primary button-large'>Sync Colleges Data with AirTable</button>
        <img width='30px' id='syncCollegesSpinner' class='hidden' src='./images/spinner-2x.gif' alt='loading..' />
        <p id='syncCollegesStatus'></p>

    </section>
    <section>
        <h2>All Algolia Data</h2>
        <button data-action="courses" data-spinner="indexCoursesSpinner" data-status="indexCoursesStatus" data-path="algolia" class='button button-primary button-large'>Index Courses in Algolia</button>
        <img width='30px' id='indexCoursesSpinner' class='hidden' src='./images/spinner-2x.gif' alt='loading..' />
        <p id='indexCoursesStatus'></p>

        <button data-action="colleges" data-spinner="indexCollegesSpinner" data-status="indexCollegesStatus" data-path="algolia" class='button button-primary button-large'>Index Colleges in Algolia</button>
        <img width='30px' id='indexCollegesSpinner' class='hidden' src='./images/spinner-2x.gif' alt='loading..' />
        <p id='indexCollegesStatus'></p>

        <button data-action="FAQs" data-spinner="indexFaqsSpinner" data-status="indexFaqsStatus" data-path="algolia" class='button button-primary button-large'>Index FAQs in Algolia</button>
        <img width='30px' id='indexFaqsSpinner' class='hidden' src='./images/spinner-2x.gif' alt='loading..' />
        <p id='indexFaqsStatus'></p>

        <button data-action="fields" data-spinner="indexFieldsSpinner" data-status="indexFieldsStatus" data-path="algolia" class='button button-primary button-large'>Index Fields of Study in Algolia</button>
        <img width='30px' id='indexFieldsSpinner' class='hidden' src='./images/spinner-2x.gif' alt='loading..' />
        <p id='indexFieldsStatus'></p>

        <button data-action="site" data-spinner="indexSiteSpinner" data-status="indexSiteStatus" data-path="algolia" class='button button-primary button-large'>Index Sitewide Search in Algolia</button>
        <img width='30px' id='indexSiteSpinner' class='hidden' src='./images/spinner-2x.gif' alt='loading..' />
        <p id='indexSiteStatus'></p>
    </section>

</div>

<script>
    const buttons = [...document.querySelectorAll('[data-action]')];
    buttons.forEach(button => {
        button.addEventListener('click', async (e) => {
            e.preventDefault();
            const action = button.dataset.action;
            const spinnerId = button.dataset.spinner;
            const statusContainer = button.dataset.status;
            const path = button.dataset.path;

            const spinner = document.getElementById(spinnerId);
            const status = document.getElementById(statusContainer);
            status.innerText = '';

            spinner.classList.remove('hidden');

            try {
                const response = await axios.post(`../wp-content/plugins/algolia-custom-integration/${path}.php`, `data=${action}`, {
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',

                    }
                });
                const data = response.data;
                spinner.classList.add('hidden');
                status.innerText = data;

            } catch (error) {
                console.log(error);
                spinner.classList.add('hidden');
                status.innerText = 'Error';
            }

        });
    })
</script>