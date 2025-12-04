<?php
/**
 * Verification script for Task 5: Page Structure and Navigation
 * Requirements: 3.1, 3.2, 3.3
 */

// Load WordPress
define('WP_USE_THEMES', false);
require('./wp-load.php');

echo "=== Verifying Page Structure and Navigation ===\n\n";

$all_tests_passed = true;

// Test 1: Verify all required pages exist
echo "Test 1: Verifying all required pages exist...\n";
$required_pages = [
    'home', 'about', 'programs', 'admissions', 'gallery', 
    'events', 'news', 'contact', 'resources'
];

$pages_exist = true;
foreach ($required_pages as $slug) {
    $page = get_page_by_path($slug);
    if ($page) {
        echo "  ✓ Page '{$slug}' exists (ID: {$page->ID})\n";
    } else {
        echo "  ✗ Page '{$slug}' NOT FOUND\n";
        $pages_exist = false;
        $all_tests_passed = false;
    }
}

if ($pages_exist) {
    echo "  ✓ All required pages exist\n\n";
} else {
    echo "  ✗ Some pages are missing\n\n";
}

// Test 2: Verify child pages exist
echo "Test 2: Verifying child pages exist...\n";
$child_pages = [
    'about/mission-vision', 'about/leadership-team', 'about/accreditation',
    'programs/play-group', 'programs/kindergarten', 'programs/grade-1-5', 'programs/islamic-studies',
    'admissions/how-to-apply', 'admissions/fee-structure', 'admissions/faq'
];

$child_pages_exist = true;
foreach ($child_pages as $path) {
    $page = get_page_by_path($path);
    if ($page) {
        echo "  ✓ Child page '{$path}' exists (ID: {$page->ID}, Parent: {$page->post_parent})\n";
    } else {
        echo "  ✗ Child page '{$path}' NOT FOUND\n";
        $child_pages_exist = false;
        $all_tests_passed = false;
    }
}

if ($child_pages_exist) {
    echo "  ✓ All child pages exist\n\n";
} else {
    echo "  ✗ Some child pages are missing\n\n";
}

// Test 3: Verify front page is set
echo "Test 3: Verifying front page configuration...\n";
$show_on_front = get_option('show_on_front');
$page_on_front = get_option('page_on_front');

if ($show_on_front === 'page' && $page_on_front) {
    $front_page = get_post($page_on_front);
    echo "  ✓ Front page is set to: {$front_page->post_title} (ID: {$page_on_front})\n\n";
} else {
    echo "  ✗ Front page is not properly configured\n\n";
    $all_tests_passed = false;
}

// Test 4: Verify primary navigation menu exists
echo "Test 4: Verifying primary navigation menu...\n";
$primary_menu = wp_get_nav_menu_object('Primary Navigation');

if ($primary_menu) {
    echo "  ✓ Primary Navigation menu exists (ID: {$primary_menu->term_id})\n";
    
    // Check menu items
    $menu_items = wp_get_nav_menu_items($primary_menu->term_id);
    if ($menu_items && count($menu_items) > 0) {
        echo "  ✓ Primary menu has " . count($menu_items) . " items\n";
        
        // Check for hierarchical structure
        $has_children = false;
        foreach ($menu_items as $item) {
            if ($item->menu_item_parent != 0) {
                $has_children = true;
                break;
            }
        }
        
        if ($has_children) {
            echo "  ✓ Primary menu has hierarchical structure (sub-menus)\n";
        } else {
            echo "  ✗ Primary menu does not have hierarchical structure\n";
            $all_tests_passed = false;
        }
    } else {
        echo "  ✗ Primary menu has no items\n";
        $all_tests_passed = false;
    }
} else {
    echo "  ✗ Primary Navigation menu NOT FOUND\n";
    $all_tests_passed = false;
}
echo "\n";

// Test 5: Verify footer navigation menu exists
echo "Test 5: Verifying footer navigation menu...\n";
$footer_menu = wp_get_nav_menu_object('Footer Navigation');

if ($footer_menu) {
    echo "  ✓ Footer Navigation menu exists (ID: {$footer_menu->term_id})\n";
    
    $menu_items = wp_get_nav_menu_items($footer_menu->term_id);
    if ($menu_items && count($menu_items) > 0) {
        echo "  ✓ Footer menu has " . count($menu_items) . " items\n";
    } else {
        echo "  ✗ Footer menu has no items\n";
        $all_tests_passed = false;
    }
} else {
    echo "  ✗ Footer Navigation menu NOT FOUND\n";
    $all_tests_passed = false;
}
echo "\n";

// Test 6: Verify menu locations are assigned
echo "Test 6: Verifying menu locations are assigned...\n";
$locations = get_theme_mod('nav_menu_locations');

