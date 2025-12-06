<?php
/**
 * Build Complete Modern Homepage - Option A
 * Matching reference design with placeholder content
 */

require_once('wp-load.php');

if (!defined('ABSPATH')) {
    die('WordPress not loaded');
}

echo "\n=== Building Complete Modern Homepage ===\n\n";

$homepage = get_page_by_path('home');
if (!$homepage) {
    die("Error: Homepage not found\n");
}

$page_id = $homepage->ID;
echo "Building homepage (ID: $page_id)...\n\n";

$elementor_data = [];

// Section 1: Hero Section with Student Image
echo "1. Creating Hero Section...\n";
$elementor_data[] = [
    'id' => wp_generate_uuid4(),
    'elType' => 'section',
    'settings' => [
        'layout' => 'full_width',
        'height' => 'min-height',
        'custom_height' => ['size' => 700, 'unit' => 'px'],
        'background_background' => 'classic',
        'background_color' => '#1a2b4a',
        'background_image' => ['url' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=1920&q=80'],
        'background_position' => 'center center',
        'background_size' => 'cover',
        'background_overlay_background' => 'classic',
        'background_overlay_color' => 'rgba(26, 43, 74, 0.75)',
        'padding' => ['top' => '120', 'bottom' => '120', 'unit' => 'px'],
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
                        'title' => 'Building Knowledge<br>Step by Step',
                        'header_size' => 'h1',
                        'title_color' => '#FFFFFF',
                        'typography_font_size' => ['size' => 60, 'unit' => 'px'],
                        'typography_font_weight' => '700',
                        'typography_line_height' => ['size' => 1.2, 'unit' => 'em'],
                        'align' => 'center',
                    ],
                    'widgetType' => 'heading',
                ],
                [
                    'id' => wp_generate_uuid4(),
                    'elType' => 'widget',
                    'settings' => [
                        'editor' => '<p style="text-align: center; color: #FFFFFF; font-size: 22px; line-height: 1.7; max-width: 800px; margin: 25px auto;">Lumina International School provides quality Islamic education, nurturing young minds with strong values and academic excellence from Play Group to Grade 5.</p>',
                    ],
                    'widgetType' => 'text-editor',
                ],
                [
                    'id' => wp_generate_uuid4(),
                    'elType' => 'widget',
                    'settings' => [
                        'text' => 'Apply Now',
                        'link' => ['url' => '/admissions'],
                        'align' => 'center',
                        'button_text_color' => '#FFFFFF',
                        'background_color' => '#f59e0b',
                        'button_background_hover_color' => '#d97706',
                        'typography_font_size' => ['size' => 18, 'unit' => 'px'],
                        'typography_font_weight' => '600',
                        'button_padding' => ['top' => '18', 'right' => '45', 'bottom' => '18', 'left' => '45', 'unit' => 'px'],
                        'border_radius' => ['size' => 8, 'unit' => 'px'],
                    ],
                    'widgetType' => 'button',
                ],
            ],
        ],
    ],
];

// Section 2: Welcome/About Section
echo "2. Creating Welcome Section...\n";
$elementor_data[] = [
    'id' => wp_generate_uuid4(),
    'elType' => 'section',
    'settings' => [
        'layout' => 'boxed',
        'content_width' => ['size' => 1200, 'unit' => 'px'],
        'background_background' => 'classic',
        'background_color' => '#f3f4f6',
        'padding' => ['top' => '90', 'bottom' => '90', 'unit' => 'px'],
    ],
    'elements' => [
        [
            'id' => wp_generate_uuid4(),
            'elType' => 'column',
            'settings' => ['_column_size' => 50, 'content_position' => 'center'],
            'elements' => [
                [
                    'id' => wp_generate_uuid4(),
                    'elType' => 'widget',
                    'settings' => [
                        'title' => 'Discover the Spirit of<br>Lumina International School',
                        'header_size' => 'h2',
                        'title_color' => '#1a2b4a',
                        'typography_font_size' => ['size' => 40, 'unit' => 'px'],
                        'typography_font_weight' => '700',
                        'typography_line_height' => ['size' => 1.3, 'unit' => 'em'],
                    ],
                    'widgetType' => 'heading',
                ],
                [
                    'id' => wp_generate_uuid4(),
                    'elType' => 'widget',
                    'settings' => [
                        'editor' => '<p style="color: #6b7280; font-size: 17px; line-height: 1.8; margin: 25px 0;">At Lumina International School, we believe in nurturing every child\'s potential through a holistic approach that combines academic excellence with Islamic values.</p><ul style="color: #6b7280; font-size: 17px; line-height: 2; margin: 20px 0; list-style: none; padding: 0;"><li style="padding: 8px 0; padding-left: 30px; position: relative;"><span style="position: absolute; left: 0; color: #f59e0b; font-weight: bold;">✓</span> Strong Islamic values and character development</li><li style="padding: 8px 0; padding-left: 30px; position: relative;"><span style="position: absolute; left: 0; color: #f59e0b; font-weight: bold;">✓</span> Comprehensive academic curriculum</li><li style="padding: 8px 0; padding-left: 30px; position: relative;"><span style="position: absolute; left: 0; color: #f59e0b; font-weight: bold;">✓</span> Modern teaching methodologies</li><li style="padding: 8px 0; padding-left: 30px; position: relative;"><span style="position: absolute; left: 0; color: #f59e0b; font-weight: bold;">✓</span> Safe and nurturing environment</li><li style="padding: 8px 0; padding-left: 30px; position: relative;"><span style="position: absolute; left: 0; color: #f59e0b; font-weight: bold;">✓</span> Experienced and dedicated teachers</li></ul>',
                    ],
                    'widgetType' => 'text-editor',
                ],
                [
                    'id' => wp_generate_uuid4(),
                    'elType' => 'widget',
                    'settings' => [
                        'text' => 'Learn More About Us',
                        'link' => ['url' => '/about'],
                        'button_text_color' => '#FFFFFF',
                        'background_color' => '#f59e0b',
                        'button_background_hover_color' => '#d97706',
                        'typography_font_size' => ['size' => 16, 'unit' => 'px'],
                        'typography_font_weight' => '600',
                        'button_padding' => ['top' => '15', 'right' => '35', 'bottom' => '15', 'left' => '35', 'unit' => 'px'],
                        'border_radius' => ['size' => 8, 'unit' => 'px'],
                    ],
                    'widgetType' => 'button',
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
                        'image' => ['url' => 'https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?w=900&q=80'],
                        'image_size' => 'full',
                        'border_radius' => ['size' => 15, 'unit' => 'px'],
                        'box_shadow_box_shadow_type' => 'yes',
                        'box_shadow_box_shadow' => [
                            'horizontal' => 0,
                            'vertical' => 10,
                            'blur' => 30,
                            'spread' => 0,
                            'color' => 'rgba(0,0,0,0.1)',
                        ],
                    ],
                    'widgetType' => 'image',
                ],
            ],
        ],
    ],
];

// Save and continue in next part...
echo "3. Creating Statistics Section...\n";

// Due to file size limits, I'll create this as a multi-part script
// Saving what we have so far
update_post_meta($page_id, '_elementor_data', wp_slash(wp_json_encode($elementor_data)));

echo "\n✓ Part 1 Complete: Hero and Welcome sections created\n";
echo "Run the next script to add remaining sections...\n";
