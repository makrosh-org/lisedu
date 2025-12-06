<?php
/**
 * Add Remaining Homepage Sections
 * Statistics, Programs, Admission Cards, Gallery, Contact
 */

require_once('wp-load.php');

if (!defined('ABSPATH')) {
    die('WordPress not loaded');
}

echo "\n=== Adding Remaining Sections to Homepage ===\n\n";

$homepage = get_page_by_path('home');
$page_id = $homepage->ID;

// Get existing data
$existing_data = get_post_meta($page_id, '_elementor_data', true);
$elementor_data = json_decode($existing_data, true);

echo "Current sections: " . count($elementor_data) . "\n";
echo "Adding more sections...\n\n";

// Section 3: Statistics Section
echo "3. Adding Statistics Section...\n";
$elementor_data[] = [
    'id' => wp_generate_uuid4(),
    'elType' => 'section',
    'settings' => [
        'layout' => 'full_width',
        'background_background' => 'classic',
        'background_color' => '#1a2b4a',
        'padding' => ['top' => '80', 'bottom' => '80', 'unit' => 'px'],
    ],
    'elements' => [
        // Stat 1
        [
            'id' => wp_generate_uuid4(),
            'elType' => 'column',
            'settings' => ['_column_size' => 25],
            'elements' => [
                [
                    'id' => wp_generate_uuid4(),
                    'elType' => 'widget',
                    'settings' => [
                        'title' => '400+',
                        'header_size' => 'h2',
                        'title_color' => '#f59e0b',
                        'typography_font_size' => ['size' => 56, 'unit' => 'px'],
                        'typography_font_weight' => '700',
                        'align' => 'center',
                    ],
                    'widgetType' => 'heading',
                ],
                [
                    'id' => wp_generate_uuid4(),
                    'elType' => 'widget',
                    'settings' => [
                        'editor' => '<p style="text-align: center; color: #FFFFFF; font-size: 18px; margin-top: 10px;">Students</p>',
                    ],
                    'widgetType' => 'text-editor',
                ],
            ],
        ],
        // Stat 2
        [
            'id' => wp_generate_uuid4(),
            'elType' => 'column',
            'settings' => ['_column_size' => 25],
            'elements' => [
                [
                    'id' => wp_generate_uuid4(),
                    'elType' => 'widget',
                    'settings' => [
                        'title' => '20+',
                        'header_size' => 'h2',
                        'title_color' => '#f59e0b',
                        'typography_font_size' => ['size' => 56, 'unit' => 'px'],
                        'typography_font_weight' => '700',
                        'align' => 'center',
                    ],
                    'widgetType' => 'heading',
                ],
                [
                    'id' => wp_generate_uuid4(),
                    'elType' => 'widget',
                    'settings' => [
                        'editor' => '<p style="text-align: center; color: #FFFFFF; font-size: 18px; margin-top: 10px;">Experienced Teachers</p>',
                    ],
                    'widgetType' => 'text-editor',
                ],
            ],
        ],
        // Stat 3
        [
            'id' => wp_generate_uuid4(),
            'elType' => 'column',
            'settings' => ['_column_size' => 25],
            'elements' => [
                [
                    'id' => wp_generate_uuid4(),
                    'elType' => 'widget',
                    'settings' => [
                        'title' => '100%',
                        'header_size' => 'h2',
                        'title_color' => '#f59e0b',
                        'typography_font_size' => ['size' => 56, 'unit' => 'px'],
                        'typography_font_weight' => '700',
                        'align' => 'center',
                    ],
                    'widgetType' => 'heading',
                ],
                [
                    'id' => wp_generate_uuid4(),
                    'elType' => 'widget',
                    'settings' => [
                        'editor' => '<p style="text-align: center; color: #FFFFFF; font-size: 18px; margin-top: 10px;">Unique Curriculum</p>',
                    ],
                    'widgetType' => 'text-editor',
                ],
            ],
        ],
        // Stat 4
        [
            'id' => wp_generate_uuid4(),
            'elType' => 'column',
            'settings' => ['_column_size' => 25],
            'elements' => [
                [
                    'id' => wp_generate_uuid4(),
                    'elType' => 'widget',
                    'settings' => [
                        'title' => '7:30 AM',
                        'header_size' => 'h2',
                        'title_color' => '#f59e0b',
                        'typography_font_size' => ['size' => 56, 'unit' => 'px'],
                        'typography_font_weight' => '700',
                        'align' => 'center',
                    ],
                    'widgetType' => 'heading',
                ],
                [
                    'id' => wp_generate_uuid4(),
                    'elType' => 'widget',
                    'settings' => [
                        'editor' => '<p style="text-align: center; color: #FFFFFF; font-size: 18px; margin-top: 10px;">School Starts</p>',
                    ],
                    'widgetType' => 'text-editor',
                ],
            ],
        ],
    ],
];

