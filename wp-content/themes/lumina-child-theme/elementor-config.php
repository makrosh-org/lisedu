<?php
/**
 * Elementor Configuration for Lumina International School
 * 
 * This file configures Elementor global settings including:
 * - Brand color palette
 * - Typography settings
 * - Button styles
 * - Spacing defaults
 * - Template creation
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Configure Elementor Global Colors
 */
function lumina_configure_elementor_colors() {
    // Get Elementor kit ID
    $kit_id = get_option('elementor_active_kit');
    
    if (!$kit_id) {
        return false;
    }
    
    // Define brand colors
    $brand_colors = [
        [
            '_id' => 'primary',
            'title' => 'Primary - Dark Blue',
            'color' => '#003d70'
        ],
        [
            '_id' => 'secondary',
            'title' => 'Secondary - Light Gray',
            'color' => '#f7f7f7'
        ],
        [
            '_id' => 'accent_teal',
            'title' => 'Accent - Teal',
            'color' => '#7EBEC5'
        ],
        [
            '_id' => 'accent_orange',
            'title' => 'Accent - Orange',
            'color' => '#F39A3B'
        ],
        [
            '_id' => 'white',
            'title' => 'Base - White',
            'color' => '#FFFFFF'
        ],
        [
            '_id' => 'text',
            'title' => 'Text',
            'color' => '#333333'
        ],
        [
            '_id' => 'accent',
            'title' => 'Accent',
            'color' => '#7EBEC5'
        ]
    ];
    
    // Update kit meta with brand colors
    update_post_meta($kit_id, '_elementor_page_settings', [
        'custom_colors' => $brand_colors,
        'system_colors' => $brand_colors
    ]);
    
    return true;
}

/**
 * Configure Elementor Global Typography
 */
function lumina_configure_elementor_typography() {
    $kit_id = get_option('elementor_active_kit');
    
    if (!$kit_id) {
        return false;
    }
    
    // Define typography settings
    $typography = [
        'system_typography' => [
            [
                '_id' => 'primary',
                'title' => 'Primary Heading',
                'typography_typography' => 'custom',
                'typography_font_family' => 'Poppins',
                'typography_font_weight' => '600',
                'typography_font_size' => ['unit' => 'px', 'size' => 48],
                'typography_line_height' => ['unit' => 'em', 'size' => 1.2],
            ],
            [
                '_id' => 'secondary',
                'title' => 'Secondary Heading',
                'typography_typography' => 'custom',
                'typography_font_family' => 'Poppins',
                'typography_font_weight' => '500',
                'typography_font_size' => ['unit' => 'px', 'size' => 32],
                'typography_line_height' => ['unit' => 'em', 'size' => 1.3],
            ],
            [
                '_id' => 'text',
                'title' => 'Body Text',
                'typography_typography' => 'custom',
                'typography_font_family' => 'Open Sans',
                'typography_font_weight' => '400',
                'typography_font_size' => ['unit' => 'px', 'size' => 16],
                'typography_line_height' => ['unit' => 'em', 'size' => 1.6],
            ],
            [
                '_id' => 'accent',
                'title' => 'Accent Text',
                'typography_typography' => 'custom',
                'typography_font_family' => 'Poppins',
                'typography_font_weight' => '500',
                'typography_font_size' => ['unit' => 'px', 'size' => 18],
                'typography_line_height' => ['unit' => 'em', 'size' => 1.4],
            ]
        ]
    ];
    
    // Get existing settings
    $settings = get_post_meta($kit_id, '_elementor_page_settings', true);
    if (!is_array($settings)) {
        $settings = [];
    }
    
    // Merge typography settings
    $settings = array_merge($settings, $typography);
    update_post_meta($kit_id, '_elementor_page_settings', $settings);
    
    return true;
}

/**
 * Configure Elementor Global Button Styles
 */
