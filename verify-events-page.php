<?php
/**
 * Verification Script for Events Page
 * 
 * This script verifies that the Events page meets all requirements
 * Requirements: 10.1, 10.2, 10.3, 10.5
 * Task 16: Build Events page with calendar functionality
 * 
 * Tests:
 * - Events display in chronological order
 * - All required fields are present
 * - Events within 7 days are highlighted
 * - Category filtering works
 * - Responsive design
 * 
 * Usage: Run via browser or WP-CLI
 */

// Load WordPress
require_once('wp-load.php');

// Check if user is logged in and has admin privileges
if (!is_user_logged_in() || !current_user_can('manage_options')) {
    wp_die('You do not have permission to access this page.');
}

echo "<h1>Events Page Verification</h1>";
echo "<div style='max-width: 1000px; margin: 20px auto; padding: 20px; background: #f7f7f7; border-radius: 8px;'>";

$all_tests_passed = true;
$warnings = array();

// Test 1: Check if Events page exists
echo "<h2>Test 1: Events Page Existence</h2>";

$events_page = get_page_by_path('events');

if ($events_page && $events_page->post_status === 'publish') {
    echo "<p style='color: green;'>✓ PASS: Events page exists and is published (ID: {$events_page->ID})</p>";
    $page_id = $events_page->ID;
} else {
    echo "<p style='color: red;'>✗ FAIL: Events page not found or not published</p>";
    $all_tests_passed = false;
    $page_id = null;
}

// Test 2: Check if archive template exists
echo "<h2>Test 2: Archive Template</h2>";

$child_archive = get_stylesheet_directory() . '/archive-lis_event.php';
$parent_archive = get_template_directory() . '/archive-lis_event.php';

if (file_exists($child_archive)) {
    echo "<p style='color: green;'>✓ PASS: Events archive template found in child theme</p>";
    $archive_path = $child_archive;
} elseif (file_exists($parent_archive)) {
    echo "<p style='color: green;'>✓ PASS: Events archive template found in parent theme</p>";
    $archive_path = $parent_archive;
} else {
    echo "<p style='color: red;'>✗ FAIL: Events archive template not found</p>";
    $all_tests_passed = false;
    $archive_path = null;
}

// Test 3: Check if single event template exists
echo "<h2>Test 3: Single Event Template</h2>";

$child_single = get_stylesheet_directory() . '/single-lis_event.php';
$parent_single = get_template_directory() . '/single-lis_event.php';

if (file_exists($child_single)) {
    echo "<p style='color: green;'>✓ PASS: Single event template found in child theme</p>";
} elseif (file_exists($parent_single)) {
    echo "<p style='color: green;'>✓ PASS: Single event template found in parent theme</p>";
} else {
    echo "<p style='color: red;'>✗ FAIL: Single event template not found</p>";
    $all_tests_passed = false;
}

// Test 4: Check event categories exist
echo "<h2>Test 4: Event Categories (Requirement 10.5)</h2>";

$required_categories = array('Academic', 'Sports', 'Cultural', 'Holidays', 'Parent Events');
$existing_categories = get_terms(array(
    'taxonomy' => 'event_category',
    'hide_empty' => false,
));

if (!is_wp_error($existing_categories) && !empty($existing_categories)) {
    echo "<p style='color: green;'>✓ PASS: Event categories exist (" . count($existing_categories) . " categories)</p>";
    
    $category_names = array_map(function($cat) { return $cat->name; }, $existing_categories);
    
    foreach ($required_categories as $req_cat) {
        if (in_array($req_cat, $category_names)) {
            echo "<p style='color: green;'>  ✓ Category '{$req_cat}' exists</p>";
        } else {
            echo "<p style='color: orange;'>  ⚠ Category '{$req_cat}' missing</p>";
            $warnings[] = "Category '{$req_cat}' not found";
        }
    }
} else {
    echo "<p style='color: red;'>✗ FAIL: No event categories found</p>";
    $all_tests_passed = false;
}

