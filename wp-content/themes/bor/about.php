<?php

/**
 * Template Name: About Page
 */
?>

<?php include('header.php'); ?>
<div id="content">
    <div id="about">
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
                                    <h1 class="color-white">About Heading</h1>
                                    <h3 class="color-white"> A smaller about heading</h3>
                                    <p class="color-white">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
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