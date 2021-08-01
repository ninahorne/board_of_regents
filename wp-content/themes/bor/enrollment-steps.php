<div class="row steps-to-enrollment">
    <div class="col-lg-4">
        <h2>Steps to Dual Enrollment</h2>
        <div class="tabs d-flex align-items-start">
            <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <p class="nav-link active" id="v-pills-one-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">How to begin</p>
                <p class="nav-link" id="v-pills-two-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">How to enroll</p>
                <p class="nav-link" id="v-pills-three-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">How to get support</p>
                <p class="nav-link" id="v-pills-four-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">How to finalize documentation</p>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="d-flex align-items-start">

            <div class="tab-content" id="stepsToEnrollmentTabs">
                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-one-tab">
                    <div class="row">
                        <div class="col-6">
                            <p class="large-number">01</p>

                        </div>
                        <div class="col-6">
                            <div class="arrow-container">
                                <i onclick="navigateTo('v-pills-four-tab')" class="fa fa-long-arrow-alt-left"></i>
                                <i onclick="navigateTo('v-pills-two-tab')" class="fa fa-long-arrow-alt-right"></i>

                            </div>
                        </div>
                    </div>
                    <h2>Talk to your School Counselor</h2>
                    <p>Interested in earning college credits while still in high school?
                        Talk to your school counselor to see what dual enrollment courses you are eligible for.
                        Explore the options of an academic or a technical dual enrollment course and
                        find what is the best fit for you. </p>


                </div>
                <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-two-tab">
                    <div class="row">
                        <div class="col-6">
                            <p class="large-number">02</p>

                        </div>
                        <div class="col-6">
                            <div class="arrow-container">
                                <i onclick="navigateTo('v-pills-one-tab')" class="fa fa-long-arrow-alt-left"></i>
                                <i onclick="navigateTo('v-pills-three-tab')" class="fa fa-long-arrow-alt-right"></i>

                            </div>
                        </div>
                    </div>
                    <h2>Complete a Dual Enrollment Application</h2>
                    <p>Decide which dual enrollment course(s) you want to register and apply for. 
                        Be sure to check the eligibility requirements and talk to your school 
                        counselor about how to apply.</p>

                </div>
                <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-three-tab">
                    <div class="row">
                        <div class="col-6">
                            <p class="large-number">03</p>

                        </div>
                        <div class="col-6">
                            <div class="arrow-container">
                                <i onclick="navigateTo('v-pills-two-tab')" class="fa fa-long-arrow-alt-left"></i>
                                <i onclick="navigateTo('v-pills-four-tab')" class="fa fa-long-arrow-alt-right"></i>

                            </div>
                        </div>
                    </div>
                    <h2>Prepare for your course</h2>
                    <p>Now that you’ve been admitted, check to see if there are any additional materials or textbooks that should be purchased. 
                        Most do not require any additional materials, but they do require your focus and preparation. 
                        Happy studying!</p>
                </div>
                <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-four-tab">
                    <div class="row">
                        <div class="col-6">
                            <p class="large-number">04</p>

                        </div>
                        <div class="col-6">
                            <div class="arrow-container">
                                <i onclick="navigateTo('v-pills-three-tab')" class="fa fa-long-arrow-alt-left"></i>
                                <i onclick="navigateTo('v-pills-one-tab')" class="fa fa-long-arrow-alt-right"></i>

                            </div>
                        </div>
                    </div>
                    <h2>Heading</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function navigateTo(id) {
        console.log("here")
        const el = document.getElementById(id);
        el.click()
    }
</script>