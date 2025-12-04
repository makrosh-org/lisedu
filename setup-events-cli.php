<?php
/**
 * CLI Setup Script for Events Custom Post Type
 * 
 * This script creates default event categories
 * 
 * Usage: php setup-events-cli.php
 */

// Load WordPress
define('WP_USE_THEMES', false);
require_once('wp-load.php');

echo "\n";
echo "========================================\n";
echo "Events Custom Post Type Setup\n";
echo "========================================\n\n";

// Step 1: Flush rewrite rules
echo "Step 1: Flushing rewrite rules...\n";
flush_rewrite_rules();
echo "✓ Rewrite rules flushed\n\n";

// Step 2: Create default event categories
echo "Step 2: Creating event categories...\n";

$default_categories = array(
    'Academic' => 'Academic events including exams, parent-teacher meetings, and educational activities',
    'Sports' => 'Sports events, competitions, and physical education activities',
    'Cultural' => 'Cultural programs, performances, and celebrations',
    'Holidays' => 'School holidays, breaks, and closures',
    'Parent Events' => 'Events specifically for parents including meetings, workshops, and orientations',
);

$created = 0;
$existing = 0;
$errors = 0;

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
            $created++;
            echo "  ✓ Created: {$category_name}\n";
        } else {
            $errors++;
            echo "  ✗ Error creating {$category_name}: " . $result->get_error_message() . "\n";
        }
    } else {
        $existing++;
        echo "  ℹ Already exists: {$category_name}\n";
    }
}

echo "\n";
echo "========================================\n";
echo "Setup Summary\n";
echo "========================================\n\n";
echo "Categories created: {$created}\n";
echo "Categories already existed: {$existing}\n";
echo "Errors: {$errors}\n\n";

if ($errors === 0) {
    echo "✓ Setup completed successfully!\n\n";
    echo "Next steps:\n";
    echo "1. Go to WordPress Admin → Events → Add New\n";
    echo "2. Create your first event\n";
    echo "3. View events at: " . get_post_type_archive_link('lis_event') . "\n";
    echo "4. Run verification: php verify-events-cpt.php\n\n";
} else {
    echo "⚠ Setup completed with errors. Please review the output above.\n\n";
}