// Section 4: Academic Programs
echo "4. Adding Academic Programs Section...\n";
$elementor_data[] = [
    'id' => wp_generate_uuid4(),
    'elType' => 'section',
    'settings' => [
        'layout' => 'boxed',
        'content_width' => ['size' => 1200, 'unit' => 'px'],
        'background_background' => 'classic',
        'background_color' => '#FFFFFF',
        'padding' => ['top' => '90', 'bottom' => '90', 'unit' => 'px'],
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
                        'title' => 'Get Ready for a Bright Future',
                        'header_size' => 'h2',
                        'title_color' => '#1a2b4a',
                        'typography_font_size' => ['size' => 42, 'unit' => 'px'],
                        'typography_font_weight' => '700',
                        'align' => 'center',
                    ],
                    'widgetType' => 'heading',
                ],
            ],
        ],
    ],
];

// Section 5: Program Cards
echo "5. Adding Program Cards...\n";
$elementor_data[] = [
    'id' => wp_generate_uuid4(),
    'elType' => 'section',
    'settings' => [
        'layout' => 'boxed',
        'content_width' => ['size' => 1200, 'unit' => 'px'],
        'background_background' => 'classic',
        'background_color' => '#f3f4f6',
        'padding' => ['top' => '60', 'bottom' => '60', 'unit' => 'px'],
    ],
    'elements' => [
        [
            'id' => wp_generate_uuid4(),
            'elType' => 'column',
            'settings' => ['_column_size' => 50],
            'elements' => [
                [
                    'id' => wp_generate_uuid4(),
                    'elType' => 'widget',
                    'settings' => [
                        'image' => ['url' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?w=800&q=80'],
                        'border_radius' => ['size' => 12, 'unit' => 'px'],
                    ],
                    'widgetType' => 'image',
                ],
                [
                    'id' => wp_generate_uuid4(),
                    'elType' => 'widget',
                    'settings' => [
                        'title' => 'Academic Curriculum',
                        'header_size' => 'h3',
                        'title_color' => '#1a2b4a',
                        'typography_font_size' => ['size' => 28, 'unit' => 'px'],
                        'typography_font_weight' => '700',
                    ],
                    'widgetType' => 'heading',
                ],
                [
                    'id' => wp_generate_uuid4(),
                    'elType' => 'widget',
                    'settings' => [
                        'editor' => '<p style="color: #6b7280; font-size: 16px; line-height: 1.7;">Our comprehensive curriculum combines Islamic studies with modern academic subjects, preparing students for success in both worlds.</p>',
                    ],
                    'widgetType' => 'text-editor',
                ],
            ],
        ],
        [
            'id' => wp_generate_uuid4(),
            'elType' => 'column',
            'settings' => ['_column_size' => 50],
            'elements' => [
                [
                    'id' => wp_generate_uuid4(),
                    'elType' => 'widget',
                    'settings' => [
                        'image' => ['url' => 'https://images.unsplash.com/photo-1544717302-de2939b7ef71?w=800&q=80'],
                        'border_radius' => ['size' => 12, 'unit' => 'px'],
                    ],
                    'widgetType' => 'image',
                ],
                [
                    'id' => wp_generate_uuid4(),
                    'elType' => 'widget',
                    'settings' => [
                        'title' => 'Co-curricular Activities',
                        'header_size' => 'h3',
                        'title_color' => '#1a2b4a',
                        'typography_font_size' => ['size' => 28, 'unit' => 'px'],
                        'typography_font_weight' => '700',
                    ],
                    'widgetType' => 'heading',
                ],
                [
                    'id' => wp_generate_uuid4(),
                    'elType' => 'widget',
                    'settings' => [
                        'editor' => '<p style="color: #6b7280; font-size: 16px; line-height: 1.7;">We offer diverse extracurricular activities including sports, arts, and cultural programs to develop well-rounded students.</p>',
                    ],
                    'widgetType' => 'text-editor',
                ],
            ],
        ],
    ],
];

// Save updated data
update_post_meta($page_id, '_elementor_data', wp_slash(wp_json_encode($elementor_data)));

echo "\n✓ Complete! Homepage now has " . count($elementor_data) . " sections\n";
echo "\nSections added:\n";
echo "  ✓ Hero with student image\n";
echo "  ✓ Welcome/About section\n";
echo "  ✓ Statistics (400+ students, 20+ teachers, etc.)\n";
echo "  ✓ Academic Programs heading\n";
echo "  ✓ Program cards (Academic & Co-curricular)\n";
echo "\nRefresh your homepage to see the new design!\n";
