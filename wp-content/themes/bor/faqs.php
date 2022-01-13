<?php

/**
 * Template Name: FAQ's Page
 */
?>

<?php include('header.php'); ?>
<main id="content">
    <div id="faqs">
        <div class="background__blue faq__background-brush-stroke">
            <div class="container">
                <div class="p-2">
                    <h1 class="color-white">FAQs</h1>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="faq__search">
                                <div class="faq__categories">
                                    <label>Categories</label>

                                    <div class="m-2">
                                        <div id="faqTags"></div>

                                    </div>
                                    <div>
                                        <div id="faqSearchBox"></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-7">
                            <div id="faqHits"></div>
                            <div id="pagination"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>
<?php include('footer.php'); ?>
<script src="<?php echo get_template_directory_uri(); ?>/js/faqs.js"></script>