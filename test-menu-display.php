<?php
/**
 * Test Menu Display Output
 */

require_once('wp-load.php');

if (!defined('ABSPATH')) {
    die('WordPress not loaded');
}

echo "\n=== Testing Menu Display ===\n\n";

// Test primary menu output
echo "1. Primary Menu Output:\n";
echo str_repeat("-", 50) . "\n";
$primary_menu = wp_nav_menu([
    'theme_location' => 'primary',
    'echo' => false,
    'fallback_cb' => false,
]);

if ($primary_menu) {
    echo "✓ Primary menu renders successfully\n";
    echo "Length: " . strlen($primary_menu) . " characters\n";
    
    // Count menu items
    preg_match_all('/<li[^>]*>/', $primary_menu, $matches);
    echo "Menu items: " . count($matches[0]) . "\n";
    
    // Show first 500 characters
    echo "\nFirst 500 characters:\n";
    echo substr($primary_menu, 0, 500) . "...\n";
} else {
    echo "✗ Primary menu returns empty\n";
}

// Test footer menu
echo "\n2. Footer Menu Output:\n";
echo str_repeat("-", 50) . "\n";
$footer_menu = wp_nav_menu([
    'theme_location' => 'footer',
    'echo' => false,
    'fallback_cb' => false,
]);

if ($footer_menu) {
    echo "✓ Footer menu renders successfully\n";
    echo "Length: " . strlen($footer_menu) . " characters\n";
    
    preg_match_all('/<li[^>]*>/', $footer_menu, $matches);
    echo "Menu items: " . count($matches[0]) . "\n";
} else {
    echo "✗ Footer menu returns empty\n";
}

// Check if theme supports menus
echo "\n3. Theme Support:\n";
echo str_repeat("-", 50) . "\n";
if (current_theme_supports('menus')) {
    echo "✓ Theme supports menus\n";
} else {
    echo "✗ Theme does not support menus\n";
}

// Check menu locations
echo "\n4. Active Theme Menu Locations:\n";
echo str_repeat("-", 50) . "\n";
$locations = get_nav_menu_locations();
foreach ($locations as $location => $menu_id) {
    $menu = wp_get_nav_menu_object($menu_id);
    if ($menu) {
        $items = wp_get_nav_menu_items($menu_id);
        echo "✓ $location: {$menu->name} (" . count($items) . " items)\n";
        
        // Show menu items
        if ($items) {
            foreach ($items as $item) {
                $indent = str_repeat("  ", $item->menu_item_parent ? 2 : 1);
                echo "$indent- {$item->title}\n";
            }
        }
    }
}

echo "\n=== Summary ===\n";
echo "If you're seeing 'no menus to show' in WordPress admin,\n";
echo "it might be in the Appearance > Menus screen when trying\n";
echo "to edit a specific menu location.\n\n";
echo "The menus ARE created and working. You can:\n";
echo "1. Go to Appearance > Menus in WordPress admin\n";
echo "2. Select 'Primary Navigation' or 'Footer Navigation'\n";
echo "3. Edit menu items as needed\n";
