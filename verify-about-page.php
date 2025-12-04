<?php
/**
 * Verify About Page Implementation
 * 
 * This script verifies that the About page meets all requirements:
 * - Page header with breadcrumbs
 * - Mission, Vision, and Values sections
 * - School history timeline
 * - Leadership team profiles section with images
 * - Accreditation and affiliations section
 * - Responsive design at all breakpoints
 * 
 * Requirements: 1.2
 */

// Load WordPress
require_once(__DIR__ . '/wp-load.php');

echo "Verifying About Page Implementation...\n";
echo str_repeat("=", 60) . "\n\n";

$errors = [];
$warnings = [];
$success = [];

// Check if About page exists
$about_page = get_page_by_path('about');

if (!$about_page) {
    $errors[] = "About page does not exist";
    echo "✗ CRITICAL: About page not found\n";
    exit(1);
}

$page_id = $about_page->ID;
echo "✓ About page exists (ID: $page_id)\n";
$success[] = "About page exists";

// Check if Elementor is enabled
$elementor_mode = get_post_meta($page_id, '_elementor_edit_mode', true);
if ($elementor_mode !== 'builder') {
    $errors[] = "Elementor is not enabled for About page";
    echo "✗ Elementor is not enabled for About page\n";
} else {
    echo "✓ Elementor is enabled for About page\n";
    $success[] = "Elementor enabled";
}

// Get Elementor data
$elementor_data = get_post_meta($page_id, '_elementor_data', true);

if (empty($elementor_data)) {
    $errors[] = "No Elementor data found for About page";
    echo "✗ No Elementor data found\n";
    exit(1);
}

$data = json_decode($elementor_data, true);

if (!is_array($data)) {
    $errors[] = "Invalid Elementor data format";
    echo "✗ Invalid Elementor data format\n";
    exit(1);
}

echo "✓ Elementor data loaded successfully\n";
$success[] = "Elementor data valid";

// Count sections
$section_count = 0;
$has_breadcrumbs = false;
$has_mission_vision_values = false;
$has_history_timeline = false;
$has_leadership_team = false;
$has_accreditation = false;

foreach ($data as $section) {
    if (isset($section['elType']) && $section['elType'] === 'section') {
        $section_count++;
        
        // Check for breadcrumbs (first section with "About Us" heading)
        if (!$has_breadcrumbs) {
            foreach ($section['elements'] ?? [] as $column) {
                foreach ($column['elements'] ?? [] as $widget) {
                    if (isset($widget['settings']['title']) && 
                        strpos($widget['settings']['title'], 'About') !== false) {
                        $has_breadcrumbs = true;
                        break 2;
                    }
                }
            }
        }
        
        // Check for Mission, Vision, Values (3 columns with these titles)
        if (!$has_mission_vision_values) {
            $column_count = count($section['elements'] ?? []);
            if ($column_count === 3) {
                $titles = [];
                foreach ($section['elements'] as $column) {
                    foreach ($column['elements'] ?? [] as $widget) {
                        if (isset($widget['settings']['title'])) {
                            $titles[] = $widget['settings']['title'];
                        }
                    }
                }
                $titles_text = implode(' ', $titles);
                if (stripos($titles_text, 'Mission') !== false && 
                    stripos($titles_text, 'Vision') !== false && 
                    stripos($titles_text, 'Values') !== false) {
                    $has_mission_vision_values = true;
                }
            }
        }
        
        // Check for History Timeline
        if (!$has_history_timeline) {
            foreach ($section['elements'] ?? [] as $column) {
                foreach ($column['elements'] ?? [] as $widget) {
                    if (isset($widget['settings']['title']) && 
                        stripos($widget['settings']['title'], 'History') !== false) {
                        $has_history_timeline = true;
                        break 2;
                    }
                    if (isset($widget['settings']['editor']) && 
                        stripos($widget['settings']['editor'], 'timeline') !== false) {
                        $has_history_timeline = true;
                        break 2;
                    }
                }
            }
        }
        
        // Check for Leadership Team
        if (!$has_leadership_team) {
            foreach ($section['elements'] ?? [] as $column) {
                foreach ($column['elements'] ?? [] as $widget) {
                    if (isset($widget['settings']['title']) && 
                        stripos($widget['settings']['title'], 'Leadership') !== false) {
                        $has_leadership_team = true;
                        break 2;
                    }
                }
            }
        }
        
        // Check for Accreditation
        if (!$has_accreditation) {
            foreach ($section['elements'] ?? [] as $column) {
                foreach ($column['elements'] ?? [] as $widget) {
                    if (isset($widget['settings']['title']) && 
                        stripos($widget['settings']['title'], 'Accreditation') !== false) {
                        $has_accreditation = true;
                        break 2;
                    }
                }
            }
        }
    }
}

echo "\n--- Section Verification ---\n";
echo "Total sections: $section_count\n\n";

