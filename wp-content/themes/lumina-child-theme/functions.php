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
    
    // Enqueue Google Fonts - Poppins for modern look
    wp_enqueue_style(
        'lumina-google-fonts',
        'https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap',
        array(),
        null
    );
    
    // Enqueue Font Awesome for social media icons
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css',
        array(),
        '6.4.0'
    );
    
    // Enqueue parent theme stylesheet
    wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css');
    
    // Enqueue brand colors CSS
    wp_enqueue_style(
        'lumina-brand-colors',
        get_stylesheet_directory_uri() . '/assets/css/brand-colors.css',
        array($parent_style),
        '1.0.2'
    );
    
    // Enqueue header fixes CSS
    wp_enqueue_style(
        'lumina-header-fixes',
        get_stylesheet_directory_uri() . '/assets/css/header-fixes.css',
        array('lumina-brand-colors'),
        '1.0.0'
    );
    
    // Enqueue contact form CSS
    wp_enqueue_style(
        'lumina-contact-form',
        get_stylesheet_directory_uri() . '/assets/css/contact-form.css',
        array($parent_style, 'lumina-brand-colors'),
        '1.0.0'
    );
    
    // Enqueue admission form CSS
    wp_enqueue_style(
        'lumina-admission-form',
        get_stylesheet_directory_uri() . '/assets/css/admission-form.css',
        array($parent_style, 'lumina-brand-colors'),
        '1.0.0'
    );
    
    // Enhanced homepage styles
    wp_enqueue_style(
        'lumina-homepage-enhanced',
        get_stylesheet_directory_uri() . '/assets/css/homepage-enhanced.css',
        array('lumina-brand-colors'),
        '2.0'
    );
    
    // Social media icons CSS
    wp_enqueue_style(
        'lumina-social-icons',
        get_stylesheet_directory_uri() . '/assets/css/social-icons.css',
        array('font-awesome'),
        '1.0.0'
    );
    
    // Enqueue child theme stylesheet
        // Fix underlines
    wp_enqueue_style(
        'lumina-underline-fixes',
        get_stylesheet_directory_uri() . '/assets/css/underline-fixes.css',
        array('lumina-homepage-enhanced'),
        '1.0.0'
    );
    
    wp_enqueue_style(
        'lumina-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array($parent_style, 'lumina-brand-colors', 'lumina-contact-form', 'lumina-admission-form'),
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
 * Register Custom Post Type: Programs
 * Requirements: 1.3 - Display detailed information for each grade level
 * 
 * This custom post type handles program information for each grade level
 * from play group to grade 5, including curriculum highlights and age ranges.
 */
function lumina_register_programs_post_type() {
    $labels = array(
        'name'                  => _x('Programs', 'Post Type General Name', 'lumina-child-theme'),
        'singular_name'         => _x('Program', 'Post Type Singular Name', 'lumina-child-theme'),
        'menu_name'             => __('Programs', 'lumina-child-theme'),
        'name_admin_bar'        => __('Program', 'lumina-child-theme'),
        'archives'              => __('Program Archives', 'lumina-child-theme'),
        'attributes'            => __('Program Attributes', 'lumina-child-theme'),
        'parent_item_colon'     => __('Parent Program:', 'lumina-child-theme'),
        'all_items'             => __('All Programs', 'lumina-child-theme'),
        'add_new_item'          => __('Add New Program', 'lumina-child-theme'),
        'add_new'               => __('Add New', 'lumina-child-theme'),
        'new_item'              => __('New Program', 'lumina-child-theme'),
        'edit_item'             => __('Edit Program', 'lumina-child-theme'),
        'update_item'           => __('Update Program', 'lumina-child-theme'),
        'view_item'             => __('View Program', 'lumina-child-theme'),
        'view_items'            => __('View Programs', 'lumina-child-theme'),
        'search_items'          => __('Search Program', 'lumina-child-theme'),
        'not_found'             => __('Not found', 'lumina-child-theme'),
        'not_found_in_trash'    => __('Not found in Trash', 'lumina-child-theme'),
        'featured_image'        => __('Featured Image', 'lumina-child-theme'),
        'set_featured_image'    => __('Set featured image', 'lumina-child-theme'),
        'remove_featured_image' => __('Remove featured image', 'lumina-child-theme'),
        'use_featured_image'    => __('Use as featured image', 'lumina-child-theme'),
        'insert_into_item'      => __('Insert into program', 'lumina-child-theme'),
        'uploaded_to_this_item' => __('Uploaded to this program', 'lumina-child-theme'),
        'items_list'            => __('Programs list', 'lumina-child-theme'),
        'items_list_navigation' => __('Programs list navigation', 'lumina-child-theme'),
        'filter_items_list'     => __('Filter programs list', 'lumina-child-theme'),
    );
    
    $args = array(
        'label'                 => __('Program', 'lumina-child-theme'),
        'description'           => __('School programs for different grade levels', 'lumina-child-theme'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'page-attributes'),
        'taxonomies'            => array('program_category'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-welcome-learn-more',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true, // Enable Gutenberg editor
        'rewrite'               => array('slug' => 'programs', 'with_front' => false),
    );
    
    register_post_type('lis_program', $args);
}
add_action('init', 'lumina_register_programs_post_type', 0);

/**
 * Register Program Category Taxonomy
 * Requirements: 1.3 - Categorize programs (academic/extracurricular)
 */
function lumina_register_program_category_taxonomy() {
    $labels = array(
        'name'                       => _x('Program Categories', 'Taxonomy General Name', 'lumina-child-theme'),
        'singular_name'              => _x('Program Category', 'Taxonomy Singular Name', 'lumina-child-theme'),
        'menu_name'                  => __('Program Categories', 'lumina-child-theme'),
        'all_items'                  => __('All Categories', 'lumina-child-theme'),
        'parent_item'                => __('Parent Category', 'lumina-child-theme'),
        'parent_item_colon'          => __('Parent Category:', 'lumina-child-theme'),
        'new_item_name'              => __('New Category Name', 'lumina-child-theme'),
        'add_new_item'               => __('Add New Category', 'lumina-child-theme'),
        'edit_item'                  => __('Edit Category', 'lumina-child-theme'),
        'update_item'                => __('Update Category', 'lumina-child-theme'),
        'view_item'                  => __('View Category', 'lumina-child-theme'),
        'separate_items_with_commas' => __('Separate categories with commas', 'lumina-child-theme'),
        'add_or_remove_items'        => __('Add or remove categories', 'lumina-child-theme'),
        'choose_from_most_used'      => __('Choose from the most used', 'lumina-child-theme'),
        'popular_items'              => __('Popular Categories', 'lumina-child-theme'),
        'search_items'               => __('Search Categories', 'lumina-child-theme'),
        'not_found'                  => __('Not Found', 'lumina-child-theme'),
        'no_terms'                   => __('No categories', 'lumina-child-theme'),
        'items_list'                 => __('Categories list', 'lumina-child-theme'),
        'items_list_navigation'      => __('Categories list navigation', 'lumina-child-theme'),
    );
    
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => false,
        'show_in_rest'               => true,
        'rewrite'                    => array('slug' => 'program-category'),
    );
    
    register_taxonomy('program_category', array('lis_program'), $args);
}
add_action('init', 'lumina_register_program_category_taxonomy', 0);

/**
 * Add custom meta boxes for Program custom fields
 * Requirements: 1.3 - Age range and curriculum highlights
 */
function lumina_add_program_meta_boxes() {
    add_meta_box(
        'lumina_program_details',
        __('Program Details', 'lumina-child-theme'),
        'lumina_program_details_callback',
        'lis_program',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'lumina_add_program_meta_boxes');

/**
 * Meta box callback function for program details
 */
function lumina_program_details_callback($post) {
    // Add nonce for security
    wp_nonce_field('lumina_program_details_nonce', 'lumina_program_details_nonce_field');
    
    // Get existing values
    $age_range = get_post_meta($post->ID, '_program_age_range', true);
    $curriculum_highlights = get_post_meta($post->ID, '_program_curriculum_highlights', true);
    
    // Display fields
    ?>
    <div class="lumina-program-meta-fields">
        <p>
            <label for="program_age_range"><strong><?php _e('Age Range:', 'lumina-child-theme'); ?></strong></label><br>
            <input type="text" id="program_age_range" name="program_age_range" value="<?php echo esc_attr($age_range); ?>" class="widefat" placeholder="e.g., 3-4 years">
            <span class="description"><?php _e('Enter the age range for this program (e.g., 3-4 years, 5-6 years)', 'lumina-child-theme'); ?></span>
        </p>
        
        <p>
            <label for="program_curriculum_highlights"><strong><?php _e('Curriculum Highlights:', 'lumina-child-theme'); ?></strong></label><br>
            <textarea id="program_curriculum_highlights" name="program_curriculum_highlights" rows="8" class="widefat" placeholder="Enter curriculum highlights, one per line"><?php echo esc_textarea($curriculum_highlights); ?></textarea>
            <span class="description"><?php _e('Enter key curriculum highlights for this program. You can use bullet points or separate items with line breaks.', 'lumina-child-theme'); ?></span>
        </p>
    </div>
    
    <style>
        .lumina-program-meta-fields p {
            margin-bottom: 20px;
        }
        .lumina-program-meta-fields label {
            display: block;
            margin-bottom: 5px;
        }
        .lumina-program-meta-fields .description {
            display: block;
            margin-top: 5px;
            font-style: italic;
            color: #666;
        }
    </style>
    <?php
}

/**
 * Save program custom field data
 */
function lumina_save_program_meta_data($post_id) {
    // Check if nonce is set
    if (!isset($_POST['lumina_program_details_nonce_field'])) {
        return;
    }
    
    // Verify nonce
    if (!wp_verify_nonce($_POST['lumina_program_details_nonce_field'], 'lumina_program_details_nonce')) {
        return;
    }
    
    // Check if this is an autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // Check user permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Save age range
    if (isset($_POST['program_age_range'])) {
        update_post_meta($post_id, '_program_age_range', sanitize_text_field($_POST['program_age_range']));
    }
    
    // Save curriculum highlights
    if (isset($_POST['program_curriculum_highlights'])) {
        update_post_meta($post_id, '_program_curriculum_highlights', sanitize_textarea_field($_POST['program_curriculum_highlights']));
    }
}
add_action('save_post_lis_program', 'lumina_save_program_meta_data');

/**
 * Register Custom Post Type: Events
 * Requirements: 10.1, 10.2, 10.5 - Event management with categories
 * Task 15: Create custom post type for Events
 * 
 * This custom post type handles school events including academic events,
 * sports, cultural activities, holidays, and parent events.
 */
function lumina_register_events_post_type() {
    $labels = array(
        'name'                  => _x('Events', 'Post Type General Name', 'lumina-child-theme'),
        'singular_name'         => _x('Event', 'Post Type Singular Name', 'lumina-child-theme'),
        'menu_name'             => __('Events', 'lumina-child-theme'),
        'name_admin_bar'        => __('Event', 'lumina-child-theme'),
        'archives'              => __('Event Archives', 'lumina-child-theme'),
        'attributes'            => __('Event Attributes', 'lumina-child-theme'),
        'parent_item_colon'     => __('Parent Event:', 'lumina-child-theme'),
        'all_items'             => __('All Events', 'lumina-child-theme'),
        'add_new_item'          => __('Add New Event', 'lumina-child-theme'),
        'add_new'               => __('Add New', 'lumina-child-theme'),
        'new_item'              => __('New Event', 'lumina-child-theme'),
        'edit_item'             => __('Edit Event', 'lumina-child-theme'),
        'update_item'           => __('Update Event', 'lumina-child-theme'),
        'view_item'             => __('View Event', 'lumina-child-theme'),
        'view_items'            => __('View Events', 'lumina-child-theme'),
        'search_items'          => __('Search Event', 'lumina-child-theme'),
        'not_found'             => __('Not found', 'lumina-child-theme'),
        'not_found_in_trash'    => __('Not found in Trash', 'lumina-child-theme'),
        'featured_image'        => __('Event Image', 'lumina-child-theme'),
        'set_featured_image'    => __('Set event image', 'lumina-child-theme'),
        'remove_featured_image' => __('Remove event image', 'lumina-child-theme'),
        'use_featured_image'    => __('Use as event image', 'lumina-child-theme'),
        'insert_into_item'      => __('Insert into event', 'lumina-child-theme'),
        'uploaded_to_this_item' => __('Uploaded to this event', 'lumina-child-theme'),
        'items_list'            => __('Events list', 'lumina-child-theme'),
        'items_list_navigation' => __('Events list navigation', 'lumina-child-theme'),
        'filter_items_list'     => __('Filter events list', 'lumina-child-theme'),
    );
    
    $args = array(
        'label'                 => __('Event', 'lumina-child-theme'),
        'description'           => __('School events and activities', 'lumina-child-theme'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail', 'excerpt', 'revisions'),
        'taxonomies'            => array('event_category'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 6,
        'menu_icon'             => 'dashicons-calendar-alt',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true, // Enable Gutenberg editor
        'rewrite'               => array('slug' => 'events', 'with_front' => false),
    );
    
    register_post_type('lis_event', $args);
}
add_action('init', 'lumina_register_events_post_type', 0);

/**
 * Register Event Category Taxonomy
 * Requirements: 10.5 - Event categories (Academic, Sports, Cultural, Holidays, Parent Events)
 */
function lumina_register_event_category_taxonomy() {
    $labels = array(
        'name'                       => _x('Event Categories', 'Taxonomy General Name', 'lumina-child-theme'),
        'singular_name'              => _x('Event Category', 'Taxonomy Singular Name', 'lumina-child-theme'),
        'menu_name'                  => __('Event Categories', 'lumina-child-theme'),
        'all_items'                  => __('All Categories', 'lumina-child-theme'),
        'parent_item'                => __('Parent Category', 'lumina-child-theme'),
        'parent_item_colon'          => __('Parent Category:', 'lumina-child-theme'),
        'new_item_name'              => __('New Category Name', 'lumina-child-theme'),
        'add_new_item'               => __('Add New Category', 'lumina-child-theme'),
        'edit_item'                  => __('Edit Category', 'lumina-child-theme'),
        'update_item'                => __('Update Category', 'lumina-child-theme'),
        'view_item'                  => __('View Category', 'lumina-child-theme'),
        'separate_items_with_commas' => __('Separate categories with commas', 'lumina-child-theme'),
        'add_or_remove_items'        => __('Add or remove categories', 'lumina-child-theme'),
        'choose_from_most_used'      => __('Choose from the most used', 'lumina-child-theme'),
        'popular_items'              => __('Popular Categories', 'lumina-child-theme'),
        'search_items'               => __('Search Categories', 'lumina-child-theme'),
        'not_found'                  => __('Not Found', 'lumina-child-theme'),
        'no_terms'                   => __('No categories', 'lumina-child-theme'),
        'items_list'                 => __('Categories list', 'lumina-child-theme'),
        'items_list_navigation'      => __('Categories list navigation', 'lumina-child-theme'),
    );
    
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => false,
        'show_in_rest'               => true,
        'rewrite'                    => array('slug' => 'event-category'),
    );
    
    register_taxonomy('event_category', array('lis_event'), $args);
}
add_action('init', 'lumina_register_event_category_taxonomy', 0);

/**
 * Add custom meta boxes for Event custom fields
 * Requirements: 10.2 - Event date, time, location, end date
 */
function lumina_add_event_meta_boxes() {
    add_meta_box(
        'lumina_event_details',
        __('Event Details', 'lumina-child-theme'),
        'lumina_event_details_callback',
        'lis_event',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'lumina_add_event_meta_boxes');

/**
 * Meta box callback function for event details
 */
function lumina_event_details_callback($post) {
    // Add nonce for security
    wp_nonce_field('lumina_event_details_nonce', 'lumina_event_details_nonce_field');
    
    // Get existing values
    $event_date = get_post_meta($post->ID, 'event_date', true);
    $event_time = get_post_meta($post->ID, 'event_time', true);
    $event_location = get_post_meta($post->ID, 'event_location', true);
    $event_end_date = get_post_meta($post->ID, 'event_end_date', true);
    
    // Display fields
    ?>
    <div class="lumina-event-meta-fields">
        <p>
            <label for="event_date"><strong><?php _e('Event Date:', 'lumina-child-theme'); ?></strong> <span style="color: red;">*</span></label><br>
            <input type="date" id="event_date" name="event_date" value="<?php echo esc_attr($event_date); ?>" class="widefat" required>
            <span class="description"><?php _e('Select the date when the event starts (required)', 'lumina-child-theme'); ?></span>
        </p>
        
        <p>
            <label for="event_time"><strong><?php _e('Event Time:', 'lumina-child-theme'); ?></strong> <span style="color: red;">*</span></label><br>
            <input type="time" id="event_time" name="event_time" value="<?php echo esc_attr($event_time); ?>" class="widefat" required>
            <span class="description"><?php _e('Select the time when the event starts (required)', 'lumina-child-theme'); ?></span>
        </p>
        
        <p>
            <label for="event_location"><strong><?php _e('Event Location:', 'lumina-child-theme'); ?></strong> <span style="color: red;">*</span></label><br>
            <input type="text" id="event_location" name="event_location" value="<?php echo esc_attr($event_location); ?>" class="widefat" placeholder="e.g., School Auditorium, Sports Field, Main Hall" required>
            <span class="description"><?php _e('Enter the location where the event will take place (required)', 'lumina-child-theme'); ?></span>
        </p>
        
        <p>
            <label for="event_end_date"><strong><?php _e('Event End Date (Optional):', 'lumina-child-theme'); ?></strong></label><br>
            <input type="date" id="event_end_date" name="event_end_date" value="<?php echo esc_attr($event_end_date); ?>" class="widefat">
            <span class="description"><?php _e('If the event spans multiple days, select the end date (optional)', 'lumina-child-theme'); ?></span>
        </p>
    </div>
    
    <style>
        .lumina-event-meta-fields p {
            margin-bottom: 20px;
        }
        .lumina-event-meta-fields label {
            display: block;
            margin-bottom: 5px;
        }
        .lumina-event-meta-fields .description {
            display: block;
            margin-top: 5px;
            font-style: italic;
            color: #666;
        }
        .lumina-event-meta-fields input[type="date"],
        .lumina-event-meta-fields input[type="time"] {
            max-width: 300px;
        }
    </style>
    <?php
}

/**
 * Save event custom field data
 */
function lumina_save_event_meta_data($post_id) {
    // Check if nonce is set
    if (!isset($_POST['lumina_event_details_nonce_field'])) {
        return;
    }
    
    // Verify nonce
    if (!wp_verify_nonce($_POST['lumina_event_details_nonce_field'], 'lumina_event_details_nonce')) {
        return;
    }
    
    // Check if this is an autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // Check user permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Save event date (required)
    if (isset($_POST['event_date'])) {
        update_post_meta($post_id, 'event_date', sanitize_text_field($_POST['event_date']));
    }
    
    // Save event time (required)
    if (isset($_POST['event_time'])) {
        update_post_meta($post_id, 'event_time', sanitize_text_field($_POST['event_time']));
    }
    
    // Save event location (required)
    if (isset($_POST['event_location'])) {
        update_post_meta($post_id, 'event_location', sanitize_text_field($_POST['event_location']));
    }
    
    // Save event end date (optional)
    if (isset($_POST['event_end_date'])) {
        update_post_meta($post_id, 'event_end_date', sanitize_text_field($_POST['event_end_date']));
    }
}
add_action('save_post_lis_event', 'lumina_save_event_meta_data');

/**
 * Register Custom Post Type: Resources
 * Requirements: 12.1, 12.2, 12.3, 12.4, 12.5 - Downloadable resources management
 * Task 19: Create custom post type for Resources
 * 
 * This custom post type handles downloadable resources including admission forms,
 * academic policies, parent handbook, fee information, and calendar documents.
 */
function lumina_register_resources_post_type() {
    $labels = array(
        'name'                  => _x('Resources', 'Post Type General Name', 'lumina-child-theme'),
        'singular_name'         => _x('Resource', 'Post Type Singular Name', 'lumina-child-theme'),
        'menu_name'             => __('Resources', 'lumina-child-theme'),
        'name_admin_bar'        => __('Resource', 'lumina-child-theme'),
        'archives'              => __('Resource Archives', 'lumina-child-theme'),
        'attributes'            => __('Resource Attributes', 'lumina-child-theme'),
        'parent_item_colon'     => __('Parent Resource:', 'lumina-child-theme'),
        'all_items'             => __('All Resources', 'lumina-child-theme'),
        'add_new_item'          => __('Add New Resource', 'lumina-child-theme'),
        'add_new'               => __('Add New', 'lumina-child-theme'),
        'new_item'              => __('New Resource', 'lumina-child-theme'),
        'edit_item'             => __('Edit Resource', 'lumina-child-theme'),
        'update_item'           => __('Update Resource', 'lumina-child-theme'),
        'view_item'             => __('View Resource', 'lumina-child-theme'),
        'view_items'            => __('View Resources', 'lumina-child-theme'),
        'search_items'          => __('Search Resource', 'lumina-child-theme'),
        'not_found'             => __('Not found', 'lumina-child-theme'),
        'not_found_in_trash'    => __('Not found in Trash', 'lumina-child-theme'),
        'featured_image'        => __('Resource Thumbnail', 'lumina-child-theme'),
        'set_featured_image'    => __('Set resource thumbnail', 'lumina-child-theme'),
        'remove_featured_image' => __('Remove resource thumbnail', 'lumina-child-theme'),
        'use_featured_image'    => __('Use as resource thumbnail', 'lumina-child-theme'),
        'insert_into_item'      => __('Insert into resource', 'lumina-child-theme'),
        'uploaded_to_this_item' => __('Uploaded to this resource', 'lumina-child-theme'),
        'items_list'            => __('Resources list', 'lumina-child-theme'),
        'items_list_navigation' => __('Resources list navigation', 'lumina-child-theme'),
        'filter_items_list'     => __('Filter resources list', 'lumina-child-theme'),
    );
    
    $args = array(
        'label'                 => __('Resource', 'lumina-child-theme'),
        'description'           => __('Downloadable resources and documents', 'lumina-child-theme'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail', 'excerpt', 'revisions'),
        'taxonomies'            => array('resource_category'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 7,
        'menu_icon'             => 'dashicons-media-document',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true, // Enable Gutenberg editor
        'rewrite'               => array('slug' => 'resources', 'with_front' => false),
    );
    
    register_post_type('lis_resource', $args);
}
add_action('init', 'lumina_register_resources_post_type', 0);

/**
 * Register Resource Category Taxonomy
 * Requirements: 12.1 - Resource categories (Admission Forms, Academic Policies, etc.)
 */
function lumina_register_resource_category_taxonomy() {
    $labels = array(
        'name'                       => _x('Resource Categories', 'Taxonomy General Name', 'lumina-child-theme'),
        'singular_name'              => _x('Resource Category', 'Taxonomy Singular Name', 'lumina-child-theme'),
        'menu_name'                  => __('Resource Categories', 'lumina-child-theme'),
        'all_items'                  => __('All Categories', 'lumina-child-theme'),
        'parent_item'                => __('Parent Category', 'lumina-child-theme'),
        'parent_item_colon'          => __('Parent Category:', 'lumina-child-theme'),
        'new_item_name'              => __('New Category Name', 'lumina-child-theme'),
        'add_new_item'               => __('Add New Category', 'lumina-child-theme'),
        'edit_item'                  => __('Edit Category', 'lumina-child-theme'),
        'update_item'                => __('Update Category', 'lumina-child-theme'),
        'view_item'                  => __('View Category', 'lumina-child-theme'),
        'separate_items_with_commas' => __('Separate categories with commas', 'lumina-child-theme'),
        'add_or_remove_items'        => __('Add or remove categories', 'lumina-child-theme'),
        'choose_from_most_used'      => __('Choose from the most used', 'lumina-child-theme'),
        'popular_items'              => __('Popular Categories', 'lumina-child-theme'),
        'search_items'               => __('Search Categories', 'lumina-child-theme'),
        'not_found'                  => __('Not Found', 'lumina-child-theme'),
        'no_terms'                   => __('No categories', 'lumina-child-theme'),
        'items_list'                 => __('Categories list', 'lumina-child-theme'),
        'items_list_navigation'      => __('Categories list navigation', 'lumina-child-theme'),
    );
    
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => false,
        'show_in_rest'               => true,
        'rewrite'                    => array('slug' => 'resource-category'),
    );
    
    register_taxonomy('resource_category', array('lis_resource'), $args);
}
add_action('init', 'lumina_register_resource_category_taxonomy', 0);

/**
 * Add custom meta boxes for Resource custom fields
 * Requirements: 12.2, 12.3, 12.4, 12.5 - File upload, type, size, download count, access level
 */
function lumina_add_resource_meta_boxes() {
    add_meta_box(
        'lumina_resource_details',
        __('Resource Details', 'lumina-child-theme'),
        'lumina_resource_details_callback',
        'lis_resource',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'lumina_add_resource_meta_boxes');

/**
 * Meta box callback function for resource details
 */
function lumina_resource_details_callback($post) {
    // Add nonce for security
    wp_nonce_field('lumina_resource_details_nonce', 'lumina_resource_details_nonce_field');
    
    // Get existing values
    $file_url = get_post_meta($post->ID, '_resource_file_url', true);
    $file_type = get_post_meta($post->ID, '_resource_file_type', true);
    $file_size = get_post_meta($post->ID, '_resource_file_size', true);
    $download_count = get_post_meta($post->ID, '_resource_download_count', true);
    $access_level = get_post_meta($post->ID, '_resource_access_level', true);
    
    // Default values
    if (empty($download_count)) {
        $download_count = 0;
    }
    if (empty($access_level)) {
        $access_level = 'public';
    }
    
    // Display fields
    ?>
    <div class="lumina-resource-meta-fields">
        <p>
            <label for="resource_file_upload"><strong><?php _e('Upload File:', 'lumina-child-theme'); ?></strong> <span style="color: red;">*</span></label><br>
            <input type="text" id="resource_file_url" name="resource_file_url" value="<?php echo esc_attr($file_url); ?>" class="widefat" readonly>
            <button type="button" class="button resource-upload-button" data-target="resource_file_url"><?php _e('Upload File', 'lumina-child-theme'); ?></button>
            <button type="button" class="button resource-remove-button" data-target="resource_file_url" style="<?php echo empty($file_url) ? 'display:none;' : ''; ?>"><?php _e('Remove File', 'lumina-child-theme'); ?></button>
            <span class="description"><?php _e('Upload a file (PDF, DOC, DOCX, XLS, XLSX supported)', 'lumina-child-theme'); ?></span>
            <?php if (!empty($file_url)): ?>
                <div class="resource-file-preview" style="margin-top: 10px;">
                    <strong>Current File:</strong> <a href="<?php echo esc_url($file_url); ?>" target="_blank"><?php echo basename($file_url); ?></a>
                </div>
            <?php endif; ?>
        </p>
        
        <p>
            <label for="resource_file_type"><strong><?php _e('File Type:', 'lumina-child-theme'); ?></strong></label><br>
            <input type="text" id="resource_file_type" name="resource_file_type" value="<?php echo esc_attr($file_type); ?>" class="widefat" readonly>
            <span class="description"><?php _e('File type is automatically detected from the uploaded file', 'lumina-child-theme'); ?></span>
        </p>
        
        <p>
            <label for="resource_file_size"><strong><?php _e('File Size:', 'lumina-child-theme'); ?></strong></label><br>
            <input type="text" id="resource_file_size" name="resource_file_size" value="<?php echo esc_attr($file_size); ?>" class="widefat" readonly>
            <span class="description"><?php _e('File size is automatically calculated from the uploaded file', 'lumina-child-theme'); ?></span>
        </p>
        
        <p>
            <label for="resource_access_level"><strong><?php _e('Access Level:', 'lumina-child-theme'); ?></strong></label><br>
            <select id="resource_access_level" name="resource_access_level" class="widefat">
                <option value="public" <?php selected($access_level, 'public'); ?>><?php _e('Public - Anyone can download', 'lumina-child-theme'); ?></option>
                <option value="restricted" <?php selected($access_level, 'restricted'); ?>><?php _e('Restricted - Logged in users only', 'lumina-child-theme'); ?></option>
            </select>
            <span class="description"><?php _e('Choose who can access this resource', 'lumina-child-theme'); ?></span>
        </p>
        
        <p>
            <label for="resource_download_count"><strong><?php _e('Download Count:', 'lumina-child-theme'); ?></strong></label><br>
            <input type="number" id="resource_download_count" name="resource_download_count" value="<?php echo esc_attr($download_count); ?>" class="widefat" readonly>
            <span class="description"><?php _e('Total number of times this resource has been downloaded (automatically tracked)', 'lumina-child-theme'); ?></span>
        </p>
    </div>
    
    <style>
        .lumina-resource-meta-fields p {
            margin-bottom: 20px;
        }
        .lumina-resource-meta-fields label {
            display: block;
            margin-bottom: 5px;
        }
        .lumina-resource-meta-fields .description {
            display: block;
            margin-top: 5px;
            font-style: italic;
            color: #666;
        }
        .resource-upload-button,
        .resource-remove-button {
            margin-top: 5px;
        }
        .resource-file-preview {
            padding: 10px;
            background: #f7f7f7;
            border-radius: 4px;
        }
    </style>
    
    <script>
    jQuery(document).ready(function($) {
        var mediaUploader;
        
        $('.resource-upload-button').on('click', function(e) {
            e.preventDefault();
            var button = $(this);
            var targetInput = $('#' + button.data('target'));
            
            // If the uploader object has already been created, reopen the dialog
            if (mediaUploader) {
                mediaUploader.open();
                return;
            }
            
            // Extend the wp.media object
            mediaUploader = wp.media({
                title: 'Choose Resource File',
                button: {
                    text: 'Use this file'
                },
                library: {
                    type: ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']
                },
                multiple: false
            });
            
            // When a file is selected, run a callback
            mediaUploader.on('select', function() {
                var attachment = mediaUploader.state().get('selection').first().toJSON();
                targetInput.val(attachment.url);
                
                // Auto-detect file type
                var fileExtension = attachment.filename.split('.').pop().toUpperCase();
                $('#resource_file_type').val(fileExtension);
                
                // Auto-calculate file size
                var fileSize = attachment.filesizeHumanReadable;
                $('#resource_file_size').val(fileSize);
                
                // Show remove button and file preview
                button.next('.resource-remove-button').show();
                
                // Update or create preview
                var preview = button.parent().find('.resource-file-preview');
                if (preview.length) {
                    preview.find('a').attr('href', attachment.url).text(attachment.filename);
                } else {
                    button.parent().append('<div class="resource-file-preview" style="margin-top: 10px;"><strong>Current File:</strong> <a href="' + attachment.url + '" target="_blank">' + attachment.filename + '</a></div>');
                }
            });
            
            // Open the uploader dialog
            mediaUploader.open();
        });
        
        $('.resource-remove-button').on('click', function(e) {
            e.preventDefault();
            var button = $(this);
            var targetInput = $('#' + button.data('target'));
            
            targetInput.val('');
            $('#resource_file_type').val('');
            $('#resource_file_size').val('');
            button.hide();
            button.parent().find('.resource-file-preview').remove();
        });
    });
    </script>
    <?php
}

/**
 * Save resource custom field data
 */
function lumina_save_resource_meta_data($post_id) {
    // Check if nonce is set
    if (!isset($_POST['lumina_resource_details_nonce_field'])) {
        return;
    }
    
    // Verify nonce
    if (!wp_verify_nonce($_POST['lumina_resource_details_nonce_field'], 'lumina_resource_details_nonce')) {
        return;
    }
    
    // Check if this is an autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // Check user permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Save file URL (required)
    if (isset($_POST['resource_file_url'])) {
        update_post_meta($post_id, '_resource_file_url', esc_url_raw($_POST['resource_file_url']));
    }
    
    // Save file type
    if (isset($_POST['resource_file_type'])) {
        update_post_meta($post_id, '_resource_file_type', sanitize_text_field($_POST['resource_file_type']));
    }
    
    // Save file size
    if (isset($_POST['resource_file_size'])) {
        update_post_meta($post_id, '_resource_file_size', sanitize_text_field($_POST['resource_file_size']));
    }
    
    // Save access level
    if (isset($_POST['resource_access_level'])) {
        update_post_meta($post_id, '_resource_access_level', sanitize_text_field($_POST['resource_access_level']));
    }
    
    // Save download count (don't allow manual editing, but preserve value)
    if (isset($_POST['resource_download_count'])) {
        $current_count = get_post_meta($post_id, '_resource_download_count', true);
        if (empty($current_count)) {
            update_post_meta($post_id, '_resource_download_count', 0);
        }
    }
}
add_action('save_post_lis_resource', 'lumina_save_resource_meta_data');

/**
 * Handle resource download tracking
 * Requirements: 12.5 - Track download counts for administrative reporting
 */
function lumina_track_resource_download() {
    if (isset($_GET['download_resource']) && !empty($_GET['download_resource'])) {
        $resource_id = intval($_GET['download_resource']);
        
        // Verify this is a valid resource post
        if (get_post_type($resource_id) !== 'lis_resource') {
            return;
        }
        
        // Check access level
        $access_level = get_post_meta($resource_id, '_resource_access_level', true);
        if ($access_level === 'restricted' && !is_user_logged_in()) {
            wp_die('You must be logged in to download this resource.', 'Access Denied', array('response' => 403));
        }
        
        // Get file URL
        $file_url = get_post_meta($resource_id, '_resource_file_url', true);
        
        if (empty($file_url)) {
            wp_die('Resource file not found.', 'File Not Found', array('response' => 404));
        }
        
        // Increment download count
        $current_count = get_post_meta($resource_id, '_resource_download_count', true);
        $new_count = intval($current_count) + 1;
        update_post_meta($resource_id, '_resource_download_count', $new_count);
        
        // Redirect to file or initiate download
        wp_redirect($file_url);
        exit;
    }
}
add_action('template_redirect', 'lumina_track_resource_download');

/**
 * Flush rewrite rules on theme activation to ensure custom post type URLs work
 */
function lumina_flush_rewrite_rules_on_activation() {
    lumina_register_programs_post_type();
    lumina_register_program_category_taxonomy();
    lumina_register_events_post_type();
    lumina_register_event_category_taxonomy();
    lumina_register_resources_post_type();
    lumina_register_resource_category_taxonomy();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'lumina_flush_rewrite_rules_on_activation');

/**
 * Include Elementor configuration
 */
require_once get_stylesheet_directory() . '/elementor-config.php';

/**
 * Include Admission Form Handler
 */
if (file_exists(get_stylesheet_directory() . '/inc/admission-form-handler.php')) {
    require_once get_stylesheet_directory() . '/inc/admission-form-handler.php';
}

/**
 * Shortcode: Display programs grid with expandable sections
 * Requirements: 1.3 - Display detailed information for each grade level
 * Task 9: Build Programs page and populate grade levels
 * 
 * Usage: [lumina_programs_grid]
 */
function lumina_programs_grid_shortcode() {
    // Query all programs ordered by menu_order
    $args = array(
        'post_type' => 'lis_program',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'orderby' => 'menu_order',
        'order' => 'ASC',
    );
    
    $programs_query = new WP_Query($args);
    
    ob_start();
    
    if ($programs_query->have_posts()) {
        echo '<div class="lumina-programs-grid">';
        
        while ($programs_query->have_posts()) {
            $programs_query->the_post();
            $program_id = get_the_ID();
            $age_range = get_post_meta($program_id, '_program_age_range', true);
            $curriculum = get_post_meta($program_id, '_program_curriculum_highlights', true);
            $categories = get_the_terms($program_id, 'program_category');
            
            echo '<div class="program-card" data-program-id="' . $program_id . '">';
            
            // Program header (always visible)
            echo '<div class="program-header">';
            
            if (has_post_thumbnail()) {
                echo '<div class="program-image">';
                the_post_thumbnail('medium', array('alt' => get_the_title()));
                echo '</div>';
            }
            
            echo '<div class="program-header-content">';
            echo '<h3 class="program-title">' . get_the_title() . '</h3>';
            
            if ($age_range) {
                echo '<p class="program-age-range"><strong>Age Range:</strong> ' . esc_html($age_range) . '</p>';
            }
            
            if ($categories && !is_wp_error($categories)) {
                echo '<div class="program-categories">';
                foreach ($categories as $category) {
                    echo '<span class="program-category-badge">' . esc_html($category->name) . '</span>';
                }
                echo '</div>';
            }
            
            echo '<button class="program-toggle" aria-expanded="false" aria-controls="program-details-' . $program_id . '">';
            echo '<span class="toggle-text">View Details</span>';
            echo '<span class="toggle-icon">+</span>';
            echo '</button>';
            
            echo '</div>'; // .program-header-content
            echo '</div>'; // .program-header
            
            // Program details (expandable)
            echo '<div class="program-details" id="program-details-' . $program_id . '" style="display: none;">';
            
            echo '<div class="program-description">';
            echo '<h4>About This Program</h4>';
            echo '<div class="program-content">' . wpautop(get_the_content()) . '</div>';
            echo '</div>';
            
            if ($curriculum) {
                echo '<div class="program-curriculum">';
                echo '<h4>Curriculum Highlights</h4>';
                echo '<ul class="curriculum-list">';
                
                $highlights = explode("\n", $curriculum);
                foreach ($highlights as $highlight) {
                    $highlight = trim($highlight);
                    if (!empty($highlight)) {
                        echo '<li>' . esc_html($highlight) . '</li>';
                    }
                }
                
                echo '</ul>';
                echo '</div>';
            }
            
            echo '<div class="program-actions">';
            echo '<a href="' . get_permalink() . '" class="program-link">Learn More</a>';
            echo '<a href="/admissions" class="program-apply-btn">Apply Now</a>';
            echo '</div>';
            
            echo '</div>'; // .program-details
            
            echo '</div>'; // .program-card
        }
        
        echo '</div>'; // .lumina-programs-grid
        
        // Add CSS for programs grid
        echo '<style>
        .lumina-programs-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 30px;
            margin: 30px 0;
        }
        
        .program-card {
            background: #FFFFFF;
            border: 2px solid #7EBEC5;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .program-card:hover {
            box-shadow: 0 8px 20px rgba(0, 61, 112, 0.15);
        }
        
        .program-header {
            display: flex;
            flex-direction: column;
            padding: 0;
        }
        
        .program-image {
            width: 100%;
            height: 250px;
            overflow: hidden;
        }
        
        .program-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .program-header-content {
            padding: 25px;
        }
        
        .program-title {
            color: #003d70;
            font-size: 28px;
            margin: 0 0 15px 0;
            font-weight: 700;
        }
        
        .program-age-range {
            color: #666;
            font-size: 16px;
            margin: 10px 0;
        }
        
        .program-categories {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin: 15px 0;
        }
        
        .program-category-badge {
            background: #7EBEC5;
            color: #FFFFFF;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }
        
        .program-toggle {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            background: #F39A3B;
            color: #FFFFFF;
            border: none;
            padding: 15px 20px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            border-radius: 8px;
            margin-top: 20px;
            transition: all 0.3s ease;
        }
        
        .program-toggle:hover {
            background: #003d70;
        }
        
        .program-toggle:focus {
            outline: 2px solid #7EBEC5;
            outline-offset: 2px;
        }
        
        .toggle-icon {
            font-size: 24px;
            font-weight: 700;
            transition: transform 0.3s ease;
        }
        
        .program-toggle[aria-expanded="true"] .toggle-icon {
            transform: rotate(45deg);
        }
        
        .program-toggle[aria-expanded="true"] .toggle-text::after {
            content: " Less";
        }
        
        .program-details {
            padding: 0 25px 25px 25px;
            background: #f7f7f7;
        }
        
        .program-details h4 {
            color: #003d70;
            font-size: 20px;
            margin: 20px 0 15px 0;
            padding-top: 20px;
            border-top: 2px solid #7EBEC5;
        }
        
        .program-details h4:first-child {
            border-top: none;
            padding-top: 20px;
        }
        
        .program-description {
            margin-bottom: 20px;
        }
        
        .program-content {
            color: #333;
            line-height: 1.8;
        }
        
        .program-content p {
            margin-bottom: 15px;
        }
        
        .program-curriculum {
            margin-bottom: 20px;
        }
        
        .curriculum-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .curriculum-list li {
            position: relative;
            padding-left: 30px;
            margin-bottom: 12px;
            color: #333;
            line-height: 1.6;
        }
        
        .curriculum-list li::before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #7EBEC5;
            font-weight: 700;
            font-size: 18px;
        }
        
        .program-actions {
            display: flex;
            gap: 15px;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 2px solid #FFFFFF;
        }
        
        .program-link,
        .program-apply-btn {
            flex: 1;
            text-align: center;
            padding: 12px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .program-link {
            background: #FFFFFF;
            color: #003d70;
            border: 2px solid #003d70;
        }
        
        .program-link:hover {
            background: #003d70;
            color: #FFFFFF;
        }
        
        .program-apply-btn {
            background: #F39A3B;
            color: #FFFFFF;
            border: 2px solid #F39A3B;
        }
        
        .program-apply-btn:hover {
            background: #FFFFFF;
            color: #F39A3B;
        }
        
        /* Responsive design */
        @media (min-width: 768px) {
            .program-header {
                flex-direction: row;
            }
            
            .program-image {
                width: 300px;
                height: auto;
                min-height: 250px;
            }
            
            .program-header-content {
                flex: 1;
            }
        }
        
        @media (min-width: 1024px) {
            .program-image {
                width: 350px;
            }
        }
        </style>';
        
        // Add JavaScript for toggle functionality
        echo '<script>
        (function() {
            document.addEventListener("DOMContentLoaded", function() {
                const toggleButtons = document.querySelectorAll(".program-toggle");
                
                toggleButtons.forEach(function(button) {
                    button.addEventListener("click", function() {
                        const isExpanded = this.getAttribute("aria-expanded") === "true";
                        const detailsId = this.getAttribute("aria-controls");
                        const details = document.getElementById(detailsId);
                        
                        if (isExpanded) {
                            // Collapse
                            this.setAttribute("aria-expanded", "false");
                            details.style.display = "none";
                            this.querySelector(".toggle-text").textContent = "View Details";
                        } else {
                            // Expand
                            this.setAttribute("aria-expanded", "true");
                            details.style.display = "block";
                            this.querySelector(".toggle-text").textContent = "Hide Details";
                            
                            // Smooth scroll to the expanded section
                            setTimeout(function() {
                                details.scrollIntoView({ behavior: "smooth", block: "nearest" });
                            }, 100);
                        }
                    });
                });
            });
        })();
        </script>';
        
    } else {
        echo '<div class="lumina-programs-grid">';
        echo '<p style="text-align: center; color: #666; padding: 60px 20px; background: #f7f7f7; border-radius: 8px;">No programs available at this time. Please check back soon!</p>';
        echo '</div>';
    }
    
    wp_reset_postdata();
    
    return ob_get_clean();
}
add_shortcode('lumina_programs_grid', 'lumina_programs_grid_shortcode');

/**
 * Shortcode: Display news category filter buttons
 * Requirements: 11.5 - Support categorizing news articles by topics
 * Task 18: Build News page with article listing
 * 
 * Usage: [lumina_news_categories]
 */
function lumina_news_categories_shortcode() {
    $categories = get_categories(array(
        'orderby' => 'name',
        'order' => 'ASC',
        'hide_empty' => true,
    ));
    
    ob_start();
    
    echo '<div class="lumina-news-categories">';
    echo '<div class="category-filter-buttons">';
    
    // All News button
    $current_category = get_query_var('cat');
    $all_active = empty($current_category) ? 'active' : '';
    $news_page_url = get_permalink(get_page_by_path('news'));
    
    echo '<a href="' . esc_url($news_page_url) . '" class="category-filter-btn ' . $all_active . '" data-category="all">';
    echo 'All News';
    echo '</a>';
    
    // Category buttons
    foreach ($categories as $category) {
        if ($category->slug !== 'uncategorized') {
            $is_active = ($current_category == $category->term_id) ? 'active' : '';
            echo '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="category-filter-btn ' . $is_active . '" data-category="' . esc_attr($category->slug) . '">';
            echo esc_html($category->name);
            echo '</a>';
        }
    }
    
    echo '</div>';
    echo '</div>';
    
    // Add CSS for category filter
    echo '<style>
    .lumina-news-categories {
        background: #FFFFFF;
        padding: 25px 30px;
        border-radius: 12px;
        margin-bottom: 40px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }
    
    .category-filter-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        justify-content: center;
    }
    
    .category-filter-btn {
        padding: 12px 24px;
        background: #f7f7f7;
        color: #003d70;
        text-decoration: none;
        border-radius: 25px;
        font-size: 15px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }
    
    .category-filter-btn:hover {
        background: #7EBEC5;
        color: #FFFFFF;
        transform: translateY(-2px);
    }
    
    .category-filter-btn.active {
        background: #003d70;
        color: #FFFFFF;
        border-color: #003d70;
    }
    
    @media (max-width: 768px) {
        .lumina-news-categories {
            padding: 20px;
        }
        
        .category-filter-buttons {
            flex-direction: column;
        }
        
        .category-filter-btn {
            text-align: center;
        }
    }
    </style>';
    
    return ob_get_clean();
}
add_shortcode('lumina_news_categories', 'lumina_news_categories_shortcode');

/**
 * Shortcode: Display news articles grid with pagination
 * Requirements: 11.1, 11.2, 11.3, 11.5 - Display articles with all required fields
 * Task 18: Build News page with article listing
 * 
 * Usage: [lumina_news_grid posts_per_page="9"]
 */
function lumina_news_grid_shortcode($atts) {
    $atts = shortcode_atts(array(
        'posts_per_page' => 9,
        'category' => '',
    ), $atts);
    
    // Get current page for pagination
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    
    // Build query args
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => intval($atts['posts_per_page']),
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC', // Reverse chronological order (Requirement 11.1)
        'paged' => $paged,
    );
    
    // Add category filter if specified
    if (!empty($atts['category'])) {
        $args['category_name'] = $atts['category'];
    }
    
    // Check if we're on a category page
    if (is_category()) {
        $args['cat'] = get_query_var('cat');
    }
    
    $news_query = new WP_Query($args);
    
    ob_start();
    
    if ($news_query->have_posts()) {
        echo '<div class="lumina-news-grid">';
        
        while ($news_query->have_posts()) {
            $news_query->the_post();
            $post_id = get_the_ID();
            $categories = get_the_category();
            
            echo '<article id="post-' . $post_id . '" class="news-grid-card">';
            
            // Featured Image (Requirement 11.3)
            if (has_post_thumbnail()) {
                echo '<div class="news-card-image">';
                echo '<a href="' . get_permalink() . '">';
                the_post_thumbnail('lumina-news', array('alt' => get_the_title()));
                echo '</a>';
                
                // Category badge
                if (!empty($categories)) {
                    $primary_category = $categories[0];
                    echo '<span class="news-category-badge">' . esc_html($primary_category->name) . '</span>';
                }
                
                echo '</div>';
            } else {
                // Placeholder if no featured image
                echo '<div class="news-card-image news-card-placeholder">';
                echo '<a href="' . get_permalink() . '">';
                echo '<div class="placeholder-content">';
                echo '<span class="placeholder-icon">📰</span>';
                echo '</div>';
                echo '</a>';
                
                if (!empty($categories)) {
                    $primary_category = $categories[0];
                    echo '<span class="news-category-badge">' . esc_html($primary_category->name) . '</span>';
                }
                
                echo '</div>';
            }
            
            // Article Content
            echo '<div class="news-card-content">';
            
            // Title (Requirement 11.2)
            echo '<h3 class="news-card-title">';
            echo '<a href="' . get_permalink() . '">' . get_the_title() . '</a>';
            echo '</h3>';
            
            // Meta Information - Date and Author (Requirement 11.2)
            echo '<div class="news-card-meta">';
            echo '<span class="news-card-date">';
            echo '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">';
            echo '<path d="M11 2h1a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h1V1h2v1h4V1h2v1zm1 3H4v8h8V5z"/>';
            echo '</svg>';
            echo get_the_date('F j, Y');
            echo '</span>';
            
            echo '<span class="news-card-author">';
            echo '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">';
            echo '<path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 1c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>';
            echo '</svg>';
            echo 'By ' . get_the_author();
            echo '</span>';
            echo '</div>';
            
            // Excerpt (Requirement 11.2)
            echo '<div class="news-card-excerpt">';
            the_excerpt();
            echo '</div>';
            
            // Read More Link
            echo '<a href="' . get_permalink() . '" class="news-card-read-more">';
            echo 'Read Full Article';
            echo '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">';
            echo '<path d="M8 0l8 8-8 8V0z"/>';
            echo '</svg>';
            echo '</a>';
            
            echo '</div>'; // .news-card-content
            
            echo '</article>';
        }
        
        echo '</div>'; // .lumina-news-grid
        
        // Pagination
        if ($news_query->max_num_pages > 1) {
            echo '<div class="lumina-news-pagination">';
            
            $pagination_args = array(
                'total' => $news_query->max_num_pages,
                'current' => $paged,
                'mid_size' => 2,
                'prev_text' => '← Previous',
                'next_text' => 'Next →',
                'type' => 'list',
            );
            
            echo paginate_links($pagination_args);
            
            echo '</div>';
        }
        
    } else {
        echo '<div class="lumina-news-grid">';
        echo '<div class="no-news-found">';
        echo '<div class="no-news-icon">📰</div>';
        echo '<h3>No News Articles Found</h3>';
        echo '<p>There are currently no news articles in this category. Please check back later or browse other categories.</p>';
        echo '<a href="' . get_permalink(get_page_by_path('news')) . '" class="back-to-all-news">View All News</a>';
        echo '</div>';
        echo '</div>';
    }
    
    wp_reset_postdata();
    
    // Add CSS for news grid
    echo '<style>
    .lumina-news-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 30px;
        margin-bottom: 40px;
    }
    
    .news-grid-card {
        background: #FFFFFF;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
    }
    
    .news-grid-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 61, 112, 0.15);
    }
    
    .news-card-image {
        position: relative;
        width: 100%;
        height: 220px;
        overflow: hidden;
        background: #f7f7f7;
    }
    
    .news-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .news-grid-card:hover .news-card-image img {
        transform: scale(1.05);
    }
    
    .news-card-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #7EBEC5 0%, #003d70 100%);
    }
    
    .placeholder-content {
        text-align: center;
    }
    
    .placeholder-icon {
        font-size: 70px;
        opacity: 0.3;
    }
    
    .news-category-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: #F39A3B;
        color: #FFFFFF;
        padding: 6px 15px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }
    
    .news-card-content {
        padding: 25px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    
    .news-card-title {
        margin: 0 0 15px 0;
        font-size: 20px;
        line-height: 1.4;
    }
    
    .news-card-title a {
        color: #003d70;
        text-decoration: none;
        transition: color 0.3s ease;
    }
    
    .news-card-title a:hover {
        color: #7EBEC5;
    }
    
    .news-card-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #f7f7f7;
    }
    
    .news-card-date,
    .news-card-author {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #999;
        font-size: 13px;
    }
    
    .news-card-date svg,
    .news-card-author svg {
        color: #7EBEC5;
    }
    
    .news-card-excerpt {
        color: #666;
        line-height: 1.7;
        margin-bottom: 20px;
        flex: 1;
    }
    
    .news-card-excerpt p {
        margin: 0;
    }
    
    .news-card-read-more {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #F39A3B;
        text-decoration: none;
        font-weight: 600;
        font-size: 15px;
        transition: all 0.3s ease;
        align-self: flex-start;
    }
    
    .news-card-read-more:hover {
        color: #003d70;
        gap: 12px;
    }
    
    .news-card-read-more svg {
        transition: transform 0.3s ease;
    }
    
    .news-card-read-more:hover svg {
        transform: translateX(3px);
    }
    
    /* No News Found */
    .no-news-found {
        grid-column: 1 / -1;
        text-align: center;
        padding: 80px 20px;
        background: #FFFFFF;
        border-radius: 12px;
    }
    
    .no-news-icon {
        font-size: 80px;
        margin-bottom: 20px;
        opacity: 0.3;
    }
    
    .no-news-found h3 {
        color: #003d70;
        font-size: 28px;
        margin-bottom: 15px;
    }
    
    .no-news-found p {
        color: #666;
        font-size: 16px;
        line-height: 1.6;
        margin-bottom: 30px;
    }
    
    .back-to-all-news {
        display: inline-block;
        padding: 12px 30px;
        background: #F39A3B;
        color: #FFFFFF;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .back-to-all-news:hover {
        background: #003d70;
    }
    
    /* Pagination */
    .lumina-news-pagination {
        margin-top: 40px;
        text-align: center;
    }
    
    .lumina-news-pagination .page-numbers {
        display: inline-flex;
        justify-content: center;
        gap: 10px;
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .lumina-news-pagination .page-numbers li {
        display: inline-block;
    }
    
    .lumina-news-pagination a,
    .lumina-news-pagination span {
        display: inline-block;
        padding: 10px 18px;
        background: #FFFFFF;
        color: #003d70;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: 2px solid #f7f7f7;
    }
    
    .lumina-news-pagination a:hover,
    .lumina-news-pagination .current {
        background: #003d70;
        color: #FFFFFF;
        border-color: #003d70;
    }
    
    .lumina-news-pagination .dots {
        background: transparent;
        border: none;
        cursor: default;
    }
    
    .lumina-news-pagination .dots:hover {
        background: transparent;
        color: #003d70;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .lumina-news-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        
        .news-card-meta {
            flex-direction: column;
            gap: 10px;
        }
        
        .news-card-content {
            padding: 20px;
        }
    }
    
    @media (max-width: 480px) {
        .news-card-image {
            height: 200px;
        }
        
        .news-card-title {
            font-size: 18px;
        }
    }
    </style>';
    
    return ob_get_clean();
}
add_shortcode('lumina_news_grid', 'lumina_news_grid_shortcode');

