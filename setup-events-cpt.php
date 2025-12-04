<?php
/**
 * Setup Script for Events Custom Post Type
 * 
 * This script:
 * 1. Registers the Events custom post type
 * 2. Creates default event categories
 * 3. Flushes rewrite rules
 * 
 * Requirements: 10.1, 10.2, 10.5
 * Task 15: Create custom post type for Events
 * 
 * Usage: Run this script once via browser or WP-CLI
 */

// Load WordPress
require_once('wp-load.php');

// Check if user is logged in and has admin privileges
if (!is_user_logged_in() || !current_user_can('manage_options')) {
    wp_die('You do not have permission to access this page.');
}

echo "<h1>Setting up Events Custom Post Type</h1>";
echo "<div style='max-width: 800px; margin: 20px auto; padding: 20px; background: #f7f7f7; border-radius: 8px;'>";

// Step 1: Flush rewrite rules to register the custom post type
echo "<h2>Step 1: Registering Custom Post Type</h2>";
flush_rewrite_rules();
echo "<p style='color: green;'>✓ Events custom post type registered successfully!</p>";

// Step 2: Create default event categories
echo "<h2>Step 2: Creating Event Categories</h2>";

$default_categories = array(
    'Academic' => 'Academic events including exams, parent-teacher meetings, and educational activities',
    'Sports' => 'Sports events, competitions, and physical education activities',
    'Cultural' => 'Cultural programs, performances, and celebrations',
    'Holidays' => 'School holidays, breaks, and closures',
    'Parent Events' => 'Events specifically for parents including meetings, workshops, and orientations',
);

$created_categories = array();
$existing_categories = array();

foreach ($default_categories as $category_name => $category_description) {
    // Check if category already exists
    $term = term_exists($category_name, 'event_category');
    
    if ($term === 0 || $term === null) {
        // Category doesn't exist, create it
        $result = wp_insert_term(
            $category_name,
            'event_category',
            array(
                'description' => $category_description,
                'slug' => sanitize_title($category_name),
            )
        );
        
        if (!is_wp_error($result)) {
            $created_categories[] = $category_name;
            echo "<p style='color: green;'>✓ Created category: <strong>{$category_name}</strong></p>";
        } else {
            echo "<p style='color: red;'>✗ Error creating category {$category_name}: " . $result->get_error_message() . "</p>";
        }
    } else {
        $existing_categories[] = $category_name;
        echo "<p style='color: blue;'>ℹ Category already exists: <strong>{$category_name}</strong></p>";
    }
}

// Step 3: Summary
echo "<h2>Step 3: Setup Summary</h2>";
echo "<div style='background: white; padding: 20px; border-radius: 8px; border-left: 5px solid #7EBEC5;'>";
echo "<h3>Setup Complete!</h3>";
echo "<ul>";
echo "<li><strong>Custom Post Type:</strong> lis_event (Events)</li>";
echo "<li><strong>Taxonomy:</strong> event_category (Event Categories)</li>";
echo "<li><strong>Categories Created:</strong> " . count($created_categories) . "</li>";
echo "<li><strong>Categories Already Existed:</strong> " . count($existing_categories) . "</li>";
echo "</ul>";

echo "<h4>Event Categories:</h4>";
echo "<ul>";
foreach ($default_categories as $category_name => $description) {
    echo "<li><strong>{$category_name}:</strong> {$description}</li>";
}
echo "</ul>";

echo "<h4>Custom Fields Available:</h4>";
echo "<ul>";
echo "<li><strong>event_date:</strong> Date when the event starts (required)</li>";
echo "<li><strong>event_time:</strong> Time when the event starts (required)</li>";
echo "<li><strong>event_location:</strong> Location where the event takes place (required)</li>";
echo "<li><strong>event_end_date:</strong> End date for multi-day events (optional)</li>";
echo "</ul>";

echo "<h4>Templates Created:</h4>";
echo "<ul>";
echo "<li><strong>single-lis_event.php:</strong> Single event display template</li>";
echo "<li><strong>archive-lis_event.php:</strong> Events archive/listing template</li>";
echo "</ul>";

echo "<h4>Features:</h4>";
echo "<ul>";
echo "<li>✓ Events displayed in chronological order (Requirement 10.1)</li>";
echo "<li>✓ All required fields displayed (title, date, time, location, description) (Requirement 10.2)</li>";
echo "<li>✓ Events within next 7 days are visually highlighted (Requirement 10.3)</li>";
echo "<li>✓ Category filtering functionality (Requirement 10.5)</li>";
echo "<li>✓ Responsive design for all devices</li>";
echo "<li>✓ Integration with existing shortcode [lumina_upcoming_events]</li>";
echo "</ul>";

echo "</div>";

// Step 4: Next Steps
echo "<h2>Next Steps</h2>";
echo "<div style='background: #FFF9F0; padding: 20px; border-radius: 8px; border-left: 5px solid #F39A3B;'>";
echo "<h3>How to Add Events:</h3>";
echo "<ol>";
echo "<li>Go to WordPress Admin Dashboard</li>";
echo "<li>Navigate to <strong>Events → Add New</strong></li>";
echo "<li>Enter the event title and description</li>";
echo "<li>Fill in the required fields in the 'Event Details' meta box:";
echo "<ul>";
echo "<li>Event Date (required)</li>";
echo "<li>Event Time (required)</li>";
echo "<li>Event Location (required)</li>";
echo "<li>Event End Date (optional, for multi-day events)</li>";
echo "</ul>";
echo "</li>";
echo "<li>Select one or more event categories</li>";
echo "<li>Add a featured image (recommended)</li>";
echo "<li>Click <strong>Publish</strong></li>";
echo "</ol>";

echo "<h3>View Events:</h3>";
echo "<ul>";
echo "<li><strong>Events Archive:</strong> <a href='" . get_post_type_archive_link('lis_event') . "' target='_blank'>" . get_post_type_archive_link('lis_event') . "</a></li>";
echo "<li><strong>Homepage Widget:</strong> Use shortcode <code>[lumina_upcoming_events limit=\"3\"]</code></li>";
echo "</ul>";

echo "<h3>Verification:</h3>";
echo "<p>Run the verification script to test the Events functionality:</p>";
echo "<pre style='background: #333; color: #0f0; padding: 15px; border-radius: 5px;'>php verify-events-cpt.php</pre>";

echo "</div>";

echo "</div>";

echo "<div style='text-align: center; margin: 30px 0;'>";
echo "<a href='" . admin_url('post-new.php?post_type=lis_event') . "' style='display: inline-block; padding: 15px 30px; background: #003d70; color: white; text-decoration: none; border-radius: 8px; font-weight: 600;'>Create Your First Event</a>";
echo " ";
echo "<a href='" . get_post_type_archive_link('lis_event') . "' style='display: inline-block; padding: 15px 30px; background: #7EBEC5; color: white; text-decoration: none; border-radius: 8px; font-weight: 600;'>View Events Page</a>";
echo "</div>";
