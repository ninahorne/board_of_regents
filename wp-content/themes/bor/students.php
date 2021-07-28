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
          <div class="col-md-7">
            <h1>Earn college & high school credit at the same time with Dual Enrollment.</h1>

          </div>
        </div>
      </div>
    </div>
    <section class="students-page__blue-section">
      <div class="students-page__blue-section__person-with-pencil">
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

  </div>
</div>

</div>




<?php include('footer.php'); ?>