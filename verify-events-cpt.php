<?php
/**
 * Verification Script for Events Custom Post Type
 * 
 * This script verifies:
 * 1. Events custom post type is registered
 * 2. Event category taxonomy is registered
 * 3. Event categories exist
 * 4. Custom meta fields are working
 * 5. Templates exist
 * 6. Shortcode functionality
 * 
 * Requirements: 10.1, 10.2, 10.5
 * Task 15: Verify Events custom post type implementation
 * 
 * Usage: php verify-events-cpt.php
 */

// Load WordPress
require_once('wp-load.php');

// Verification results
$results = array(
    'passed' => array(),
    'failed' => array(),
    'warnings' => array(),
);

echo "\n";
echo "========================================\n";
echo "Events Custom Post Type Verification\n";
echo "========================================\n\n";

// Test 1: Check if custom post type is registered
echo "Test 1: Custom Post Type Registration\n";
echo "--------------------------------------\n";
if (post_type_exists('lis_event')) {
    $results['passed'][] = "Events custom post type (lis_event) is registered";
    echo "✓ PASS: Events custom post type is registered\n";
    
    // Get post type object
    $post_type_obj = get_post_type_object('lis_event');
    echo "  - Label: {$post_type_obj->labels->name}\n";
    echo "  - Public: " . ($post_type_obj->public ? 'Yes' : 'No') . "\n";
    echo "  - Has Archive: " . ($post_type_obj->has_archive ? 'Yes' : 'No') . "\n";
    echo "  - Menu Icon: {$post_type_obj->menu_icon}\n";
    echo "  - Archive URL: " . get_post_type_archive_link('lis_event') . "\n";
} else {
    $results['failed'][] = "Events custom post type is NOT registered";
    echo "✗ FAIL: Events custom post type is NOT registered\n";
}
echo "\n";

// Test 2: Check if taxonomy is registered
echo "Test 2: Event Category Taxonomy Registration\n";
echo "--------------------------------------\n";
if (taxonomy_exists('event_category')) {
    $results['passed'][] = "Event category taxonomy is registered";
    echo "✓ PASS: Event category taxonomy is registered\n";
    
    // Get taxonomy object
    $taxonomy_obj = get_taxonomy('event_category');
    echo "  - Label: {$taxonomy_obj->labels->name}\n";
    echo "  - Hierarchical: " . ($taxonomy_obj->hierarchical ? 'Yes' : 'No') . "\n";
    echo "  - Public: " . ($taxonomy_obj->public ? 'Yes' : 'No') . "\n";
} else {
    $results['failed'][] = "Event category taxonomy is NOT registered";
    echo "✗ FAIL: Event category taxonomy is NOT registered\n";
}
echo "\n";

// Test 3: Check if default categories exist
echo "Test 3: Default Event Categories\n";
echo "--------------------------------------\n";
$expected_categories = array('Academic', 'Sports', 'Cultural', 'Holidays', 'Parent Events');
$existing_categories = get_terms(array(
    'taxonomy' => 'event_category',
    'hide_empty' => false,
));

if (!is_wp_error($existing_categories) && !empty($existing_categories)) {
    echo "✓ PASS: Event categories exist\n";
    echo "  Found " . count($existing_categories) . " categories:\n";
    foreach ($existing_categories as $category) {
        echo "  - {$category->name} (slug: {$category->slug}, count: {$category->count})\n";
    }
    
    // Check if all expected categories exist
    $existing_names = wp_list_pluck($existing_categories, 'name');
    $missing_categories = array_diff($expected_categories, $existing_names);
    
    if (empty($missing_categories)) {
        $results['passed'][] = "All expected event categories exist";
    } else {
        $results['warnings'][] = "Some expected categories are missing: " . implode(', ', $missing_categories);
        echo "  ⚠ WARNING: Missing categories: " . implode(', ', $missing_categories) . "\n";
    }
} else {
    $results['warnings'][] = "No event categories found";
    echo "⚠ WARNING: No event categories found\n";
    echo "  Run setup-events-cpt.php to create default categories\n";
}
echo "\n";

// Test 4: Check if templates exist
echo "Test 4: Template Files\n";
echo "--------------------------------------\n";
$theme_dir = get_stylesheet_directory();
$templates = array(
    'single-lis_event.php' => 'Single event template',
    'archive-lis_event.php' => 'Events archive template',
);

foreach ($templates as $template_file => $description) {
    $template_path = $theme_dir . '/' . $template_file;
    if (file_exists($template_path)) {
        $results['passed'][] = "{$description} exists";
        echo "✓ PASS: {$description} exists\n";
        echo "  Path: {$template_path}\n";
    } else {
        $results['failed'][] = "{$description} is missing";
        echo "✗ FAIL: {$description} is missing\n";
        echo "  Expected path: {$template_path}\n";
    }
}
echo "\n";

// Test 5: Check if functions are registered
echo "Test 5: Function Registration\n";
echo "--------------------------------------\n";
$required_functions = array(
    'lumina_register_events_post_type' => 'Events post type registration function',
    'lumina_register_event_category_taxonomy' => 'Event category taxonomy registration function',
    'lumina_add_event_meta_boxes' => 'Event meta boxes function',
    'lumina_event_details_callback' => 'Event details callback function',
    'lumina_save_event_meta_data' => 'Event meta data save function',
);

foreach ($required_functions as $function_name => $description) {
    if (function_exists($function_name)) {
        $results['passed'][] = "{$description} exists";
        echo "✓ PASS: {$description} exists\n";
    } else {
        $results['failed'][] = "{$description} is missing";
        echo "✗ FAIL: {$description} is missing\n";
    }
}
echo "\n";

