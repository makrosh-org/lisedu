<?php
/**
 * Assign Primary Menu to Mobile Location
 */

require_once('wp-load.php');

if (!defined('ABSPATH')) {
    die('WordPress not loaded');
}

echo "\n=== Fixing Mobile Menu Assignment ===\n\n";

// Get current menu locations
$locations = get_nav_menu_locations();

// Get the primary menu ID
$primary_menu_id = isset($locations['primary']) ? $locations['primary'] : 0;

if ($primary_menu_id) {
    echo "Found Primary Navigation menu (ID: $primary_menu_id)\n";
    
    // Assign it to mobile location as well
    $locations['mobile'] = $primary_menu_id;
    
    // Save the updated locations
    set_theme_mod('nav_menu_locations', $locations);
    
    echo "✓ Assigned Primary Navigation to mobile location\n";
    
    // Verify
    $updated_locations = get_nav_menu_locations();
    echo "\nUpdated Menu Assignments:\n";
    foreach ($updated_locations as $location => $menu_id) {
        $menu = wp_get_nav_menu_object($menu_id);
        if ($menu) {
            echo "  ✓ $location: {$menu->name}\n";
        }
    }
    
    echo "\n✓ Mobile menu is now configured!\n";
} else {
    echo "✗ Could not find primary menu\n";
}
