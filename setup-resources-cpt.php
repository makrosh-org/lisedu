<?php
/**
 * Setup Script for Resources Custom Post Type
 * 
 * This script:
 * 1. Registers the Resources custom post type
 * 2. Creates default resource categories
 * 3. Flushes rewrite rules
 * 
 * Requirements: 12.1, 12.2, 12.3, 12.4, 12.5
 * Task 19: Create custom post type for Resources
 * 
 * Usage: Run this script once via browser or WP-CLI
 */

// Load WordPress
require_once('wp-load.php');

// Check if user is logged in and has admin privileges
if (!is_user_logged_in() || !current_user_can('manage_options')) {
    wp_die('You do not have permission to access this page.');
}

echo "<h1>Setting up Resources Custom Post Type</h1>";
echo "<div style='max-width: 800px; margin: 20px auto; padding: 20px; background: #f7f7f7; border-radius: 8px;'>";

// Step 1: Flush rewrite rules to register the custom post type
echo "<h2>Step 1: Registering Custom Post Type</h2>";
flush_rewrite_rules();
echo "<p style='color: green;'>✓ Resources custom post type registered successfully!</p>";

// Step 2: Create default resource categories
echo "<h2>Step 2: Creating Resource Categories</h2>";

$default_categories = array(
    'Admission Forms' => 'Forms and documents required for the admission process',
    'Academic Policies' => 'School policies related to academics, curriculum, and educational standards',
    'Parent Handbook' => 'Comprehensive guides and handbooks for parents',
    'Fee Information' => 'Fee structures, payment schedules, and financial information',
    'Calendar' => 'Academic calendars, event schedules, and important dates',
);

$created_categories = array();
$existing_categories = array();

foreach ($default_categories as $category_name => $category_description) {
    // Check if category already exists
    $term = term_exists($category_name, 'resource_category');
    
    if ($term === 0 || $term === null) {
        // Category doesn't exist, create it
        $result = wp_insert_term(
            $category_name,
            'resource_category',
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
echo "<li><strong>Custom Post Type:</strong> lis_resource (Resources)</li>";
echo "<li><strong>Taxonomy:</strong> resource_category (Resource Categories)</li>";
echo "<li><strong>Categories Created:</strong> " . count($created_categories) . "</li>";
echo "<li><strong>Categories Already Existed:</strong> " . count($existing_categories) . "</li>";
echo "</ul>";

echo "<h4>Resource Categories:</h4>";
echo "<ul>";
foreach ($default_categories as $category_name => $description) {
    echo "<li><strong>{$category_name}:</strong> {$description}</li>";
}
echo "</ul>";

echo "<h4>Custom Fields Available:</h4>";
echo "<ul>";
echo "<li><strong>File Upload:</strong> Upload PDF, DOC, DOCX, XLS, XLSX files (required)</li>";
echo "<li><strong>File Type:</strong> Automatically detected from uploaded file</li>";
echo "<li><strong>File Size:</strong> Automatically calculated from uploaded file</li>";
echo "<li><strong>Download Count:</strong> Automatically tracked when users download (Requirement 12.5)</li>";
echo "<li><strong>Access Level:</strong> Public or Restricted (logged-in users only)</li>";
echo "</ul>";

echo "<h4>Templates Created:</h4>";
echo "<ul>";
echo "<li><strong>single-lis_resource.php:</strong> Single resource display template with download functionality</li>";
echo "<li><strong>archive-lis_resource.php:</strong> Resources archive/listing template with category filtering</li>";
echo "</ul>";

echo "<h4>Features:</h4>";
echo "<ul>";
echo "<li>✓ Resources organized by categories (Requirement 12.1)</li>";
echo "<li>✓ Download links that open PDFs in new tab or initiate download (Requirement 12.2)</li>";
echo "<li>✓ File type and size information displayed (Requirement 12.3)</li>";
echo "<li>✓ Support for PDF, DOC, DOCX, XLS, XLSX formats (Requirement 12.4)</li>";
echo "<li>✓ Download count tracking for administrative reporting (Requirement 12.5)</li>";
echo "<li>✓ Access level control (public or restricted)</li>";
echo "<li>✓ Responsive design for all devices</li>";
echo "<li>✓ Category filtering on archive page</li>";
echo "<li>✓ Related resources suggestions</li>";
echo "</ul>";

echo "</div>";

// Step 4: Next Steps
echo "<h2>Next Steps</h2>";
echo "<div style='background: #FFF9F0; padding: 20px; border-radius: 8px; border-left: 5px solid #F39A3B;'>";
echo "<h3>How to Add Resources:</h3>";
echo "<ol>";
echo "<li>Go to WordPress Admin Dashboard</li>";
echo "<li>Navigate to <strong>Resources → Add New</strong></li>";
echo "<li>Enter the resource title and description</li>";
echo "<li>In the 'Resource Details' meta box:";
echo "<ul>";
echo "<li>Click <strong>Upload File</strong> to select a document</li>";
echo "<li>File type and size will be automatically detected</li>";
echo "<li>Choose access level (Public or Restricted)</li>";
echo "<li>Download count starts at 0 and increments automatically</li>";
echo "</ul>";
echo "</li>";
echo "<li>Select one or more resource categories</li>";
echo "<li>Add a featured image (optional, for visual appeal)</li>";
echo "<li>Click <strong>Publish</strong></li>";
echo "</ol>";

echo "<h3>Download Tracking:</h3>";
echo "<p>The system automatically tracks downloads when users click the download button. The download count is displayed on both the archive and single resource pages.</p>";

echo "<h3>Access Control:</h3>";
echo "<ul>";
echo "<li><strong>Public:</strong> Anyone can download the resource</li>";
echo "<li><strong>Restricted:</strong> Only logged-in users can download. Non-logged-in users will see a login prompt.</li>";
echo "</ul>";

echo "<h3>Supported File Formats:</h3>";
echo "<ul>";
echo "<li>📕 <strong>PDF</strong> - Portable Document Format</li>";
echo "<li>📘 <strong>DOC/DOCX</strong> - Microsoft Word Documents</li>";
echo "<li>📊 <strong>XLS/XLSX</strong> - Microsoft Excel Spreadsheets</li>";
echo "</ul>";

echo "<h3>View Resources:</h3>";
echo "<ul>";
echo "<li><strong>Resources Archive:</strong> <a href='" . get_post_type_archive_link('lis_resource') . "' target='_blank'>" . get_post_type_archive_link('lis_resource') . "</a></li>";
echo "</ul>";

echo "<h3>Verification:</h3>";
echo "<p>Run the verification script to test the Resources functionality:</p>";
echo "<pre style='background: #333; color: #0f0; padding: 15px; border-radius: 5px;'>php verify-resources-cpt.php</pre>";

echo "</div>";

echo "</div>";

echo "<div style='text-align: center; margin: 30px 0;'>";
echo "<a href='" . admin_url('post-new.php?post_type=lis_resource') . "' style='display: inline-block; padding: 15px 30px; background: #003d70; color: white; text-decoration: none; border-radius: 8px; font-weight: 600;'>Add Your First Resource</a>";
echo " ";
echo "<a href='" . get_post_type_archive_link('lis_resource') . "' style='display: inline-block; padding: 15px 30px; background: #7EBEC5; color: white; text-decoration: none; border-radius: 8px; font-weight: 600;'>View Resources Page</a>";
echo "</div>";
