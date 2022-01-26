<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Louisiana_Board_of_Regents_-_Dual_Enrollment
 */

?>

<footer id="colophon" class="site-footer">
	<div class="site-info">
		<div class="container">

			<p class="footer__title">Get in touch. <span class="bold">Call <a href="tel:2253424253">225.342.4253</a></span> or <span class="
			bold">email <a href="mailto:dualenrollment@laregents.edu">dualenrollment@laregents.edu.</a></span></p>

			<hr />
			<div class="row">
				<div class="col-md-6">
					<div class="row">
						<div class="col-md-6">
							<ul class="footer__nav-links">
								<li class="bold color-white">Start here</li>
								<li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
								<li><a href="./index.php/details">Details</a></li>
								<li><a href="./index.php/courses">Courses</a></li>
								<li><a href="./index.php/fields-of-study">Fields of Study</a></li>

							</ul>
						</div>
						<div class="col-md-6">
							<ul class="footer__nav-links">
								<li class="bold color-white">Useful Information</li>
								<li><a href="./index.php/faqs">FAQs</a></li>
								<li><a href="./index.php/apply">Apply</a></li>
								<li><a href="./index.php/contact">Contact</a></li>
							</ul>
						</div>
					</div>
					<p class="footer__copyright">
						Copyright
						<a target='_blank' href="<?php echo esc_url(__('https://regents.la.gov/', 'bor')); ?>">
							<?php
							/* translators: %s: CMS name, i.e. WordPress. */
							printf(esc_html__('Louisiana Board of Regents'));

							?>
						</a>
						
						<br class="footer__copyright__break" />
						Created by
						<a href="<?php echo esc_url(__('https://wherewego.org/', 'bor')); ?>target='_blank'">
							<?php
							/* translators: %s: CMS name, i.e. WordPress. */
							printf(esc_html__('WhereWeGo'));

							?>
						</a>
					</p>

				</div>
				<div class="col-md-6">
					<img class="footer__logo" src="<?php echo get_template_directory_uri(); ?>/images/Dual Enrollment Logo - Footer.svg" alt="">

				</div>
			</div>


		</div>



	</div><!-- .site-info -->
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>