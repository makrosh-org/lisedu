<?php
/**
 * Create Test Events
 * 
 * This script creates sample events for testing the Events page
 * Task 16: Build Events page with calendar functionality
 */

// Sample events data
$test_events = array(
    array(
        'title' => 'Parent-Teacher Conference',
        'content' => 'Join us for our quarterly parent-teacher conference to discuss your child\'s progress and development. Individual time slots will be assigned to each family.',
        'date' => date('Y-m-d', strtotime('+3 days')),
        'time' => '14:00:00',
        'location' => 'Main School Building, Classrooms',
        'category' => 'Parent Events',
    ),
    array(
        'title' => 'Annual Sports Day',
        'content' => 'Our annual sports day featuring track and field events, team sports, and fun activities for all grade levels. Parents are encouraged to attend and cheer for their children!',
        'date' => date('Y-m-d', strtotime('+5 days')),
        'time' => '09:00:00',
        'location' => 'School Sports Ground',
        'category' => 'Sports',
    ),
    array(
        'title' => 'Islamic Studies Workshop',
        'content' => 'A special workshop on Islamic values and character building for students in grades 3-5. Led by our experienced Islamic Studies teachers.',
        'date' => date('Y-m-d', strtotime('+10 days')),
        'time' => '10:30:00',
        'location' => 'School Auditorium',
        'category' => 'Academic',
    ),
    array(
        'title' => 'Cultural Festival',
        'content' => 'Celebrate diversity with our annual cultural festival! Students will showcase traditional dances, music, and art from various cultures. Food stalls and exhibitions included.',
        'date' => date('Y-m-d', strtotime('+15 days')),
        'time' => '15:00:00',
        'location' => 'School Grounds',
        'category' => 'Cultural',
        'end_date' => date('Y-m-d', strtotime('+16 days')),
    ),
    array(
        'title' => 'Mid-Term Examinations',
        'content' => 'Mid-term examinations for all grade levels. Please ensure students arrive on time and bring all necessary materials.',
        'date' => date('Y-m-d', strtotime('+20 days')),
        'time' => '08:00:00',
        'location' => 'Examination Halls',
        'category' => 'Academic',
        'end_date' => date('Y-m-d', strtotime('+24 days')),
    ),
    array(
        'title' => 'Winter Break',
        'content' => 'School will be closed for winter break. Classes will resume on the specified date. Enjoy your holidays!',
        'date' => date('Y-m-d', strtotime('+30 days')),
        'time' => '00:00:00',
        'location' => 'N/A',
        'category' => 'Holidays',
        'end_date' => date('Y-m-d', strtotime('+44 days')),
    ),
    array(
        'title' => 'Science Fair',
        'content' => 'Students will present their science projects and experiments. Parents and community members are welcome to attend and view the innovative work of our young scientists.',
        'date' => date('Y-m-d', strtotime('+50 days')),
        'time' => '13:00:00',
        'location' => 'School Gymnasium',
        'category' => 'Academic',
    ),
    array(
        'title' => 'Football Tournament',
        'content' => 'Inter-class football tournament for grades 3-5. Come support your class team!',
        'date' => date('Y-m-d', strtotime('+60 days')),
        'time' => '14:30:00',
        'location' => 'Football Field',
        'category' => 'Sports',
    ),
);

$created_count = 0;
$errors = array();

foreach ($test_events as $event_data) {
    // Create the event post
    $post_id = wp_insert_post(array(
        'post_title' => $event_data['title'],
        'post_content' => $event_data['content'],
        'post_status' => 'publish',
        'post_type' => 'lis_event',
    ));
    
    if (is_wp_error($post_id)) {
        $errors[] = "Failed to create event: {$event_data['title']} - " . $post_id->get_error_message();
        continue;
    }
    
    // Add custom fields
    update_post_meta($post_id, 'event_date', $event_data['date']);
    update_post_meta($post_id, 'event_time', $event_data['time']);
    update_post_meta($post_id, 'event_location', $event_data['location']);
    
    if (isset($event_data['end_date'])) {
        update_post_meta($post_id, 'event_end_date', $event_data['end_date']);
    }
    
    // Assign category
    $category = get_term_by('name', $event_data['category'], 'event_category');
    if ($category) {
        wp_set_object_terms($post_id, $category->term_id, 'event_category');
    }
    
    $created_count++;
    WP_CLI::log("Created event: {$event_data['title']} on {$event_data['date']}");
}

if (!empty($errors)) {
    WP_CLI::warning('Some events failed to create:');
    foreach ($errors as $error) {
        WP_CLI::log("  - {$error}");
    }
}

WP_CLI::success("Created {$created_count} test events");

// Display summary
WP_CLI::log('');
WP_CLI::log('Event Summary:');
WP_CLI::log("  - Total events created: {$created_count}");

$today = strtotime(date('Y-m-d'));
$seven_days = strtotime('+7 days', $today);
$upcoming_count = 0;

foreach ($test_events as $event_data) {
    $event_timestamp = strtotime($event_data['date']);
    if ($event_timestamp >= $today && $event_timestamp <= $seven_days) {
        $upcoming_count++;
    }
}

WP_CLI::log("  - Events within next 7 days: {$upcoming_count}");
WP_CLI::log('');
WP_CLI::log('View the Events page to see the results!');
