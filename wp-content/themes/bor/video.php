<div class="ugb-video-popup" data-video='<?php echo get_template_directory_uri(); ?>/videos/Dual Enrollment LA_061521.mp4'>

<div class="ugb-video-wrapper">

  <a href="#">
    <img class="video-poster" src="<?php echo get_template_directory_uri(); ?>/images/video-poster.png" alt="">

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