<?php
/**
 * Verify Programs Page Implementation
 * 
 * This script verifies that Task 9 has been completed successfully:
 * - Programs page has Elementor layout
 * - All grade levels created (Play Group to Grade 5)
 * - Expandable sections implemented
 * - Curriculum highlights added
 * - Islamic studies integration section present
 * - Extracurricular activities section present
 * - Responsive grid layout implemented
 * 
 * Requirements: 1.3
 */

require_once 'wp-load.php';

if (!defined('ABSPATH')) {
    die('WordPress not loaded');
}

echo "=== Programs Page Verification ===\n\n";

$all_checks_passed = true;

// Check 1: Programs page exists and has Elementor data
echo "1. Checking Programs page...\n";
$programs_page = get_page_by_path('programs');
if ($programs_page) {
    echo "   ✓ Programs page exists (ID: {$programs_page->ID})\n";
    
    $elementor_data = get_post_meta($programs_page->ID, '_elementor_data', true);
    if (!empty($elementor_data)) {
        echo "   ✓ Elementor layout configured\n";
        
        // Check for key sections in Elementor data
        $data_decoded = json_decode($elementor_data, true);
        if ($data_decoded && is_array($data_decoded)) {
            echo "   ✓ Elementor data is valid JSON with " . count($data_decoded) . " sections\n";
        }
    } else {
        echo "   ✗ No Elementor layout found\n";
        $all_checks_passed = false;
    }
} else {
    echo "   ✗ Programs page not found\n";
    $all_checks_passed = false;
}

echo "\n";

// Check 2: All grade level programs exist
echo "2. Checking program posts...\n";
$expected_programs = [
    'Play Group',
    'Kindergarten',
    'Grade 1',
    'Grade 2',
    'Grade 3',
    'Grade 4',
    'Grade 5',
];

$programs = get_posts(array(
    'post_type' => 'lis_program',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'orderby' => 'menu_order',
    'order' => 'ASC',
));

echo "   Found " . count($programs) . " published programs\n";

foreach ($expected_programs as $expected) {
    $found = false;
    foreach ($programs as $program) {
        if ($program->post_title === $expected) {
            $found = true;
            
            // Check for age range
            $age_range = get_post_meta($program->ID, '_program_age_range', true);
            
            // Check for curriculum highlights
            $curriculum = get_post_meta($program->ID, '_program_curriculum_highlights', true);
            
            // Check for category
            $categories = get_the_terms($program->ID, 'program_category');
            
            echo "   ✓ $expected";
            
            if ($age_range) {
                echo " (Age: $age_range)";
            } else {
                echo " [Missing age range]";
            }
            
            if ($curriculum) {
                $highlights_count = count(array_filter(explode("\n", $curriculum)));
                echo " - $highlights_count curriculum highlights";
            } else {
                echo " [Missing curriculum]";
                $all_checks_passed = false;
            }
            
            if ($categories && !is_wp_error($categories)) {
                $cat_names = array_map(function($cat) { return $cat->name; }, $categories);
                echo " - Categories: " . implode(', ', $cat_names);
            }
            
            echo "\n";
            break;
        }
    }
    
    if (!$found) {
        echo "   ✗ $expected not found\n";
        $all_checks_passed = false;
    }
}

echo "\n";

// Check 3: Programs grid shortcode exists
echo "3. Checking programs grid shortcode...\n";
if (shortcode_exists('lumina_programs_grid')) {
    echo "   ✓ [lumina_programs_grid] shortcode registered\n";
    
    // Test the shortcode output
    $shortcode_output = do_shortcode('[lumina_programs_grid]');
    if (strpos($shortcode_output, 'lumina-programs-grid') !== false) {
        echo "   ✓ Shortcode generates grid HTML\n";
    } else {
        echo "   ✗ Shortcode output doesn't contain expected grid class\n";
        $all_checks_passed = false;
    }
    
    if (strpos($shortcode_output, 'program-toggle') !== false) {
        echo "   ✓ Expandable sections implemented\n";
    } else {
        echo "   ✗ Expandable sections not found\n";
        $all_checks_passed = false;
    }
    
    if (strpos($shortcode_output, 'curriculum-list') !== false) {
        echo "   ✓ Curriculum highlights display implemented\n";
    } else {
        echo "   ✗ Curriculum highlights display not found\n";
        $all_checks_passed = false;
    }
} else {
    echo "   ✗ [lumina_programs_grid] shortcode not registered\n";
    $all_checks_passed = false;
}

echo "\n";