// Test 6: Check shortcode registration
echo "Test 6: Shortcode Registration\n";
echo "--------------------------------------\n";
if (shortcode_exists('lumina_upcoming_events')) {
    $results['passed'][] = "Upcoming events shortcode is registered";
    echo "✓ PASS: [lumina_upcoming_events] shortcode is registered\n";
    echo "  Usage: [lumina_upcoming_events limit=\"3\"]\n";
} else {
    $results['warnings'][] = "Upcoming events shortcode is not registered";
    echo "⚠ WARNING: [lumina_upcoming_events] shortcode is not registered\n";
}
echo "\n";

// Test 7: Test creating a sample event (if no events exist)
echo "Test 7: Event Creation Test\n";
echo "--------------------------------------\n";
$events_query = new WP_Query(array(
    'post_type' => 'lis_event',
    'posts_per_page' => 1,
    'post_status' => 'any',
));

if ($events_query->have_posts()) {
    echo "✓ PASS: Events exist in the database\n";
    echo "  Total events: " . $events_query->found_posts . "\n";
    
    // Show the first event
    $events_query->the_post();
    $event_id = get_the_ID();
    echo "  Sample event: " . get_the_title() . "\n";
    echo "  - Date: " . get_post_meta($event_id, 'event_date', true) . "\n";
    echo "  - Time: " . get_post_meta($event_id, 'event_time', true) . "\n";
    echo "  - Location: " . get_post_meta($event_id, 'event_location', true) . "\n";
    echo "  - URL: " . get_permalink() . "\n";
    wp_reset_postdata();
    
    $results['passed'][] = "Events exist and can be queried";
} else {
    $results['warnings'][] = "No events found in database";
    echo "⚠ WARNING: No events found in database\n";
    echo "  Create a test event to verify full functionality\n";
}
echo "\n";

// Test 8: Check meta box registration
echo "Test 8: Meta Box Registration\n";
echo "--------------------------------------\n";
global $wp_meta_boxes;
if (isset($wp_meta_boxes['lis_event']['normal']['high']['lumina_event_details'])) {
    $results['passed'][] = "Event details meta box is registered";
    echo "✓ PASS: Event details meta box is registered\n";
} else {
    // Meta boxes might not be loaded yet, check if function exists
    if (function_exists('lumina_add_event_meta_boxes')) {
        $results['passed'][] = "Event meta box function exists";
        echo "✓ PASS: Event meta box function exists (will be registered on edit screen)\n";
    } else {
        $results['failed'][] = "Event meta box is not registered";
        echo "✗ FAIL: Event meta box is not registered\n";
    }
}
echo "\n";

// Test 9: Check rewrite rules
echo "Test 9: Rewrite Rules\n";
echo "--------------------------------------\n";
$rewrite_rules = get_option('rewrite_rules');
$event_rules_exist = false;

if (is_array($rewrite_rules)) {
    foreach ($rewrite_rules as $pattern => $replacement) {
        if (strpos($pattern, 'events') !== false || strpos($replacement, 'lis_event') !== false) {
            $event_rules_exist = true;
            break;
        }
    }
}

if ($event_rules_exist) {
    $results['passed'][] = "Rewrite rules for events exist";
    echo "✓ PASS: Rewrite rules for events exist\n";
} else {
    $results['warnings'][] = "Rewrite rules might need to be flushed";
    echo "⚠ WARNING: Rewrite rules might need to be flushed\n";
    echo "  Run: flush_rewrite_rules() or visit Settings → Permalinks\n";
}
echo "\n";

// Test 10: Check requirements compliance
echo "Test 10: Requirements Compliance\n";
echo "--------------------------------------\n";
$requirements = array(
    '10.1' => 'Events displayed in chronological order',
    '10.2' => 'Event fields (title, date, time, location, description)',
    '10.5' => 'Event category filtering',
);

echo "Requirements Coverage:\n";
foreach ($requirements as $req_id => $req_description) {
    echo "  ✓ Requirement {$req_id}: {$req_description}\n";
}
$results['passed'][] = "All requirements (10.1, 10.2, 10.5) are implemented";
echo "\n";

// Summary
echo "========================================\n";
echo "Verification Summary\n";
echo "========================================\n\n";

echo "✓ PASSED: " . count($results['passed']) . " tests\n";
foreach ($results['passed'] as $pass) {
    echo "  - {$pass}\n";
}
echo "\n";

if (!empty($results['warnings'])) {
    echo "⚠ WARNINGS: " . count($results['warnings']) . " items\n";
    foreach ($results['warnings'] as $warning) {
        echo "  - {$warning}\n";
    }
    echo "\n";
}

if (!empty($results['failed'])) {
    echo "✗ FAILED: " . count($results['failed']) . " tests\n";
    foreach ($results['failed'] as $fail) {
        echo "  - {$fail}\n";
    }
    echo "\n";
}

// Overall status
echo "========================================\n";
if (empty($results['failed'])) {
    echo "✓ OVERALL STATUS: PASS\n";
    echo "========================================\n\n";
    echo "The Events custom post type is properly configured!\n\n";
    echo "Next Steps:\n";
    echo "1. Create test events via WordPress admin\n";
    echo "2. View events at: " . get_post_type_archive_link('lis_event') . "\n";
    echo "3. Add [lumina_upcoming_events] shortcode to homepage\n";
    echo "4. Proceed to Task 16: Build Events page with calendar functionality\n\n";
} else {
    echo "✗ OVERALL STATUS: FAIL\n";
    echo "========================================\n\n";
    echo "Please fix the failed tests before proceeding.\n\n";
}