function lumina_configure_elementor_buttons() {
    $kit_id = get_option('elementor_active_kit');
    
    if (!$kit_id) {
        return false;
    }
    
    // Define button styles
    $button_settings = [
        'button_typography_typography' => 'custom',
        'button_typography_font_family' => 'Poppins',
        'button_typography_font_weight' => '600',
        'button_typography_font_size' => ['unit' => 'px', 'size' => 16],
        'button_background_color' => '#003d70',
        'button_text_color' => '#FFFFFF',
        'button_border_radius' => ['unit' => 'px', 'size' => 5],
        'button_padding' => [
            'unit' => 'px',
            'top' => 15,
            'right' => 30,
            'bottom' => 15,
            'left' => 30,
            'isLinked' => false
        ],
        'button_hover_background_color' => '#7EBEC5',
        'button_hover_text_color' => '#FFFFFF',
        'button_hover_border_color' => '#7EBEC5',
    ];
    
    // Get existing settings
    $settings = get_post_meta($kit_id, '_elementor_page_settings', true);
    if (!is_array($settings)) {
        $settings = [];
    }
    
    // Merge button settings
    $settings = array_merge($settings, $button_settings);
    update_post_meta($kit_id, '_elementor_page_settings', $settings);
    
    return true;
}

/**
 * Configure Elementor Default Spacing
 */
function lumina_configure_elementor_spacing() {
    $kit_id = get_option('elementor_active_kit');
    
    if (!$kit_id) {
        return false;
    }
    
    // Define spacing defaults
    $spacing_settings = [
        'container_padding' => [
            'unit' => 'px',
            'top' => 20,
            'right' => 20,
            'bottom' => 20,
            'left' => 20,
            'isLinked' => true
        ],
        'page_title_selector' => 'h1.entry-title',
        'stretched_section_container' => '.elementor-section-stretched',
        'default_generic_fonts' => 'Sans-serif',
    ];
    
    // Get existing settings
    $settings = get_post_meta($kit_id, '_elementor_page_settings', true);
    if (!is_array($settings)) {
        $settings = [];
    }
    
    // Merge spacing settings
    $settings = array_merge($settings, $spacing_settings);
    update_post_meta($kit_id, '_elementor_page_settings', $settings);
    
    return true;
}

/**
 * Create Header Template
 */
