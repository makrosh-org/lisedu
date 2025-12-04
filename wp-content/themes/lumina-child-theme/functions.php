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
 * Register navigation menus
 */
function lumina_register_menus() {
    register_nav_menus(array(
        'primary' => __('Primary Navigation', 'lumina-child-theme'),
        'footer'  => __('Footer Navigation', 'lumina-child-theme'),
        'mobile'  => __('Mobile Navigation', 'lumina-child-theme'),
    ));
}
add_action('after_setup_theme', 'lumina_register_menus');

/**
 * Add mobile menu toggle button support
 * This adds a CSS class to body for mobile menu state
 */
function lumina_body_classes($classes) {
    $classes[] = 'has-mobile-menu';
    return $classes;
}
add_filter('body_class', 'lumina_body_classes');

/**
 * Custom breadcrumb navigation function
 * Requirements: 3.1, 3.2, 3.3
 */
function lumina_breadcrumbs() {
    // Check if breadcrumbs are enabled
    if (!get_option('lumina_breadcrumbs_enabled', true)) {
        return;
    }
    
    // Don't display on homepage
    if (is_front_page()) {
        return;
    }
    
    global $post;
    
    $breadcrumb_html = '<nav class="lumina-breadcrumbs" aria-label="Breadcrumb">';
    $breadcrumb_html .= '<ol class="breadcrumb-list">';
    
    // Home link
    $breadcrumb_html .= '<li class="breadcrumb-item">';
    $breadcrumb_html .= '<a href="' . home_url('/') . '">Home</a>';
    $breadcrumb_html .= '</li>';
    
    if (is_page()) {
        // Get page ancestors
        if ($post->post_parent) {
            $ancestors = array_reverse(get_post_ancestors($post->ID));
            foreach ($ancestors as $ancestor) {
                $breadcrumb_html .= '<li class="breadcrumb-item">';
                $breadcrumb_html .= '<a href="' . get_permalink($ancestor) . '">' . get_the_title($ancestor) . '</a>';
                $breadcrumb_html .= '</li>';
            }
        }
        
        // Current page
        $breadcrumb_html .= '<li class="breadcrumb-item active" aria-current="page">';
        $breadcrumb_html .= get_the_title();
        $breadcrumb_html .= '</li>';
        
    } elseif (is_single()) {
        // For single posts, show category
        $categories = get_the_category();
        if ($categories) {
            $category = $categories[0];
            $breadcrumb_html .= '<li class="breadcrumb-item">';
            $breadcrumb_html .= '<a href="' . get_category_link($category->term_id) . '">' . $category->name . '</a>';
            $breadcrumb_html .= '</li>';
        }
        
        // Current post
        $breadcrumb_html .= '<li class="breadcrumb-item active" aria-current="page">';
        $breadcrumb_html .= get_the_title();
        $breadcrumb_html .= '</li>';
        
    } elseif (is_category()) {
        $breadcrumb_html .= '<li class="breadcrumb-item active" aria-current="page">';
        $breadcrumb_html .= single_cat_title('', false);
        $breadcrumb_html .= '</li>';
        
    } elseif (is_archive()) {
        $breadcrumb_html .= '<li class="breadcrumb-item active" aria-current="page">';
        $breadcrumb_html .= post_type_archive_title('', false);
        $breadcrumb_html .= '</li>';
        
    } elseif (is_search()) {
        $breadcrumb_html .= '<li class="breadcrumb-item active" aria-current="page">';
        $breadcrumb_html .= 'Search Results';
        $breadcrumb_html .= '</li>';
        
    } elseif (is_404()) {
        $breadcrumb_html .= '<li class="breadcrumb-item active" aria-current="page">';
        $breadcrumb_html .= '404 Not Found';
        $breadcrumb_html .= '</li>';
    }
    
    $breadcrumb_html .= '</ol>';
    $breadcrumb_html .= '</nav>';
    
    echo $breadcrumb_html;
}

/**
 * Add breadcrumb shortcode for Elementor
 */
function lumina_breadcrumb_shortcode() {
    ob_start();
    lumina_breadcrumbs();
    return ob_get_clean();
}
add_shortcode('lumina_breadcrumbs', 'lumina_breadcrumb_shortcode');