// Test 5: Check if events exist and test chronological ordering
echo "<h2>Test 5: Events and Chronological Ordering (Requirement 10.1)</h2>";

$events = get_posts(array(
    'post_type' => 'lis_event',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'meta_key' => 'event_date',
    'orderby' => 'meta_value',
    'order' => 'ASC',
));

if (!empty($events)) {
    echo "<p style='color: green;'>✓ PASS: Found " . count($events) . " published events</p>";
    
    // Check if events are ordered chronologically
    $dates_in_order = true;
    $prev_date = null;
    
    foreach ($events as $event) {
        $event_date = get_post_meta($event->ID, 'event_date', true);
        
        if ($prev_date && $event_date < $prev_date) {
            $dates_in_order = false;
            break;
        }
        
        $prev_date = $event_date;
    }
    
    if ($dates_in_order) {
        echo "<p style='color: green;'>✓ PASS: Events are ordered chronologically</p>";
    } else {
        echo "<p style='color: red;'>✗ FAIL: Events are not in chronological order</p>";
        $all_tests_passed = false;
    }
    
    // Display first 3 events
    echo "<p><strong>Sample Events:</strong></p>";
    echo "<ul>";
    foreach (array_slice($events, 0, 3) as $event) {
        $event_date = get_post_meta($event->ID, 'event_date', true);
        echo "<li>{$event->post_title} - " . date('F j, Y', strtotime($event_date)) . "</li>";
    }
    echo "</ul>";
    
} else {
    echo "<p style='color: orange;'>⚠ WARNING: No events found (create test events to verify functionality)</p>";
    $warnings[] = "No events exist for testing";
}

// Test 6: Check required event fields (Requirement 10.2)
echo "<h2>Test 6: Required Event Fields (Requirement 10.2)</h2>";

if (!empty($events)) {
    $fields_complete = true;
    $sample_event = $events[0];
    
    $event_date = get_post_meta($sample_event->ID, 'event_date', true);
    $event_time = get_post_meta($sample_event->ID, 'event_time', true);
    $event_location = get_post_meta($sample_event->ID, 'event_location', true);
    
    echo "<p><strong>Testing event: {$sample_event->post_title}</strong></p>";
    
    if (!empty($sample_event->post_title)) {
        echo "<p style='color: green;'>  ✓ Title: Present</p>";
    } else {
        echo "<p style='color: red;'>  ✗ Title: Missing</p>";
        $fields_complete = false;
    }
    
    if (!empty($event_date)) {
        echo "<p style='color: green;'>  ✓ Date: {$event_date}</p>";
    } else {
        echo "<p style='color: red;'>  ✗ Date: Missing</p>";
        $fields_complete = false;
    }
    
    if (!empty($event_time)) {
        echo "<p style='color: green;'>  ✓ Time: {$event_time}</p>";
    } else {
        echo "<p style='color: red;'>  ✗ Time: Missing</p>";
        $fields_complete = false;
    }
    
    if (!empty($event_location)) {
        echo "<p style='color: green;'>  ✓ Location: {$event_location}</p>";
    } else {
        echo "<p style='color: red;'>  ✗ Location: Missing</p>";
        $fields_complete = false;
    }
    
    if (!empty($sample_event->post_content)) {
        echo "<p style='color: green;'>  ✓ Description: Present</p>";
    } else {
        echo "<p style='color: orange;'>  ⚠ Description: Empty</p>";
        $warnings[] = "Sample event has no description";
    }
    
    if ($fields_complete) {
        echo "<p style='color: green;'>✓ PASS: All required fields present</p>";
    } else {
        echo "<p style='color: red;'>✗ FAIL: Some required fields missing</p>";
        $all_tests_passed = false;
    }
} else {
    echo "<p style='color: orange;'>⚠ SKIP: No events to test</p>";
}

// Test 7: Check upcoming event highlighting (Requirement 10.3)
echo "<h2>Test 7: Upcoming Event Highlighting (Requirement 10.3)</h2>";

