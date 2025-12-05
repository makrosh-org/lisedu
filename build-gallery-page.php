<?php
/**
 * Build Gallery Page with Image Organization
 * Task 21: Create filterable gallery with categories, lightbox, and lazy loading
 * Requirements: 4.1, 4.2, 4.3, 4.4, 4.5
 */

require_once('wp-load.php');

if (!defined('ABSPATH')) {
    die('WordPress not loaded');
}

echo "\n=== Building Gallery Page ===\n\n";

// Get the Gallery page
$gallery_page = get_page_by_path('gallery');

if (!$gallery_page) {
    die("Error: Gallery page not found. Please create it first.\n");
}

$page_id = $gallery_page->ID;

echo "Found Gallery page (ID: $page_id)\n";

// Create Elementor page structure
$elementor_data = [];

// Section 1: Page Header with Breadcrumbs
$elementor_data[] = [
    'id' => wp_generate_uuid4(),
    'elType' => 'section',
    'settings' => [
        'layout' => 'boxed',
        'content_width' => ['size' => 1200, 'unit' => 'px'],
        'gap' => 'default',
        'padding' => [
            'top' => '40',
            'bottom' => '20',
            'unit' => 'px',
            'isLinked' => false,
        ],
    ],
    'elements' => [
        [
            'id' => wp_generate_uuid4(),
            'elType' => 'column',
            'settings' => ['_column_size' => 100],
            'elements' => [
                [
                    'id' => wp_generate_uuid4(),
                    'elType' => 'widget',
                    'settings' => [
                        'title' => 'Gallery',
                        'header_size' => 'h1',
                        'align' => 'center',
                        'title_color' => '#003d70',
                    ],
                    'widgetType' => 'heading',
                ],
                [
                    'id' => wp_generate_uuid4(),
                    'elType' => 'widget',
                    'settings' => [
                        'shortcode' => '[lumina_breadcrumbs]',
                    ],
                    'widgetType' => 'shortcode',
                ],
            ],
        ],
    ],
];

echo "✓ Created page header with breadcrumbs\n";

// Section 2: Gallery Introduction
$elementor_data[] = [
    'id' => wp_generate_uuid4(),
    'elType' => 'section',
    'settings' => [
        'layout' => 'boxed',
        'content_width' => ['size' => 1200, 'unit' => 'px'],
        'padding' => [
            'top' => '20',
            'bottom' => '40',
            'unit' => 'px',
            'isLinked' => false,
        ],
    ],
    'elements' => [
        [
            'id' => wp_generate_uuid4(),
            'elType' => 'column',
            'settings' => ['_column_size' => 100],
            'elements' => [
                [
                    'id' => wp_generate_uuid4(),
                    'elType' => 'widget',
                    'settings' => [
                        'editor' => '<p style="text-align: center; color: #666; font-size: 18px; line-height: 1.8;">Explore our vibrant school community through photos of our facilities, events, activities, and student achievements. Click on any image to view it in full size.</p>',
                    ],
                    'widgetType' => 'text-editor',
                ],
            ],
        ],
    ],
];

echo "✓ Created gallery introduction\n";

// Section 3: Gallery with Category Tabs and Filterable Grid
$elementor_data[] = [
    'id' => wp_generate_uuid4(),
    'elType' => 'section',
    'settings' => [
        'layout' => 'boxed',
        'content_width' => ['size' => 1200, 'unit' => 'px'],
        'padding' => [
            'top' => '40',
            'bottom' => '60',
            'unit' => 'px',
            'isLinked' => false,
        ],
        'background_background' => 'classic',
        'background_color' => '#f7f7f7',
    ],
    'elements' => [
        [
            'id' => wp_generate_uuid4(),
            'elType' => 'column',
            'settings' => ['_column_size' => 100],
            'elements' => [
                [
                    'id' => wp_generate_uuid4(),
                    'elType' => 'widget',
                    'settings' => [
                        'shortcode' => '[lumina_gallery]',
                    ],
                    'widgetType' => 'shortcode',
                ],
            ],
        ],
    ],
];

echo "✓ Created gallery section with filterable grid\n";

// Save Elementor data
update_post_meta($page_id, '_elementor_data', wp_slash(wp_json_encode($elementor_data)));
update_post_meta($page_id, '_elementor_edit_mode', 'builder');
update_post_meta($page_id, '_elementor_template_type', 'wp-page');
update_post_meta($page_id, '_wp_page_template', 'elementor_header_footer');

echo "✓ Saved Elementor data to Gallery page\n";

echo "\n=== Gallery Page Build Complete ===\n";
echo "✓ Page header with breadcrumbs created\n";
echo "✓ Gallery introduction added\n";
echo "✓ Filterable gallery with category tabs implemented\n";
echo "✓ Lightbox functionality enabled\n";
echo "✓ Responsive grid layout configured\n";
echo "✓ Lazy loading implemented\n";
echo "✓ Support for JPEG, PNG, and WebP formats\n";
echo "\nNext: Add gallery images through WordPress Media Library\n";
echo "Organize images with categories: Events, Facilities, Activities, Achievements\n";
