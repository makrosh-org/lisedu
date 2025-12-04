<?php
/**
 * Build Facilities Page with Elementor
 * 
 * This script creates the Facilities page layout with:
 * - Page header with breadcrumbs
 * - Image galleries for classrooms, playgrounds, libraries
 * - Descriptions for each facility type
 * - Responsive image grid
 * - Lightbox functionality for images
 * 
 * Task 10: Build Facilities page with images and descriptions
 * Requirements: 1.4
 */

// Load WordPress
require_once(__DIR__ . '/wp-load.php');

// Check if Elementor is active
if (!did_action('elementor/loaded')) {
    die('Elementor is not active. Please activate Elementor first.');
}

echo "Building Facilities Page for Lumina International School...\n\n";

// Get or create the Facilities page
$facilities_page = get_page_by_path('facilities');

if (!$facilities_page) {
    echo "Creating Facilities page...\n";
    $page_id = wp_insert_post([
        'post_title'   => 'Facilities',
        'post_name'    => 'facilities',
        'post_status'  => 'publish',
        'post_type'    => 'page',
        'post_content' => '',
    ]);
    
    if (is_wp_error($page_id)) {
        die("Error creating Facilities page: " . $page_id->get_error_message());
    }
} else {
    $page_id = $facilities_page->ID;
    echo "Facilities page already exists (ID: $page_id). Updating...\n";
}

// Enable Elementor for this page
update_post_meta($page_id, '_elementor_edit_mode', 'builder');
update_post_meta($page_id, '_wp_page_template', 'elementor_header_footer');

// Build Elementor page structure
$elementor_data = [];

// Page Header Section with Breadcrumbs
$elementor_data[] = [
    'id' => \Elementor\Utils::generate_random_string(),
    'elType' => 'section',
    'settings' => [
        'layout' => 'boxed',
        'background_background' => 'gradient',
        'background_color' => '#003d70',
        'background_color_b' => '#7EBEC5',
        'background_gradient_angle' => ['size' => 135, 'unit' => 'deg'],
        'padding' => [
            'unit' => 'px',
            'top' => '80',
            'right' => '20',
            'bottom' => '80',
            'left' => '20',
        ],
    ],
    'elements' => [
        [
            'id' => \Elementor\Utils::generate_random_string(),
            'elType' => 'column',
            'settings' => [
                '_column_size' => 100,
            ],
            'elements' => [
                [
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'settings' => [
                        'title' => 'Our Facilities',
                        'header_size' => 'h1',
                        'align' => 'center',
                        'title_color' => '#FFFFFF',
                        'typography_typography' => 'custom',
                        'typography_font_size' => ['size' => 48, 'unit' => 'px'],
                        'typography_font_weight' => '700',
                    ],
                    'widgetType' => 'heading',
                ],
                [
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'settings' => [
                        'text' => 'Home > Facilities',
                        'align' => 'center',
                        'text_color' => '#FFFFFF',
                    ],
                    'widgetType' => 'text-editor',
                ],
                [
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'settings' => [
                        'editor' => 'Explore our modern, safe, and inspiring learning spaces designed to nurture young minds.',
                        'align' => 'center',
                        'text_color' => '#FFFFFF',
                    ],
                    'widgetType' => 'text-editor',
                ],
            ],
        ],
    ],
];

echo "✓ Created page header with breadcrumbs\n";