/**
 * Shortcode: Display resources grid
 * Requirements: 12.1, 12.2, 12.3, 12.4 - Display resources with filtering
 * Task 20: Build Resources page with downloadable documents
 * 
 * Usage: [lumina_resources_grid]
 */
function lumina_resources_grid_shortcode($atts) {
    $atts = shortcode_atts(array(
        'category' => '',
        'limit' => -1,
    ), $atts);
    
    // Build query args
    $args = array(
        'post_type' => 'lis_resource',
        'posts_per_page' => intval($atts['limit']),
        'post_status' => 'publish',
        'orderby' => 'title',
        'order' => 'ASC',
    );
    
    // Add category filter if specified
    if (!empty($atts['category'])) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'resource_category',
                'field' => 'slug',
                'terms' => $atts['category'],
            ),
        );
    }
    
    $resources_query = new WP_Query($args);
    
    ob_start();
    
    if ($resources_query->have_posts()) {
        echo '<div class="lumina-resources-grid-shortcode">';
        echo '<div class="resources-grid-container">';
        
        while ($resources_query->have_posts()) {
            $resources_query->the_post();
            
            $resource_id = get_the_ID();
            $file_url = get_post_meta($resource_id, '_resource_file_url', true);
            $file_type = get_post_meta($resource_id, '_resource_file_type', true);
            $file_size = get_post_meta($resource_id, '_resource_file_size', true);
            $download_count = get_post_meta($resource_id, '_resource_download_count', true);
            $access_level = get_post_meta($resource_id, '_resource_access_level', true);
            $categories = get_the_terms($resource_id, 'resource_category');
            
            // Get file icon based on type
            $file_icon = '📄';
            if (!empty($file_type)) {
                switch (strtoupper($file_type)) {
                    case 'PDF':
                        $file_icon = '📕';
                        break;
                    case 'DOC':
                    case 'DOCX':
                        $file_icon = '📘';
                        break;
                    case 'XLS':
                    case 'XLSX':
                        $file_icon = '📊';
                        break;
                }
            }
            
            echo '<div class="resource-grid-card">';
            echo '<div class="resource-grid-icon">' . $file_icon . '</div>';
            echo '<div class="resource-grid-content">';
            echo '<h3 class="resource-grid-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
            
            if ($categories && !is_wp_error($categories)) {
                echo '<div class="resource-grid-categories">';
                foreach ($categories as $category) {
                    echo '<span class="resource-grid-category-badge">' . esc_html($category->name) . '</span>';
                }
                echo '</div>';
            }
            
            echo '<div class="resource-grid-excerpt">' . get_the_excerpt() . '</div>';
            
            echo '<div class="resource-grid-meta">';
            if (!empty($file_type)) {
                echo '<span class="resource-grid-type"><strong>Type:</strong> ' . esc_html($file_type) . '</span>';
            }
            if (!empty($file_size)) {
                echo '<span class="resource-grid-size"><strong>Size:</strong> ' . esc_html($file_size) . '</span>';
            }
            if (!empty($download_count)) {
                echo '<span class="resource-grid-downloads"><strong>Downloads:</strong> ' . number_format($download_count) . '</span>';
            }
            echo '</div>';
            
            echo '<div class="resource-grid-actions">';
            if (!empty($file_url)) {
                if ($access_level === 'restricted' && !is_user_logged_in()) {
                    echo '<a href="' . wp_login_url(get_permalink()) . '" class="resource-grid-download-btn restricted">🔒 Login to Download</a>';
                } else {
                    $download_url = add_query_arg('download_resource', $resource_id, home_url('/'));
                    echo '<a href="' . esc_url($download_url) . '" class="resource-grid-download-btn" target="_blank">⬇️ Download</a>';
                }
            }
            echo '<a href="' . get_permalink() . '" class="resource-grid-view-btn">View Details</a>';
            echo '</div>';
            
            echo '</div>';
            echo '</div>';
        }
        
        echo '</div>';
        echo '</div>';
        
        // Add CSS for resources grid
        echo '<style>
        .lumina-resources-grid-shortcode {
            margin: 30px 0;
        }
        .resources-grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
        }
        .resource-grid-card {
            background: #FFFFFF;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            display: flex;
            gap: 20px;
        }
        .resource-grid-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 61, 112, 0.15);
        }
        .resource-grid-icon {
            font-size: 50px;
            flex-shrink: 0;
        }
        .resource-grid-content {
            flex: 1;
        }
        .resource-grid-title {
            margin: 0 0 12px 0;
            font-size: 20px;
            line-height: 1.4;
        }
        .resource-grid-title a {
            color: #003d70;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .resource-grid-title a:hover {
            color: #7EBEC5;
        }
        .resource-grid-categories {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 12px;
        }
        .resource-grid-category-badge {
            background: #7EBEC5;
            color: #FFFFFF;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
        }
        .resource-grid-excerpt {
            color: #666;
            line-height: 1.6;
            margin-bottom: 15px;
            font-size: 14px;
        }
        .resource-grid-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 20px;
            padding: 15px;
            background: #f7f7f7;
            border-radius: 8px;
            font-size: 13px;
        }
        .resource-grid-meta span {
            color: #666;
        }
        .resource-grid-meta strong {
            color: #003d70;
        }
        .resource-grid-actions {
            display: flex;
            gap: 10px;
        }
        .resource-grid-download-btn,
        .resource-grid-view-btn {
            flex: 1;
            text-align: center;
            padding: 12px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .resource-grid-download-btn {
            background: #F39A3B;
            color: #FFFFFF;
        }
        .resource-grid-download-btn:hover {
            background: #003d70;
        }
        .resource-grid-download-btn.restricted {
            background: #999;
        }
        .resource-grid-download-btn.restricted:hover {
            background: #666;
        }
        .resource-grid-view-btn {
            background: #FFFFFF;
            color: #003d70;
            border: 2px solid #003d70;
        }
        .resource-grid-view-btn:hover {
            background: #003d70;
            color: #FFFFFF;
        }
        
        @media (max-width: 768px) {
            .resources-grid-container {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            .resource-grid-card {
                flex-direction: column;
                text-align: center;
            }
            .resource-grid-icon {
                font-size: 60px;
            }
            .resource-grid-actions {
                flex-direction: column;
            }
        }
        </style>';
        
    } else {
        echo '<div class="lumina-resources-grid-shortcode">';
        echo '<div class="no-resources-message" style="text-align: center; padding: 60px 20px; background: #FFFFFF; border-radius: 12px;">';
        echo '<div style="font-size: 60px; margin-bottom: 20px; opacity: 0.3;">📁</div>';
        echo '<h3 style="color: #003d70; font-size: 24px; margin-bottom: 15px;">No Resources Found</h3>';
        echo '<p style="color: #666; font-size: 16px;">There are currently no resources available. Please check back later.</p>';
        echo '</div>';
        echo '</div>';
    }
    
    wp_reset_postdata();
    
    return ob_get_clean();
}
add_shortcode('lumina_resources_grid', 'lumina_resources_grid_shortcode');

