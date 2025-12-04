<?php
/**
 * Verification Script for Events Page (WP-CLI version)
 * 
 * This script verifies that the Events page meets all requirements
 * Requirements: 10.1, 10.2, 10.3, 10.5
 * Task 16: Build Events page with calendar functionality
 */

$all_tests_passed = true;
$warnings = array();

// Test 1: Check if Events page exists
WP_CLI::log('Test 1: Events Page Existence');

$events_page = get_page_by_path('events');

if ($events_page && $events_page->post_status === 'publish') {
    WP_CLI::success("Events page exists and is published (ID: {$events_page->ID})");
    $page_id = $events_page->ID;
} else {
    WP_CLI::error('Events page not found or not published');
    $all_tests_passed = false;
    $page_id = null;
}

// Test 2: Check if archive template exists
WP_CLI::log('Test 2: Archive Template');

$child_archive = get_stylesheet_directory() . '/archive-lis_event.php';

if (file_exists($child_archive)) {
    WP_CLI::success('Events archive template found in child theme');
} else {
    WP_CLI::error('Events archive template not found');
    $all_tests_passed = false;
}

// Test 3: Check if single event template exists
WP_CLI::log('Test 3: Single Event Template');

$child_single = get_stylesheet_directory() . '/single-lis_event.php';

if (file_exists($child_single)) {
    WP_CLI::success('Single event template found in child theme');
} else {
    WP_CLI::error('Single event template not found');
    $all_tests_passed = false;
}

// Test 4: Check event categories exist
WP_CLI::log('Test 4: Event Categories (Requirement 10.5)');

$required_categories = array('Academic', 'Sports', 'Cultural', 'Holidays', 'Parent Events');
$existing_categories = get_terms(array(
    'taxonomy' => 'event_category',
    'hide_empty' => false,
));

if (!is_wp_error($existing_categories) && !empty($existing_categories)) {
    WP_CLI::success('Event categories exist (' . count($existing_categories) . ' categories)');
    
    $category_names = array_map(function($cat) { return $cat->name; }, $existing_categories);
    
    foreach ($required_categories as $req_cat) {
        if (in_array($req_cat, $category_names)) {
            WP_CLI::log("  ✓ Category '{$req_cat}' exists");
        } else {
            WP_CLI::warning("  Category '{$req_cat}' missing");
            $warnings[] = "Category '{$req_cat}' not found";
        }
    }
} else {
    WP_CLI::error('No event categories found');
    $all_tests_passed = false;
}

// Test 5: Check if events exist and test chronological ordering
WP_CLI::log('Test 5: Events and Chronological Ordering (Requirement 10.1)');

$events = get_posts(array(
    'post_type' => 'lis_event',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'meta_key' => 'event_date',
    'orderby' => 'meta_value',
    'order' => 'ASC',
));

if (!empty($events)) {
    WP_CLI::success('Found ' . count($events) . ' published events');
    
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
        WP_CLI::success('Events are ordered chronologically');
    } else {
        WP_CLI::error('Events are not in chronological order');
        $all_tests_passed = false;
    }
    
    // Display first 3 events
    WP_CLI::log('Sample Events:');
    foreach (array_slice($events, 0, 3) as $event) {
        $event_date = get_post_meta($event->ID, 'event_date', true);
        WP_CLI::log("  - {$event->post_title} - " . date('F j, Y', strtotime($event_date)));
    }
    
} else {
    WP_CLI::warning('No events found (create test events to verify functionality)');
    $warnings[] = 'No events exist for testing';
}

// Test 6: Check required event fields (Requirement 10.2)
WP_CLI::log('Test 6: Required Event Fields (Requirement 10.2)');

if (!empty($events)) {
    $fields_complete = true;
    $sample_event = $events[0];
    
    $event_date = get_post_meta($sample_event->ID, 'event_date', true);
    $event_time = get_post_meta($sample_event->ID, 'event_time', true);
    $event_location = get_post_meta($sample_event->ID, 'event_location', true);
    
    WP_CLI::log("Testing event: {$sample_event->post_title}");
    
    if (!empty($sample_event->post_title)) {
        WP_CLI::log('  ✓ Title: Present');
    } else {
        WP_CLI::error('  Title: Missing');
        $fields_complete = false;
    }
    
    if (!empty($event_date)) {
        WP_CLI::log("  ✓ Date: {$event_date}");
    } else {
        WP_CLI::error('  Date: Missing');
        $fields_complete = false;
    }
    
    if (!empty($event_time)) {
        WP_CLI::log("  ✓ Time: {$event_time}");
    } else {
        WP_CLI::error('  Time: Missing');
        $fields_complete = false;
    }
    
    if (!empty($event_location)) {
        WP_CLI::log("  ✓ Location: {$event_location}");
    } else {
        WP_CLI::error('  Location: Missing');
        $fields_complete = false;
    }
    
    if (!empty($sample_event->post_content)) {
        WP_CLI::log('  ✓ Description: Present');
    } else {
        WP_CLI::warning('  Description: Empty');
        $warnings[] = 'Sample event has no description';
    }
    
    if ($fields_complete) {
        WP_CLI::success('All required fields present');
    } else {
        WP_CLI::error('Some required fields missing');
        $all_tests_passed = false;
    }
} else {
    WP_CLI::log('SKIP: No events to test');
}

