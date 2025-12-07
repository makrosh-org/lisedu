<?php

/**
 * Creativ Preschool FSE functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Creativ Preschool FSE
 */

define( 'creativ_preschool_fse_VERSION', wp_get_theme()->get( 'Version' ) );

if ( ! function_exists( 'creativ_preschool_fse_setup' ) ) {

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function creativ_preschool_fse_setup() {

		// Make theme available for translation.
		load_theme_textdomain( 'creativ-preschool-fse', get_template_directory() . '/languages' );

		// Add theme support
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'editor-styles' );
		add_theme_support( 'html5', array( 'comment-form', 'comment-list' ) );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'customize-selective-refresh-widgets' );
	}
}
add_action( 'after_setup_theme', 'creativ_preschool_fse_setup' );

/**
 * Enqueue scripts and styles
 */
function creativ_preschool_fse_scripts() {
	$version = wp_get_theme( 'creativ-preschool-fse' )->get( 'Version' );
	// Stylesheet
	wp_enqueue_style( 'creativ-preschool-fse-styles', get_theme_file_uri( '/style.css' ), array(), $version );

	if ( file_exists( get_template_directory() . '/assets/css/theme-style.css' ) ) {
		wp_enqueue_style( 'creativ-preschool-fse-theme-style', get_template_directory_uri() . '/assets/css/theme-style.css',  array(), $version );
	}
}
add_action( 'wp_enqueue_scripts', 'creativ_preschool_fse_scripts' );

/**
 * Add editor styles
 */
function creativ_preschool_fse_editor_style() {
    wp_enqueue_style( 'creativ-preschool-fse-editor-style', get_template_directory_uri() . '/assets/css/editor-style.css', array(), '1.0' );
}
add_action( 'enqueue_block_editor_assets', 'creativ_preschool_fse_editor_style' );

/**
 * Enqueue assets scripts for both backend and frontend
 */
function creativ_preschool_fse_block_assets()
{
    wp_enqueue_style( 'creativ-preschool-fse-blocks-style', get_template_directory_uri() . '/assets/css/blocks.css' );
}
add_action( 'enqueue_block_assets', 'creativ_preschool_fse_block_assets' );


/**
 * Enqueue the admin CSS files.
 *
 * @since 1.0.0
 *
 * @return void
 */
function creativ_preschool_fse_admin_styles() {
	wp_enqueue_style(
		'creativ-preschool-fse-theme-dashboard-style',
		get_template_directory_uri() . '/assets/css/theme-info.css',
		[],
		creativ_preschool_fse_VERSION
	);
}
add_action( 'admin_enqueue_scripts', 'creativ_preschool_fse_admin_styles' );

/**
 * Load core file
 */
require get_theme_file_path() . '/inc/core/init.php';

// Theme dashboard.
require get_theme_file_path( 'inc/theme-info.php' );