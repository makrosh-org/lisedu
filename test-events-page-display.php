<?php
/**
 * Test Events Page Display
 * 
 * This script tests the visual display and functionality of the Events page
 * Task 16: Build Events page with calendar functionality
 */

// Test chronological ordering
WP_CLI::log('=== Testing Event Chronological Ordering ===');

$events = get_posts(array(
    'post_type' => 'lis_event',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'meta_key' => 'event_date',
    'orderby' => 'meta_value',
    'order' => 'ASC',
));

if (!empty($events)) {
    WP_CLI::log("Found " . count($events) . " events");
    WP_CLI::log('');
    
    foreach ($events as $index => $event) {
        $event_date = get_post_meta($event->ID, 'event_date', true);
        $event_time = get_post_meta($event->ID, 'event_time', true);
        $event_location = get_post_meta($event->ID, 'event_location', true);
        $categories = get_the_terms($event->ID, 'event_category');
        
        $category_names = array();
        if ($categories && !is_wp_error($categories)) {
            foreach ($categories as $cat) {
                $category_names[] = $cat->name;
            }
        }
        
        WP_CLI::log(($index + 1) . ". {$event->post_title}");
        WP_CLI::log("   Date: " . date('F j, Y', strtotime($event_date)));
        WP_CLI::log("   Time: " . date('g:i A', strtotime($event_time)));
        WP_CLI::log("   Location: {$event_location}");
        WP_CLI::log("   Categories: " . implode(', ', $category_names));
        
        // Check if upcoming
        $today = strtotime(date('Y-m-d'));
        $seven_days = strtotime('+7 days', $today);
        $event_timestamp = strtotime($event_date);
        
        if ($event_timestamp >= $today && $event_timestamp <= $seven_days) {
            $days_until = floor(($event_timestamp - $today) / (60 * 60 * 24));
            WP_CLI::log("   🔔 UPCOMING! ({$days_until} days away)");
        }
        
        WP_CLI::log('');
    }
} else {
    WP_CLI::error('No events found');
}

// Test category distribution
WP_CLI::log('=== Testing Category Distribution ===');

$categories = get_terms(array(
    'taxonomy' => 'event_category',
    'hide_empty' => false,
));

if ($categories && !is_wp_error($categories)) {
    foreach ($categories as $category) {
        $count = $category->count;
        WP_CLI::log("{$category->name}: {$count} events");
    }
} else {
    WP_CLI::error('No categories found');
}

WP_CLI::log('');

// Test upcoming events
WP_CLI::log('=== Testing Upcoming Events Highlighting ===');

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
    WP_CLI::log("Found " . count($upcoming_events) . " upcoming events (within 7 days):");
    WP_CLI::log('');
    
    foreach ($upcoming_events as $event) {
        $event_date = get_post_meta($event->ID, 'event_date', true);
        $days_until = floor((strtotime($event_date) - $today) / (60 * 60 * 24));
        
        WP_CLI::log("🔔 {$event->post_title}");
        WP_CLI::log("   Date: " . date('F j, Y', strtotime($event_date)));
        WP_CLI::log("   Days until: {$days_until}");
        WP_CLI::log("   Should display with orange highlighting");
        WP_CLI::log('');
    }
} else {
    WP_CLI::warning('No upcoming events within next 7 days');
}

// Test page URLs
WP_CLI::log('=== Testing Page URLs ===');

$events_page = get_page_by_path('events');
if ($events_page) {
    $page_url = get_permalink($events_page->ID);
    WP_CLI::log("Events Page: {$page_url}");
}

$archive_url = get_post_type_archive_link('lis_event');
WP_CLI::log("Events Archive: {$archive_url}");

WP_CLI::log('');

// Test individual event URLs
WP_CLI::log('=== Sample Event URLs ===');

foreach (array_slice($events, 0, 3) as $event) {
    $event_url = get_permalink($event->ID);
    WP_CLI::log("{$event->post_title}: {$event_url}");
}

WP_CLI::log('');

// Test category filter URLs
WP_CLI::log('=== Category Filter URLs ===');

if ($categories && !is_wp_error($categories)) {
    foreach ($categories as $category) {
        $category_url = get_term_link($category);
        WP_CLI::log("{$category->name}: {$category_url}");
    }
}

WP_CLI::log('');
WP_CLI::success('Events page display test complete!');
WP_CLI::log('');
WP_CLI::log('Next Steps:');
WP_CLI::log('1. Visit the Events page in your browser');
WP_CLI::log('2. Test category filtering by clicking filter buttons');
WP_CLI::log('3. Verify upcoming events have orange highlighting');
WP_CLI::log('4. Test responsive design on mobile/tablet/desktop');
WP_CLI::log('5. Click on events to view detail pages');