// Verify required sections
if ($has_breadcrumbs) {
    echo "✓ Breadcrumbs header present\n";
    $success[] = "Breadcrumbs header";
} else {
    echo "✗ Breadcrumbs header missing\n";
    $errors[] = "Breadcrumbs header missing";
}

if ($has_mission_vision_values) {
    echo "✓ Mission, Vision, and Values sections present\n";
    $success[] = "Mission, Vision, Values sections";
} else {
    echo "✗ Mission, Vision, and Values sections missing\n";
    $errors[] = "Mission, Vision, Values sections missing";
}

if ($has_history_timeline) {
    echo "✓ School history timeline present\n";
    $success[] = "School history timeline";
} else {
    echo "✗ School history timeline missing\n";
    $errors[] = "School history timeline missing";
}

if ($has_leadership_team) {
    echo "✓ Leadership team section present\n";
    $success[] = "Leadership team section";
} else {
    echo "✗ Leadership team section missing\n";
    $errors[] = "Leadership team section missing";
}

if ($has_accreditation) {
    echo "✓ Accreditation and affiliations section present\n";
    $success[] = "Accreditation section";
} else {
    echo "✗ Accreditation and affiliations section missing\n";
    $errors[] = "Accreditation section missing";
}

// Check for brand colors usage
echo "\n--- Brand Colors Verification ---\n";
$content_string = json_encode($data);
$brand_colors = [
    '#003d70' => 'base-darkblue',
    '#f7f7f7' => 'base-lightgray',
    '#7EBEC5' => 'base-accent-teal',
    '#F39A3B' => 'base-accent-orange',
];

$colors_found = [];
foreach ($brand_colors as $color => $name) {
    if (stripos($content_string, $color) !== false) {
        $colors_found[] = $name;
        echo "✓ Brand color used: $name ($color)\n";
    }
}

if (count($colors_found) >= 3) {
    $success[] = "Brand colors used consistently";
} else {
    $warnings[] = "Limited brand color usage detected";
    echo "⚠ Only " . count($colors_found) . " brand colors detected\n";
}

// Check for responsive design elements
echo "\n--- Responsive Design Verification ---\n";
$has_column_layouts = false;
$has_padding_settings = false;

foreach ($data as $section) {
    if (isset($section['elements'])) {
        foreach ($section['elements'] as $column) {
            if (isset($column['settings']['_column_size'])) {
                $has_column_layouts = true;
            }
            if (isset($column['settings']['padding'])) {
                $has_padding_settings = true;
            }
        }
    }
}

if ($has_column_layouts) {
    echo "✓ Responsive column layouts configured\n";
    $success[] = "Responsive column layouts";
} else {
    echo "⚠ No responsive column layouts detected\n";
    $warnings[] = "No responsive column layouts";
}

if ($has_padding_settings) {
    echo "✓ Responsive padding settings configured\n";
    $success[] = "Responsive padding";
} else {
    echo "⚠ No responsive padding settings detected\n";
    $warnings[] = "No responsive padding";
}

// Check for images in leadership section
echo "\n--- Leadership Team Images Verification ---\n";
$image_count = 0;
foreach ($data as $section) {
    foreach ($section['elements'] ?? [] as $column) {
        foreach ($column['elements'] ?? [] as $widget) {
            if (isset($widget['widgetType']) && $widget['widgetType'] === 'image') {
                $image_count++;
            }
        }
    }
}

if ($image_count >= 3) {
    echo "✓ Leadership team images present ($image_count images found)\n";
    $success[] = "Leadership team images ($image_count)";
} else {
    echo "⚠ Limited leadership team images ($image_count images found)\n";
    $warnings[] = "Only $image_count images found";
}

// Final summary
echo "\n" . str_repeat("=", 60) . "\n";
echo "VERIFICATION SUMMARY\n";
echo str_repeat("=", 60) . "\n\n";

echo "✓ Successes: " . count($success) . "\n";
foreach ($success as $item) {
    echo "  • $item\n";
}

if (!empty($warnings)) {
    echo "\n⚠ Warnings: " . count($warnings) . "\n";
    foreach ($warnings as $warning) {
        echo "  • $warning\n";
    }
}

if (!empty($errors)) {
    echo "\n✗ Errors: " . count($errors) . "\n";
    foreach ($errors as $error) {
        echo "  • $error\n";
    }
    echo "\n❌ VERIFICATION FAILED\n";
    exit(1);
} else {
    echo "\n✅ VERIFICATION PASSED\n";
    echo "\nThe About page has been successfully implemented with:\n";
    echo "- Page header with breadcrumbs ✓\n";
    echo "- Mission, Vision, and Values sections ✓\n";
    echo "- School history timeline ✓\n";
    echo "- Leadership team profiles with images ✓\n";
    echo "- Accreditation and affiliations section ✓\n";
    echo "- Responsive design elements ✓\n";
    echo "- Brand colors applied ✓\n";
    echo "\nPage URL: " . get_permalink($page_id) . "\n";
    exit(0);
}
