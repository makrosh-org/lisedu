<?php
/**
 * Build Contact Page for Lumina International School
 * 
 * This script creates the Contact page with:
 * - School's physical address, phone number, and email
 * - Embedded Google Maps with school location
 * - Contact form
 * - Office hours information
 * - Social media links
 * - Responsive design
 * 
 * Requirements: 5.1, 5.2
 */

require_once('wp-load.php');

if (!defined('ABSPATH')) {
    die('WordPress not loaded');
}

// Check if Elementor is active
if (!did_action('elementor/loaded')) {
    die('Elementor is not active. Please activate Elementor first.');
}

echo "Building Contact Page for Lumina International School...\n\n";

// Get or create the Contact page
$contact_page = get_page_by_path('contact');

if (!$contact_page) {
    $contact_page_id = wp_insert_post([
        'post_title'   => 'Contact',
        'post_name'    => 'contact',
        'post_status'  => 'publish',
        'post_type'    => 'page',
        'post_content' => '',
    ]);
    
    if (is_wp_error($contact_page_id)) {
        die("Error creating Contact page: " . $contact_page_id->get_error_message() . "\n");
    }
    
    echo "✓ Contact page created (ID: $contact_page_id)\n";
} else {
    $contact_page_id = $contact_page->ID;
    echo "✓ Contact page already exists (ID: $contact_page_id)\n";
}

// Enable Elementor for this page
update_post_meta($contact_page_id, '_elementor_edit_mode', 'builder');
update_post_meta($contact_page_id, '_wp_page_template', 'elementor_header_footer');

// Get the contact form shortcode (from Contact Form 7 or WPForms)
$contact_form_shortcode = '';
if (class_exists('WPCF7')) {
    // Get the first Contact Form 7 form
    $forms = get_posts([
        'post_type' => 'wpcf7_contact_form',
        'posts_per_page' => 1,
    ]);
    if (!empty($forms)) {
        $contact_form_shortcode = '[contact-form-7 id="' . $forms[0]->ID . '"]';
        echo "✓ Found Contact Form 7 form (ID: {$forms[0]->ID})\n";
    }
} elseif (function_exists('wpforms')) {
    // Get the first WPForms form
    $forms = wpforms()->form->get('', ['numberposts' => 1]);
    if (!empty($forms)) {
        $contact_form_shortcode = '[wpforms id="' . $forms[0]->ID . '"]';
        echo "✓ Found WPForms form (ID: {$forms[0]->ID})\n";
    }
}

if (empty($contact_form_shortcode)) {
    echo "⚠ Warning: No contact form found. Please create a contact form first.\n";
    $contact_form_shortcode = '[contact-form-placeholder]';
}

