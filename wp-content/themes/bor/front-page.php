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
                    <button class="cta">
                        Learn more &nbsp;&nbsp;<i class="fa fa-arrow-right"></i>
                    </button>
                </div>
                <div class="col-md-6">
                    <div class="flex-center">
                        <div class="background__blue-brush-stroke">
                            <img  src="<?php echo get_template_directory_uri(); ?>/images/students.png" alt="">
                        </div>
                    </div>
                </div>
                </div>

            </div>
        </section>
</div>

<?php include('footer.php'); ?>