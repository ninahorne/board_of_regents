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
      <div class="ugb-video-popup" data-video='<?php echo get_template_directory_uri(); ?>/videos/Dual Enrollment LA_061521.mp4'>

        <div class="ugb-video-wrapper">

          <a href="#">
            <img class="video-poster" src="<?php echo get_template_directory_uri(); ?>/images/BoR-Video-poster.jpg" alt="">

            <span class="ugb-play-button">
              <img src="<?php echo get_template_directory_uri(); ?>/images/play-button.svg" alt="">
            </span>
          </a>

        </div>
      </div>



      <script>
        const elems = document.querySelectorAll('.ugb-video-popup')
        const openVideo = el => {
          if (BigPicture) {
            const videoID = el.getAttribute('data-video')
            const args = {
              el,
              noLoader: true,
            }
            if (videoID.match(/^\d+$/g)) {
              args['vimeoSrc'] = videoID
            } else if (videoID.match(/^https?:\/\//g)) {
              args['vidSrc'] = videoID
            } else {
              args['ytSrc'] = videoID
            }
            BigPicture(args)
          }
        }
        elems.forEach(el => {
          const a = el.querySelector('a')
          a.addEventListener('click', ev => {
            ev.preventDefault()
            openVideo(el)
          })
          a.addEventListener('touchend', ev => {
            ev.preventDefault()
            openVideo(el)
          })
        });
      </script>
    </section>
  </div>
</div>

</div>




<?php include('footer.php'); ?>