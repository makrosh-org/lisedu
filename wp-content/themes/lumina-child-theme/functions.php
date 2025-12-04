<?php
/**
 * Lumina International School Child Theme Functions
 * 
 * @package Lumina_Child_Theme
 * @version 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue parent and child theme styles
 */
function lumina_child_enqueue_styles() {
    // Get parent theme stylesheet
    $parent_style = 'parent-style';
    
    // Enqueue parent theme stylesheet
    wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css');
    
    // Enqueue brand colors CSS
    wp_enqueue_style(
        'lumina-brand-colors',
        get_stylesheet_directory_uri() . '/assets/css/brand-colors.css',
        array($parent_style),
        '1.0.0'
    );
    
    // Enqueue child theme stylesheet
    wp_enqueue_style(
        'lumina-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array($parent_style, 'lumina-brand-colors'),
        wp_get_theme()->get('Version')
    );
    
    // Enqueue custom scripts
    wp_enqueue_script(
        'lumina-custom-scripts',
        get_stylesheet_directory_uri() . '/assets/js/custom-scripts.js',
        array('jquery'),
        '1.0.0',
        true
    );
}
add_action('wp_enqueue_scripts', 'lumina_child_enqueue_styles');

/**
 * Add theme support features
 */
function lumina_child_theme_setup() {
    // Add support for custom logo
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    
    // Add support for title tag
    add_theme_support('title-tag');
    
    // Add support for post thumbnails
    add_theme_support('post-thumbnails');
    
    // Add support for HTML5 markup
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
}
add_action('after_setup_theme', 'lumina_child_theme_setup');

/**
 * Register custom image sizes for the school website
 */
function lumina_register_image_sizes() {
    // Hero images
    add_image_size('lumina-hero', 1920, 1080, true);
    
    // Gallery images
    add_image_size('lumina-gallery', 1200, 800, true);
    add_image_size('lumina-gallery-thumb', 400, 300, true);
    
    // Team photos
    add_image_size('lumina-team', 600, 600, true);
    
    // News featured images
    add_image_size('lumina-news', 800, 600, true);
}
add_action('after_setup_theme', 'lumina_register_image_sizes');

/**
 * Customize excerpt length
 */
function lumina_excerpt_length($length) {
    return 50; // 50 words for news excerpts
}
add_filter('excerpt_length', 'lumina_excerpt_length');

/**
 * Customize excerpt more text
 */
function lumina_excerpt_more($more) {
    return '... <a href="' . get_permalink() . '" class="read-more">Read More</a>';
}
add_filter('excerpt_more', 'lumina_excerpt_more');

/**
 * Include Elementor configuration
 */
require_once get_stylesheet_directory() . '/elementor-config.php';
