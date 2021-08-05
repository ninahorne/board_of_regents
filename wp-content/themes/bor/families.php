<?php

/**
 * Template Name: Families Page
 */
?>

<?php include('header.php'); ?>

<div id="content">
    <div id="families">
        <div class="families-page__banner">
            <div class="flex-vertical-center">
                <div class="container">
                    <h1>Information for Families</h1>

                </div>
            </div>
        </div>
        <section class="blue-section blue-section--families">
            <div class="flex-vertical-center">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-7">
                            <h1>Let’s help your student experience college early.</h1>
                            <p>With dual enrollment, students may begin accumulating college credits while still in high school, thus providing a smoother transition to college after high school graduation. Students also have the opportunity to complete college faster by earning college credits while still in high school.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="families-page__video">
            <?php include('video.php'); ?>

        </section>
        <section class="students-page__enrollment-steps">
            <div class="container">
                <?php include('enrollment-steps.php'); ?>

            </div>

        </section>
        <section class="students-page__eligibility">

            <?php include('eligibility.php'); ?>
        </section>
        <?php include('faq_preview.php'); ?>

    </div>
</div>


<?php include('footer.php'); ?>