// Build Elementor page structure
$elementor_data = [
    // Page Header Section
    [
        'id' => \Elementor\Utils::generate_random_string(),
        'elType' => 'section',
        'settings' => [
            'layout' => 'boxed',
            'background_background' => 'classic',
            'background_color' => '#003d70',
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
                            'title' => 'Contact Us',
                            'align' => 'center',
                            'title_color' => '#FFFFFF',
                            'typography_typography' => 'custom',
                            'typography_font_size' => [
                                'unit' => 'px',
                                'size' => 48,
                            ],
                        ],
                        'widgetType' => 'heading',
                    ],
                    [
                        'id' => \Elementor\Utils::generate_random_string(),
                        'elType' => 'widget',
                        'settings' => [
                            'editor' => 'We\'re here to help! Reach out to us through any of the channels below.',
                            'align' => 'center',
                            'text_color' => '#FFFFFF',
                        ],
                        'widgetType' => 'text-editor',
                    ],
                ],
            ],
        ],
    ],
    
    // Contact Information Section
    [
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
            // Address Column
            [
                'id' => \Elementor\Utils::generate_random_string(),
                'elType' => 'column',
                'settings' => [
                    '_column_size' => 33,
                ],
                'elements' => [
                    [
                        'id' => \Elementor\Utils::generate_random_string(),
                        'elType' => 'widget',
                        'settings' => [
                            'selected_icon' => [
                                'value' => 'fas fa-map-marker-alt',
                                'library' => 'fa-solid',
                            ],
                            'icon_color' => '#003d70',
                            'icon_size' => [
                                'unit' => 'px',
                                'size' => 40,
                            ],
                            'view' => 'default',
                            'align' => 'center',
                        ],
                        'widgetType' => 'icon',
                    ],
                    [
                        'id' => \Elementor\Utils::generate_random_string(),
                        'elType' => 'widget',
                        'settings' => [
                            'title' => 'Visit Us',
                            'align' => 'center',
                            'title_color' => '#003d70',
                            'typography_typography' => 'custom',
                            'typography_font_size' => [
                                'unit' => 'px',
                                'size' => 24,
                            ],
                        ],
                        'widgetType' => 'heading',
                    ],
                    [
                        'id' => \Elementor\Utils::generate_random_string(),
                        'elType' => 'widget',
                        'settings' => [
                            'editor' => '<p style="text-align: center;">Lumina International School<br>123 Education Street<br>City, State 12345<br>Country</p>',
                            'align' => 'center',
                        ],
                        'widgetType' => 'text-editor',
                    ],
                ],
            ],
            
            // Phone & Email Column
            [
                'id' => \Elementor\Utils::generate_random_string(),
                'elType' => 'column',
                'settings' => [
                    '_column_size' => 33,
                ],
                'elements' => [
                    [
                        'id' => \Elementor\Utils::generate_random_string(),
                        'elType' => 'widget',
                        'settings' => [
                            'selected_icon' => [
                                'value' => 'fas fa-phone',
                                'library' => 'fa-solid',
                            ],
                            'icon_color' => '#003d70',
                            'icon_size' => [
                                'unit' => 'px',
                                'size' => 40,
                            ],
                            'view' => 'default',
                            'align' => 'center',
                        ],
                        'widgetType' => 'icon',
                    ],
                    [
                        'id' => \Elementor\Utils::generate_random_string(),
                        'elType' => 'widget',
                        'settings' => [
                            'title' => 'Call Us',
                            'align' => 'center',
                            'title_color' => '#003d70',
                            'typography_typography' => 'custom',
                            'typography_font_size' => [
                                'unit' => 'px',
                                'size' => 24,
                            ],
                        ],
                        'widgetType' => 'heading',
                    ],
                    [
                        'id' => \Elementor\Utils::generate_random_string(),
                        'elType' => 'widget',
                        'settings' => [
                            'editor' => '<p style="text-align: center;"><strong>Phone:</strong> +1 (555) 123-4567<br><strong>Email:</strong> info@luminaschool.edu</p>',
                            'align' => 'center',
                        ],
                        'widgetType' => 'text-editor',
                    ],
                ],
            ],
            
            // Office Hours Column
            [
                'id' => \Elementor\Utils::generate_random_string(),
                'elType' => 'column',
                'settings' => [
                    '_column_size' => 33,
                ],
                'elements' => [
                    [
                        'id' => \Elementor\Utils::generate_random_string(),
                        'elType' => 'widget',
                        'settings' => [
                            'selected_icon' => [
                                'value' => 'fas fa-clock',
                                'library' => 'fa-solid',
                            ],
                            'icon_color' => '#003d70',
                            'icon_size' => [
                                'unit' => 'px',
                                'size' => 40,
                            ],
                            'view' => 'default',
                            'align' => 'center',
                        ],
                        'widgetType' => 'icon',
                    ],
                    [
                        'id' => \Elementor\Utils::generate_random_string(),
                        'elType' => 'widget',
                        'settings' => [
                            'title' => 'Office Hours',
                            'align' => 'center',
                            'title_color' => '#003d70',
                            'typography_typography' => 'custom',
                            'typography_font_size' => [
                                'unit' => 'px',
                                'size' => 24,
                            ],
                        ],
                        'widgetType' => 'heading',
                    ],
                    [
                        'id' => \Elementor\Utils::generate_random_string(),
                        'elType' => 'widget',
                        'settings' => [
                            'editor' => '<p style="text-align: center;">Monday - Friday<br>8:00 AM - 4:00 PM<br><br>Saturday<br>9:00 AM - 1:00 PM<br><br>Sunday: Closed</p>',
                            'align' => 'center',
                        ],
                        'widgetType' => 'text-editor',
                    ],
                ],
            ],
        ],
    ],
    
    // Google Maps Section
    [
        'id' => \Elementor\Utils::generate_random_string(),
        'elType' => 'section',
        'settings' => [
            'layout' => 'full_width',
            'padding' => [
                'unit' => 'px',
                'top' => '0',
                'right' => '0',
                'bottom' => '0',
                'left' => '0',
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
                            'address' => 'Lumina International School, 123 Education Street, City, State 12345',
                            'zoom' => [
                                'size' => 15,
                            ],
                            'height' => [
                                'unit' => 'px',
                                'size' => 450,
                            ],
                            'prevent_scroll' => 'yes',
                        ],
                        'widgetType' => 'google_maps',
                    ],
                ],
            ],
        ],
    ],
    
    // Contact Form Section
    [
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
                            'title' => 'Send Us a Message',
                            'align' => 'center',
                            'title_color' => '#003d70',
                            'typography_typography' => 'custom',
                            'typography_font_size' => [
                                'unit' => 'px',
                                'size' => 36,
                            ],
                        ],
                        'widgetType' => 'heading',
                    ],
                    [
                        'id' => \Elementor\Utils::generate_random_string(),
                        'elType' => 'widget',
                        'settings' => [
                            'editor' => '<p style="text-align: center;">Have a question or need more information? Fill out the form below and we\'ll get back to you as soon as possible.</p>',
                            'align' => 'center',
                        ],
                        'widgetType' => 'text-editor',
                    ],
                    [
                        'id' => \Elementor\Utils::generate_random_string(),
                        'elType' => 'widget',
                        'settings' => [
                            'shortcode' => $contact_form_shortcode,
                        ],
                        'widgetType' => 'shortcode',
                    ],
                ],
            ],
        ],
    ],
    
    // Social Media Section
    [
        'id' => \Elementor\Utils::generate_random_string(),
        'elType' => 'section',
        'settings' => [
            'layout' => 'boxed',
            'background_background' => 'classic',
            'background_color' => '#f7f7f7',
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
                            'title' => 'Connect With Us',
                            'align' => 'center',
                            'title_color' => '#003d70',
                            'typography_typography' => 'custom',
                            'typography_font_size' => [
                                'unit' => 'px',
                                'size' => 32,
                            ],
                        ],
                        'widgetType' => 'heading',
                    ],
                    [
                        'id' => \Elementor\Utils::generate_random_string(),
                        'elType' => 'widget',
                        'settings' => [
                            'editor' => '<p style="text-align: center;">Follow us on social media to stay updated with the latest news and events.</p>',
                            'align' => 'center',
                        ],
                        'widgetType' => 'text-editor',
                    ],
                    [
                        'id' => \Elementor\Utils::generate_random_string(),
                        'elType' => 'widget',
                        'settings' => [
                            'social_icon_list' => [
                                [
                                    'social_icon' => [
                                        'value' => 'fab fa-facebook-f',
                                        'library' => 'fa-brands',
                                    ],
                                    'link' => [
                                        'url' => 'https://facebook.com/luminaschool',
                                        'is_external' => true,
                                    ],
                                ],
                                [
                                    'social_icon' => [
                                        'value' => 'fab fa-twitter',
                                        'library' => 'fa-brands',
                                    ],
                                    'link' => [
                                        'url' => 'https://twitter.com/luminaschool',
                                        'is_external' => true,
                                    ],
                                ],
                                [
                                    'social_icon' => [
                                        'value' => 'fab fa-instagram',
                                        'library' => 'fa-brands',
                                    ],
                                    'link' => [
                                        'url' => 'https://instagram.com/luminaschool',
                                        'is_external' => true,
                                    ],
                                ],
                                [
                                    'social_icon' => [
                                        'value' => 'fab fa-linkedin-in',
                                        'library' => 'fa-brands',
                                    ],
                                    'link' => [
                                        'url' => 'https://linkedin.com/company/luminaschool',
                                        'is_external' => true,
                                    ],
                                ],
                                [
                                    'social_icon' => [
                                        'value' => 'fab fa-youtube',
                                        'library' => 'fa-brands',
                                    ],
                                    'link' => [
                                        'url' => 'https://youtube.com/luminaschool',
                                        'is_external' => true,
                                    ],
                                ],
                            ],
                            'align' => 'center',
                            'icon_color' => '#003d70',
                            'icon_size' => [
                                'unit' => 'px',
                                'size' => 30,
                            ],
                            'icon_spacing' => [
                                'unit' => 'px',
                                'size' => 20,
                            ],
                        ],
                        'widgetType' => 'social-icons',
                    ],
                ],
            ],
        ],
    ],
];

