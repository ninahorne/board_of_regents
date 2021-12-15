<?php include('header.php') ?>
<div id="content">
    <div id="singleCourse">
        <div class="background__blue">
            <div class="container">
                <div class="course__row">
                    <a href="javascript:history.go(-1)" class="cta unformatted"><i class="fa fa-long-arrow-alt-left"></i>&nbsp;&nbsp;Back</a>
                    <div class="course__share">
                        <p>Share this course</p>
                        <div data-bs-toggle="tooltip" data-bs-placement="top" title="Email Course" class="results__icon">
                            <a id="emailShare" href="mailto:?subject=LA Dual Enrollment Course - <?php the_title() ?>&body=Check out this Louisiana Dual Enrollment Course: <?php the_title() ?>!  <?php echo 'https://' . getenv('HTTP_HOST') . $_SERVER['REQUEST_URI'] ?>">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/envelope-solid.svg" alt="">
                            </a>
                        </div>
                        <div data-bs-toggle="tooltip" data-bs-placement="top" title="Download PDF" class="results__icon">
                            <img id="pdfShare" onclick="generatePDF(
                                '<?php the_title() ?>', 
                                '<?php the_field('course_full_title') ?>',
                                '<?php the_field('institution') ?>',
                                '<?php the_field('description') ?>', 
                                '<?php the_field('cost_per_course') ?>', 
                                '<?php the_field('modality') ?>', 
                                '<?php the_field('semester') ?>', 
                                '<?php the_field('number_of_credit_hours') ?>', 
                                '<?php the_field('satellite_campus') ?>', 
                                '<?php the_field('coures_prerequisite') ?>',
                                '<?php the_field('course_subject') ?>',
                                '<?php the_field('image') ?>'
                            )" src="<?php echo get_template_directory_uri(); ?>/images/file-pdf-solid.svg" alt="">
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
                            <?php if (get_field('cost_per_course')) : ?>
                                <div class="course__detail">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/money-check-edit-alt-light.svg" alt="">
                                    <p> Cost:&nbsp;$<?php the_field('cost_per_course') ?></p>
                                </div>
                            <?php endif; ?>

                            <?php if (get_field('modality')) : ?>
                                <div class="course__detail">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/school-light.svg" alt="">
                                    <p><?php the_field('modality') ?></p>
                                </div>
                            <?php endif; ?>

                            <?php if (get_field('semester')) : ?>
                                <div class="course__detail">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/calendar-alt-light.svg" alt="" />
                                    <p><?php the_field('semester') ?></p>
                                </div>
                            <?php endif; ?>

                            <?php if (get_field('number_of_credit_hours')) : ?>
                                <div class="course__detail">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/clock.svg" alt="" />
                                    <p> Credit Hours:&nbsp;<?php echo the_field('number_of_credit_hours') ?></p>
                                </div>
                            <?php endif; ?>


                            <?php if (get_field('general_education')) : ?>
                                <div class="course__detail">
                                    <img src="<?php echo get_template_directory_uri() ?>/images/users-class-light.svg" alt="" />
                                    <p>General Education Course</p>
                                </div>
                            <?php endif; ?>
                            <?php if (get_field('satellite_campus')) : ?>
                                <div class="course__detail">
                                    <img src="<?php echo get_template_directory_uri() ?>/images/satellite-light.svg" alt="" />
                                    <p>Satellite Campus: <br /> <?php the_field('satellite_campus') ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-lg-6 position-relative">
                        <div class="background__orange-brush-stroke background__brush-stroke--large">
                            <img class="m-1 course__image" src="<?php the_field('image') ?>" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="background__white">
            <div class="courses__tabs">
                <div class="container">

                    <div class="tabs">
                        <div class="nav nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <p class="nav-link active" id="v-pills-one-tab" data-bs-toggle="pill" data-bs-target="#v-pills-prerequisites" role="tab" aria-controls="v-pills-prerequisites" aria-selected="true">Prerequisites</p>
                            <p class="nav-link" id="v-pills-two-tab" data-bs-toggle="pill" data-bs-target="#v-pills-cost" role="tab" aria-controls="v-pills-cost" aria-selected="false">Cost Info</p>
                            <p class="nav-link" id="v-pills-three-tab" data-bs-toggle="pill" data-bs-target="#v-pills-links" role="tab" aria-controls="v-pills-links" aria-selected="false">Useful Links</p>
                        </div>
                    </div>

                    <div class="tab-content pb-4" style="max-width: 800px">
                        <div class="tab-pane fade show active" id="v-pills-prerequisites" role="tabpanel" aria-labelledby="v-pills-one-tab">
                            <?php if (get_field('coures_prerequisite')) : ?>
                                <h2 class='mb-4'><?php the_field('coures_prerequisite'); ?></h2>
                            <?php endif; ?>
                            <?php if (!get_field('coures_prerequisite')) : ?>
                                <p>There are no known prerequisites for this course.</p>
                            <?php endif; ?>

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
                                <p> If you have more questions about costs, please contact your school counselor or check out our FAQs.</p>
                                <a href="./index.php/faqs" class="cta unformatted">Cost FAQs&nbsp;&nbsp;<i class="fa fa-long-arrow-alt-right"></i></a>
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
                                    'meta_key' => 'campus',
                                    'meta_value' => $institution,
                                    'limit' => 1
                                );
                                $cc_query = new WP_Query($cc_args);

                                return $cc_query->posts;
                            }
                            ?>

                            <div class="course__college">
                                <div class="row">
                                    <div class="col-md-5">
                                        <h2><?php echo get_field('campus', $post_id) ?></h2>
                                        <a target="_blank" class="unformatted" href="<?php echo get_field('dual_enrollment_application', $post_id) ?>">
                                            <i class="fas fa-external-link-alt"></i>&nbsp;Go to Dual Enrollment Application*
                                        </a>
                                        <p class="footnote">*Note: Some postsecondary institutions require account creation for application.
                                        <p>
                                    </div>
                                    <div class="col-md-7">
                                        <h3>Dual Enrollment Contact</h3>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <p class="mb-0"><?php echo get_field('department_contact_name', $post_id) ?></p>
                                                <a class="unformatted" target="_blank" href="mailto:<?php echo get_field('department_contact_email', $post_id) ?>"><?php echo get_field('department_contact_email', $post_id) ?></a>
                                            </div>
                                            <div class="col-lg-6">
                                                <?php if (get_field('transfer_form', $post_id)) : ?>
                                                    <a target="_blank" class="d-block unformatted" href="<?php echo get_field('transfer_form', $post_id) ?>">
                                                    <?php endif; ?>
                                                    <i class="fas fa-external-link-alt"></i>&nbsp;Request information on transcript/transfer</a>
                                                    <?php if (get_field('registrar_email', $post_id)) : ?>
                                                        <a class="unformatted" href="mailto:<?php echo get_field('registrar_email', $post_id) ?>"><i class="far fa-envelope"></i>&nbsp;&nbsp;Contact the Registrar </a>
                                                    <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <a target="_blank" style='max-width: 285px;' href="<?php echo get_field('institution_url', $post_id) ?>" class="cta unformatted">Visit College Website&nbsp;&nbsp;<i class="fa fa-long-arrow-alt-right"></i></a>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <?php include('footer.php') ?>
            <script>
                document.addEventListener("DOMContentLoaded", activateTooltips);

                async function generatePDF(
                    fileName,
                    title,
                    subtitle,
                    description,
                    cost,
                    type,
                    semester,
                    creditHours,
                    satellite,
                    prerequisites,
                    subjectArea,
                    image
                ) {

                    const div = document.createElement('div');
                    div.style.padding = '4rem';
                    div.classList.add('course__pdf');
                    const h1 = document.createElement('h1');
                    h1.innerText = title;
                    const h6 = document.createElement('h6');
                    h6.innerText = subtitle;
                    const p = document.createElement('p');
                    p.innerText = description;
                    const imageEl = document.createElement('div');
                    imageEl.classList.add("pdf__image");

                    const row = document.createElement('div');
                    row.classList.add('pdf__row');

                    const leftColumn = document.createElement('div');
                    const rightColumn = document.createElement('div');


                    const ul = document.createElement('ul');
                    ul.style.listStyle = 'circle';
                    const costContent = document.createElement('li');
                    costContent.innerText = `Cost: $${cost}`;
                    const typeContent = document.createElement('li');
                    typeContent.innerText = `Type: ${type}`;
                    const semesterContent = document.createElement('li');
                    semesterContent.innerText = `Semester: ${semester}`;
                    const creditHoursContent = document.createElement('li');
                    creditHoursContent.innerText = `Credit Hours: ${creditHours}`;
                    const satelliteCampusContent = document.createElement('li');
                    satelliteCampusContent.innerText = `Satellite Campus: ${satellite}`;
                    const prereqInfo = document.createElement('li');
                    prereqInfo.innerText = `Prerequisites: ${prerequisites}`;
                    const subjectAreaInfo = document.createElement('li');
                    subjectAreaInfo.innerText = `Subject Area: ${subjectArea}`;


                    if (cost) {
                        ul.appendChild(costContent);
                    }
                    if (type) {
                        ul.appendChild(typeContent);
                    }
                    if (semester) {
                        ul.appendChild(semesterContent);
                    }
                    if (creditHours) {
                        ul.appendChild(creditHoursContent);
                    }
                    if (satellite) {
                        ul.appendChild(satelliteCampusContent);
                    }

                    if (subjectArea) {
                        ul.appendChild(subjectAreaInfo);
                    }

                    leftColumn.appendChild(h1);
                    leftColumn.appendChild(h6);
                    leftColumn.appendChild(p);
                    leftColumn.appendChild(ul);
                    rightColumn.appendChild(imageEl);

                    row.appendChild(leftColumn);
                    row.appendChild(rightColumn);
                    div.appendChild(row);

                    const prereqTitle = document.createElement('h4');
                    prereqTitle.innerText = 'Prerequisites:';
                    const costInfoTitle = document.createElement('h4');
                    costInfoTitle.innerText = 'Cost Info:';
                    const usefulLinksTitle = document.createElement('h4');
                    usefulLinksTitle.innerText = 'Useful Links:';
                    usefulLinksTitle.classList.add('page-break-before');

                    const prerequisiteInfo = document.querySelector('#v-pills-prerequisites');
                    const prereqClone = prerequisiteInfo.cloneNode(true);
                    prereqClone.classList.remove('fade');
                    const costInfo = document.querySelector('#v-pills-cost');
                    const usefulLinks = document.querySelector('#v-pills-links');
                    const costInfoClone = costInfo.cloneNode(true);
                    costInfoClone.classList.remove('fade');
                    const usefulLinksClone = usefulLinks.cloneNode(true);
                    usefulLinksClone.classList.remove('fade');

                    div.appendChild(prereqTitle);
                    div.appendChild(prereqClone);
                    div.appendChild(costInfoTitle);
                    div.appendChild(costInfoClone);
                    div.appendChild(usefulLinksTitle);
                    div.appendChild(usefulLinksClone);

                    html2pdf().set({
                        margin: 5,
                        pagebreak: {
                            mode: ['css', 'legacy']
                        }
                    }).from(div).save(fileName);

                }

                // Initiate Tool Tips

                function activateTooltips() {
                    console.log('here')
                    const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
                    tooltips.forEach(
                        tooltip => {
                            var tooltip = new bootstrap.Tooltip(tooltip)
                        }
                    )
                }
            </script>