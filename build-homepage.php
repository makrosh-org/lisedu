<?php
/**
 * Build Homepage with Elementor
 * Task 6: Design and implement homepage sections
 * 
 * Requirements: 1.1, 10.4, 11.4
 */

// Load WordPress
require_once __DIR__ . '/wp-load.php';

// Check if Elementor is active
if (!did_action('elementor/loaded')) {
    die("Error: Elementor is not active.\n");
}

echo "Building Lumina International School Homepage...\n";
echo "================================================\n\n";

// Get the homepage
$homepage = get_page_by_path('home');
if (!$homepage) {
    die("Error: Home page not found. Please create it first.\n");
}

echo "✓ Found homepage (ID: {$homepage->ID})\n";

// Enable Elementor for this page
update_post_meta($homepage->ID, '_elementor_edit_mode', 'builder');

// Build the Elementor data structure
$elementor_data = array();

// Section 1: Hero Section
// Requirements: 1.1 - Hero section with school name, tagline, and CTA button
$elementor_data[] = array(
    'id' => \Elementor\Utils::generate_random_string(),
    'elType' => 'section',
    'settings' => array(
        'background_background' => 'gradient',
        'background_color' => '#003d70',
        'background_color_b' => '#7EBEC5',
        'background_gradient_angle' => array('size' => 135, 'unit' => 'deg'),
        'padding' => array(
            'unit' => 'px',
            'top' => '100',
            'right' => '20',
            'bottom' => '100',
            'left' => '20',
        ),
        'height' => 'min-height',
        'custom_height' => array('size' => 600, 'unit' => 'px'),
    ),
    'elements' => array(
        array(
            'id' => \Elementor\Utils::generate_random_string(),
            'elType' => 'column',
            'settings' => array('_column_size' => 100),
            'elements' => array(
                // School Name
                array(
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'widgetType' => 'heading',
                    'settings' => array(
                        'title' => 'Lumina International School',
                        'header_size' => 'h1',
                        'align' => 'center',
                        'title_color' => '#FFFFFF',
                        'typography_typography' => 'custom',
                        'typography_font_size' => array('size' => 56, 'unit' => 'px'),
                        'typography_font_weight' => '700',
                    ),
                ),
                // Tagline
                array(
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'widgetType' => 'heading',
                    'settings' => array(
                        'title' => 'Nurturing Young Minds with Islamic Values',
                        'header_size' => 'h2',
                        'align' => 'center',
                        'title_color' => '#FFFFFF',
                        'typography_typography' => 'custom',
                        'typography_font_size' => array('size' => 24, 'unit' => 'px'),
                        'typography_font_weight' => '400',
                    ),
                ),
                // CTA Button
                array(
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'widgetType' => 'button',
                    'settings' => array(
                        'text' => 'Apply Now',
                        'link' => array('url' => '/admissions/'),
                        'align' => 'center',
                        'button_type' => 'default',
                        'button_background_color' => '#F39A3B',
                        'button_text_color' => '#FFFFFF',
                        'typography_typography' => 'custom',
                        'typography_font_size' => array('size' => 18, 'unit' => 'px'),
                        'typography_font_weight' => '600',
                        'button_padding' => array(
                            'unit' => 'px',
                            'top' => '15',
                            'right' => '40',
                            'bottom' => '15',
                            'left' => '40',
                        ),
                        'button_border_radius' => array('size' => 5, 'unit' => 'px'),
                    ),
                ),
            ),
        ),
    ),
);

echo "✓ Created hero section\n";

// Section 2: Welcome Message
$elementor_data[] = array(
    'id' => \Elementor\Utils::generate_random_string(),
    'elType' => 'section',
    'settings' => array(
        'background_background' => 'classic',
        'background_color' => '#FFFFFF',
        'padding' => array(
            'unit' => 'px',
            'top' => '80',
            'right' => '20',
            'bottom' => '80',
            'left' => '20',
        ),
    ),
    'elements' => array(
        array(
            'id' => \Elementor\Utils::generate_random_string(),
            'elType' => 'column',
            'settings' => array('_column_size' => 100),
            'elements' => array(
                // Welcome Heading
                array(
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'widgetType' => 'heading',
                    'settings' => array(
                        'title' => 'Welcome to Lumina International School',
                        'header_size' => 'h2',
                        'align' => 'center',
                        'title_color' => '#003d70',
                        'typography_typography' => 'custom',
                        'typography_font_size' => array('size' => 36, 'unit' => 'px'),
                        'typography_font_weight' => '700',
                    ),
                ),
                // Welcome Text
                array(
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'widgetType' => 'text-editor',
                    'settings' => array(
                        'editor' => 'At Lumina International School, we provide a nurturing environment where children from play group to grade 5 receive quality education rooted in Islamic values. Our dedicated faculty and modern facilities ensure that every child develops academically, spiritually, and socially.',
                        'align' => 'center',
                    ),
                ),
            ),
        ),
    ),
);