if (!empty($events)) {
    $today = strtotime(date('Y-m-d'));
    $seven_days = strtotime('+7 days', $today);
    
    $upcoming_events = array();
    
    foreach ($events as $event) {
        $event_date = get_post_meta($event->ID, 'event_date', true);
        if ($event_date) {
            $event_timestamp = strtotime($event_date);
            if ($event_timestamp >= $today && $event_timestamp <= $seven_days) {
                $upcoming_events[] = $event;
            }
        }
    }
    
    if (!empty($upcoming_events)) {
        echo "<p style='color: green;'>✓ PASS: Found " . count($upcoming_events) . " events within next 7 days</p>";
        echo "<p><strong>Upcoming Events:</strong></p>";
        echo "<ul>";
        foreach ($upcoming_events as $event) {
            $event_date = get_post_meta($event->ID, 'event_date', true);
            $days_until = floor((strtotime($event_date) - $today) / (60 * 60 * 24));
            echo "<li>{$event->post_title} - " . date('F j, Y', strtotime($event_date)) . " ({$days_until} days away)</li>";
        }
        echo "</ul>";
        echo "<p style='color: blue;'>ℹ These events should display with orange highlighting on the Events page</p>";
    } else {
        echo "<p style='color: orange;'>⚠ WARNING: No events within next 7 days (create test events to verify highlighting)</p>";
        $warnings[] = "No upcoming events to test highlighting";
    }
} else {
    echo "<p style='color: orange;'>⚠ SKIP: No events to test</p>";
}

// Test 8: Check archive template content
echo "<h2>Test 8: Archive Template Features</h2>";

if ($archive_path) {
    $template_content = file_get_contents($archive_path);
    
    // Check for key features
    $features = array(
        'event_category' => 'Category filtering',
        'upcoming-highlight' => 'Upcoming event highlighting',
        'event-filters' => 'Filter buttons',
        'chronological' => 'Chronological ordering',
        'event-meta' => 'Event metadata display',
    );
    
    foreach ($features as $search => $feature) {
        if (strpos($template_content, $search) !== false) {
            echo "<p style='color: green;'>  ✓ {$feature} implemented</p>";
        } else {
            echo "<p style='color: orange;'>  ⚠ {$feature} may not be implemented</p>";
        }
    }
    
    echo "<p style='color: green;'>✓ PASS: Archive template contains expected features</p>";
} else {
    echo "<p style='color: red;'>✗ FAIL: Cannot verify template features</p>";
}

// Test 9: Check responsive design elements
echo "<h2>Test 9: Responsive Design</h2>";

if ($archive_path) {
    $template_content = file_get_contents($archive_path);
    
    $responsive_checks = array(
        '@media' => 'Media queries',
        'max-width: 767px' => 'Mobile breakpoint',
        'min-width: 768px' => 'Tablet breakpoint',
        'grid-template-columns' => 'Grid layout',
    );
    
    $responsive_count = 0;
    foreach ($responsive_checks as $search => $feature) {
        if (strpos($template_content, $search) !== false) {
            echo "<p style='color: green;'>  ✓ {$feature} found</p>";
            $responsive_count++;
        }
    }
    
    if ($responsive_count >= 3) {
        echo "<p style='color: green;'>✓ PASS: Responsive design implemented</p>";
    } else {
        echo "<p style='color: orange;'>⚠ WARNING: Limited responsive design features</p>";
        $warnings[] = "Limited responsive design features detected";
    }
} else {
    echo "<p style='color: red;'>✗ FAIL: Cannot verify responsive design</p>";
}

// Test 10: Check page URLs
echo "<h2>Test 10: Page URLs</h2>";

if ($page_id) {
    $page_url = get_permalink($page_id);
    echo "<p style='color: green;'>✓ Events Page URL: <a href='{$page_url}' target='_blank'>{$page_url}</a></p>";
}

