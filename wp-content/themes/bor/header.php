<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Louisiana_Board_of_Regents_-_Dual_Enrollment
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<div id="page" class="site">

		<header id="masthead" class="site-header">
			<!-- <div class="site-branding">
				<?php
				the_custom_logo();
				if (is_front_page() && is_home()) :
				?>
					<h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
				<?php
				else :
				?>
					<p class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></p>
				<?php
				endif;
				$bor_description = get_bloginfo('description', 'display');
				if ($bor_description || is_customize_preview()) :
				?>
					<p class="site-description"><?php echo $bor_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
												?></p>
				<?php endif; ?>
			</div>

			<nav id="site-navigation" class="main-navigation">
				<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e('Primary Menu', 'bor'); ?></button>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'menu-1',
						'menu_id'        => 'primary-menu',
					)
				);
				?>
			</nav> -->


			<nav class="navbar navbar-expand-md navbar-light" role="navigation">
				<div class="container pb-0 pt-0">
					<!-- Brand and toggle get grouped for better mobile display -->

					<a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home">
						<img src="<?php echo get_template_directory_uri(); ?>/images/Dual Enrollment Logo.svg" alt="Logo" />
					</a>
					<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#bs-example-navbar-collapse-1" aria-controls="bs-example-navbar-collapse-1" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation', 'your-theme-slug'); ?>">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div id="searchToggle" class="d-md-none d-block" data-bs-toggle="modal" data-bs-target="#searchModalDialog">
						<i  class="fa fa-search"></i>

					</div>
					<?php
					wp_nav_menu(array(
						'theme_location'    => 'extra-menu',
						'depth'             => 2,
						'container'         => 'div',
						'container_class'   => 'collapse navbar-collapse',
						'container_id'      => 'bs-example-navbar-collapse-1',
						'menu_class'        => 'nav navbar-nav',

					));
					?>
					<div class="vertical-line"></div>
					<?php
					wp_nav_menu(array(
						'theme_location'    => 'header-menu',
						'depth'             => 2,
						'container'         => 'div',
						'container_class'   => 'collapse navbar-collapse',
						'container_id'      => 'bs-example-navbar-collapse-1',
						'menu_class'        => 'nav navbar-nav',

					));
					?>
					<div id="searchToggle" class="d-none d-md-block" data-bs-toggle="modal" data-bs-target="#searchModalDialog">
						<i  class="fa fa-search"></i>

					</div>

				</div>
			</nav>
		</header><!-- #masthead -->
		<div class="modal fade" id="searchModalDialog" tabindex="-1" aria-labelledby="searchModalDialog" aria-hidden="true">
			<div class="modal-dialog modal-lg modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<div id="algoliaSearch"></div>
						<i onclick="closeHeaderSearchModal()" class="far fa-times-circle"></i>

						<!-- <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
					</div>
					<div style="height: 400px; overflow-y: scroll" class="modal-body">
						<div id="hits"></div>
						<div id="tags-list"></div>
					</div>

				</div>
			</div>
		</div>


		<script>
			function closeHeaderSearchModal() {
				const button = document.querySelector('#searchToggle');
				button.click();
			}
		</script>