echo "✓ Created welcome message section\n";

// Section 3: Featured Programs (3-column grid)
$elementor_data[] = array(
    'id' => \Elementor\Utils::generate_random_string(),
    'elType' => 'section',
    'settings' => array(
        'background_background' => 'classic',
        'background_color' => '#f7f7f7',
        'padding' => array(
            'unit' => 'px',
            'top' => '80',
            'right' => '20',
            'bottom' => '80',
            'left' => '20',
        ),
    ),
    'elements' => array(
        // Full-width column for heading
        array(
            'id' => \Elementor\Utils::generate_random_string(),
            'elType' => 'column',
            'settings' => array('_column_size' => 100),
            'elements' => array(
                array(
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'widgetType' => 'heading',
                    'settings' => array(
                        'title' => 'Our Programs',
                        'header_size' => 'h2',
                        'align' => 'center',
                        'title_color' => '#003d70',
                        'typography_typography' => 'custom',
                        'typography_font_size' => array('size' => 36, 'unit' => 'px'),
                        'typography_font_weight' => '700',
                    ),
                ),
            ),
        ),
    ),
);

// Add a new section for the 3-column grid
$elementor_data[] = array(
    'id' => \Elementor\Utils::generate_random_string(),
    'elType' => 'section',
    'settings' => array(
        'background_background' => 'classic',
        'background_color' => '#f7f7f7',
        'padding' => array(
            'unit' => 'px',
            'top' => '0',
            'right' => '20',
            'bottom' => '80',
            'left' => '20',
        ),
        'layout' => 'boxed',
    ),
    'elements' => array(
        // Column 1: Early Years
        array(
            'id' => \Elementor\Utils::generate_random_string(),
            'elType' => 'column',
            'settings' => array('_column_size' => 33),
            'elements' => array(
                array(
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'widgetType' => 'icon-box',
                    'settings' => array(
                        'title_text' => 'Early Years',
                        'description_text' => 'Play Group & Kindergarten programs designed to foster curiosity and love for learning in a safe, nurturing environment.',
                        'icon' => array('value' => 'fas fa-child', 'library' => 'fa-solid'),
                        'icon_color' => '#7EBEC5',
                        'title_color' => '#003d70',
                        'description_color' => '#333333',
                        'link' => array('url' => '/programs/'),
                    ),
                ),
            ),
        ),
        // Column 2: Primary Education
        array(
            'id' => \Elementor\Utils::generate_random_string(),
            'elType' => 'column',
            'settings' => array('_column_size' => 33),
            'elements' => array(
                array(
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'widgetType' => 'icon-box',
                    'settings' => array(
                        'title_text' => 'Primary Education',
                        'description_text' => 'Grades 1-5 with comprehensive curriculum combining academic excellence with Islamic studies and character development.',
                        'icon' => array('value' => 'fas fa-book-open', 'library' => 'fa-solid'),
                        'icon_color' => '#7EBEC5',
                        'title_color' => '#003d70',
                        'description_color' => '#333333',
                        'link' => array('url' => '/programs/'),
                    ),
                ),
            ),
        ),
        // Column 3: Islamic Studies
        array(
            'id' => \Elementor\Utils::generate_random_string(),
            'elType' => 'column',
            'settings' => array('_column_size' => 33),
            'elements' => array(
                array(
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'widgetType' => 'icon-box',
                    'settings' => array(
                        'title_text' => 'Islamic Studies',
                        'description_text' => 'Integrated Islamic education teaching Quran, Arabic, and Islamic values throughout all grade levels.',
                        'icon' => array('value' => 'fas fa-mosque', 'library' => 'fa-solid'),
                        'icon_color' => '#7EBEC5',
                        'title_color' => '#003d70',
                        'description_color' => '#333333',
                        'link' => array('url' => '/programs/islamic-studies/'),
                    ),
                ),
            ),
        ),
    ),
);

