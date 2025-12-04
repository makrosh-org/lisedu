<?php
/**
 * Verify Elementor Configuration
 * 
 * This script verifies that all Elementor global settings and templates
 * have been properly configured for Lumina International School
 */

// Load WordPress
define('WP_USE_THEMES', false);
require_once(__DIR__ . '/../wp-load.php');

echo "=== Elementor Configuration Verification ===\n\n";

$all_passed = true;

// Check if Elementor is active
echo "1. Checking Elementor plugin status...\n";
if (is_plugin_active('elementor/elementor.php')) {
    echo "   ✓ Elementor is active\n\n";
} else {
    echo "   ✗ Elementor is NOT active\n\n";
    $all_passed = false;
}

// Check active kit
echo "2. Checking Elementor active kit...\n";
$kit_id = get_option('elementor_active_kit');
if ($kit_id) {
    echo "   ✓ Active kit found (ID: $kit_id)\n\n";
} else {
    echo "   ✗ No active kit found\n\n";
    $all_passed = false;
}

// Check global settings
echo "3. Checking global settings...\n";
$settings = get_post_meta($kit_id, '_elementor_page_settings', true);
if (is_array($settings) && !empty($settings)) {
    echo "   ✓ Global settings configured (" . count($settings) . " settings)\n";
    
    // Check colors
    if (isset($settings['custom_colors']) && is_array($settings['custom_colors'])) {
        echo "   ✓ Custom colors: " . count($settings['custom_colors']) . " colors configured\n";
        foreach ($settings['custom_colors'] as $color) {
            if (isset($color['title']) && isset($color['color'])) {
                echo "     - {$color['title']}: {$color['color']}\n";
            }
        }
    } else {
        echo "   ✗ Custom colors not configured\n";
        $all_passed = false;
    }
    
    // Check typography
    if (isset($settings['system_typography']) && is_array($settings['system_typography'])) {
        echo "   ✓ Typography: " . count($settings['system_typography']) . " styles configured\n";
    } else {
        echo "   ⚠ Typography not configured (may need manual setup)\n";
    }
    
    // Check button styles
    if (isset($settings['button_background_color'])) {
        echo "   ✓ Button styles configured\n";
    } else {
        echo "   ⚠ Button styles not configured (may need manual setup)\n";
    }
    
    echo "\n";
} else {
    echo "   ✗ Global settings not found\n\n";
    $all_passed = false;
}

// Check templates
echo "4. Checking templates...\n";
$templates = get_posts([
    'post_type' => 'elementor_library',
    'posts_per_page' => -1,
    'post_status' => 'publish'
]);

$required_templates = [
    'Lumina Header' => 'header',
    'Lumina Footer' => 'footer',
    'Team Member Card' => 'section',
    'Program Card' => 'section',
    'Event Card' => 'section'
];

$found_templates = [];
foreach ($templates as $template) {
    $type = get_post_meta($template->ID, '_elementor_template_type', true);
    $found_templates[$template->post_title] = [
        'id' => $template->ID,
        'type' => $type
    ];
}

foreach ($required_templates as $name => $expected_type) {
    if (isset($found_templates[$name])) {
        $template = $found_templates[$name];
        if ($template['type'] === $expected_type) {
            echo "   ✓ $name (ID: {$template['id']}, Type: {$template['type']})\n";
        } else {
            echo "   ⚠ $name found but wrong type (Expected: $expected_type, Got: {$template['type']})\n";
        }
    } else {
        echo "   ✗ $name not found\n";
        $all_passed = false;
    }
}

echo "\n";

// Check configuration flag
echo "5. Checking configuration status...\n";
if (get_option('lumina_elementor_configured')) {
    echo "   ✓ Configuration marked as complete\n\n";
} else {
    echo "   ✗ Configuration not marked as complete\n\n";
    $all_passed = false;
}

// Summary
echo "=== Verification Summary ===\n";
if ($all_passed) {
    echo "✓ All checks passed! Elementor is properly configured.\n";
    exit(0);
} else {
    echo "✗ Some checks failed. Please review the output above.\n";
    echo "\nTo reconfigure, run: php docs/configure-elementor.php\n";
    exit(1);
}