function lumina_create_header_template() {
    // Check if header template already exists
    $existing = get_posts([
        'post_type' => 'elementor_library',
        'meta_query' => [
            [
                'key' => '_elementor_template_type',
                'value' => 'header'
            ]
        ],
        'meta_key' => 'lumina_header_template',
        'posts_per_page' => 1
    ]);
    
    if (!empty($existing)) {
        return $existing[0]->ID;
    }
    
    // Create header template
    $header_id = wp_insert_post([
        'post_title' => 'Lumina Header',
        'post_type' => 'elementor_library',
        'post_status' => 'publish',
        'meta_input' => [
            '_elementor_template_type' => 'header',
            'lumina_header_template' => true,
            '_elementor_edit_mode' => 'builder'
        ]
    ]);
    
    if (is_wp_error($header_id)) {
        return false;
    }
    
    // Define header structure
    $header_data = [
        [
            'id' => \Elementor\Utils::generate_random_string(),
            'elType' => 'section',
            'settings' => [
                'background_background' => 'classic',
                'background_color' => '#003d70',
                'padding' => [
                    'unit' => 'px',
                    'top' => 20,
                    'right' => 20,
                    'bottom' => 20,
                    'left' => 20,
                    'isLinked' => true
                ]
            ],
            'elements' => [
                [
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'column',
                    'settings' => ['_column_size' => 50],
                    'elements' => [
                        [
                            'id' => \Elementor\Utils::generate_random_string(),
                            'elType' => 'widget',
                            'widgetType' => 'image',
                            'settings' => [
                                'image' => ['url' => get_stylesheet_directory_uri() . '/assets/images/logo.png'],
                                'image_size' => 'medium',
                                'align' => 'left'
                            ]
                        ]
                    ]
                ],
                [
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'column',
                    'settings' => ['_column_size' => 50],
                    'elements' => [
                        [
                            'id' => \Elementor\Utils::generate_random_string(),
                            'elType' => 'widget',
                            'widgetType' => 'nav-menu',
                            'settings' => [
                                'layout' => 'horizontal',
                                'align_items' => 'right',
                                'pointer' => 'underline',
                                'menu_text_color' => '#FFFFFF',
                                'menu_hover_color' => '#7EBEC5'
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ];
    
    update_post_meta($header_id, '_elementor_data', wp_json_encode($header_data));
    
    // Set as default header
    update_option('elementor_header_location', $header_id);
    
    return $header_id;
}

/**
 * Create Footer Template
 */
function lumina_create_footer_template() {
    // Check if footer template already exists
    $existing = get_posts([
        'post_type' => 'elementor_library',
        'meta_query' => [
            [
                'key' => '_elementor_template_type',
                'value' => 'footer'
            ]
        ],
        'meta_key' => 'lumina_footer_template',
        'posts_per_page' => 1
    ]);
    
    if (!empty($existing)) {
        return $existing[0]->ID;
    }
    
    // Create footer template
    $footer_id = wp_insert_post([
        'post_title' => 'Lumina Footer',
        'post_type' => 'elementor_library',
        'post_status' => 'publish',
        'meta_input' => [
            '_elementor_template_type' => 'footer',
            'lumina_footer_template' => true,
            '_elementor_edit_mode' => 'builder'
        ]
    ]);
    
    if (is_wp_error($footer_id)) {
        return false;
    }
    
    // Define footer structure
    $footer_data = [
        [
            'id' => \Elementor\Utils::generate_random_string(),
            'elType' => 'section',
            'settings' => [
                'background_background' => 'classic',
                'background_color' => '#003d70',
                'padding' => [
                    'unit' => 'px',
                    'top' => 40,
                    'right' => 20,
                    'bottom' => 40,
                    'left' => 20,
                    'isLinked' => false
                ]
            ],
            'elements' => [
                [
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'column',
                    'settings' => ['_column_size' => 33],
                    'elements' => [
                        [
                            'id' => \Elementor\Utils::generate_random_string(),
                            'elType' => 'widget',
                            'widgetType' => 'heading',
                            'settings' => [
                                'title' => 'Contact Information',
                                'header_size' => 'h4',
                                'title_color' => '#FFFFFF'
                            ]
                        ],
                        [
                            'id' => \Elementor\Utils::generate_random_string(),
                            'elType' => 'widget',
                            'widgetType' => 'text-editor',
                            'settings' => [
                                'editor' => '<p style="color: #FFFFFF;">Lumina International School<br>Address: [School Address]<br>Phone: [Phone Number]<br>Email: info@luminaschool.com</p>',
                                'text_color' => '#FFFFFF'
                            ]
                        ]
                    ]
                ],
                [
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'column',
                    'settings' => ['_column_size' => 33],
                    'elements' => [
                        [
                            'id' => \Elementor\Utils::generate_random_string(),
                            'elType' => 'widget',
                            'widgetType' => 'heading',
                            'settings' => [
                                'title' => 'Quick Links',
                                'header_size' => 'h4',
                                'title_color' => '#FFFFFF'
                            ]
                        ],
                        [
                            'id' => \Elementor\Utils::generate_random_string(),
                            'elType' => 'widget',
                            'widgetType' => 'nav-menu',
                            'settings' => [
                                'layout' => 'vertical',
                                'menu_text_color' => '#FFFFFF'
                            ]
                        ]
                    ]
                ],
                [
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'column',
                    'settings' => ['_column_size' => 33],
                    'elements' => [
                        [
                            'id' => \Elementor\Utils::generate_random_string(),
                            'elType' => 'widget',
                            'widgetType' => 'heading',
                            'settings' => [
                                'title' => 'Follow Us',
                                'header_size' => 'h4',
                                'title_color' => '#FFFFFF'
                            ]
                        ],
                        [
                            'id' => \Elementor\Utils::generate_random_string(),
                            'elType' => 'widget',
                            'widgetType' => 'social-icons',
                            'settings' => [
                                'social_icon_list' => [
                                    ['social' => 'fa fa-facebook', 'link' => ['url' => '#']],
                                    ['social' => 'fa fa-twitter', 'link' => ['url' => '#']],
                                    ['social' => 'fa fa-instagram', 'link' => ['url' => '#']],
                                    ['social' => 'fa fa-linkedin', 'link' => ['url' => '#']]
                                ],
                                'icon_color' => '#FFFFFF'
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ];
    
    update_post_meta($footer_id, '_elementor_data', wp_json_encode($footer_data));
    
    // Set as default footer
    update_option('elementor_footer_location', $footer_id);
    
    return $footer_id;
}

/**
 * Create Team Member Card Template
 */
function lumina_create_team_member_template() {
    // Check if template already exists
    $existing = get_posts([
        'post_type' => 'elementor_library',
        'title' => 'Team Member Card',
        'posts_per_page' => 1
    ]);
    
    if (!empty($existing)) {
        return $existing[0]->ID;
    }
    
    $template_id = wp_insert_post([
        'post_title' => 'Team Member Card',
        'post_type' => 'elementor_library',
        'post_status' => 'publish',
        'meta_input' => [
            '_elementor_template_type' => 'section',
            '_elementor_edit_mode' => 'builder'
        ]
    ]);
    
    if (is_wp_error($template_id)) {
        return false;
    }
    
    $template_data = [
        [
            'id' => \Elementor\Utils::generate_random_string(),
            'elType' => 'section',
            'settings' => [
                'background_background' => 'classic',
                'background_color' => '#f7f7f7',
                'border_radius' => ['unit' => 'px', 'size' => 10],
                'padding' => [
                    'unit' => 'px',
                    'top' => 20,
                    'right' => 20,
                    'bottom' => 20,
                    'left' => 20,
                    'isLinked' => true
                ]
            ],
            'elements' => [
                [
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'column',
                    'settings' => ['_column_size' => 100],
                    'elements' => [
                        [
                            'id' => \Elementor\Utils::generate_random_string(),
                            'elType' => 'widget',
                            'widgetType' => 'image',
                            'settings' => [
                                'image' => ['url' => ''],
                                'image_size' => 'medium',
                                'align' => 'center',
                                'border_radius' => ['unit' => 'px', 'size' => 50]
                            ]
                        ],
                        [
                            'id' => \Elementor\Utils::generate_random_string(),
                            'elType' => 'widget',
                            'widgetType' => 'heading',
                            'settings' => [
                                'title' => 'Team Member Name',
                                'header_size' => 'h3',
                                'align' => 'center',
                                'title_color' => '#003d70'
                            ]
                        ],
                        [
                            'id' => \Elementor\Utils::generate_random_string(),
                            'elType' => 'widget',
                            'widgetType' => 'text-editor',
                            'settings' => [
                                'editor' => '<p style="text-align: center; color: #7EBEC5; font-weight: 600;">Position Title</p>',
                                'align' => 'center'
                            ]
                        ],
                        [
                            'id' => \Elementor\Utils::generate_random_string(),
                            'elType' => 'widget',
                            'widgetType' => 'text-editor',
                            'settings' => [
                                'editor' => '<p style="text-align: center;">Brief bio or description of the team member.</p>',
                                'align' => 'center'
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ];
    
    update_post_meta($template_id, '_elementor_data', wp_json_encode($template_data));
    
    return $template_id;
}

/**
 * Create Program Card Template
 */
function lumina_create_program_card_template() {
    // Check if template already exists
    $existing = get_posts([
        'post_type' => 'elementor_library',
        'title' => 'Program Card',
        'posts_per_page' => 1
    ]);
    
    if (!empty($existing)) {
        return $existing[0]->ID;
    }
    
    $template_id = wp_insert_post([
        'post_title' => 'Program Card',
        'post_type' => 'elementor_library',
        'post_status' => 'publish',
        'meta_input' => [
            '_elementor_template_type' => 'section',
            '_elementor_edit_mode' => 'builder'
        ]
    ]);
    
    if (is_wp_error($template_id)) {
        return false;
    }
    
    $template_data = [
        [
            'id' => \Elementor\Utils::generate_random_string(),
            'elType' => 'section',
            'settings' => [
                'background_background' => 'classic',
                'background_color' => '#FFFFFF',
                'border_border' => 'solid',
                'border_width' => ['unit' => 'px', 'size' => 2],
                'border_color' => '#7EBEC5',
                'border_radius' => ['unit' => 'px', 'size' => 10],
                'padding' => [
                    'unit' => 'px',
                    'top' => 30,
                    'right' => 30,
                    'bottom' => 30,
                    'left' => 30,
                    'isLinked' => true
                ]
            ],
            'elements' => [
                [
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'column',
                    'settings' => ['_column_size' => 100],
                    'elements' => [
                        [
                            'id' => \Elementor\Utils::generate_random_string(),
                            'elType' => 'widget',
                            'widgetType' => 'heading',
                            'settings' => [
                                'title' => 'Program Name',
                                'header_size' => 'h3',
                                'title_color' => '#003d70'
                            ]
                        ],
                        [
                            'id' => \Elementor\Utils::generate_random_string(),
                            'elType' => 'widget',
                            'widgetType' => 'text-editor',
                            'settings' => [
                                'editor' => '<p><strong>Age Range:</strong> X-Y years</p><p>Program description and highlights go here.</p>'
                            ]
                        ],
                        [
                            'id' => \Elementor\Utils::generate_random_string(),
                            'elType' => 'widget',
                            'widgetType' => 'button',
                            'settings' => [
                                'text' => 'Learn More',
                                'button_type' => 'primary',
                                'link' => ['url' => '#']
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ];
    
    update_post_meta($template_id, '_elementor_data', wp_json_encode($template_data));
    
    return $template_id;
}

/**
 * Create Event Card Template
 */
function lumina_create_event_card_template() {
    // Check if template already exists
    $existing = get_posts([
        'post_type' => 'elementor_library',
        'title' => 'Event Card',
        'posts_per_page' => 1
    ]);
    
    if (!empty($existing)) {
        return $existing[0]->ID;
    }
    
    $template_id = wp_insert_post([
        'post_title' => 'Event Card',
        'post_type' => 'elementor_library',
        'post_status' => 'publish',
        'meta_input' => [
            '_elementor_template_type' => 'section',
            '_elementor_edit_mode' => 'builder'
        ]
    ]);
    
    if (is_wp_error($template_id)) {
        return false;
    }
    
    $template_data = [
        [
            'id' => \Elementor\Utils::generate_random_string(),
            'elType' => 'section',
            'settings' => [
                'background_background' => 'classic',
                'background_color' => '#f7f7f7',
                'border_radius' => ['unit' => 'px', 'size' => 10],
                'padding' => [
                    'unit' => 'px',
                    'top' => 20,
                    'right' => 20,
                    'bottom' => 20,
                    'left' => 20,
                    'isLinked' => true
                ]
            ],
            'elements' => [
                [
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'column',
                    'settings' => ['_column_size' => 100],
                    'elements' => [
                        [
                            'id' => \Elementor\Utils::generate_random_string(),
                            'elType' => 'widget',
                            'widgetType' => 'heading',
                            'settings' => [
                                'title' => 'Event Title',
                                'header_size' => 'h4',
                                'title_color' => '#003d70'
                            ]
                        ],
                        [
                            'id' => \Elementor\Utils::generate_random_string(),
                            'elType' => 'widget',
                            'widgetType' => 'text-editor',
                            'settings' => [
                                'editor' => '<p><strong style="color: #F39A3B;">Date:</strong> [Event Date]</p><p><strong>Time:</strong> [Event Time]</p><p><strong>Location:</strong> [Event Location]</p><p>[Event Description]</p>'
                            ]
                        ],
                        [
                            'id' => \Elementor\Utils::generate_random_string(),
                            'elType' => 'widget',
                            'widgetType' => 'button',
                            'settings' => [
                                'text' => 'View Details',
                                'button_type' => 'primary',
                                'link' => ['url' => '#']
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ];
    
    update_post_meta($template_id, '_elementor_data', wp_json_encode($template_data));
    
    return $template_id;
}

/**
 * Initialize all Elementor configurations
 */
function lumina_initialize_elementor_config() {
    // Only run if Elementor is active
    if (!did_action('elementor/loaded')) {
        return;
    }
    
    // Configure global settings
    lumina_configure_elementor_colors();
    lumina_configure_elementor_typography();
    lumina_configure_elementor_buttons();
    lumina_configure_elementor_spacing();
    
    // Create templates
    lumina_create_header_template();
    lumina_create_footer_template();
    lumina_create_team_member_template();
    lumina_create_program_card_template();
    lumina_create_event_card_template();
    
    // Mark configuration as complete
    update_option('lumina_elementor_configured', true);
}

// Hook to run configuration
add_action('init', function() {
    // Only run once
    if (!get_option('lumina_elementor_configured')) {
        lumina_initialize_elementor_config();
    }
});

// Add admin notice for successful configuration
add_action('admin_notices', function() {
    if (get_option('lumina_elementor_configured') && !get_option('lumina_elementor_notice_dismissed')) {
        echo '<div class="notice notice-success is-dismissible">';
        echo '<p><strong>Lumina Elementor Configuration:</strong> Global settings and templates have been configured successfully!</p>';
        echo '</div>';
        update_option('lumina_elementor_notice_dismissed', true);
    }
});
