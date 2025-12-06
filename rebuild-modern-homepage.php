<?php
/**
 * Rebuild Homepage with Modern Design
 * Matching the reference school website design
 */

require_once('wp-load.php');

if (!defined('ABSPATH')) {
    die('WordPress not loaded');
}

echo "\n=== Rebuilding Homepage with Modern Design ===\n\n";

// Get the homepage
$homepage = get_page_by_path('home');

if (!$homepage) {
    echo "✗ Homepage not found\n";
    exit(1);
}

$page_id = $homepage->ID;
echo "Found homepage (ID: $page_id)\n\n";

// Create modern Elementor structure
$elementor_data = [];

// Section 1: Hero Section with Large Image and Text
echo "Creating Hero Section...\n";
$elementor_data[] = [
    'id' => wp_generate_uuid4(),
    'elType' => 'section',
    'settings' => [
        'layout' => 'full_width',
        'height' => 'min-height',
        'custom_height' => ['size' => 600, 'unit' => 'px'],
        'background_background' => 'classic',
        'background_color' => '#1a2b4a',
        'background_image' => ['url' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=1920'],
        'background_position' => 'center center',
        'background_size' => 'cover',
        'background_overlay_background' => 'classic',
        'background_overlay_color' => 'rgba(26, 43, 74, 0.85)',
        'padding' => [
            'top' => '100',
            'bottom' => '100',
            'unit' => 'px',
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
                        'title' => 'Building Knowledge<br>Step by Step',
                        'header_size' => 'h1',
                        'title_color' => '#FFFFFF',
                        'typography_font_size' => ['size' => 56, 'unit' => 'px'],
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
                        'editor' => '<p style="text-align: center; color: #FFFFFF; font-size: 20px; line-height: 1.6; max-width: 700px; margin: 20px auto;">Lumina International School provides quality Islamic education, nurturing young minds with strong values and academic excellence from Play Group to Grade 5.</p>',
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
                        'button_type' => 'default',
                        'button_text_color' => '#FFFFFF',
                        'background_color' => '#f59e0b',
                        'button_background_hover_color' => '#d97706',
                        'typography_font_size' => ['size' => 18, 'unit' => 'px'],
                        'typography_font_weight' => '600',
                        'button_padding' => [
                            'top' => '15',
                            'right' => '40',
                            'bottom' => '15',
                            'left' => '40',
                            'unit' => 'px',
                        ],
                        'border_radius' => ['size' => 8, 'unit' => 'px'],
                    ],
                    'widgetType' => 'button',
                ],
            ],
        ],
    ],
];

echo "✓ Hero section created\n";

// Section 2: Welcome/About Section
echo "Creating Welcome Section...\n";
$elementor_data[] = [
    'id' => wp_generate_uuid4(),
    'elType' => 'section',
    'settings' => [
        'layout' => 'boxed',
        'content_width' => ['size' => 1200, 'unit' => 'px'],
        'background_background' => 'classic',
        'background_color' => '#f3f4f6',
        'padding' => [
            'top' => '80',
            'bottom' => '80',
            'unit' => 'px',
        ],
    ],
    'elements' => [
        [
            'id' => wp_generate_uuid4(),
            'elType' => 'column',
            'settings' => [
                '_column_size' => 50,
                'content_position' => 'center',
            ],
            'elements' => [
                [
                    'id' => wp_generate_uuid4(),
                    'elType' => 'widget',
                    'settings' => [
                        'title' => 'Discover the Spirit of<br>Lumina International School',
                        'header_size' => 'h2',
                        'title_color' => '#1a2b4a',
                        'typography_font_size' => ['size' => 36, 'unit' => 'px'],
                        'typography_font_weight' => '700',
                    ],
                    'widgetType' => 'heading',
                ],
                [
                    'id' => wp_generate_uuid4(),
                    'elType' => 'widget',
                    'settings' => [
                        'editor' => '<p style="color: #6b7280; font-size: 16px; line-height: 1.8; margin: 20px 0;">At Lumina International School, we believe in nurturing every child\'s potential through:</p><ul style="color: #6b7280; font-size: 16px; line-height: 1.8; margin-left: 20px;"><li>✓ Strong Islamic values and character development</li><li>✓ Comprehensive academic curriculum</li><li>✓ Modern teaching methodologies</li><li>✓ Safe and nurturing environment</li><li>✓ Experienced and dedicated teachers</li></ul>',
                    ],
                    'widgetType' => 'text-editor',
                ],
                [
                    'id' => wp_generate_uuid4(),
                    'elType' => 'widget',
                    'settings' => [
                        'text' => 'Learn More',
                        'link' => ['url' => '/about'],
                        'button_type' => 'default',
                        'button_text_color' => '#FFFFFF',
                        'background_color' => '#f59e0b',
                        'button_background_hover_color' => '#d97706',
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
                        'image' => ['url' => 'https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?w=800'],
                        'image_size' => 'full',
                        'border_radius' => ['size' => 12, 'unit' => 'px'],
                    ],
                    'widgetType' => 'image',
                ],
            ],
        ],
    ],
];

echo "✓ Welcome section created\n";

// Save to database
update_post_meta($page_id, '_elementor_data', wp_slash(wp_json_encode($elementor_data)));
update_post_meta($page_id, '_elementor_edit_mode', 'builder');
update_post_meta($page_id, '_wp_page_template', 'elementor_header_footer');

echo "\n=== Homepage Rebuild Complete ===\n";
echo "✓ Modern hero section with overlay\n";
echo "✓ Welcome section with image\n";
echo "✓ Updated brand colors applied\n\n";
echo "Next: Visit your homepage to see the new design!\n";
echo "Note: Replace placeholder images with your own school photos.\n";
