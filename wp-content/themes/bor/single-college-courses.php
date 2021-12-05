<?php include('header.php') ?>
<div id="content">
    <div id="singleCourse">
        <div class="background__blue">
            <div class="container">
                <div class="course__row">
                    <a href="javascript:history.go(-1)" class="cta unformatted"><i class="fa fa-long-arrow-alt-left"></i>&nbsp;&nbsp;Back</a>
                    <div class="course__share">
                        <p>Share this course</p>
                        <div class="results__icon">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/envelope-solid.svg" alt="">
                        </div>
                        <div class="results__icon">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/file-pdf-solid.svg" alt="">
                        </div>
                    </div>
                </div>
                <p class="course__heading">
                    <?php the_field('institution') ?> |
                    <?php the_field('course_abbreviation') ?> <?php the_field('course_number'); ?>
                    <br />
                    Louisiana Common Course (<?php the_field('la_common_course_number'); ?>)

                </p>
                <div class="row">
                    <div class="col-lg-6">
                        <h1 class="course__title"><?php the_field("course_full_title") ?></h1>
                        <p class="course__description">
                            <?php the_field("description") ?>
                        </p>
                        <div class="course__details">
                            <div class="course__detail">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/money-check-edit-alt-light.svg" alt="">
                                <p> Cost:&nbsp;$<?php the_field('cost_per_course') ?></p>
                            </div>
                            <div class="course__detail">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/school-light.svg" alt="">
                                <p><?php the_field('modality') ?></p>
                            </div>
                            <div class="course__detail">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/calendar-alt-light.svg" alt="" />
                                <p><?php the_field('semester') ?></p>
                            </div>
                        </div>
                        <div class="course__details">
                            <div class="course__detail">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/money-check-edit-alt-light.svg" alt="" />
                                <p> Credit Hours:&nbsp;$<?php echo the_field('number_of_credit_hours') ?></p>
                            </div>

                            <?php
                            if (get_field('general_education')[0] == 'Yes') {
                                echo '<div class="course__detail">
                            <img src="' . get_template_directory_uri() . '/images/school-light.svg" alt="" />
                            <p>General Education Course</p>
                        </div>';
                            };
                            if (the_field("satellite_campus")) {
                                echo '<div class="course__detail">
                            <img src="' . get_template_directory_uri() . '/images/school-light.svg" alt="" />
                            <p>Satellite Campus:&nbsp;' . the_field('satellite_campus') . '</p>
                        </div>';
                            };
                            ?>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="background__orange-brush-stroke background__brush-stroke--large">
                            <img class="m-1 " src="<?php echo get_template_directory_uri(); ?>/images/adolescent-psychology.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="background__white p-5">
            <div class="courses__tabs">
                <div class="container">

                    <div class="tabs">
                        <div class="nav nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <p class="nav-link active" id="v-pills-one-tab" data-bs-toggle="pill" data-bs-target="#v-pills-prerequisites" role="tab" aria-controls="v-pills-prerequisites" aria-selected="true">Prerequisites</p>
                            <p class="nav-link" id="v-pills-two-tab" data-bs-toggle="pill" data-bs-target="#v-pills-cost" role="tab" aria-controls="v-pills-cost" aria-selected="false">Cost Info</p>
                            <p class="nav-link" id="v-pills-three-tab" data-bs-toggle="pill" data-bs-target="#v-pills-links" role="tab" aria-controls="v-pills-links" aria-selected="false">Useful Links</p>
                        </div>
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="v-pills-prerequisites" role="tabpanel" aria-labelledby="v-pills-one-tab">
                            <?php
                            if (the_field('coures_prerequisite')) {
                                echo
                                "<h2><?php the_field('coures_prerequisite'); ?></h2>";
                            } else {
                                echo '<p>There are no prerequisites for this course.';
                            }
                            ?>

                            <p class="course__prereq">
                                A prerequisite is a course that a student must take before enrolling in a given course. To enroll
                                in this course, a student must have successfully completed any prerequisites listed here.
                            </p>
                        </div>
                        <div class="tab-pane fade" id="v-pills-cost" role="tabpanel" aria-labelledby="v-pills-two-tab">
                            <div>
                                <div class="course__cost">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/money-check-edit-green.svg" alt="" />
                                    <p>Cost:&nbsp;$<?php the_field('cost_per_course') ?></p>
                                </div>

                                <p class="mt-4">This course’s costs might be lower due to funding from your local high school.</p>

                            </div>

                        </div>
                        <div class="tab-pane fade" id="v-pills-links" role="tabpanel" aria-labelledby="v-pills-three-tab">
                            <?php
                            $institution = get_field('institution');
                            $colleges = get_college_by_institution($institution);
                            $college = $colleges[0];
                            $post_id = $college->ID;
                            function get_college_by_institution($institution)
                            {
                                $cc_args = array(
                                    'posts_per_page' => -1,
                                    'post_type' => 'college',
                                    'meta_key' => 'abbreviation',
                                    'meta_value' => $institution,
                                    'limit' => 1
                                );
                                $cc_query = new WP_Query($cc_args);

                                return $cc_query->posts;
                            }
                            ?>

                            <h2><?php echo get_field('campus', $post_id) ?></h2>
                            <div class="course__college">
                                <h3>Dual Enrollment Contact</h3>

                                <div class="row">
                                    <div class="col-4">
                                        <p class="m-0"><?php echo get_field('registrar_name', $post_id) ?></p>
                                        <p class="m-0"><?php echo get_field('registrar_contact_information', $post_id) ?></p>

                                    </div>
                                    <div class="col-8">
                                        <a target="_blank" class="d-block unformatted" href="<?php echo get_field('transfer_form') ?>"><i class="fas fa-external-link-alt"></i>&nbsp;Request information on transcript/transfer</a>
                                        <a class="unformatted" href="mailto:<?php echo get_field('registrar_contact_information') ?>"><i class="far fa-envelope"></i>&nbsp;&nbsp;Contact the registrat </a>

                                    </div>

                                </div>
                            </div>
                            <div class="mt-3">
                                <a target="_blank" style='max-width: 285px;' href="<?php echo get_field('general_de_info_link', $post_id) ?>" class="cta unformatted">Visit College Website&nbsp;&nbsp;<i class="fa fa-long-arrow-alt-right"></i></a>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php include('footer.php') ?>