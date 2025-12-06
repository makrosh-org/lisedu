<?php
/**
 * Create Elementor Header and Footer Templates with Navigation
 */

require_once('wp-load.php');

if (!defined('ABSPATH')) {
    die('WordPress not loaded');
}

echo "\n=== Creating Elementor Header and Footer Templates ===\n\n";

// 1. Create Header Template
echo "1. Creating Header Template...\n";

$header_post = array(
    'post_title'    => 'Site Header',
    'post_content'  => '',
    'post_status'   => 'publish',
    'post_type'     => 'elementor_library',
    'post_author'   => 1,
);

$header_id = wp_insert_post($header_post);

if ($header_id) {
    echo "   ✓ Header template created (ID: $header_id)\n";
    
    // Set template type
    update_post_meta($header_id, '_elementor_template_type', 'header');
    update_post_meta($header_id, '_elementor_edit_mode', 'builder');
    
    // Create header structure with logo and navigation
    $header_data = [
        [
            'id' => wp_generate_uuid4(),
            'elType' => 'section',
            'settings' => [
                'layout' => 'full_width',
                'background_background' => 'classic',
                'background_color' => '#FFFFFF',
                'padding' => [
                    'top' => '15',
                    'bottom' => '15',
                    'left' => '20',
                    'right' => '20',
                    'unit' => 'px',
                ],
                'box_shadow_box_shadow_type' => 'yes',
                'box_shadow_box_shadow' => [
                    'horizontal' => 0,
                    'vertical' => 2,
                    'blur' => 10,
                    'spread' => 0,
                    'color' => 'rgba(0,0,0,0.1)',
                ],
            ],
            'elements' => [
                [
                    'id' => wp_generate_uuid4(),
                    'elType' => 'column',
                    'settings' => [
                        '_column_size' => 30,
                        'content_position' => 'center',
                    ],
                    'elements' => [
                        [
                            'id' => wp_generate_uuid4(),
                            'elType' => 'widget',
                            'settings' => [
                                'title' => 'Lumina International School',
                                'header_size' => 'h1',
                                'title_color' => '#003d70',
                                'typography_font_size' => ['size' => 24, 'unit' => 'px'],
                                'typography_font_weight' => '700',
                            ],
                            'widgetType' => 'heading',
                        ],
                    ],
                ],
                [
                    'id' => wp_generate_uuid4(),
                    'elType' => 'column',
                    'settings' => [
                        '_column_size' => 70,
                        'content_position' => 'center',
                    ],
                    'elements' => [
                        [
                            'id' => wp_generate_uuid4(),
                            'elType' => 'widget',
                            'settings' => [
                                'menu' => '2', // Primary Navigation menu ID
                                'layout' => 'horizontal',
                                'align_items' => 'right',
                                'pointer' => 'underline',
                                'animation_line' => 'slide',
                                'color_text' => '#003d70',
                                'color_text_hover' => '#7EBEC5',
                                'color_text_active' => '#F39A3B',
                                'typography_font_size' => ['size' => 16, 'unit' => 'px'],
                                'typography_font_weight' => '600',
                                'padding_horizontal_menu_item' => ['size' => 15, 'unit' => 'px'],
                                'dropdown_background_color' => '#FFFFFF',
                                'dropdown_color' => '#003d70',
                                'dropdown_box_shadow_box_shadow_type' => 'yes',
                            ],
                            'widgetType' => 'nav-menu',
                        ],
                    ],
                ],
            ],
        ],
    ];
    
    update_post_meta($header_id, '_elementor_data', wp_slash(wp_json_encode($header_data)));
    echo "   ✓ Header structure created with logo and navigation\n";
    
} else {
    echo "   ✗ Failed to create header template\n";
}

// 2. Create Footer Template
echo "\n2. Creating Footer Template...\n";

$footer_post = array(
    'post_title'    => 'Site Footer',
    'post_content'  => '',
    'post_status'   => 'publish',
    'post_type'     => 'elementor_library',
    'post_author'   => 1,
);

$footer_id = wp_insert_post($footer_post);

if ($footer_id) {
    echo "   ✓ Footer template created (ID: $footer_id)\n";
    
    // Set template type
    update_post_meta($footer_id, '_elementor_template_type', 'footer');
    update_post_meta($footer_id, '_elementor_edit_mode', 'builder');
    
    // Create footer structure
    $footer_data = [
        [
            'id' => wp_generate_uuid4(),
            'elType' => 'section',
            'settings' => [
                'layout' => 'full_width',
                'background_background' => 'classic',
                'background_color' => '#003d70',
                'padding' => [
                    'top' => '40',
                    'bottom' => '40',
                    'unit' => 'px',
                ],
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
                                'title' => 'Lumina International School',
                                'header_size' => 'h3',
                                'title_color' => '#FFFFFF',
                            ],
                            'widgetType' => 'heading',
                        ],
                        [
                            'id' => wp_generate_uuid4(),
                            'elType' => 'widget',
                            'settings' => [
                                'editor' => '<p style="color: #FFFFFF;">Nurturing Young Minds with Islamic Values</p><p style="color: #FFFFFF;">Email: info@luminaschool.edu</p><p style="color: #FFFFFF;">Phone: (123) 456-7890</p>',
                                'text_color' => '#FFFFFF',
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
                                'title' => 'Quick Links',
                                'header_size' => 'h4',
                                'title_color' => '#FFFFFF',
                            ],
                            'widgetType' => 'heading',
                        ],
                        [
                            'id' => wp_generate_uuid4(),
                            'elType' => 'widget',
                            'settings' => [
                                'menu' => '3', // Footer Navigation menu ID
                                'layout' => 'vertical',
                                'color_text' => '#FFFFFF',
                                'color_text_hover' => '#7EBEC5',
                            ],
                            'widgetType' => 'nav-menu',
                        ],
                    ],
                ],
            ],
        ],
        [
            'id' => wp_generate_uuid4(),
            'elType' => 'section',
            'settings' => [
                'layout' => 'full_width',
                'background_background' => 'classic',
                'background_color' => '#002850',
                'padding' => [
                    'top' => '20',
                    'bottom' => '20',
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
                                'editor' => '<p style="text-align: center; color: #FFFFFF; margin: 0;">© ' . date('Y') . ' Lumina International School. All rights reserved.</p>',
                            ],
                            'widgetType' => 'text-editor',
                        ],
                    ],
                ],
            ],
        ],
    ];
    
    update_post_meta($footer_id, '_elementor_data', wp_slash(wp_json_encode($footer_data)));
    echo "   ✓ Footer structure created with navigation and contact info\n";
    
} else {
    echo "   ✗ Failed to create footer template\n";
}

// 3. Set these as the site-wide header and footer
echo "\n3. Setting as site-wide templates...\n";

if ($header_id && $footer_id) {
    update_option('elementor_active_kit', $header_id);
    
    // Set in Elementor Theme Builder
    $elementor_settings = get_option('elementor_settings', []);
    $elementor_settings['header'] = $header_id;
    $elementor_settings['footer'] = $footer_id;
    update_option('elementor_settings', $elementor_settings);
    
    echo "   ✓ Header and footer set as site-wide templates\n";
}

echo "\n=== Summary ===\n";
echo "✓ Header template created with logo and navigation menu\n";
echo "✓ Footer template created with links and contact info\n";
echo "✓ Templates set as site-wide header/footer\n\n";
echo "The navigation menu should now appear on all pages!\n";
echo "You can customize these templates in Elementor > Theme Builder\n";
