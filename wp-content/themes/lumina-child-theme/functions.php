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
    
    // Enqueue contact form CSS
    wp_enqueue_style(
        'lumina-contact-form',
        get_stylesheet_directory_uri() . '/assets/css/contact-form.css',
        array($parent_style, 'lumina-brand-colors'),
        '1.0.0'
    );
    
    // Enqueue child theme stylesheet
    wp_enqueue_style(
        'lumina-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array($parent_style, 'lumina-brand-colors', 'lumina-contact-form'),
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
 * Flush rewrite rules on theme activation to ensure custom post type URLs work
 */
function lumina_flush_rewrite_rules_on_activation() {
    lumina_register_programs_post_type();
    lumina_register_program_category_taxonomy();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'lumina_flush_rewrite_rules_on_activation');

/**
 * Include Elementor configuration
 */
require_once get_stylesheet_directory() . '/elementor-config.php';

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
