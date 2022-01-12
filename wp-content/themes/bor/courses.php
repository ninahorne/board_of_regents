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
                                            <input disabled id="distanceSlider" class="slider" step="5" type="range" min="0" max="50" value="25">

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
                                        <div data-refinement="institutions" id="institutionsRefinements" class="refinements__select">
                                            <div data-refinementslabel="institutions" data-dropdown="#institutionsDropdown" id="institutionsLabel" class="refinements__label">
                                                <p>All Institutions</p>
                                                <span><img src="<?php echo get_template_directory_uri(); ?>/images/sort-down-solid.svg" /></span>

                                            </div>
                                            <div id="institutionsDropdown" class="refinements__dropdown">
                                                <div tabindex="0" id="institutionMenu"></div>

                                            </div>

                                        </div>
                                        <div data-refinement="subjectArea" id="subjectAreaRefinements" class="refinements__select">
                                            <div data-refinementslabel="subjectArea" data-dropdown="#subjectAreaDropdown" id="subjectAreaLabel" class="refinements__label">
                                                <div class="refinements__title">
                                                    <p>Subject Areas</p>
                                                    <span>&nbsp;&nbsp;&nbsp;Ex: Marketing</span>
                                                </div>
                                                <span><img src="<?php echo get_template_directory_uri(); ?>/images/sort-down-solid.svg" /></span>

                                            </div>
                                            <div id="subjectAreaDropdown" class="refinements__dropdown">
                                                <div tabindex="0" id="subjectAreaMenu"></div>

                                            </div>

                                        </div>
                                        <div data-refinement="type" id="typeRefinements" class="refinements__select">
                                            <div data-refinementslabel="type" data-dropdown="#typeDropdown" id="typeLabel" class="refinements__label">
                                                <div class="refinements__title">
                                                    <p>Type</p>
                                                    <span>&nbsp;&nbsp;&nbsp;Ex: College - On Campus</span>
                                                </div>
                                                <span><img src="<?php echo get_template_directory_uri(); ?>/images/sort-down-solid.svg" /></span>
                                            </div>
                                            <div id="typeDropdown" class="refinements__dropdown">
                                                <div tabindex="0" id="typeMenu"></div>

                                            </div>

                                        </div>
                                        <div data-refinement="semester" id="semesterRefinements" class="refinements__select">
                                            <div data-refinementslabel="semester" data-dropdown="#semesterDropdown" id="semesterLabel" class="refinements__label">
                                                <div class="refinements__title">
                                                    <p>Semester</p>
                                                </div>
                                                <span><img src="<?php echo get_template_directory_uri(); ?>/images/sort-down-solid.svg" /></span>
                                            </div>
                                            <div id="semesterDropdown" class="refinements__dropdown">
                                                <div tabindex="0" id="semesterMenu"></div>

                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div id="nbHits"></div>
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
                                <div data-bs-toggle="tooltip" data-bs-placement="top" title="Email List" class="results__icon">
                                    <a target="_blank" id="emailShare" href="mailto:?subject=LA Board of Regents - Dual Enrollment Courses&body=Check out these Louisiana Dual Enrollment Courses!  <?php echo 'https://' . getenv('HTTP_HOST') . $_SERVER['REQUEST_URI'] ?>">
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/envelope-solid.svg" alt="">
                                    </a>
                                </div>
                                <div data-bs-toggle="tooltip" data-bs-placement="top" title="Download PDF" id='pdfShare' class="results__icon">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/file-pdf-solid.svg" alt="">
                                </div>
                                <div data-bs-toggle="tooltip" data-bs-placement="top" title="Download CSV" id='csvShare' class="results__icon">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/file-csv-solid.svg" alt="">

                                </div>
                                <div data-bs-toggle="tooltip" data-bs-placement="top" title="Create a QR Code" id='qrShare' class="results__icon">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/qrcode-solid.svg" alt="">
                                </div>
                            </div>

                            <h6 class="results__share-text visible-sm">Share these results</h6>

                        </div>
                        <div id="qrCode">

                        </div>

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
<script src="<?php echo get_template_directory_uri(); ?>/js/courses.js"></script>

<?php include('footer.php'); ?>