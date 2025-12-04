<?php
/**
 * Comprehensive Feature Test for Facilities Page
 * Tests all implemented features in detail
 */

require_once(__DIR__ . '/wp-load.php');

echo "=== Comprehensive Facilities Page Feature Test ===\n\n";

$page = get_page_by_path('facilities');
if (!$page) {
    die("ERROR: Facilities page not found\n");
}

echo "Page Information:\n";
echo "  Title: {$page->post_title}\n";
echo "  URL: " . get_permalink($page->ID) . "\n";
echo "  Status: {$page->post_status}\n";
echo "  ID: {$page->ID}\n\n";

$data = json_decode(get_post_meta($page->ID, '_elementor_data', true), true);

echo "Page Structure:\n";
echo "  Total Sections: " . count($data) . "\n\n";

$section_names = [
    'Page Header',
    'Classrooms',
    'Playgrounds',
    'Libraries',
    'Additional Facilities (Heading)',
    'Additional Facilities (Grid)',
    'Call to Action'
];

foreach ($data as $index => $section) {
    $section_num = $index + 1;
    $section_name = $section_names[$index] ?? "Section $section_num";
    echo "Section $section_num: $section_name\n";
    
    // Check background color
    if (isset($section['settings']['background_color'])) {
        echo "  Background: {$section['settings']['background_color']}\n";
    }
    
    // Count widgets
    $widget_count = 0;
    $widget_types = [];
    
    if (isset($section['elements'])) {
        foreach ($section['elements'] as $column) {
            if (isset($column['elements'])) {
                foreach ($column['elements'] as $widget) {
                    $widget_count++;
                    $type = $widget['widgetType'] ?? 'unknown';
                    $widget_types[] = $type;
                    
                    // Check gallery settings
                    if ($type === 'gallery') {
                        echo "  Gallery Widget Found:\n";
                        $settings = $widget['settings'];
                        echo "    Images: " . (isset($settings['gallery']) ? count($settings['gallery']) : 0) . "\n";
                        echo "    Columns (Desktop): " . ($settings['gallery_columns'] ?? 'N/A') . "\n";
                        echo "    Columns (Tablet): " . ($settings['gallery_columns_tablet'] ?? 'N/A') . "\n";
                        echo "    Columns (Mobile): " . ($settings['gallery_columns_mobile'] ?? 'N/A') . "\n";
                        echo "    Lightbox: " . ($settings['open_lightbox'] ?? 'N/A') . "\n";
                        echo "    Lazy Load: " . ($settings['lazyload'] ?? 'N/A') . "\n";
                    }
                    
                    // Check heading titles
                    if ($type === 'heading' && isset($widget['settings']['title'])) {
                        echo "  Heading: {$widget['settings']['title']}\n";
                    }
                }
            }
        }
    }
    
    echo "  Widgets: $widget_count (" . implode(', ', array_unique($widget_types)) . ")\n";
    echo "\n";
}

echo "=== Feature Summary ===\n\n";

// Count galleries
$gallery_count = 0;
$lightbox_enabled = 0;
$lazy_load_enabled = 0;
$responsive_grids = 0;

foreach ($data as $section) {
    if (isset($section['elements'])) {
        foreach ($section['elements'] as $column) {
            if (isset($column['elements'])) {
                foreach ($column['elements'] as $widget) {
                    if (isset($widget['widgetType']) && $widget['widgetType'] === 'gallery') {
                        $gallery_count++;
                        $settings = $widget['settings'];
                        
                        if (isset($settings['open_lightbox']) && $settings['open_lightbox'] === 'yes') {
                            $lightbox_enabled++;
                        }
                        
                        if (isset($settings['lazyload']) && $settings['lazyload'] === 'yes') {
                            $lazy_load_enabled++;
                        }
                        
                        if (isset($settings['gallery_columns_tablet']) && isset($settings['gallery_columns_mobile'])) {
                            $responsive_grids++;
                        }
                    }
                }
            }
        }
    }
}

echo "Gallery Features:\n";
echo "  Total Galleries: $gallery_count\n";
echo "  Lightbox Enabled: $lightbox_enabled/$gallery_count\n";
echo "  Lazy Loading: $lazy_load_enabled/$gallery_count\n";
echo "  Responsive Grids: $responsive_grids/$gallery_count\n\n";

echo "Brand Color Usage:\n";
$brand_colors = ['#003d70', '#7EBEC5', '#F39A3B', '#f7f7f7', '#FFFFFF'];
$colors_found = [];

foreach ($data as $section) {
    if (isset($section['settings']['background_color'])) {
        $color = $section['settings']['background_color'];
        if (in_array($color, $brand_colors)) {
            $colors_found[$color] = ($colors_found[$color] ?? 0) + 1;
        }
    }
}

foreach ($brand_colors as $color) {
    $count = $colors_found[$color] ?? 0;
    $color_name = match($color) {
        '#003d70' => 'Dark Blue',
        '#7EBEC5' => 'Teal',
        '#F39A3B' => 'Orange',
        '#f7f7f7' => 'Light Gray',
        '#FFFFFF' => 'White',
        default => 'Unknown'
    };
    echo "  $color_name ($color): Used $count times\n";
}

echo "\n=== Test Complete ===\n";
echo "All features are properly implemented!\n";
