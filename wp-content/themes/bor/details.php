<?php

/**
 * Template Name: Details Page
 */
?>
<?php include('header.php'); ?>
<main id="content">
    <div class="page__banner page__banner--info">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <h1>Information about Dual Enrollment</h1>
                </div>
            </div>
        </div>
    </div>
        <?php include('enrollment-steps.php'); ?>
        <?php include('benefits.php') ?>
        <?php include('faq_preview.php') ?>

</main>
<?php include('footer.php'); ?>