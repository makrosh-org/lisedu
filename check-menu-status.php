<?php
/**
 * Check Navigation Menu Status
 */

require_once('wp-load.php');

if (!defined('ABSPATH')) {
    die('WordPress not loaded');
}

echo "\n=== Navigation Menu Status Check ===\n\n";

// 1. Check registered menu locations
echo "1. Registered Menu Locations:\n";
$locations = get_registered_nav_menus();
if (!empty($locations)) {
    foreach ($locations as $location => $description) {
        echo "   - $location: $description\n";
    }
} else {
    echo "   ✗ No menu locations registered\n";
}

// 2. Check if menus are assigned to locations
echo "\n2. Menu Assignments:\n";
$menu_locations = get_nav_menu_locations();
if (!empty($menu_locations)) {
    foreach ($menu_locations as $location => $menu_id) {
        $menu = wp_get_nav_menu_object($menu_id);
        if ($menu) {
            echo "   ✓ $location: {$menu->name} (ID: $menu_id)\n";
        } else {
            echo "   ✗ $location: No menu assigned\n";
        }
    }
} else {
    echo "   ✗ No menus assigned to locations\n";
}

// 3. Check existing menus
echo "\n3. Existing Menus:\n";
$menus = wp_get_nav_menus();
if (!empty($menus)) {
    foreach ($menus as $menu) {
        $count = wp_get_nav_menu_items($menu->term_id);
        echo "   - {$menu->name} (ID: {$menu->term_id}) - " . count($count) . " items\n";
    }
} else {
    echo "   ✗ No menus created\n";
}

// 4. Check pages that should be in menu
echo "\n4. Available Pages:\n";
$pages = get_pages(['sort_column' => 'menu_order']);
foreach ($pages as $page) {
    echo "   - {$page->post_title} (ID: {$page->ID})\n";
}

echo "\n=== Diagnosis ===\n";
if (empty($menus)) {
    echo "✗ ISSUE: No navigation menus have been created\n";
    echo "  Solution: Run create-pages-navigation.php to create menus\n";
} elseif (empty($menu_locations)) {
    echo "✗ ISSUE: Menus exist but are not assigned to locations\n";
    echo "  Solution: Assign menus to theme locations\n";
} else {
    echo "✓ Menus are configured\n";
}
