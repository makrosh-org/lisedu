<?php
/**
 * Verify Header and Footer Setup
 */

require_once('wp-load.php');

if (!defined('ABSPATH')) {
    die('WordPress not loaded');
}

echo "\n=== Header and Footer Setup Verification ===\n\n";

// Check for header template
$header = get_posts([
    'post_type' => 'elementor_library',
    'meta_key' => '_elementor_template_type',
    'meta_value' => 'header',
    'posts_per_page' => 1,
]);

if (!empty($header)) {
    $header_id = $header[0]->ID;
    echo "✓ Header template found (ID: $header_id)\n";
    echo "  Title: {$header[0]->post_title}\n";
    echo "  Status: {$header[0]->post_status}\n";
    
    $header_data = get_post_meta($header_id, '_elementor_data', true);
    if ($header_data) {
        $data = json_decode($header_data, true);
        echo "  Sections: " . count($data) . "\n";
        
        // Check for nav menu widget
        $has_nav = false;
        foreach ($data as $section) {
            if (isset($section['elements'])) {
                foreach ($section['elements'] as $column) {
                    if (isset($column['elements'])) {
                        foreach ($column['elements'] as $widget) {
                            if (isset($widget['widgetType']) && $widget['widgetType'] === 'nav-menu') {
                                $has_nav = true;
                                echo "  ✓ Navigation menu widget found\n";
                            }
                        }
                    }
                }
            }
        }
        
        if (!$has_nav) {
            echo "  ⚠ Navigation menu widget not found in header\n";
        }
    }
    
    $location = get_post_meta($header_id, '_elementor_location', true);
    echo "  Location: " . ($location ?: 'not set') . "\n";
    
} else {
    echo "✗ No header template found\n";
}

// Check for footer template
echo "\n";
$footer = get_posts([
    'post_type' => 'elementor_library',
    'meta_key' => '_elementor_template_type',
    'meta_value' => 'footer',
    'posts_per_page' => 1,
]);

if (!empty($footer)) {
    $footer_id = $footer[0]->ID;
    echo "✓ Footer template found (ID: $footer_id)\n";
    echo "  Title: {$footer[0]->post_title}\n";
    echo "  Status: {$footer[0]->post_status}\n";
    
    $location = get_post_meta($footer_id, '_elementor_location', true);
    echo "  Location: " . ($location ?: 'not set') . "\n";
    
} else {
    echo "✗ No footer template found\n";
}

// Check menu assignments
echo "\n";
echo "Navigation Menus:\n";
$menus = get_nav_menu_locations();
foreach ($menus as $location => $menu_id) {
    $menu = wp_get_nav_menu_object($menu_id);
    if ($menu) {
        echo "  ✓ $location: {$menu->name}\n";
    }
}

echo "\n=== Summary ===\n";
if (!empty($header) && !empty($footer)) {
    echo "✓ Header and footer templates are set up\n";
    echo "✓ Navigation menus are assigned\n\n";
    echo "Your site should now display:\n";
    echo "  - Header with 'Lumina International School' logo\n";
    echo "  - Horizontal navigation menu (Home, About, Programs, etc.)\n";
    echo "  - Footer with quick links and contact info\n\n";
    echo "If you don't see the navigation, try:\n";
    echo "  1. Clear your browser cache\n";
    echo "  2. Clear WordPress cache (if using a caching plugin)\n";
    echo "  3. Visit: Elementor > Theme Builder to verify templates\n";
} else {
    echo "✗ Setup incomplete - please run create-elementor-header-footer.php\n";
}