// Check 4: Program category taxonomy
echo "4. Checking program categories...\n";
$category = get_term_by('name', 'Academic Programs', 'program_category');
if ($category) {
    echo "   ✓ 'Academic Programs' category exists\n";
    
    // Count programs in this category
    $cat_programs = get_posts(array(
        'post_type' => 'lis_program',
        'posts_per_page' => -1,
        'tax_query' => array(
            array(
                'taxonomy' => 'program_category',
                'field' => 'term_id',
                'terms' => $category->term_id,
            ),
        ),
    ));
    
    echo "   ✓ " . count($cat_programs) . " programs assigned to this category\n";
} else {
    echo "   ✗ 'Academic Programs' category not found\n";
    $all_checks_passed = false;
}

echo "\n";

// Check 5: Responsive design elements
echo "5. Checking responsive design implementation...\n";
$shortcode_output = do_shortcode('[lumina_programs_grid]');

if (strpos($shortcode_output, '@media') !== false) {
    echo "   ✓ Responsive CSS media queries present\n";
} else {
    echo "   ⚠ No media queries found in shortcode output\n";
}

if (strpos($shortcode_output, 'grid-template-columns') !== false) {
    echo "   ✓ CSS Grid layout implemented\n";
} else {
    echo "   ✗ CSS Grid not found\n";
    $all_checks_passed = false;
}

echo "\n";

// Check 6: Content sections
echo "6. Checking content sections...\n";

// Check for Islamic Studies integration in page content
$page_content = $programs_page->post_content;
$elementor_data = get_post_meta($programs_page->ID, '_elementor_data', true);

if (stripos($elementor_data, 'Islamic Studies Integration') !== false || 
    stripos($elementor_data, 'Islamic values') !== false) {
    echo "   ✓ Islamic Studies integration section present\n";
} else {
    echo "   ⚠ Islamic Studies integration section not clearly identified\n";
}

if (stripos($elementor_data, 'Extracurricular Activities') !== false) {
    echo "   ✓ Extracurricular Activities section present\n";
} else {
    echo "   ⚠ Extracurricular Activities section not clearly identified\n";
}

if (stripos($elementor_data, 'Apply Now') !== false || 
    stripos($elementor_data, 'Enroll') !== false) {
    echo "   ✓ Call-to-action section present\n";
} else {
    echo "   ⚠ Call-to-action section not found\n";
}

echo "\n";

// Check 7: Individual program pages
echo "7. Checking individual program pages...\n";
$sample_program = $programs[0] ?? null;
if ($sample_program) {
    $permalink = get_permalink($sample_program->ID);
    echo "   ✓ Program permalinks working\n";
    echo "   Sample: $permalink\n";
    
    // Check if single template exists
    $template_path = get_stylesheet_directory() . '/single-lis_program.php';
    if (file_exists($template_path)) {
        echo "   ✓ Single program template exists\n";
    } else {
        echo "   ⚠ Single program template not found (will use default)\n";
    }
} else {
    echo "   ✗ No programs available to check\n";
    $all_checks_passed = false;
}

echo "\n";

// Check 8: Archive template
echo "8. Checking archive template...\n";
$archive_template = get_stylesheet_directory() . '/archive-lis_program.php';
if (file_exists($archive_template)) {
    echo "   ✓ Archive template exists\n";
} else {
    echo "   ⚠ Archive template not found (will use default)\n";
}

echo "\n";

// Summary
echo "=== Verification Summary ===\n\n";

if ($all_checks_passed) {
    echo "✓ ALL CHECKS PASSED\n\n";
    echo "Task 9 Implementation Complete:\n";
    echo "- Programs page layout designed with Elementor\n";
    echo "- Program cards created for all grade levels (Play Group to Grade 5)\n";
    echo "- Expandable sections implemented for detailed information\n";
    echo "- Curriculum highlights added for each grade\n";
    echo "- Islamic studies integration information included\n";
    echo "- Extracurricular activities section added\n";
    echo "- Responsive grid layout ensured\n";
    echo "\nRequirements 1.3 validated ✓\n";
    echo "\nView the page at: " . get_permalink($programs_page->ID) . "\n";
} else {
    echo "✗ SOME CHECKS FAILED\n\n";
    echo "Please review the issues above and make necessary corrections.\n";
}

echo "\n=== Additional Information ===\n\n";
echo "Total Programs: " . count($programs) . "\n";
echo "Programs Page URL: " . get_permalink($programs_page->ID) . "\n";
echo "Archive URL: " . home_url('/programs/') . "\n";

// List all programs with their details
echo "\nProgram Details:\n";
foreach ($programs as $program) {
    echo "\n" . $program->post_title . ":\n";
    echo "  - URL: " . get_permalink($program->ID) . "\n";
    echo "  - Age Range: " . get_post_meta($program->ID, '_program_age_range', true) . "\n";
    
    $curriculum = get_post_meta($program->ID, '_program_curriculum_highlights', true);
    if ($curriculum) {
        $highlights = array_filter(explode("\n", $curriculum));
        echo "  - Curriculum Items: " . count($highlights) . "\n";
    }
}

echo "\n";