echo "✓ Created featured programs section (3-column grid)\n";

// Section 4: Upcoming Events Widget
// Requirements: 10.4 - Display next 3 upcoming events
$elementor_data[] = array(
    'id' => \Elementor\Utils::generate_random_string(),
    'elType' => 'section',
    'settings' => array(
        'background_background' => 'classic',
        'background_color' => '#FFFFFF',
        'padding' => array(
            'unit' => 'px',
            'top' => '80',
            'right' => '20',
            'bottom' => '80',
            'left' => '20',
        ),
    ),
    'elements' => array(
        array(
            'id' => \Elementor\Utils::generate_random_string(),
            'elType' => 'column',
            'settings' => array('_column_size' => 100),
            'elements' => array(
                // Section Heading
                array(
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'widgetType' => 'heading',
                    'settings' => array(
                        'title' => 'Upcoming Events',
                        'header_size' => 'h2',
                        'align' => 'center',
                        'title_color' => '#003d70',
                        'typography_typography' => 'custom',
                        'typography_font_size' => array('size' => 36, 'unit' => 'px'),
                        'typography_font_weight' => '700',
                    ),
                ),
                // Shortcode for upcoming events
                array(
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'widgetType' => 'shortcode',
                    'settings' => array(
                        'shortcode' => '[lumina_upcoming_events limit=3]',
                    ),
                ),
                // View All Events Button
                array(
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'widgetType' => 'button',
                    'settings' => array(
                        'text' => 'View All Events',
                        'link' => array('url' => '/events/'),
                        'align' => 'center',
                        'button_type' => 'default',
                        'button_background_color' => '#7EBEC5',
                        'button_text_color' => '#FFFFFF',
                    ),
                ),
            ),
        ),
    ),
);

echo "✓ Created upcoming events widget section\n";

// Section 5: Recent News
// Requirements: 11.4 - Display 3 most recent news articles
$elementor_data[] = array(
    'id' => \Elementor\Utils::generate_random_string(),
    'elType' => 'section',
    'settings' => array(
        'background_background' => 'classic',
        'background_color' => '#f7f7f7',
        'padding' => array(
            'unit' => 'px',
            'top' => '80',
            'right' => '20',
            'bottom' => '80',
            'left' => '20',
        ),
    ),
    'elements' => array(
        array(
            'id' => \Elementor\Utils::generate_random_string(),
            'elType' => 'column',
            'settings' => array('_column_size' => 100),
            'elements' => array(
                // Section Heading
                array(
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'widgetType' => 'heading',
                    'settings' => array(
                        'title' => 'Latest News',
                        'header_size' => 'h2',
                        'align' => 'center',
                        'title_color' => '#003d70',
                        'typography_typography' => 'custom',
                        'typography_font_size' => array('size' => 36, 'unit' => 'px'),
                        'typography_font_weight' => '700',
                    ),
                ),
                // Shortcode for recent news
                array(
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'widgetType' => 'shortcode',
                    'settings' => array(
                        'shortcode' => '[lumina_recent_news limit=3]',
                    ),
                ),
                // View All News Button
                array(
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'widgetType' => 'button',
                    'settings' => array(
                        'text' => 'View All News',
                        'link' => array('url' => '/news/'),
                        'align' => 'center',
                        'button_type' => 'default',
                        'button_background_color' => '#7EBEC5',
                        'button_text_color' => '#FFFFFF',
                    ),
                ),
            ),
        ),
    ),
);

echo "✓ Created recent news section\n";

