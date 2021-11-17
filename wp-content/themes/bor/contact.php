<?php

/**
 * Template Name: Contact Page
 */
?>

<?php include('header.php'); ?>
<div id="content">
    <div id="about">
        <?php include('useful-college-links.php'); ?>
        <?php include('ask-a-question.php'); ?>

        <div class="background__blue">
            <div class="container">
                <div class="py-5">
                    <div class="py-5">
                        <div class="row flex-column-reverse flex-md-row">

                            <div class="col-md-5">
                                <?php echo do_shortcode('[wpforms id="207" title="true"]') ?>
                            </div>
                            <div class="col-md-7">
                                <div class="px-3">
                                    <h1 class="color-white">We want to hear from you!</h1>
                                    <h3 class="color-white">Please provide your feedback.</h3>
                                    <p class="color-white">
                                        Welcome to the first phase of the Louisiana Dual Enrollment Portal! We appreciate any feedback you can provide in the box provided. Your feedback will help us improve on future website updates. For specific questions regarding Dual Enrollment, not answered in this portal, please contact the Louisiana Department of Education or the Louisiana Board of Regents at the contact infornation provided.
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>



<?php include('footer.php'); ?>