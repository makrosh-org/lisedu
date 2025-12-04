<?php
/**
 * Setup Events Page via WP-CLI
 * 
 * This script configures the Events page
 * Requirements: 10.1, 10.2, 10.3, 10.5
 * Task 16: Build Events page with calendar functionality
 */

// Get or verify Events page
$events_page = get_page_by_path('events');

if (!$events_page) {
    WP_CLI::error('Events page not found. Please create it first.');
    exit;
}

$page_id = $events_page->ID;

WP_CLI::log("Found Events page with ID: {$page_id}");

// Enable Elementor for this page
update_post_meta($page_id, '_elementor_edit_mode', 'builder');
update_post_meta($page_id, '_elementor_template_type', 'wp-page');
update_post_meta($page_id, '_wp_page_template', 'elementor_header_footer');

WP_CLI::success('Elementor enabled for Events page');

// Create Elementor page structure
$elementor_data = array(
    array(
        'id' => 'events-header-section',
        'elType' => 'section',
        'settings' => array(
            'background_background' => 'classic',
            'background_color' => '#f7f7f7',
            'padding' => array(
                'unit' => 'px',
                'top' => '60',
                'right' => '20',
                'bottom' => '60',
                'left' => '20',
            ),
        ),
        'elements' => array(
            array(
                'id' => 'events-header-column',
                'elType' => 'column',
                'settings' => array(
                    '_column_size' => 100,
                ),
                'elements' => array(
                    array(
                        'id' => 'events-title',
                        'elType' => 'widget',
                        'widgetType' => 'heading',
                        'settings' => array(
                            'title' => 'School Events',
                            'header_size' => 'h1',
                            'align' => 'center',
                            'title_color' => '#003d70',
                        ),
                    ),
                    array(
                        'id' => 'events-description',
                        'elType' => 'widget',
                        'widgetType' => 'text-editor',
                        'settings' => array(
                            'editor' => '<p style="text-align: center; font-size: 18px; color: #666;">Stay informed about upcoming school activities, academic events, sports, cultural programs, and important dates.</p>',
                        ),
                    ),
                ),
            ),
        ),
    ),
);

// Save Elementor data
update_post_meta($page_id, '_elementor_data', wp_slash(wp_json_encode($elementor_data)));

WP_CLI::success('Events page layout created');

// Verify templates
$child_archive = get_stylesheet_directory() . '/archive-lis_event.php';
$child_single = get_stylesheet_directory() . '/single-lis_event.php';

if (file_exists($child_archive)) {
    WP_CLI::success('Events archive template found');
} else {
    WP_CLI::warning('Events archive template not found');
}

if (file_exists($child_single)) {
    WP_CLI::success('Single event template found');
} else {
    WP_CLI::warning('Single event template not found');
}

// Display URLs
$page_url = get_permalink($page_id);
$archive_url = get_post_type_archive_link('lis_event');

WP_CLI::log("Events Page URL: {$page_url}");
WP_CLI::log("Events Archive URL: {$archive_url}");

WP_CLI::success('Events page setup complete!');