// Classrooms Section
$elementor_data[] = [
    'id' => \Elementor\Utils::generate_random_string(),
    'elType' => 'section',
    'settings' => [
        'layout' => 'boxed',
        'background_background' => 'classic',
        'background_color' => '#FFFFFF',
        'padding' => [
            'unit' => 'px',
            'top' => '80',
            'right' => '20',
            'bottom' => '80',
            'left' => '20',
        ],
    ],
    'elements' => [
        [
            'id' => \Elementor\Utils::generate_random_string(),
            'elType' => 'column',
            'settings' => [
                '_column_size' => 100,
            ],
            'elements' => [
                [
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'settings' => [
                        'title' => 'Classrooms',
                        'header_size' => 'h2',
                        'align' => 'center',
                        'title_color' => '#003d70',
                        'typography_typography' => 'custom',
                        'typography_font_size' => ['size' => 36, 'unit' => 'px'],
                        'typography_font_weight' => '700',
                    ],
                    'widgetType' => 'heading',
                ],
                [
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'settings' => [
                        'editor' => '<p style="text-align: center; max-width: 800px; margin: 0 auto 40px;">Our bright, spacious classrooms are designed to create an optimal learning environment. Each classroom is equipped with modern teaching aids, comfortable seating, and ample natural light to enhance the learning experience.</p>',
                    ],
                    'widgetType' => 'text-editor',
                ],
                [
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'settings' => [
                        'gallery' => [
                            ['url' => 'https://via.placeholder.com/800x600/003d70/FFFFFF?text=Classroom+1', 'id' => 0],
                            ['url' => 'https://via.placeholder.com/800x600/7EBEC5/FFFFFF?text=Classroom+2', 'id' => 0],
                            ['url' => 'https://via.placeholder.com/800x600/F39A3B/FFFFFF?text=Classroom+3', 'id' => 0],
                            ['url' => 'https://via.placeholder.com/800x600/003d70/FFFFFF?text=Classroom+4', 'id' => 0],
                            ['url' => 'https://via.placeholder.com/800x600/7EBEC5/FFFFFF?text=Classroom+5', 'id' => 0],
                            ['url' => 'https://via.placeholder.com/800x600/F39A3B/FFFFFF?text=Classroom+6', 'id' => 0],
                        ],
                        'gallery_columns' => '3',
                        'gallery_columns_tablet' => '2',
                        'gallery_columns_mobile' => '1',
                        'gallery_link' => 'file',
                        'open_lightbox' => 'yes',
                        'gallery_layout' => 'grid',
                        'gap' => ['size' => 20, 'unit' => 'px'],
                        'lazyload' => 'yes',
                    ],
                    'widgetType' => 'gallery',
                ],
            ],
        ],
    ],
];

echo "✓ Created classrooms section with image gallery\n";

// Playgrounds Section
$elementor_data[] = [
    'id' => \Elementor\Utils::generate_random_string(),
    'elType' => 'section',
    'settings' => [
        'layout' => 'boxed',
        'background_background' => 'classic',
        'background_color' => '#f7f7f7',
        'padding' => [
            'unit' => 'px',
            'top' => '80',
            'right' => '20',
            'bottom' => '80',
            'left' => '20',
        ],
    ],
    'elements' => [
        [
            'id' => \Elementor\Utils::generate_random_string(),
            'elType' => 'column',
            'settings' => [
                '_column_size' => 100,
            ],
            'elements' => [
                [
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'settings' => [
                        'title' => 'Playgrounds',
                        'header_size' => 'h2',
                        'align' => 'center',
                        'title_color' => '#003d70',
                        'typography_typography' => 'custom',
                        'typography_font_size' => ['size' => 36, 'unit' => 'px'],
                        'typography_font_weight' => '700',
                    ],
                    'widgetType' => 'heading',
                ],
                [
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'settings' => [
                        'editor' => '<p style="text-align: center; max-width: 800px; margin: 0 auto 40px;">Our safe, well-maintained playgrounds provide children with space to play, explore, and develop their physical skills. With age-appropriate equipment and soft surfaces, we ensure a secure environment for active play and social interaction.</p>',
                    ],
                    'widgetType' => 'text-editor',
                ],
                [
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'settings' => [
                        'gallery' => [
                            ['url' => 'https://via.placeholder.com/800x600/7EBEC5/FFFFFF?text=Playground+1', 'id' => 0],
                            ['url' => 'https://via.placeholder.com/800x600/F39A3B/FFFFFF?text=Playground+2', 'id' => 0],
                            ['url' => 'https://via.placeholder.com/800x600/003d70/FFFFFF?text=Playground+3', 'id' => 0],
                            ['url' => 'https://via.placeholder.com/800x600/7EBEC5/FFFFFF?text=Playground+4', 'id' => 0],
                            ['url' => 'https://via.placeholder.com/800x600/F39A3B/FFFFFF?text=Playground+5', 'id' => 0],
                            ['url' => 'https://via.placeholder.com/800x600/003d70/FFFFFF?text=Playground+6', 'id' => 0],
                        ],
                        'gallery_columns' => '3',
                        'gallery_columns_tablet' => '2',
                        'gallery_columns_mobile' => '1',
                        'gallery_link' => 'file',
                        'open_lightbox' => 'yes',
                        'gallery_layout' => 'grid',
                        'gap' => ['size' => 20, 'unit' => 'px'],
                        'lazyload' => 'yes',
                    ],
                    'widgetType' => 'gallery',
                ],
            ],
        ],
    ],
];

