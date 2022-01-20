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
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<div id="page" class="site">

		<header id="masthead" class="site-header">

			<nav class="navbar navbar-expand-md navbar-light" role="navigation">
				<div class="container pb-0 pt-0">
					<!-- Brand and toggle get grouped for better mobile display -->

					<a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home">
						<img src="<?php echo get_template_directory_uri(); ?>/images/Dual Enrollment Logo.svg" alt="Logo" />
					</a>
					<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar1" aria-controls="navbar1" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation', 'your-theme-slug'); ?>">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div id="searchToggle" class="d-md-none d-block" data-bs-toggle="modal" data-bs-target="#searchModalDialog">
						<i class="fa fa-search"></i>

					</div>
					<?php
					wp_nav_menu(array(
						'theme_location'    => 'extra-menu',
						'depth'             => 2,
						'container'         => 'div',
						'container_class'   => 'collapse navbar-collapse',
						'container_id'      => 'navbar1',
						'menu_class'        => 'nav navbar-nav first-menu',

					));
					?>

					<div class="vertical-line"></div>
					<?php
					wp_nav_menu(array(
						'theme_location'    => 'header-menu',
						'depth'             => 2,
						'container'         => 'div',
						'container_class'   => 'collapse navbar-collapse',
						'container_id'      => 'navbar1',
						'menu_class'        => 'nav navbar-nav',

					));
					?>
					<div id="searchToggle" class="d-none d-md-block" data-bs-toggle="modal" data-bs-target="#searchModalDialog">
						<i class="fa fa-search"></i>

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
					</div>
					<div style="height: 400px; overflow-y: scroll" class="modal-body">
						<div id="hits"></div>
						<div id="tags-list"></div>
					</div>

				</div>
			</div>
		</div>


		<script>
			document.addEventListener('DOMContentLoaded', () => {
				addFastForwardLink();
				fastForwardDropdownToggle();
			})

			function closeHeaderSearchModal() {
				const button = document.querySelector('#searchToggle');
				button.click();
			}

			function addFastForwardLink() {
				const firstMenu = document.querySelector(".first-menu");
				const li = document.createElement('li');
				li.innerHTML = `<div class="fast-forward">
					<a  href="#" id="fastForwardToggleButton">
						Fast Forward
					</a>
					<div id="fastForwardDropdown">
						<p>The Fast Forward program is another dual enrollment pathway, allowing students to earn a high school diploma while also earning a technical associate’s degree, transfer associate’s degree or a state-approved apprenticeship at the same time.</p>
						<a target="_blank" href="https://fastforward.la">Go&nbsp;&nbsp;<i class="fa fa-long-arrow-alt-right"></i></a>
					</div>
				</div>
								`;
				firstMenu.appendChild(li);

				

			}

			function fastForwardDropdownToggle(){
				const button = document.getElementById('fastForwardToggleButton');
				const fastForward = document.querySelector('.fast-forward');
				button.addEventListener('click', ()=> {
					fastForward.classList.toggle("open");
				})
			}
		</script>