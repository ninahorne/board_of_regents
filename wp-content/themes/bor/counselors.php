<?php

/**
 * Template Name: Counselors Page
 */
?>

<?php include('header.php'); ?>

<div id="content">
    <div id="counselors">
        <div class="counselors-page__banner">
            <div class="flex-vertical-center">
                <div class="container">
                    <h1>Information for Counselors</h1>

                </div>
            </div>
        </div>
        <section class="blue-section blue-section--counselors">
            <div class="blue-section__image"></div>
            <div class="flex-vertical-center">
                <div class="container">
                    <div class="row">
                        <div class="col-md-7">
                            <h1>Dual Enrollment links and resources, in one place.</h1>
                            <p>Check out these resources to help motivate and support the students you serve.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="shifted-up">
            <?php include('benefits.php') ?>

        </div>
        <section>
            <section class="students-page__section-three">
                <div class="container">
                    <div class="d-md-block d-none">
                        <div class="background__blue-brush-stroke background__brush-stroke--large">
                            <img class="m-1 " src="<?php echo get_template_directory_uri(); ?>/images/career-pathways@2x.png" alt="">

                        </div>
                    </div>
                    <div>
                        <div class="flex-vertical-center">
                            <h1>Articulation Matrix</h1>
                            <p>
                                <span class="bold">
                                    Dual enrollment courses taken at any public postsecondary institution in Louisiana will transfer with each other.
                                </span>
                                If you are interested in taking dual enrollment to transfer to a private or out of state institution, you will need to contact that campus to determine transferability of your courses. Otherwise, you can look to the Louisiana Board of Regents for useful information about transferable credits. One particularly helpful resource is <a target="_blank" href="https://regents.la.gov/master-course-articulation/"> The Master Course Articulation Matrix.</a>

                                <br />
                                <br />

                                <span class="bold"> The Articulation Matrix is a crosswalk of general education courses that transfer between all public institutions in Louisiana.</span> For example, if a student took dual enrollment courses through Baton Rouge Community College and wishes to transfer those to Southeastern, the Matrix will provide a listing of how the courses will transfer. The Board of Regents also provides a guide to help navigate the Matrix.
                                <br />
                                <br />
                                <span class="bold">
                                    The Articulation Matrix is a useful tool for dual enrollment students.
                                </span>
                                Students can know ahead of time how their courses will transfer to other post-secondary institutions. This allows high school students to take dual enrollment courses at a campus in close proximity to their high school, while allowing the credits to count towards other post-secondary choices.
                                <br />
                                <br />
                                <span class="bold">

                                </span>
                                Lastly, the Louisiana Statewide Common Course Catalog provides course rubrics, numbers and course descriptions for all courses listed in the matrix to help students find the most beficial course for their future.
                            </p>
                            <a href="./career-pathways" style="max-width: 315px; line-height: 65px;" class="cta unformatted color-white">Download Spreadsheet &nbsp;&nbsp;<i class="fa fa-long-arrow-alt-right"></i></a>
                            <a style="max-width: 148px" target="_blank" href="https://regents.la.gov/master-course-articulation/" class="btn faq-preview__view-all"><i class="fas fa-share"></i>&nbsp;&nbsp;More Info</a>

                        </div>

                    </div>

                </div>
            </section>
            <section>
                <?php include('useful-college-links.php') ?>
            </section>
            <?php include('faq_preview.php') ?>

        </section>

    </div>

</div>


<?php include('footer.php'); ?>