echo "✓ Created playgrounds section with image gallery\n";

// Libraries Section
$elementor_data[] = [
    'id' => \Elementor\Utils::generate_random_string(),
    'elType' => 'section',
    'settings' => [
        'layout' => 'boxed',
        'background_background' => 'classic',
        'background_color' => '#FFFFFF',
        'padding' => [
            'unit' => 'px',
            'top' => '80',
            'right' => '20',
            'bottom' => '80',
            'left' => '20',
        ],
    ],
    'elements' => [
        [
            'id' => \Elementor\Utils::generate_random_string(),
            'elType' => 'column',
            'settings' => [
                '_column_size' => 100,
            ],
            'elements' => [
                [
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'settings' => [
                        'title' => 'Libraries',
                        'header_size' => 'h2',
                        'align' => 'center',
                        'title_color' => '#003d70',
                        'typography_typography' => 'custom',
                        'typography_font_size' => ['size' => 36, 'unit' => 'px'],
                        'typography_font_weight' => '700',
                    ],
                    'widgetType' => 'heading',
                ],
                [
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'settings' => [
                        'editor' => '<p style="text-align: center; max-width: 800px; margin: 0 auto 40px;">Our well-stocked libraries offer a quiet, comfortable space for reading and research. With a diverse collection of books, including Islamic literature, educational resources, and age-appropriate fiction, we foster a love of reading and lifelong learning.</p>',
                    ],
                    'widgetType' => 'text-editor',
                ],
                [
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'settings' => [
                        'gallery' => [
                            ['url' => 'https://via.placeholder.com/800x600/003d70/FFFFFF?text=Library+1', 'id' => 0],
                            ['url' => 'https://via.placeholder.com/800x600/7EBEC5/FFFFFF?text=Library+2', 'id' => 0],
                            ['url' => 'https://via.placeholder.com/800x600/F39A3B/FFFFFF?text=Library+3', 'id' => 0],
                            ['url' => 'https://via.placeholder.com/800x600/003d70/FFFFFF?text=Library+4', 'id' => 0],
                            ['url' => 'https://via.placeholder.com/800x600/7EBEC5/FFFFFF?text=Library+5', 'id' => 0],
                            ['url' => 'https://via.placeholder.com/800x600/F39A3B/FFFFFF?text=Library+6', 'id' => 0],
                        ],
                        'gallery_columns' => '3',
                        'gallery_columns_tablet' => '2',
                        'gallery_columns_mobile' => '1',
                        'gallery_link' => 'file',
                        'open_lightbox' => 'yes',
                        'gallery_layout' => 'grid',
                        'gap' => ['size' => 20, 'unit' => 'px'],
                        'lazyload' => 'yes',
                    ],
                    'widgetType' => 'gallery',
                ],
            ],
        ],
    ],
];

echo "✓ Created libraries section with image gallery\n";

// Additional Facilities Section
$elementor_data[] = [
    'id' => \Elementor\Utils::generate_random_string(),
    'elType' => 'section',
    'settings' => [
        'layout' => 'boxed',
        'background_background' => 'classic',
        'background_color' => '#f7f7f7',
        'padding' => [
            'unit' => 'px',
            'top' => '80',
            'right' => '20',
            'bottom' => '80',
            'left' => '20',
        ],
    ],
    'elements' => [
        [
            'id' => \Elementor\Utils::generate_random_string(),
            'elType' => 'column',
            'settings' => [
                '_column_size' => 100,
            ],
            'elements' => [
                [
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'settings' => [
                        'title' => 'Additional Facilities',
                        'header_size' => 'h2',
                        'align' => 'center',
                        'title_color' => '#003d70',
                        'typography_typography' => 'custom',
                        'typography_font_size' => ['size' => 36, 'unit' => 'px'],
                        'typography_font_weight' => '700',
                    ],
                    'widgetType' => 'heading',
                ],
            ],
        ],
    ],
];

