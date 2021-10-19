<?php

/**
 * Template Name: Students Page
 */
?>

<?php include('header.php'); ?>
<div id="content">
  <div id="students">
    <div class="students-page__banner">
      <div class="container">
        <div class="row">
          <div class="col-lg-7">
            <h1>Information for Students</h1>

          </div>
        </div>
      </div>
    </div>
    <section class="blue-section blue-section--students">
      <div class="blue-section__image">
      </div>
      <div class="flex-center">
        <div class="container">
          <div class="row">
            <div class="col-md-7">
              <h1>College credit means college expectations and college resources.</h1>
              <p>
                Sometimes DE (dual enrollment) courses are on a college campus. Sometimes they are held at your school. Either way, you’ll get a taste of life after high school.
              </p>
            </div>
          </div>
        </div>

      </div>
    </section>
    <section class="students-page__video">
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
    <?php include('useful-college-links.php'); ?>
    <section class="students-page__section-three">
      <div class="container">
        <div class="row">
          <div class="col-md-6 d-md-block d-none">
            <div class="background__blue-brush-stroke background__brush-stroke--large">
              <img class="m-1 " src="<?php echo get_template_directory_uri(); ?>/images/career-pathways@2x.png" alt="">

            </div>
          </div>
          <div class="col-md-6">
            <div class="flex-vertical-center">
              <h1>Fields of Study</h1>
              <p>Dual Enrollment courses connect to all sorts of careers and high school credits. You might be looking to take college algebra to get ahead in high school and college at the same time. Or, you might want a more career-specific option like cosmetology!</p>
              <a href="./fields-of-study" style="max-width: 200px; line-height: 65px;" class="cta unformatted color-white">Learn More <i class="fa fa-long-arrow-alt-right"></i></a>
            </div>

          </div>
          <div class="col-md-6 d-sm-block d-md-none">
            <div class="background__blue-brush-stroke">
              <img class="m-1 " src="<?php echo get_template_directory_uri(); ?>/images/career-pathways@2x.png" alt="">

            </div>
          </div>
        </div>
      </div>
    </section>
    <?php include('faq_preview.php'); ?>

  </div>
</div>

</div>




<?php include('footer.php'); ?>