<?php

/**
 * Template Name: Fields of Study
 */
?>

<?php include('header.php'); ?>
<main id="content">
    <div id="fieldsOfStudy">
        <div class="courses-page__banner">
            <div class="flex-vertical-center">
                <div class="container">
                    <h1>Fields of Study</h1>

                </div>
            </div>
        </div>
        <div class="background__blue">
            <div class="flex-vertical-center">
                <div class="fields-of-study__fixed-width">
                    <h1 class="text-center color-white">What dual enrollment courses do colleges and universities near you offer?</h1>
                    <p class="text-center color-white">
                        Louisiana’s colleges and universities offer all sorts of courses to help high school students double up on credits.
                    </p>
                    <!-- <img src="<?php echo get_template_directory_uri(); ?>/images/courses-illustration.svg" alt=""> -->
                </div>

            </div>

            <div class="container">
                <div class="row">
                    <?php
                    $cc_args = array(
                        'posts_per_page' => 20,
                        'post_type' => 'field-of-study',
                        'order_by' => 'date',
                        'order' => 'DESC'

                    );
                    $cc_query = new WP_Query($cc_args);

                    $result = $cc_query->posts;
                    

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
                                $image = $value;
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

                        echo '<div class="col-lg-4 col-md-6">
                                <div onclick="changeParams(\'' . $url_params .  '\')" id="' . $course_html_id . '"  data-bs-toggle="modal" data-bs-target="#' . $url_params . '" class="courses-page__item">
                                    <img src="' . wp_get_attachment_image_src($image, 'large')[0] . '" class="courses-page__item__image" />
                                    <h5  class="text-center">' . $title . '</h5>
                                    <p  id="' . $button_html_id . '"  class="courses-page__more">
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

</main>



<?php include('footer.php'); ?>

<script src="<?php echo get_template_directory_uri(); ?>/js/fields-of-study.js">

</script>