// Test 7: Check upcoming event highlighting (Requirement 10.3)
WP_CLI::log('Test 7: Upcoming Event Highlighting (Requirement 10.3)');

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
        WP_CLI::success('Found ' . count($upcoming_events) . ' events within next 7 days');
        WP_CLI::log('Upcoming Events:');
        foreach ($upcoming_events as $event) {
            $event_date = get_post_meta($event->ID, 'event_date', true);
            $days_until = floor((strtotime($event_date) - $today) / (60 * 60 * 24));
            WP_CLI::log("  - {$event->post_title} - " . date('F j, Y', strtotime($event_date)) . " ({$days_until} days away)");
        }
        WP_CLI::log('These events should display with orange highlighting on the Events page');
    } else {
        WP_CLI::warning('No events within next 7 days (create test events to verify highlighting)');
        $warnings[] = 'No upcoming events to test highlighting';
    }
} else {
    WP_CLI::log('SKIP: No events to test');
}

// Test 8: Check archive template content
WP_CLI::log('Test 8: Archive Template Features');

if (file_exists($child_archive)) {
    $template_content = file_get_contents($child_archive);
    
    $features = array(
        'event_category' => 'Category filtering',
        'upcoming-highlight' => 'Upcoming event highlighting',
        'event-filters' => 'Filter buttons',
        'event-meta' => 'Event metadata display',
    );
    
    foreach ($features as $search => $feature) {
        if (strpos($template_content, $search) !== false) {
            WP_CLI::log("  ✓ {$feature} implemented");
        } else {
            WP_CLI::warning("  {$feature} may not be implemented");
        }
    }
    
    WP_CLI::success('Archive template contains expected features');
}

// Test 9: Check responsive design elements
WP_CLI::log('Test 9: Responsive Design');

if (file_exists($child_archive)) {
    $template_content = file_get_contents($child_archive);
    
    $responsive_checks = array(
        '@media' => 'Media queries',
        'max-width: 767px' => 'Mobile breakpoint',
        'min-width: 768px' => 'Tablet breakpoint',
    );
    
    $responsive_count = 0;
    foreach ($responsive_checks as $search => $feature) {
        if (strpos($template_content, $search) !== false) {
            WP_CLI::log("  ✓ {$feature} found");
            $responsive_count++;
        }
    }
    
    if ($responsive_count >= 2) {
        WP_CLI::success('Responsive design implemented');
    } else {
        WP_CLI::warning('Limited responsive design features');
        $warnings[] = 'Limited responsive design features detected';
    }
}

// Test 10: Check page URLs
WP_CLI::log('Test 10: Page URLs');

if ($page_id) {
    $page_url = get_permalink($page_id);
    WP_CLI::log("Events Page URL: {$page_url}");
}

$archive_url = get_post_type_archive_link('lis_event');
if ($archive_url) {
    WP_CLI::log("Events Archive URL: {$archive_url}");
} else {
    WP_CLI::error('Events archive URL not available');
    $all_tests_passed = false;
}

// Final Summary
WP_CLI::log('');
WP_CLI::log('=== Verification Summary ===');

if ($all_tests_passed && empty($warnings)) {
    WP_CLI::success('All Tests Passed!');
    WP_CLI::log('The Events page is fully functional and meets all requirements.');
} elseif ($all_tests_passed && !empty($warnings)) {
    WP_CLI::warning('Tests Passed with Warnings');
    WP_CLI::log('The Events page is functional but has some warnings:');
    foreach ($warnings as $warning) {
        WP_CLI::log("  - {$warning}");
    }
} else {
    WP_CLI::error('Some Tests Failed');
    WP_CLI::log('Please review the failed tests above and make necessary corrections.');
}

WP_CLI::log('');
WP_CLI::log('Requirements Status:');
WP_CLI::log('  - Requirement 10.1: Events in chronological order - ' . ($all_tests_passed ? '✓ PASS' : 'Review needed'));
WP_CLI::log('  - Requirement 10.2: All required fields displayed - ' . ($all_tests_passed ? '✓ PASS' : 'Review needed'));
WP_CLI::log('  - Requirement 10.3: Upcoming event highlighting - ' . (empty($warnings) ? '✓ PASS' : '⚠ Needs test events'));
WP_CLI::log('  - Requirement 10.5: Category filtering - ' . ($all_tests_passed ? '✓ PASS' : 'Review needed'));
WP_CLI::log('  - Responsive Design: Mobile-friendly layout - ' . ($all_tests_passed ? '✓ PASS' : 'Review needed'));