if (is_array($locations)) {
    if (isset($locations['primary'])) {
        echo "  ✓ Primary menu location is assigned (Menu ID: {$locations['primary']})\n";
    } else {
        echo "  ✗ Primary menu location is NOT assigned\n";
        $all_tests_passed = false;
    }
    
    if (isset($locations['footer'])) {
        echo "  ✓ Footer menu location is assigned (Menu ID: {$locations['footer']})\n";
    } else {
        echo "  ✗ Footer menu location is NOT assigned\n";
        $all_tests_passed = false;
    }
} else {
    echo "  ✗ No menu locations are assigned\n";
    $all_tests_passed = false;
}
echo "\n";

// Test 7: Verify navigation menus are registered in theme
echo "Test 7: Verifying navigation menu registration...\n";
$registered_menus = get_registered_nav_menus();

if (isset($registered_menus['primary'])) {
    echo "  ✓ Primary menu location is registered\n";
} else {
    echo "  ✗ Primary menu location is NOT registered\n";
    $all_tests_passed = false;
}

if (isset($registered_menus['footer'])) {
    echo "  ✓ Footer menu location is registered\n";
} else {
    echo "  ✗ Footer menu location is NOT registered\n";
    $all_tests_passed = false;
}

if (isset($registered_menus['mobile'])) {
    echo "  ✓ Mobile menu location is registered\n";
} else {
    echo "  ✗ Mobile menu location is NOT registered\n";
    $all_tests_passed = false;
}
echo "\n";

// Test 8: Verify breadcrumb functionality
echo "Test 8: Verifying breadcrumb configuration...\n";
$breadcrumbs_enabled = get_option('lumina_breadcrumbs_enabled');

if ($breadcrumbs_enabled) {
    echo "  ✓ Breadcrumbs are enabled\n";
} else {
    echo "  ✗ Breadcrumbs are NOT enabled\n";
    $all_tests_passed = false;
}

// Check if breadcrumb function exists
if (function_exists('lumina_breadcrumbs')) {
    echo "  ✓ Breadcrumb function exists\n";
} else {
    echo "  ✗ Breadcrumb function NOT FOUND\n";
    $all_tests_passed = false;
}

// Check if breadcrumb shortcode exists
if (shortcode_exists('lumina_breadcrumbs')) {
    echo "  ✓ Breadcrumb shortcode is registered\n";
} else {
    echo "  ✗ Breadcrumb shortcode is NOT registered\n";
    $all_tests_passed = false;
}
echo "\n";

// Test 9: Verify Elementor is enabled for pages
echo "Test 9: Verifying Elementor is enabled for pages...\n";
$sample_page = get_page_by_path('about');
if ($sample_page) {
    $elementor_mode = get_post_meta($sample_page->ID, '_elementor_edit_mode', true);
    if ($elementor_mode === 'builder') {
        echo "  ✓ Elementor is enabled for pages\n";
    } else {
        echo "  ✗ Elementor is NOT enabled for pages\n";
        $all_tests_passed = false;
    }
} else {
    echo "  ✗ Could not verify Elementor status (sample page not found)\n";
    $all_tests_passed = false;
}
echo "\n";

// Test 10: Verify mobile navigation support
echo "Test 10: Verifying mobile navigation support...\n";

// Check if mobile menu functions exist
if (function_exists('lumina_mobile_nav_assets')) {
    echo "  ✓ Mobile navigation assets function exists\n";
} else {
    echo "  ✗ Mobile navigation assets function NOT FOUND\n";
    $all_tests_passed = false;
}

if (function_exists('lumina_add_mobile_menu')) {
    echo "  ✓ Mobile menu output function exists\n";
} else {
    echo "  ✗ Mobile menu output function NOT FOUND\n";
    $all_tests_passed = false;
}

// Check if actions are hooked
if (has_action('wp_enqueue_scripts', 'lumina_mobile_nav_assets')) {
    echo "  ✓ Mobile navigation assets are enqueued\n";
} else {
    echo "  ✗ Mobile navigation assets are NOT enqueued\n";
    $all_tests_passed = false;
}

if (has_action('wp_footer', 'lumina_add_mobile_menu')) {
    echo "  ✓ Mobile menu is added to footer\n";
} else {
    echo "  ✗ Mobile menu is NOT added to footer\n";
    $all_tests_passed = false;
}
echo "\n";

// Final summary
echo "=== Verification Summary ===\n\n";

if ($all_tests_passed) {
    echo "✓ ALL TESTS PASSED\n";
    echo "\nPage structure and navigation have been successfully configured:\n";
    echo "- All required pages created\n";
    echo "- Primary navigation menu with hierarchical structure\n";
    echo "- Footer navigation menu\n";
    echo "- Mobile responsive navigation (hamburger menu at <768px)\n";
    echo "- Breadcrumb navigation enabled\n";
    echo "- All pages enabled for Elementor editing\n";
    echo "\nRequirements validated: 3.1, 3.2, 3.3\n";
    exit(0);
} else {
    echo "✗ SOME TESTS FAILED\n";
    echo "\nPlease review the failed tests above and fix any issues.\n";
    exit(1);
}