// Section 6: Testimonials Slider
$elementor_data[] = array(
    'id' => \Elementor\Utils::generate_random_string(),
    'elType' => 'section',
    'settings' => array(
        'background_background' => 'classic',
        'background_color' => '#003d70',
        'padding' => array(
            'unit' => 'px',
            'top' => '80',
            'right' => '20',
            'bottom' => '80',
            'left' => '20',
        ),
    ),
    'elements' => array(
        array(
            'id' => \Elementor\Utils::generate_random_string(),
            'elType' => 'column',
            'settings' => array('_column_size' => 100),
            'elements' => array(
                // Section Heading
                array(
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'widgetType' => 'heading',
                    'settings' => array(
                        'title' => 'What Parents Say',
                        'header_size' => 'h2',
                        'align' => 'center',
                        'title_color' => '#FFFFFF',
                        'typography_typography' => 'custom',
                        'typography_font_size' => array('size' => 36, 'unit' => 'px'),
                        'typography_font_weight' => '700',
                    ),
                ),
                // Testimonials
                array(
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'widgetType' => 'testimonial',
                    'settings' => array(
                        'testimonial_content' => 'Lumina International School has been a blessing for our family. The teachers are caring and dedicated, and our daughter has grown so much academically and spiritually.',
                        'testimonial_name' => 'Sarah Ahmed',
                        'testimonial_job' => 'Parent of Grade 3 Student',
                        'testimonial_alignment' => 'center',
                        'testimonial_text_color' => '#FFFFFF',
                        'testimonial_name_color' => '#F39A3B',
                        'testimonial_job_color' => '#7EBEC5',
                    ),
                ),
            ),
        ),
    ),
);

echo "✓ Created testimonials section\n";

// Section 7: Quick Contact
$elementor_data[] = array(
    'id' => \Elementor\Utils::generate_random_string(),
    'elType' => 'section',
    'settings' => array(
        'background_background' => 'classic',
        'background_color' => '#FFFFFF',
        'padding' => array(
            'unit' => 'px',
            'top' => '80',
            'right' => '20',
            'bottom' => '80',
            'left' => '20',
        ),
    ),
    'elements' => array(
        array(
            'id' => \Elementor\Utils::generate_random_string(),
            'elType' => 'column',
            'settings' => array('_column_size' => 50),
            'elements' => array(
                // Contact Heading
                array(
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'widgetType' => 'heading',
                    'settings' => array(
                        'title' => 'Get in Touch',
                        'header_size' => 'h2',
                        'title_color' => '#003d70',
                        'typography_typography' => 'custom',
                        'typography_font_size' => array('size' => 32, 'unit' => 'px'),
                        'typography_font_weight' => '700',
                    ),
                ),
                // Contact Info
                array(
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'widgetType' => 'text-editor',
                    'settings' => array(
                        'editor' => 'Address: 123 Education Street, City, Country\n\nPhone: +1 (555) 123-4567\n\nEmail: info@luminaschool.edu\n\nOffice Hours: Monday - Friday, 8:00 AM - 4:00 PM',
                    ),
                ),
            ),
        ),
        array(
            'id' => \Elementor\Utils::generate_random_string(),
            'elType' => 'column',
            'settings' => array('_column_size' => 50),
            'elements' => array(
                // Quick Contact Form placeholder
                array(
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'widgetType' => 'text-editor',
                    'settings' => array(
                        'editor' => 'Contact form will be added in Task 11',
                    ),
                ),
            ),
        ),
    ),
);

echo "✓ Created quick contact section\n";

// Save the Elementor data
// Elementor expects the data as a JSON string
$elementor_data_json = wp_json_encode($elementor_data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
if ($elementor_data_json === false) {
    die("Error: Failed to encode Elementor data - " . json_last_error_msg() . "\n");
}

update_post_meta($homepage->ID, '_elementor_data', $elementor_data_json);
update_post_meta($homepage->ID, '_elementor_page_settings', array());
update_post_meta($homepage->ID, '_elementor_version', ELEMENTOR_VERSION);

// Clear Elementor cache
if (class_exists('\Elementor\Plugin')) {
    \Elementor\Plugin::$instance->files_manager->clear_cache();
}

echo "\n✓ Homepage built successfully!\n";
echo "✓ All sections use brand colors\n";
echo "✓ Responsive design implemented\n";
echo "\nHomepage URL: " . get_permalink($homepage->ID) . "\n";
echo "\nNext steps:\n";
echo "1. Visit the homepage to see the design\n";
echo "2. Edit with Elementor to customize content\n";
echo "3. Add actual images and content\n";
echo "4. Create sample events and news posts for widgets\n";

echo "\n================================================\n";
echo "Task 6 Implementation Complete!\n";
echo "================================================\n";
