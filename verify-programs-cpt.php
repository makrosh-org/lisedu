<?php
/**
 * Verification Script for Programs Custom Post Type
 * 
 * This script verifies that the Programs custom post type has been
 * properly registered with all required features.
 * 
 * Requirements: 1.3
 */

// Load WordPress
require_once __DIR__ . '/wp-load.php';

echo "=== Programs Custom Post Type Verification ===\n\n";

// Check if custom post type is registered
$post_type_exists = post_type_exists('lis_program');
echo "1. Custom Post Type 'lis_program' registered: " . ($post_type_exists ? "✓ YES" : "✗ NO") . "\n";

if ($post_type_exists) {
    // Get post type object
    $post_type_obj = get_post_type_object('lis_program');
    
    echo "\n2. Post Type Details:\n";
    echo "   - Label: " . $post_type_obj->label . "\n";
    echo "   - Public: " . ($post_type_obj->public ? "✓ YES" : "✗ NO") . "\n";
    echo "   - Has Archive: " . ($post_type_obj->has_archive ? "✓ YES" : "✗ NO") . "\n";
    echo "   - Show in REST: " . ($post_type_obj->show_in_rest ? "✓ YES" : "✗ NO") . "\n";
    echo "   - Menu Icon: " . $post_type_obj->menu_icon . "\n";
    echo "   - Rewrite Slug: " . ($post_type_obj->rewrite['slug'] ?? 'N/A') . "\n";
    
    echo "\n3. Supported Features:\n";
    $supports = get_all_post_type_supports('lis_program');
    foreach ($supports as $feature => $value) {
        echo "   - " . $feature . ": ✓\n";
    }
}

// Check if taxonomy is registered
$taxonomy_exists = taxonomy_exists('program_category');
echo "\n4. Taxonomy 'program_category' registered: " . ($taxonomy_exists ? "✓ YES" : "✗ NO") . "\n";

if ($taxonomy_exists) {
    $taxonomy_obj = get_taxonomy('program_category');
    
    echo "\n5. Taxonomy Details:\n";
    echo "   - Label: " . $taxonomy_obj->label . "\n";
    echo "   - Hierarchical: " . ($taxonomy_obj->hierarchical ? "✓ YES" : "✗ NO") . "\n";
    echo "   - Public: " . ($taxonomy_obj->public ? "✓ YES" : "✗ NO") . "\n";
    echo "   - Show in REST: " . ($taxonomy_obj->show_in_rest ? "✓ YES" : "✗ NO") . "\n";
    echo "   - Rewrite Slug: " . ($taxonomy_obj->rewrite['slug'] ?? 'N/A') . "\n";
    
    // Check associated post types
    echo "   - Associated Post Types: " . implode(', ', $taxonomy_obj->object_type) . "\n";
}

// Check for meta boxes
echo "\n6. Custom Meta Boxes:\n";
global $wp_meta_boxes;
if (isset($wp_meta_boxes['lis_program'])) {
    foreach ($wp_meta_boxes['lis_program'] as $context => $priorities) {
        foreach ($priorities as $priority => $boxes) {
            foreach ($boxes as $box_id => $box) {
                if (strpos($box_id, 'lumina') !== false) {
                    echo "   - " . $box['title'] . " (Context: $context, Priority: $priority): ✓\n";
                }
            }
        }
    }
} else {
    echo "   - Meta boxes will be registered on edit screen\n";
}

// Check template files
echo "\n7. Template Files:\n";
$theme_dir = get_stylesheet_directory();
$single_template = $theme_dir . '/single-lis_program.php';
$archive_template = $theme_dir . '/archive-lis_program.php';

echo "   - Single template (single-lis_program.php): " . (file_exists($single_template) ? "✓ EXISTS" : "✗ MISSING") . "\n";
echo "   - Archive template (archive-lis_program.php): " . (file_exists($archive_template) ? "✓ EXISTS" : "✗ MISSING") . "\n";

// Test creating a sample program (if none exist)
$existing_programs = get_posts(array(
    'post_type' => 'lis_program',
    'posts_per_page' => 1,
    'post_status' => 'any',
));

echo "\n8. Existing Programs: " . count($existing_programs) . "\n";

if (count($existing_programs) === 0) {
    echo "\n9. Creating Test Program...\n";
    
    // Create a test program
    $test_program_id = wp_insert_post(array(
        'post_title' => 'Test Program - Play Group',
        'post_content' => 'This is a test program to verify the custom post type functionality. It includes comprehensive curriculum designed for young learners.',
        'post_type' => 'lis_program',
        'post_status' => 'draft',
        'post_author' => 1,
    ));
    
    if (!is_wp_error($test_program_id)) {
        echo "   - Test program created with ID: $test_program_id ✓\n";
        
        // Add custom fields
        update_post_meta($test_program_id, '_program_age_range', '3-4 years');
        update_post_meta($test_program_id, '_program_curriculum_highlights', "Early literacy development\nBasic numeracy skills\nSocial and emotional learning\nIslamic values introduction");
        
        echo "   - Custom fields added ✓\n";
        
        // Create and assign a test category
        $test_category = wp_insert_term('Academic', 'program_category');
        if (!is_wp_error($test_category)) {
            wp_set_object_terms($test_program_id, $test_category['term_id'], 'program_category');
            echo "   - Test category created and assigned ✓\n";
        }
        
        // Verify custom fields
        $age_range = get_post_meta($test_program_id, '_program_age_range', true);
        $curriculum = get_post_meta($test_program_id, '_program_curriculum_highlights', true);
        
        echo "\n10. Custom Field Verification:\n";
        echo "   - Age Range: " . ($age_range ? "✓ '$age_range'" : "✗ NOT SAVED") . "\n";
        echo "   - Curriculum Highlights: " . ($curriculum ? "✓ SAVED (" . str_word_count($curriculum) . " words)" : "✗ NOT SAVED") . "\n";
        
        // Get the program URL
        $program_url = get_permalink($test_program_id);
        echo "\n11. Test Program URL: $program_url\n";
        echo "    (Note: Program is in draft status)\n";
        
    } else {
        echo "   - Error creating test program: " . $test_program_id->get_error_message() . " ✗\n";
    }
} else {
    echo "   - Programs already exist, skipping test creation\n";
    
    // Show existing programs
    echo "\n9. Existing Programs:\n";
    foreach ($existing_programs as $program) {
        echo "   - " . $program->post_title . " (ID: " . $program->ID . ", Status: " . $program->post_status . ")\n";
        
        $age_range = get_post_meta($program->ID, '_program_age_range', true);
        if ($age_range) {
            echo "     Age Range: $age_range\n";
        }
    }
}

// Check archive URL
$archive_url = get_post_type_archive_link('lis_program');
echo "\n12. Programs Archive URL: " . ($archive_url ? $archive_url : "Not available") . "\n";

// Summary
echo "\n=== VERIFICATION SUMMARY ===\n";
$checks = array(
    'Custom Post Type Registered' => $post_type_exists,
    'Taxonomy Registered' => $taxonomy_exists,
    'Single Template Exists' => file_exists($single_template),
    'Archive Template Exists' => file_exists($archive_template),
);

$passed = 0;
$total = count($checks);

foreach ($checks as $check => $result) {
    echo ($result ? "✓" : "✗") . " $check\n";
    if ($result) $passed++;
}

echo "\nResult: $passed/$total checks passed\n";

if ($passed === $total) {
    echo "\n✓ All checks passed! The Programs custom post type is properly configured.\n";
} else {
    echo "\n✗ Some checks failed. Please review the output above.\n";
}

echo "\n=== END VERIFICATION ===\n";