// Additional Facilities Grid
$elementor_data[] = [
    'id' => \Elementor\Utils::generate_random_string(),
    'elType' => 'section',
    'settings' => [
        'layout' => 'boxed',
        'background_background' => 'classic',
        'background_color' => '#f7f7f7',
        'padding' => [
            'unit' => 'px',
            'top' => '0',
            'right' => '20',
            'bottom' => '80',
            'left' => '20',
        ],
    ],
    'elements' => [
        // Science Laboratory
        [
            'id' => \Elementor\Utils::generate_random_string(),
            'elType' => 'column',
            'settings' => [
                '_column_size' => 33,
                'background_background' => 'classic',
                'background_color' => '#FFFFFF',
                'padding' => [
                    'unit' => 'px',
                    'top' => '30',
                    'right' => '30',
                    'bottom' => '30',
                    'left' => '30',
                ],
                'border_radius' => [
                    'unit' => 'px',
                    'top' => '10',
                    'right' => '10',
                    'bottom' => '10',
                    'left' => '10',
                ],
            ],
            'elements' => [
                [
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'settings' => [
                        'icon' => ['value' => 'fas fa-flask', 'library' => 'fa-solid'],
                        'icon_color' => '#7EBEC5',
                        'icon_size' => ['size' => 48, 'unit' => 'px'],
                        'align' => 'center',
                    ],
                    'widgetType' => 'icon',
                ],
                [
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'settings' => [
                        'title' => 'Science Laboratory',
                        'header_size' => 'h3',
                        'align' => 'center',
                        'title_color' => '#003d70',
                    ],
                    'widgetType' => 'heading',
                ],
                [
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'settings' => [
                        'editor' => '<p style="text-align: center;">Fully equipped science lab for hands-on experiments and discovery learning.</p>',
                    ],
                    'widgetType' => 'text-editor',
                ],
            ],
        ],
        // Computer Lab
        [
            'id' => \Elementor\Utils::generate_random_string(),
            'elType' => 'column',
            'settings' => [
                '_column_size' => 33,
                'background_background' => 'classic',
                'background_color' => '#FFFFFF',
                'padding' => [
                    'unit' => 'px',
                    'top' => '30',
                    'right' => '30',
                    'bottom' => '30',
                    'left' => '30',
                ],
                'border_radius' => [
                    'unit' => 'px',
                    'top' => '10',
                    'right' => '10',
                    'bottom' => '10',
                    'left' => '10',
                ],
            ],
            'elements' => [
                [
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'settings' => [
                        'icon' => ['value' => 'fas fa-laptop', 'library' => 'fa-solid'],
                        'icon_color' => '#F39A3B',
                        'icon_size' => ['size' => 48, 'unit' => 'px'],
                        'align' => 'center',
                    ],
                    'widgetType' => 'icon',
                ],
                [
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'settings' => [
                        'title' => 'Computer Lab',
                        'header_size' => 'h3',
                        'align' => 'center',
                        'title_color' => '#003d70',
                    ],
                    'widgetType' => 'heading',
                ],
                [
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'settings' => [
                        'editor' => '<p style="text-align: center;">Modern computer lab with latest technology for digital literacy and coding.</p>',
                    ],
                    'widgetType' => 'text-editor',
                ],
            ],
        ],
        // Prayer Room
        [
            'id' => \Elementor\Utils::generate_random_string(),
            'elType' => 'column',
            'settings' => [
                '_column_size' => 33,
                'background_background' => 'classic',
                'background_color' => '#FFFFFF',
                'padding' => [
                    'unit' => 'px',
                    'top' => '30',
                    'right' => '30',
                    'bottom' => '30',
                    'left' => '30',
                ],
                'border_radius' => [
                    'unit' => 'px',
                    'top' => '10',
                    'right' => '10',
                    'bottom' => '10',
                    'left' => '10',
                ],
            ],
            'elements' => [
                [
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'settings' => [
                        'icon' => ['value' => 'fas fa-mosque', 'library' => 'fa-solid'],
                        'icon_color' => '#7EBEC5',
                        'icon_size' => ['size' => 48, 'unit' => 'px'],
                        'align' => 'center',
                    ],
                    'widgetType' => 'icon',
                ],
                [
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'settings' => [
                        'title' => 'Prayer Room',
                        'header_size' => 'h3',
                        'align' => 'center',
                        'title_color' => '#003d70',
                    ],
                    'widgetType' => 'heading',
                ],
                [
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'settings' => [
                        'editor' => '<p style="text-align: center;">Dedicated prayer space for daily prayers and Islamic education.</p>',
                    ],
                    'widgetType' => 'text-editor',
                ],
            ],
        ],
    ],
];

