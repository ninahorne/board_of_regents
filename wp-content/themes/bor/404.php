<?php

/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Louisiana_Board_of_Regents_-_Dual_Enrollment
 */

get_header();
?>

<main id="primary" class="site-main">

	<div class="background__blue p-5">
		<div class="container">
			<header class="page-header">
				<h1 class="color-white page-title"><?php esc_html_e('Oops! That page can&rsquo;t be found.', 'bor'); ?></h1>
			</header><!-- .page-header -->
			<section>
				<p class="color-white">
					Try searching for what you're looking for.
				</p>
			</section>
		</div>


	</div>




</main><!-- #main -->

<?php
get_footer();