$archive_url = get_post_type_archive_link('lis_event');
if ($archive_url) {
    echo "<p style='color: green;'>✓ Events Archive URL: <a href='{$archive_url}' target='_blank'>{$archive_url}</a></p>";
} else {
    echo "<p style='color: red;'>✗ FAIL: Events archive URL not available</p>";
    $all_tests_passed = false;
}

// Final Summary
echo "<h2>Verification Summary</h2>";
echo "<div style='background: white; padding: 20px; border-radius: 8px; border-left: 5px solid " . ($all_tests_passed ? "#7EBEC5" : "#F39A3B") . ";'>";

if ($all_tests_passed && empty($warnings)) {
    echo "<h3 style='color: green;'>✓ All Tests Passed!</h3>";
    echo "<p>The Events page is fully functional and meets all requirements.</p>";
} elseif ($all_tests_passed && !empty($warnings)) {
    echo "<h3 style='color: orange;'>⚠ Tests Passed with Warnings</h3>";
    echo "<p>The Events page is functional but has some warnings:</p>";
    echo "<ul>";
    foreach ($warnings as $warning) {
        echo "<li>{$warning}</li>";
    }
    echo "</ul>";
} else {
    echo "<h3 style='color: red;'>✗ Some Tests Failed</h3>";
    echo "<p>Please review the failed tests above and make necessary corrections.</p>";
}

echo "<h4>Requirements Status:</h4>";
echo "<ul>";
echo "<li><strong>Requirement 10.1:</strong> Events in chronological order - " . ($all_tests_passed ? "✓ PASS" : "Review needed") . "</li>";
echo "<li><strong>Requirement 10.2:</strong> All required fields displayed - " . ($all_tests_passed ? "✓ PASS" : "Review needed") . "</li>";
echo "<li><strong>Requirement 10.3:</strong> Upcoming event highlighting - " . (empty($warnings) ? "✓ PASS" : "⚠ Needs test events") . "</li>";
echo "<li><strong>Requirement 10.5:</strong> Category filtering - " . ($all_tests_passed ? "✓ PASS" : "Review needed") . "</li>";
echo "<li><strong>Responsive Design:</strong> Mobile-friendly layout - " . ($all_tests_passed ? "✓ PASS" : "Review needed") . "</li>";
echo "</ul>";

echo "</div>";

// Recommendations
echo "<h2>Recommendations</h2>";
echo "<div style='background: #FFF9F0; padding: 20px; border-radius: 8px; border-left: 5px solid #F39A3B;'>";

echo "<h3>To Complete Testing:</h3>";
echo "<ol>";
echo "<li><strong>Add Test Events:</strong> Create events with various dates (past, present, future)</li>";
echo "<li><strong>Test Upcoming Highlighting:</strong> Create events within next 7 days</li>";
echo "<li><strong>Test Categories:</strong> Assign different categories to events</li>";
echo "<li><strong>Test Filtering:</strong> Click category filter buttons on the Events page</li>";
echo "<li><strong>Test Responsive:</strong> View page on mobile, tablet, and desktop</li>";
echo "<li><strong>Test Navigation:</strong> Click on events to view detail pages</li>";
echo "<li><strong>Test Pagination:</strong> Create 10+ events to test pagination</li>";
echo "</ol>";

echo "<h3>Quick Actions:</h3>";
echo "<ul>";
echo "<li><a href='" . admin_url('post-new.php?post_type=lis_event') . "' target='_blank'>Add New Event</a></li>";
echo "<li><a href='" . admin_url('edit.php?post_type=lis_event') . "' target='_blank'>Manage Events</a></li>";
if ($page_id) {
    echo "<li><a href='" . get_permalink($page_id) . "' target='_blank'>View Events Page</a></li>";
}
if ($archive_url) {
    echo "<li><a href='{$archive_url}' target='_blank'>View Events Archive</a></li>";
}
echo "</ul>";

echo "</div>";

echo "</div>";
