<?php include('header.php'); ?>
<div id="content">
    <div id="frontPage">
        <div class="front-page__full-width-image">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h1>Welcome to Louisiana’s Dual Enrollment resource.</h1>
                        <p>The Board of Regents of Louisiana has developed this information to help students, families, and counselors access dual enrollment opportunities throughout the state. We’re glad you’re here!</p>
                    </div>
                </div>
            </div>

        </div>
        <?php include('secondary-navigation.php'); ?>

    </div>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h1>What is dual enrollment?</h1>
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
                    <a style="max-width: 210px;" href="./index.php/faqs?question=What%20is%20Dual%20Enrollment%20and%20why%20is%20it%20beneficial%3F%20" class="cta unformatted">
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
            <h1 class="text-center">How does duel enrollment work?</h1>
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
                    <button class="cta cta--center">
                        See Application Help &nbsp;&nbsp; <i class="fa fa-long-arrow-alt-right"></i>
                    </button>
                </div>

            </div>

        </div>

    </section>
    <section>
        <div class="container">
            <div class="background__light-orange home-page__section-three">
                <h1 class="text-center">
                    Are you ready to get
                    <span class="color-orange">
                        double the credit
                    </span> for your hard work?
                </h1>
                <?php include('video.php'); ?>

            </div>
        </div>

    </section>
</div>

<?php include('footer.php'); ?>