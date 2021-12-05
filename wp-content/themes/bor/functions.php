<?php

/**
 * Louisiana Board of Regents - Dual Enrollment functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Louisiana_Board_of_Regents_-_Dual_Enrollment
 */

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

if (!function_exists('bor_setup')) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function bor_setup()
	{
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Louisiana Board of Regents - Dual Enrollment, use a find and replace
		 * to change 'bor' to the name of your theme in all the template files.
		 */
		load_theme_textdomain('bor', get_template_directory() . '/languages');

		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support('post-thumbnails');

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__('Primary', 'bor'),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'bor_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support('customize-selective-refresh-widgets');

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action('after_setup_theme', 'bor_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function bor_content_width()
{
	$GLOBALS['content_width'] = apply_filters('bor_content_width', 640);
}
add_action('after_setup_theme', 'bor_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function bor_widgets_init()
{
	register_sidebar(
		array(
			'name'          => esc_html__('Sidebar', 'bor'),
			'id'            => 'sidebar-1',
			'description'   => esc_html__('Add widgets here.', 'bor'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action('widgets_init', 'bor_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function bor_scripts()
{
	wp_enqueue_style('bor-style', get_stylesheet_uri(), array(), _S_VERSION);
	wp_style_add_data('bor-style', 'rtl', 'replace');
	wp_enqueue_style('bootstrap-style', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css');
	wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js', array('jquery'));
	wp_enqueue_style('swiper-style', get_template_directory_uri() . '/swiper/css/swiper.min.css');
	wp_enqueue_script('swiper-js', get_template_directory_uri() . '/swiper/js/swiper-bundle.js');
	wp_enqueue_script('bor-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);
	wp_enqueue_style('theme', get_template_directory_uri() . '/sass/style.min.css');
	wp_enqueue_style('font-awesome', 'https://pro.fontawesome.com/releases/v5.10.0/css/all.css');
	wp_enqueue_script('big-picture', 'https://cdn.jsdelivr.net/npm/bigpicture@2.5.3/dist/BigPicture.min.js');
	wp_enqueue_script('google-maps', '//maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyDmpMknHZCk19dfAumNHIRMIziQb6Ny5Y4');

	if (!is_admin()) {
		wp_register_script('gmaps-init', get_template_directory_uri() . '/js/vendor/gmaps.js', array(), '', false);
		wp_enqueue_script('gmaps-init');
	}
	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'bor_scripts');

// Locations Map Shortcode - [locations_map]



/**
 * Custom Menu Location
 */

function wpb_custom_new_menu()
{
	register_nav_menus(
		array(
			'extra-menu' => __('First Menu
			')
		)
	);
	register_nav_menus(
		array(
			'front-page' => __('Front Page
			')
		)
	);
}
add_action('init', 'wpb_custom_new_menu');
/**
 * Register Custom Navigation Walker
 */
function register_navwalker()
{
	require_once get_template_directory() . '/class-wp-bootstrap-navwalker.php';
}
add_action('after_setup_theme', 'register_navwalker');

/*Navigation Menus*/
function register_my_menu()
{
	register_nav_menu('header-menu', __('Header Menu'));
}
add_action('init', 'register_my_menu');
/*End*/

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}
function algolia_load_assets()
{
	$clientPath = '/js/vendor/algoliasearch-lite.umd.js';
	$instantSearchPath = '/js/vendor/instantsearch.production.min.js';

	// Create a version number based on the last time the file was modified
	$clientVersion = date("ymd-Gis", filemtime(get_template_directory() . $clientPath));
	$instantSearchVersion = date("ymd-Gis", filemtime(get_template_directory() . $instantSearchPath));

	wp_enqueue_script('algolia-client', get_template_directory_uri() . $clientPath, array(), $clientVersion, true);
	wp_enqueue_script('algolia-instant-search', get_template_directory_uri() . $instantSearchPath, array('algolia-client'), $instantSearchVersion, true);
	$algoliaPath = '/js/algolia-search.js';
	$algoliaVersion = date("ymd-Gis", filemtime(get_template_directory() . $algoliaPath));
	wp_enqueue_script('algolia-search', get_template_directory_uri() . $algoliaPath, array('algolia-instant-search'), $algoliaVersion, true);
}
add_action('wp_enqueue_scripts', 'algolia_load_assets');
wp_enqueue_style('algolia-theme', get_template_directory_uri() . '/satellite-min.css');

// TODO include 301 redirects for single post types

/** Allow SVG Upload */
function enable_svg_upload($upload_mimes)
{
	$upload_mimes['svg'] = 'image/svg+xml';
	$upload_mimes['svgz'] = 'image/svg+xml';
	return $upload_mimes;
}
add_filter('upload_mimes', 'enable_svg_upload', 10, 1);

/** Since we are sycing with AirTable, remove Colleges and Courses from Dashboard menu */
function bor_remove_menu_items()
{
	remove_menu_page('edit.php?post_type=college');
	remove_menu_page('edit.php?post_type=college-courses');
}
add_action('admin_menu', 'bor_remove_menu_items');

/** Redirect form single post type for CIP Codes, Colleges, and Fields of Study */
function redirect_faq_single()
{
	if (is_singular('faq')) {
		wp_redirect(get_home_url(), 301);
	}
}
function redirect_cip_codes_single()
{
	if (is_singular('cip_codes')) {
		wp_redirect( get_home_url(), 301);
	}
}
function redirect_field_of_study_single()
{
	if (is_singular('field-of-study')) {
		wp_redirect(get_home_url(), 301);
	}
}
function redirect_college_single()
{
	if (is_singular('college')) {
		wp_redirect(get_home_url(), 301);
	}
}
add_action('template_redirect', 'redirect_faq_single');
add_action('template_redirect', 'redirect_cip_codes_single');
add_action('template_redirect', 'redirect_field_of_study_single');
add_action('template_redirect', 'redirect_college_single');