/**
 * Shortcode: Display filterable gallery with categories
 * Requirements: 4.1, 4.2, 4.3, 4.4, 4.5
 * 
 * Usage: [lumina_gallery]
 */
function lumina_gallery_shortcode($atts) {
    $atts = shortcode_atts(array(
        'category' => '',
    ), $atts);
    
    // Get all attachments (images)
    $args = array(
        'post_type' => 'attachment',
        'post_mime_type' => array('image/jpeg', 'image/png', 'image/webp'),
        'post_status' => 'inherit',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'DESC',
    );
    
    $attachments = get_posts($args);
    
    // Organize images by category (using alt text or custom taxonomy)
    $categorized_images = array(
        'all' => array(),
        'events' => array(),
        'facilities' => array(),
        'activities' => array(),
        'achievements' => array(),
    );
    
    foreach ($attachments as $attachment) {
        $image_data = array(
            'id' => $attachment->ID,
            'url' => wp_get_attachment_url($attachment->ID),
            'thumb' => wp_get_attachment_image_url($attachment->ID, 'lumina-gallery-thumb'),
            'full' => wp_get_attachment_image_url($attachment->ID, 'full'),
            'title' => get_the_title($attachment->ID),
            'alt' => get_post_meta($attachment->ID, '_wp_attachment_image_alt', true),
        );
        
        // Add to 'all' category
        $categorized_images['all'][] = $image_data;
        
        // Categorize based on alt text or title keywords
        $search_text = strtolower($image_data['title'] . ' ' . $image_data['alt']);
        
        if (strpos($search_text, 'event') !== false) {
            $categorized_images['events'][] = $image_data;
        }
        if (strpos($search_text, 'facility') !== false || strpos($search_text, 'classroom') !== false || 
            strpos($search_text, 'library') !== false || strpos($search_text, 'playground') !== false) {
            $categorized_images['facilities'][] = $image_data;
        }
        if (strpos($search_text, 'activity') !== false || strpos($search_text, 'activities') !== false) {
            $categorized_images['activities'][] = $image_data;
        }
        if (strpos($search_text, 'achievement') !== false || strpos($search_text, 'award') !== false) {
            $categorized_images['achievements'][] = $image_data;
        }
    }
    
    ob_start();
    
    if (!empty($categorized_images['all'])) {
        ?>
        <div class="lumina-gallery-container">
            <!-- Category Filter Tabs -->
            <div class="gallery-filter-tabs">
                <button class="gallery-tab active" data-category="all">All Images</button>
                <button class="gallery-tab" data-category="events">Events</button>
                <button class="gallery-tab" data-category="facilities">Facilities</button>
                <button class="gallery-tab" data-category="activities">Activities</button>
                <button class="gallery-tab" data-category="achievements">Achievements</button>
            </div>
            
            <!-- Gallery Grid -->
            <div class="gallery-grid" id="lumina-gallery-grid">
                <?php foreach ($categorized_images as $category => $images): ?>
                    <?php foreach ($images as $image): ?>
                        <div class="gallery-item" data-category="<?php echo esc_attr($category); ?>" data-image-id="<?php echo esc_attr($image['id']); ?>">
                            <img 
                                src="<?php echo esc_url($image['thumb']); ?>" 
                                data-full="<?php echo esc_url($image['full']); ?>"
                                alt="<?php echo esc_attr($image['alt'] ?: $image['title']); ?>"
                                loading="lazy"
                                class="gallery-image"
                            />
                            <div class="gallery-overlay">
                                <span class="gallery-zoom-icon">🔍</span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </div>
            
            <!-- Lightbox -->
            <div class="gallery-lightbox" id="gallery-lightbox">
                <button class="lightbox-close" aria-label="Close lightbox">&times;</button>
                <button class="lightbox-prev" aria-label="Previous image">‹</button>
                <button class="lightbox-next" aria-label="Next image">›</button>
                <div class="lightbox-content">
                    <img src="" alt="" id="lightbox-image" />
                </div>
            </div>
        </div>
        <?php
        
        // Add CSS
        echo '<style>
        .lumina-gallery-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        /* Filter Tabs */
        .gallery-filter-tabs {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 40px;
            padding: 20px;
            background: #FFFFFF;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        .gallery-tab {
            padding: 12px 30px;
            background: #f7f7f7;
            color: #003d70;
            border: 2px solid transparent;
            border-radius: 25px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .gallery-tab:hover {
            background: #7EBEC5;
            color: #FFFFFF;
        }
        
        .gallery-tab.active {
            background: #003d70;
            color: #FFFFFF;
            border-color: #003d70;
        }
        
        /* Gallery Grid */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        
        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 12px;
            cursor: pointer;
            aspect-ratio: 4/3;
            background: #f7f7f7;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .gallery-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 61, 112, 0.15);
        }
        
        .gallery-item.hidden {
            display: none;
        }
        
        .gallery-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .gallery-item:hover .gallery-image {
            transform: scale(1.1);
        }
        
        .gallery-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 61, 112, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }
        
        .gallery-zoom-icon {
            font-size: 48px;
            color: #FFFFFF;
        }
        
        /* Lightbox */
        .gallery-lightbox {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.95);
            z-index: 10000;
            align-items: center;
            justify-content: center;
        }
        
        .gallery-lightbox.active {
            display: flex;
        }
        
        .lightbox-content {
            max-width: 90%;
            max-height: 90%;
            position: relative;
        }
        
        #lightbox-image {
            max-width: 100%;
            max-height: 90vh;
            object-fit: contain;
        }
        
        .lightbox-close,
        .lightbox-prev,
        .lightbox-next {
            position: absolute;
            background: rgba(255, 255, 255, 0.2);
            color: #FFFFFF;
            border: none;
            font-size: 40px;
            cursor: pointer;
            padding: 10px 20px;
            transition: background 0.3s ease;
            z-index: 10001;
        }
        
        .lightbox-close:hover,
        .lightbox-prev:hover,
        .lightbox-next:hover {
            background: rgba(255, 255, 255, 0.3);
        }
        
        .lightbox-close {
            top: 20px;
            right: 20px;
            font-size: 50px;
            line-height: 1;
        }
        
        .lightbox-prev {
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
        }
        
        .lightbox-next {
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .gallery-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            
            .gallery-filter-tabs {
                gap: 10px;
                padding: 15px;
            }
            
            .gallery-tab {
                padding: 10px 20px;
                font-size: 14px;
            }
            
            .lightbox-prev,
            .lightbox-next {
                font-size: 30px;
                padding: 5px 15px;
            }
            
            .lightbox-close {
                font-size: 40px;
            }
        }
        
        @media (min-width: 769px) and (max-width: 1024px) {
            .gallery-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        </style>';
        
        // Add JavaScript
        echo '<script>
        (function() {
            // Category filtering
            const tabs = document.querySelectorAll(".gallery-tab");
            const galleryItems = document.querySelectorAll(".gallery-item");
            
            tabs.forEach(tab => {
                tab.addEventListener("click", function() {
                    const category = this.getAttribute("data-category");
                    
                    // Update active tab
                    tabs.forEach(t => t.classList.remove("active"));
                    this.classList.add("active");
                    
                    // Filter gallery items
                    galleryItems.forEach(item => {
                        const itemCategory = item.getAttribute("data-category");
                        if (category === "all" || itemCategory === category) {
                            item.classList.remove("hidden");
                        } else {
                            item.classList.add("hidden");
                        }
                    });
                });
            });
            
            // Lightbox functionality
            const lightbox = document.getElementById("gallery-lightbox");
            const lightboxImage = document.getElementById("lightbox-image");
            const closeBtn = document.querySelector(".lightbox-close");
            const prevBtn = document.querySelector(".lightbox-prev");
            const nextBtn = document.querySelector(".lightbox-next");
            
            let currentImageIndex = 0;
            let visibleImages = [];
            
            function updateVisibleImages() {
                visibleImages = Array.from(document.querySelectorAll(".gallery-item:not(.hidden)"));
            }
            
            function openLightbox(index) {
                updateVisibleImages();
                currentImageIndex = index;
                const imageData = visibleImages[currentImageIndex].querySelector(".gallery-image");
                lightboxImage.src = imageData.getAttribute("data-full");
                lightboxImage.alt = imageData.alt;
                lightbox.classList.add("active");
                document.body.style.overflow = "hidden";
            }
            
            function closeLightbox() {
                lightbox.classList.remove("active");
                document.body.style.overflow = "";
            }
            
            function showNextImage() {
                updateVisibleImages();
                currentImageIndex = (currentImageIndex + 1) % visibleImages.length;
                const imageData = visibleImages[currentImageIndex].querySelector(".gallery-image");
                lightboxImage.src = imageData.getAttribute("data-full");
                lightboxImage.alt = imageData.alt;
            }
            
            function showPrevImage() {
                updateVisibleImages();
                currentImageIndex = (currentImageIndex - 1 + visibleImages.length) % visibleImages.length;
                const imageData = visibleImages[currentImageIndex].querySelector(".gallery-image");
                lightboxImage.src = imageData.getAttribute("data-full");
                lightboxImage.alt = imageData.alt;
            }
            
            // Open lightbox on image click
            galleryItems.forEach((item, index) => {
                item.addEventListener("click", function() {
                    if (!this.classList.contains("hidden")) {
                        updateVisibleImages();
                        const visibleIndex = visibleImages.indexOf(this);
                        openLightbox(visibleIndex);
                    }
                });
            });
            
            // Close lightbox
            closeBtn.addEventListener("click", closeLightbox);
            
            // Navigation
            nextBtn.addEventListener("click", showNextImage);
            prevBtn.addEventListener("click", showPrevImage);
            
            // Keyboard navigation
            document.addEventListener("keydown", function(e) {
                if (lightbox.classList.contains("active")) {
                    if (e.key === "Escape") {
                        closeLightbox();
                    } else if (e.key === "ArrowRight") {
                        showNextImage();
                    } else if (e.key === "ArrowLeft") {
                        showPrevImage();
                    }
                }
            });
            
            // Close on background click
            lightbox.addEventListener("click", function(e) {
                if (e.target === lightbox) {
                    closeLightbox();
                }
            });
        })();
        </script>';
        
    } else {
        echo '<div class="lumina-gallery-container">';
        echo '<div class="no-gallery-message" style="text-align: center; padding: 80px 20px; background: #FFFFFF; border-radius: 12px;">';
        echo '<div style="font-size: 80px; margin-bottom: 20px; opacity: 0.3;">📷</div>';
        echo '<h3 style="color: #003d70; font-size: 28px; margin-bottom: 15px;">No Images Yet</h3>';
        echo '<p style="color: #666; font-size: 18px; line-height: 1.6;">Our gallery is currently empty. Please check back soon for photos of our events, facilities, activities, and achievements!</p>';
        echo '</div>';
        echo '</div>';
    }
    
    return ob_get_clean();
}
add_shortcode('lumina_gallery', 'lumina_gallery_shortcode');


/**
 * Force full width header and footer
 */
function lumina_force_full_width() {
    wp_enqueue_style(
        'lumina-force-full-width',
        get_stylesheet_directory_uri() . '/assets/css/force-full-width.css',
        array(),
        '1.0.0'
    );
}
add_action('wp_enqueue_scripts', 'lumina_force_full_width', 999);
