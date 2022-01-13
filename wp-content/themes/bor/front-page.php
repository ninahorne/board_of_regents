<?php include('header.php'); ?>
<main id="content">
    <div id="frontPage">
        <div class="front-page__full-width-image">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <h1>Welcome to Louisiana’s Dual Enrollment resource.</h1>
                        <p>The Louisiana Board of Regents has developed this information to help students, families, and counselors access dual enrollment opportunities throughout the state. We’re glad you’re here!</p>
                    </div>
                </div>
            </div>

        </div>
        <?php include('secondary-navigation.php'); ?>

    </div>

    <section>
        <div class="container">
            <div class="row align-center">
                <div class="col-md-6">
                    <h2>What is dual enrollment?</h2>
                    <p>
                        Dual Enrollment is the opportunity for a student to be enrolled
                        in high school and college at the same time. A dual enrollment
                        student receives credit on both their high school and college
                        transcripts for the same course. Courses are offered by local
                        technical, community, and four-year colleges.

                        <br />
                        <br />

                        Dual enrollment courses are much more affordable than college
                        credits, so they save money as well as time.
                    </p>
                    <a href="./index.php/faqs" class="cta unformatted">
                        Learn more &nbsp;&nbsp;<i class="fa fa-long-arrow-alt-right"></i>
                    </a>
                </div>
                <div class="col-md-6">
                    <div class="flex-center">
                        <div class="background__blue-brush-stroke">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/students.png" alt="">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <section>
        <div class="container">
            <div class="row align-center">
                <div class="col-md-6">
                    <div class="flex-center">
                        <div class="background__blue-brush-stroke">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/art.png" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h2 class="text-lg-right"">What kinds of courses are offered?</h2>
                    <p class="text-lg-right">
                        Courses are available for scientists, mechanics, writers, film producers,
                        lawyers, musicians, artists, doctors, and much, much more. College and university
                        campuses offer exciting facilities and equipment to practice hands on learning and
                        real-world application. Dual enrollment courses taken at a student’s own high school
                        (which is also possible) conveniently offer courses across English, math, science, history,
                        art, and technology subjects. Browse your options here.
                    </p>
                    <div class="d-flex flex-lg-row flex-md-column">
                        <a href="./index.php/courses" class="mt-1 mr-1 cta unformatted">
                            Courses &nbsp;&nbsp;<i class=" fa fa-long-arrow-alt-right"></i>
                        </a>
                        <a  href="./index.php/fields-of-study" class="mt-1 mr-1 cta unformatted">
                            Fields of Study &nbsp;&nbsp;<i class="fa fa-long-arrow-alt-right"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <section>
        <div class="container">
            <h2 class="text-center">How does dual enrollment work?</h2>
            <div class="mt-4 mb-4">
                <div class="row home-page__section-two__graphic">
                    <div class="col-lg-3  col-xl-2 offset-lg-1">
                        <div class="brush-stroke__wrapper">
                            <div class="home-page__step-one-illustration">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/step-one.svg" alt="">

                            </div>

                        </div>
                        <h3 class="text-center">Step 1: Talk to your High School Counselor</p>
                    </div>
                    <div class="d-none d-lg-block col-lg-1 col-xl-2">
                        <div class="dotted-connector--top flex-center">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/dotted-top.svg" alt="">

                        </div>

                    </div>
                    <div class="col-lg-3 col-xl-2">
                        <div class="brush-stroke__wrapper">
                            <div class="home-page__step-one-illustration">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/step-two.svg" alt="">

                            </div>
                        </div>
                        <h3 class="text-center">Step 2: Complete a Dual Enrollment Application</h3>

                    </div>
                    <div class="d-none d-lg-block col-lg-1 col-xl-2">
                        <div class="dotted-connector--bottom flex-center">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/dotted-bottom.svg" alt="">

                        </div>

                    </div>
                    <div class="col-lg-3 col-xl-2">
                        <div class="brush-stroke__wrapper">
                            <div class="home-page__step-one-illustration">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/step-three.svg" alt="">

                            </div>
                        </div>
                        <h3 class="text-center">Step 3: Prepare for the Course</h3>


                    </div>
                </div>
                <div class="mt-4 mb-4">
                    <p class="text-center">
                        We're here to help each step of the way.
                    </p>
                </div>

                <div class="mt-4 mb-4">
                    <a href="./index.php/faqs?question=how%20to%20apply" class="unformatted cta cta--center">
                        See Application Help &nbsp;&nbsp; <i class="fa fa-long-arrow-alt-right"></i>
                    </a>
                </div>

            </div>

        </div>

    </section>
    <section>
        <div class="container">
            <div class="background__light-orange home-page__section-three">
                <h2 class="text-center">
                    Are you ready to get
                    <span class="color-orange">
                        double the credit
                    </span> for your hard work?
                </h2>
                <?php include('video.php'); ?>

            </div>
        </div>

    </section>
</main>

<?php include('footer.php'); ?>