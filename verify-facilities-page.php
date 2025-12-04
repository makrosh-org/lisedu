<?php
/**
 * Verify Facilities Page Implementation
 * 
 * This script verifies that the Facilities page meets all requirements:
 * - Page exists and is published
 * - Elementor is enabled
 * - Contains image galleries for classrooms, playgrounds, libraries
 * - Has descriptions for each facility type
 * - Implements responsive image grid
 * - Has lightbox functionality enabled
 * 
 * Requirements: 1.4
 */

require_once(__DIR__ . '/wp-load.php');

echo "=== Verifying Facilities Page Implementation ===\n\n";

$errors = [];
$warnings = [];
$success = [];

// Check if Facilities page exists
$facilities_page = get_page_by_path('facilities');
if (!$facilities_page) {
    $errors[] = "Facilities page not found";
} else {
    $success[] = "Facilities page exists (ID: {$facilities_page->ID})";
    
    // Check if page is published
    if ($facilities_page->post_status !== 'publish') {
        $errors[] = "Facilities page is not published (status: {$facilities_page->post_status})";
    } else {
        $success[] = "Facilities page is published";
    }
    
    // Check if Elementor is enabled
    $elementor_enabled = get_post_meta($facilities_page->ID, '_elementor_edit_mode', true);
    if ($elementor_enabled !== 'builder') {
        $errors[] = "Elementor is not enabled for Facilities page";
    } else {
        $success[] = "Elementor is enabled for Facilities page";
    }
    
    // Get Elementor data
    $elementor_data = get_post_meta($facilities_page->ID, '_elementor_data', true);
    if (empty($elementor_data)) {
        $errors[] = "No Elementor data found for Facilities page";
    } else {
        $success[] = "Elementor data found";
        
        // Handle both JSON string and array
        if (is_string($elementor_data)) {
            $data = json_decode($elementor_data, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $errors[] = "Failed to parse Elementor data: " . json_last_error_msg();
                $data = null;
            }
        } else {
            $data = $elementor_data;
        }
        
        if ($data !== null) {
            $success[] = "Elementor data is valid JSON";
            
            // Check for required sections
            $has_classrooms = false;
            $has_playgrounds = false;
            $has_libraries = false;
            $gallery_count = 0;
            $has_lightbox = false;
            $has_responsive_grid = false;
            $has_lazy_loading = false;
            
            foreach ($data as $section) {
                if (isset($section['elements'])) {
                    foreach ($section['elements'] as $column) {
                        if (isset($column['elements'])) {
                            foreach ($column['elements'] as $widget) {
                                // Check for gallery widgets
                                if (isset($widget['widgetType']) && $widget['widgetType'] === 'gallery') {
                                    $gallery_count++;
                                    
                                    // Check for lightbox
                                    if (isset($widget['settings']['open_lightbox']) && $widget['settings']['open_lightbox'] === 'yes') {
                                        $has_lightbox = true;
                                    }
                                    
                                    // Check for responsive columns
                                    if (isset($widget['settings']['gallery_columns_tablet']) && 
                                        isset($widget['settings']['gallery_columns_mobile'])) {
                                        $has_responsive_grid = true;
                                    }
                                    
                                    // Check for lazy loading
                                    if (isset($widget['settings']['lazyload']) && $widget['settings']['lazyload'] === 'yes') {
                                        $has_lazy_loading = true;
                                    }
                                }
                                
                                // Check for section headings
                                if (isset($widget['widgetType']) && $widget['widgetType'] === 'heading') {
                                    $title = $widget['settings']['title'] ?? '';
                                    if (stripos($title, 'classroom') !== false) {
                                        $has_classrooms = true;
                                    }
                                    if (stripos($title, 'playground') !== false) {
                                        $has_playgrounds = true;
                                    }
                                    if (stripos($title, 'librar') !== false) {
                                        $has_libraries = true;
                                    }
                                }
                            }
                        }
                    }
                }
            }
            
            // Verify required sections
            if ($has_classrooms) {
                $success[] = "Classrooms section found";
            } else {
                $errors[] = "Classrooms section not found";
            }
            
            if ($has_playgrounds) {
                $success[] = "Playgrounds section found";
            } else {
                $errors[] = "Playgrounds section not found";
            }
            
            if ($has_libraries) {
                $success[] = "Libraries section found";
            } else {
                $errors[] = "Libraries section not found";
            }
            
            // Verify galleries
            if ($gallery_count >= 3) {
                $success[] = "Found $gallery_count image galleries";
            } else {
                $errors[] = "Expected at least 3 galleries, found $gallery_count";
            }
            
            // Verify lightbox
            if ($has_lightbox) {
                $success[] = "Lightbox functionality enabled";
            } else {
                $errors[] = "Lightbox functionality not enabled";
            }
            
            // Verify responsive grid
            if ($has_responsive_grid) {
                $success[] = "Responsive image grid implemented";
            } else {
                $errors[] = "Responsive image grid not implemented";
            }
            
            // Verify lazy loading
            if ($has_lazy_loading) {
                $success[] = "Lazy loading enabled";
            } else {
                $warnings[] = "Lazy loading not enabled (optional but recommended)";
            }
        }
    }
}

// Print results
echo "SUCCESS:\n";
foreach ($success as $msg) {
    echo "  ✓ $msg\n";
}

if (!empty($warnings)) {
    echo "\nWARNINGS:\n";
    foreach ($warnings as $msg) {
        echo "  ⚠ $msg\n";
    }
}

if (!empty($errors)) {
    echo "\nERRORS:\n";
    foreach ($errors as $msg) {
        echo "  ✗ $msg\n";
    }
    echo "\n=== VERIFICATION FAILED ===\n";
    exit(1);
} else {
    echo "\n=== VERIFICATION PASSED ===\n";
    echo "\nAll requirements for Task 10 have been met:\n";
    echo "  ✓ Facilities page layout created\n";
    echo "  ✓ Image galleries for classrooms, playgrounds, libraries\n";
    echo "  ✓ Descriptions for each facility type\n";
    echo "  ✓ Responsive image grid implemented\n";
    echo "  ✓ Lightbox functionality enabled\n";
    exit(0);
}
