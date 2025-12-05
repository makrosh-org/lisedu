<?php
/**
 * Test Resources Page Display
 * 
 * Simple test to check if Resources page exists and display basic info
 * Task 20: Build Resources page with downloadable documents
 */

// Load WordPress
require_once('wp-load.php');

echo "=== Resources Page Test ===\n\n";

// Check if Resources page exists
$resources_page = get_page_by_path('resources');

if ($resources_page) {
    echo "✓ Resources page exists\n";
    echo "  ID: {$resources_page->ID}\n";
    echo "  Title: {$resources_page->post_title}\n";
    echo "  Status: {$resources_page->post_status}\n";
    echo "  URL: " . get_permalink($resources_page->ID) . "\n";
    echo "  Template: " . get_post_meta($resources_page->ID, '_wp_page_template', true) . "\n";
    
    // Check Elementor
    $elementor_mode = get_post_meta($resources_page->ID, '_elementor_edit_mode', true);
    echo "  Elementor Mode: " . ($elementor_mode ? $elementor_mode : 'Not set') . "\n";
    
    $elementor_data = get_post_meta($resources_page->ID, '_elementor_data', true);
    if (!empty($elementor_data)) {
        $data = json_decode($elementor_data, true);
        $section_count = is_array($data) ? count($data) : 0;
        echo "  Elementor Sections: {$section_count}\n";
    }
} else {
    echo "✗ Resources page NOT found\n";
    echo "  Creating page...\n";
    
    // Create the page
    $page_id = wp_insert_post(array(
        'post_title' => 'Resources',
        'post_name' => 'resources',
        'post_status' => 'publish',
        'post_type' => 'page',
        'post_content' => '[lumina_resources_grid]',
    ));
    
    if (!is_wp_error($page_id)) {
        echo "✓ Resources page created (ID: {$page_id})\n";
        echo "  URL: " . get_permalink($page_id) . "\n";
    } else {
        echo "✗ Error creating page: " . $page_id->get_error_message() . "\n";
    }
}

echo "\n";

// Check shortcode
if (shortcode_exists('lumina_resources_grid')) {
    echo "✓ Resources grid shortcode is registered\n";
} else {
    echo "✗ Resources grid shortcode NOT registered\n";
}

echo "\n";

// Check for resources
$resources_query = new WP_Query(array(
    'post_type' => 'lis_resource',
    'posts_per_page' => 5,
    'post_status' => 'publish',
));

if ($resources_query->have_posts()) {
    echo "✓ Found {$resources_query->found_posts} published resource(s)\n";
    echo "\nSample Resources:\n";
    while ($resources_query->have_posts()) {
        $resources_query->the_post();
        $resource_id = get_the_ID();
        $file_type = get_post_meta($resource_id, '_resource_file_type', true);
        $file_size = get_post_meta($resource_id, '_resource_file_size', true);
        echo "  - " . get_the_title() . " ({$file_type}, {$file_size})\n";
    }
    wp_reset_postdata();
} else {
    echo "⚠ No resources found\n";
}

echo "\n";

// Check categories
$categories = get_terms(array(
    'taxonomy' => 'resource_category',
    'hide_empty' => false,
));

if (!empty($categories) && !is_wp_error($categories)) {
    echo "✓ Found " . count($categories) . " resource categories\n";
    foreach ($categories as $category) {
        echo "  - {$category->name} ({$category->count} resources)\n";
    }
} else {
    echo "⚠ No resource categories found\n";
}

echo "\n=== Test Complete ===\n";
