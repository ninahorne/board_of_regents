<?php

/**
 * Template Name: Fields of Study
 */
?>

<?php include('header.php'); ?>
<div id="content">
    <div id="coursesByCampus">
        <div class="courses-page__banner">
            <div class="flex-vertical-center">
                <div class="container">
                    <h1>Fields of Study</h1>

                </div>
            </div>
        </div>
        <div class="background__blue">
            <div class="row">
                <div class="col-md-4 offset-md-4">
                    <h1 class="text-center color-white">What dual enrollment courses do colleges and universities near you offer?</h1>
                    <p class="text-center color-white">
                        Louisiana’s colleges and universities offer all sorts of courses to help high school students double up on credits.
                    </p>
                    <img src="<?php echo get_template_directory_uri(); ?>/images/courses-illustration.svg" alt="">
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <?php
                    global $wpdb;
                    $result = $wpdb->get_results("
                                                SELECT * 
                                                FROM  $wpdb->posts
                                                    WHERE post_type = 'course'
                                            
                                            ");



                    foreach ($result as $course) {
                        $course_id = $course->ID;
                        $course_html_id = 'course-' . $course_id;
                        $details_html_id = 'details-' . $course_id;
                        $course_result = $wpdb->get_results("
                                                SELECT * 
                                                FROM  $wpdb->postmeta
                                                    WHERE post_id = $course_id
                                                 
                                                ");

                        $title;
                        $image;
                        $details;
                        $url_params;
                        $button_html_id;
                        foreach ($course_result as $course_item) {
                            $key = $course_item->meta_key;
                            $value = $course_item->meta_value;
                            $id = $course_item->post_id;
                            if ($key == 'career_cluster') {
                                $title = $value;
                            }
                            if ($key == 'image') {
                                $image == $value;
                            }
                            if ($key == 'details') {
                                $formattedString = str_replace('&nbsp;', '<br /><br />', $value);

                                $details = $formattedString;
                            }
                            if ($key == 'url-params') {
                                $url_params = $value;
                                $button_html_id = 'button-' . $course_id;
                            }
                        }


                        echo '<div class="col-md-4">
                                <div id="' . $course_html_id . '" class="courses-page__item">
                                    <div class="courses-page__item__image"></div>
                                    <h5  class="text-center">' . $title . '</h5>
                                    <p onclick="changeParams(\'' . $url_params .  '\')" id="' . $button_html_id . '" data-bs-toggle="modal" data-bs-target="#' . $url_params . '" class="courses-page__more">
                                        <i class="fa fa-plus"></i> &nbsp;&nbsp;More Info 
                                    </p>
                                    
                                </div>

                                <div id="' . $url_params . '" class="modal  fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                            <i onclick="closeModal(\'' . $button_html_id . '\')" class="far text-end fa-times-circle"></i>
                                            <h5 class="text-center">' . $title . '</h5>

                                            <div  class="courses-page__item__details">'
                            . $details .
                            '</div>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                    }


                    ?>
                </div>

            </div>


        </div>
    </div>

</div>



<?php include('footer.php'); ?>

<script>
    const queryParams = window.location.search;
    console.log(window.location.search);

    if (queryParams) {
        const id = queryParams.replace('?field=', '');
        openModal(id);
    }

    listenForAllModalsToHide();

    function listenForAllModalsToHide() {
        const modals = document.querySelectorAll('.modal');
        console.log(modals.length);
        modals.forEach(
            modal => {
                modal.addEventListener('hidden.bs.modal', function(event) {
                    clearParams();
                });
            }
        )

    }


    function openModal(id) {

        var myModal = new bootstrap.Modal(document.getElementById(id), {
            keyboard: false
        })
        myModal.show();
    }

    function clearParams(params)  {
        window.history.replaceState(null, null, '?');

    }

    function closeModal(id) {
        var button = document.getElementById(id);

        button.click();
        clearParams();

    }

   

    function changeParams(params) {
        window.history.replaceState(null, null, `?field=${params}`);

        // document.location.search = `?field=${params}`;
    }
</script>