echo "✓ Created additional facilities section\n";

// Call to Action Section
$elementor_data[] = [
    'id' => \Elementor\Utils::generate_random_string(),
    'elType' => 'section',
    'settings' => [
        'layout' => 'boxed',
        'background_background' => 'gradient',
        'background_color' => '#003d70',
        'background_color_b' => '#7EBEC5',
        'background_gradient_angle' => ['size' => 135, 'unit' => 'deg'],
        'padding' => [
            'unit' => 'px',
            'top' => '60',
            'right' => '20',
            'bottom' => '60',
            'left' => '20',
        ],
    ],
    'elements' => [
        [
            'id' => \Elementor\Utils::generate_random_string(),
            'elType' => 'column',
            'settings' => [
                '_column_size' => 100,
            ],
            'elements' => [
                [
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'settings' => [
                        'title' => 'Schedule a Campus Tour',
                        'header_size' => 'h2',
                        'align' => 'center',
                        'title_color' => '#FFFFFF',
                    ],
                    'widgetType' => 'heading',
                ],
                [
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'settings' => [
                        'editor' => '<p style="text-align: center; color: #FFFFFF;">Experience our facilities firsthand. Contact us to arrange a visit.</p>',
                    ],
                    'widgetType' => 'text-editor',
                ],
                [
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'settings' => [
                        'text' => 'Contact Us',
                        'link' => ['url' => '/contact'],
                        'align' => 'center',
                        'button_background_color' => '#F39A3B',
                        'button_text_color' => '#FFFFFF',
                        'typography_typography' => 'custom',
                        'typography_font_size' => ['size' => 18, 'unit' => 'px'],
                        'typography_font_weight' => '600',
                    ],
                    'widgetType' => 'button',
                ],
            ],
        ],
    ],
];

echo "✓ Created call to action section\n";

// Save Elementor data
$elementor_data_json = wp_json_encode($elementor_data);
if ($elementor_data_json === false) {
    die("Error: Failed to encode Elementor data - " . json_last_error_msg() . "\n");
}

update_post_meta($page_id, '_elementor_data', wp_slash($elementor_data_json));
update_post_meta($page_id, '_elementor_page_settings', []);
update_post_meta($page_id, '_elementor_version', ELEMENTOR_VERSION);

// Clear Elementor cache
if (class_exists('\Elementor\Plugin')) {
    \Elementor\Plugin::$instance->files_manager->clear_cache();
}

echo "\n=== Facilities Page Build Complete ===\n";
echo "✓ Page header with breadcrumbs created\n";
echo "✓ Classrooms section with image gallery added\n";
echo "✓ Playgrounds section with image gallery added\n";
echo "✓ Libraries section with image gallery added\n";
echo "✓ Additional facilities section created\n";
echo "✓ Responsive image grid implemented (3 columns desktop, 2 tablet, 1 mobile)\n";
echo "✓ Lightbox functionality enabled for all images\n";
echo "✓ Lazy loading enabled for optimal performance\n";
echo "✓ All sections use brand colors\n";
echo "\nFacilities Page URL: " . get_permalink($page_id) . "\n";
echo "\nNext steps:\n";
echo "1. Visit the Facilities page to see the layout\n";
echo "2. Replace placeholder images with actual facility photos\n";
echo "3. Edit descriptions as needed using Elementor\n";
echo "4. Add more facility types if needed\n";
echo "\n================================================\n";
echo "Task 10 Implementation Complete!\n";
echo "================================================\n";