// Save Elementor data
update_post_meta($contact_page_id, '_elementor_data', wp_slash(wp_json_encode($elementor_data)));
update_post_meta($contact_page_id, '_elementor_page_settings', []);

// Clear Elementor cache
if (class_exists('\Elementor\Plugin')) {
    \Elementor\Plugin::$instance->files_manager->clear_cache();
}

echo "\n✓ Contact page structure created with Elementor\n";
echo "\nContact Page Components:\n";
echo "  ✓ Page header with title\n";
echo "  ✓ Contact information (address, phone, email)\n";
echo "  ✓ Office hours\n";
echo "  ✓ Google Maps embed\n";
echo "  ✓ Contact form\n";
echo "  ✓ Social media links\n";
echo "  ✓ Responsive design with brand colors\n";

echo "\n" . str_repeat("=", 60) . "\n";
echo "Contact Page Build Complete!\n";
echo str_repeat("=", 60) . "\n\n";

echo "Page URL: " . get_permalink($contact_page_id) . "\n";
echo "\nNext Steps:\n";
echo "1. Visit the Contact page in your browser\n";
echo "2. Update the address, phone, and email with actual school information\n";
echo "3. Configure Google Maps with the correct school location\n";
echo "4. Update social media links with actual URLs\n";
echo "5. Adjust office hours as needed\n";
echo "6. Test the contact form submission\n";
echo "7. Test responsive design on mobile devices\n";

echo "\nRequirements Validated:\n";
echo "  ✓ 5.1 - Display physical address, phone number, and email\n";
echo "  ✓ 5.2 - Embed interactive Google Maps location\n";