/**
 * Enqueue mobile navigation scripts and styles
 */
function lumina_mobile_nav_assets() {
    // Add inline CSS for mobile menu
    $mobile_css = "
    /* Mobile Navigation Styles */
    @media (max-width: 767px) {
        .mobile-menu-toggle {
            display: block;
            background: var(--base-darkblue, #003d70);
            color: var(--base-white, #FFFFFF);
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            font-size: 18px;
            position: relative;
            z-index: 1000;
        }
        
        .mobile-menu-toggle .hamburger {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        
        .mobile-menu-toggle .hamburger span {
            display: block;
            width: 25px;
            height: 3px;
            background: var(--base-white, #FFFFFF);
            transition: all 0.3s ease;
        }
        
        .mobile-menu-toggle.active .hamburger span:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }
        
        .mobile-menu-toggle.active .hamburger span:nth-child(2) {
            opacity: 0;
        }
        
        .mobile-menu-toggle.active .hamburger span:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -6px);
        }
        
        .mobile-nav-menu {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: var(--base-white, #FFFFFF);
            z-index: 999;
            overflow-y: auto;
            padding: 60px 20px 20px;
        }
        
        .mobile-nav-menu.active {
            display: block;
        }
        
        .mobile-nav-menu ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .mobile-nav-menu li {
            border-bottom: 1px solid var(--base-lightgray, #f7f7f7);
        }
        
        .mobile-nav-menu a {
            display: block;
            padding: 15px 10px;
            color: var(--base-darkblue, #003d70);
            text-decoration: none;
            font-size: 16px;
        }
        
        .mobile-nav-menu .sub-menu {
            padding-left: 20px;
        }
        
        .mobile-nav-menu .sub-menu a {
            font-size: 14px;
            color: var(--base-accent-teal, #7EBEC5);
        }
    }
    
    @media (min-width: 768px) {
        .mobile-menu-toggle {
            display: none;
        }
        
        .mobile-nav-menu {
            display: none;
        }
    }
    
    /* Breadcrumb Styles */
    .lumina-breadcrumbs {
        padding: 15px 0;
        margin-bottom: 20px;
    }
    
    .breadcrumb-list {
        display: flex;
        flex-wrap: wrap;
        list-style: none;
        padding: 0;
        margin: 0;
        font-size: 14px;
    }
    
    .breadcrumb-item {
        display: flex;
        align-items: center;
    }
    
    .breadcrumb-item + .breadcrumb-item::before {
        content: '/';
        padding: 0 8px;
        color: var(--base-accent-teal, #7EBEC5);
    }
    
    .breadcrumb-item a {
        color: var(--base-darkblue, #003d70);
        text-decoration: none;
        transition: color 0.3s ease;
    }
    
    .breadcrumb-item a:hover {
        color: var(--base-accent-orange, #F39A3B);
    }
    
    .breadcrumb-item.active {
        color: var(--base-accent-teal, #7EBEC5);
    }
    ";
    
    wp_add_inline_style('lumina-child-style', $mobile_css);
    
    // Add inline JavaScript for mobile menu toggle
    $mobile_js = "
    jQuery(document).ready(function($) {
        // Create mobile menu toggle button if it doesn't exist
        if ($('.mobile-menu-toggle').length === 0) {
            var toggleButton = '<button class=\"mobile-menu-toggle\" aria-label=\"Toggle mobile menu\" aria-expanded=\"false\">' +
                '<span class=\"hamburger\">' +
                '<span></span>' +
                '<span></span>' +
                '<span></span>' +
                '</span>' +
                '</button>';
            
            // Try to insert before the primary menu
            if ($('nav[role=\"navigation\"]').length > 0) {
                $('nav[role=\"navigation\"]').first().before(toggleButton);
            } else if ($('.site-header').length > 0) {
                $('.site-header').prepend(toggleButton);
            }
        }
        
        // Mobile menu toggle functionality
        $(document).on('click', '.mobile-menu-toggle', function(e) {
            e.preventDefault();
            $(this).toggleClass('active');
            $('.mobile-nav-menu').toggleClass('active');
            
            var isExpanded = $(this).hasClass('active');
            $(this).attr('aria-expanded', isExpanded);
            
            // Prevent body scroll when menu is open
            if (isExpanded) {
                $('body').css('overflow', 'hidden');
            } else {
                $('body').css('overflow', '');
            }
        });
        
        // Close mobile menu when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.mobile-menu-toggle, .mobile-nav-menu').length) {
                $('.mobile-menu-toggle').removeClass('active');
                $('.mobile-nav-menu').removeClass('active');
                $('.mobile-menu-toggle').attr('aria-expanded', 'false');
                $('body').css('overflow', '');
            }
        });
        
        // Handle sub-menu toggles on mobile
        $('.mobile-nav-menu .menu-item-has-children > a').on('click', function(e) {
            if ($(window).width() < 768) {
                e.preventDefault();
                $(this).parent().toggleClass('open');
                $(this).next('.sub-menu').slideToggle(300);
            }
        });
    });
    ";
    
    wp_add_inline_script('lumina-custom-scripts', $mobile_js);
}
add_action('wp_enqueue_scripts', 'lumina_mobile_nav_assets');

/**
 * Add mobile navigation menu to footer
 */
function lumina_add_mobile_menu() {
    if (has_nav_menu('primary')) {
        echo '<div class="mobile-nav-menu">';
        wp_nav_menu(array(
            'theme_location' => 'primary',
            'container'      => 'nav',
            'container_class' => 'mobile-navigation',
            'menu_class'     => 'mobile-menu',
            'fallback_cb'    => false,
        ));
        echo '</div>';
    }
}
add_action('wp_footer', 'lumina_add_mobile_menu');

/**
 * Shortcode: Display upcoming events
 * Requirements: 10.4 - Display next 3 upcoming events on homepage
 * 
 * Usage: [lumina_upcoming_events limit="3"]
 */
function lumina_upcoming_events_shortcode($atts) {
    $atts = shortcode_atts(array(
        'limit' => 3,
    ), $atts);
    
    // Query for upcoming events (custom post type will be created in task 15)
    // For now, we'll create a placeholder that can be populated later
    $args = array(
        'post_type' => 'lis_event',
        'posts_per_page' => intval($atts['limit']),
        'post_status' => 'publish',
        'meta_key' => 'event_date',
        'orderby' => 'meta_value',
        'order' => 'ASC',
        'meta_query' => array(
            array(
                'key' => 'event_date',
                'value' => date('Y-m-d'),
                'compare' => '>=',
                'type' => 'DATE',
            ),
        ),
    );
    
    $events_query = new WP_Query($args);
    
    ob_start();
    
    if ($events_query->have_posts()) {
        echo '<div class="lumina-upcoming-events">';
        echo '<div class="events-grid">';
        
        while ($events_query->have_posts()) {
            $events_query->the_post();
            $event_date = get_post_meta(get_the_ID(), 'event_date', true);
            $event_time = get_post_meta(get_the_ID(), 'event_time', true);
            $event_location = get_post_meta(get_the_ID(), 'event_location', true);
            
            echo '<div class="event-card">';
            echo '<h3 class="event-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
            
            if ($event_date) {
                echo '<p class="event-date"><strong>Date:</strong> ' . date('F j, Y', strtotime($event_date)) . '</p>';
            }
            
            if ($event_time) {
                echo '<p class="event-time"><strong>Time:</strong> ' . esc_html($event_time) . '</p>';
            }
            
            if ($event_location) {
                echo '<p class="event-location"><strong>Location:</strong> ' . esc_html($event_location) . '</p>';
            }
            
            echo '<div class="event-excerpt">' . get_the_excerpt() . '</div>';
            echo '<a href="' . get_permalink() . '" class="event-link">Learn More →</a>';
            echo '</div>';
        }
        
        echo '</div>';
        echo '</div>';
        
        // Add CSS for event cards
        echo '<style>
        .lumina-upcoming-events {
            margin: 30px 0;
        }
        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 20px;
        }
        .event-card {
            background: #FFFFFF;
            border: 2px solid #7EBEC5;
            border-radius: 8px;
            padding: 25px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .event-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 61, 112, 0.1);
        }
        .event-title {
            color: #003d70;
            font-size: 22px;
            margin-bottom: 15px;
        }
        .event-title a {
            color: #003d70;
            text-decoration: none;
        }
        .event-title a:hover {
            color: #7EBEC5;
        }
        .event-date, .event-time, .event-location {
            color: #333;
            margin: 8px 0;
            font-size: 14px;
        }
        .event-excerpt {
            margin: 15px 0;
            color: #666;
            line-height: 1.6;
        }
        .event-link {
            display: inline-block;
            color: #F39A3B;
            text-decoration: none;
            font-weight: 600;
            margin-top: 10px;
        }
        .event-link:hover {
            color: #003d70;
        }
        </style>';
        
    } else {
        echo '<div class="lumina-upcoming-events">';
        echo '<p style="text-align: center; color: #666; padding: 40px 20px;">No upcoming events at this time. Check back soon!</p>';
        echo '</div>';
    }
    
    wp_reset_postdata();
    
    return ob_get_clean();
}
add_shortcode('lumina_upcoming_events', 'lumina_upcoming_events_shortcode');

/**
 * Shortcode: Display recent news articles
 * Requirements: 11.4 - Display 3 most recent news articles on homepage
 * 
 * Usage: [lumina_recent_news limit="3"]
 */
function lumina_recent_news_shortcode($atts) {
    $atts = shortcode_atts(array(
        'limit' => 3,
    ), $atts);
    
    // Query for recent posts (news articles)
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => intval($atts['limit']),
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC',
    );
    
    $news_query = new WP_Query($args);
    
    ob_start();
    
    if ($news_query->have_posts()) {
        echo '<div class="lumina-recent-news">';
        echo '<div class="news-grid">';
        
        while ($news_query->have_posts()) {
            $news_query->the_post();
            
            echo '<div class="news-card">';
            
            // Featured image
            if (has_post_thumbnail()) {
                echo '<div class="news-image">';
                echo '<a href="' . get_permalink() . '">';
                the_post_thumbnail('lumina-news', array('alt' => get_the_title()));
                echo '</a>';
                echo '</div>';
            }
            
            echo '<div class="news-content">';
            echo '<h3 class="news-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
            echo '<p class="news-meta">';
            echo '<span class="news-date">' . get_the_date('F j, Y') . '</span>';
            echo ' | ';
            echo '<span class="news-author">By ' . get_the_author() . '</span>';
            echo '</p>';
            echo '<div class="news-excerpt">' . get_the_excerpt() . '</div>';
            echo '<a href="' . get_permalink() . '" class="news-link">Read More →</a>';
            echo '</div>';
            
            echo '</div>';
        }
        
        echo '</div>';
        echo '</div>';
        
        // Add CSS for news cards
        echo '<style>
        .lumina-recent-news {
            margin: 30px 0;
        }
        .news-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 20px;
        }
        .news-card {
            background: #FFFFFF;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .news-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0, 61, 112, 0.15);
        }
        .news-image {
            width: 100%;
            height: 200px;
            overflow: hidden;
        }
        .news-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        .news-card:hover .news-image img {
            transform: scale(1.05);
        }
        .news-content {
            padding: 20px;
        }
        .news-title {
            color: #003d70;
            font-size: 20px;
            margin-bottom: 10px;
            line-height: 1.4;
        }
        .news-title a {
            color: #003d70;
            text-decoration: none;
        }
        .news-title a:hover {
            color: #7EBEC5;
        }
        .news-meta {
            color: #999;
            font-size: 13px;
            margin-bottom: 15px;
        }
        .news-excerpt {
            color: #666;
            line-height: 1.6;
            margin-bottom: 15px;
        }
        .news-link {
            display: inline-block;
            color: #F39A3B;
            text-decoration: none;
            font-weight: 600;
        }
        .news-link:hover {
            color: #003d70;
        }
        </style>';
        
    } else {
        echo '<div class="lumina-recent-news">';
        echo '<p style="text-align: center; color: #666; padding: 40px 20px;">No news articles available yet. Stay tuned for updates!</p>';
        echo '</div>';
    }
    
    wp_reset_postdata();
    
    return ob_get_clean();
}
add_shortcode('lumina_recent_news', 'lumina_recent_news_shortcode');

/**
 * Include Elementor configuration
 */
require_once get_stylesheet_directory() . '/elementor-config.php';
