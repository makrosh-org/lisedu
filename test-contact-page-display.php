<?php
/**
 * Test Contact Page Display
 * 
 * This script tests the visual display of the Contact page
 */

require_once('wp-load.php');

if (!defined('ABSPATH')) {
    die('WordPress not loaded');
}

echo "Testing Contact Page Display...\n\n";

$contact_page = get_page_by_path('contact');

if (!$contact_page) {
    die("✗ Contact page not found\n");
}

$contact_page_id = $contact_page->ID;
echo "✓ Contact page found (ID: $contact_page_id)\n";

// Get Elementor data
$elementor_data = get_post_meta($contact_page_id, '_elementor_data', true);
$data = json_decode($elementor_data, true);

echo "\nPage Structure:\n";
echo str_repeat("-", 60) . "\n";

$section_num = 1;
foreach ($data as $section) {
    if (isset($section['elType']) && $section['elType'] === 'section') {
        echo "\nSection $section_num:\n";
        
        // Get section background color
        if (isset($section['settings']['background_color'])) {
            echo "  Background: {$section['settings']['background_color']}\n";
        }
        
        // Count columns
        $column_count = 0;
        if (isset($section['elements'])) {
            foreach ($section['elements'] as $column) {
                if (isset($column['elType']) && $column['elType'] === 'column') {
                    $column_count++;
                    
                    // List widgets in column
                    if (isset($column['elements'])) {
                        foreach ($column['elements'] as $widget) {
                            if (isset($widget['widgetType'])) {
                                $widget_type = $widget['widgetType'];
                                
                                // Get widget title or content
                                $content = '';
                                if (isset($widget['settings']['title'])) {
                                    $content = $widget['settings']['title'];
                                } elseif (isset($widget['settings']['editor'])) {
                                    $content = strip_tags($widget['settings']['editor']);
                                    $content = substr($content, 0, 50) . '...';
                                } elseif (isset($widget['settings']['shortcode'])) {
                                    $content = $widget['settings']['shortcode'];
                                }
                                
                                echo "    - Widget: $widget_type";
                                if ($content) {
                                    echo " ($content)";
                                }
                                echo "\n";
                            }
                        }
                    }
                }
            }
        }
        
        echo "  Columns: $column_count\n";
        $section_num++;
    }
}

echo "\n" . str_repeat("-", 60) . "\n";
echo "\nContact Information Summary:\n";
echo str_repeat("-", 60) . "\n";

$content_string = wp_json_encode($data);

// Extract contact details
if (preg_match('/\+1\s*\([0-9]{3}\)\s*[0-9]{3}-[0-9]{4}/', $content_string, $matches)) {
    echo "Phone: {$matches[0]}\n";
}

if (preg_match('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/', $content_string, $matches)) {
    echo "Email: {$matches[0]}\n";
}

if (preg_match('/Monday\s*-\s*Friday/', $content_string)) {
    echo "Office Hours: Monday - Friday (and more)\n";
}

// Count social media links
$social_count = 0;
if (strpos($content_string, 'facebook') !== false) $social_count++;
if (strpos($content_string, 'twitter') !== false) $social_count++;
if (strpos($content_string, 'instagram') !== false) $social_count++;
if (strpos($content_string, 'linkedin') !== false) $social_count++;
if (strpos($content_string, 'youtube') !== false) $social_count++;

echo "Social Media Links: $social_count platforms\n";

echo "\n" . str_repeat("=", 60) . "\n";
echo "Display Test Complete!\n";
echo str_repeat("=", 60) . "\n";

echo "\nPage URL: " . get_permalink($contact_page_id) . "\n";
echo "\nVisit the page in your browser to see the full design.\n";
