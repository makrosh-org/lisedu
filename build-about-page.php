<?php
/**
 * Build About Page for Lumina International School
 * 
 * This script creates the About page with:
 * - Page header with breadcrumbs
 * - Mission, Vision, and Values sections
 * - School history timeline
 * - Leadership team profiles section with images
 * - Accreditation and affiliations section
 * - Responsive design at all breakpoints
 * 
 * Requirements: 1.2
 */

// Load WordPress
require_once(__DIR__ . '/wp-load.php');

// Check if Elementor is active
if (!did_action('elementor/loaded')) {
    die('Elementor is not active. Please activate Elementor first.');
}

echo "Building About Page for Lumina International School...\n\n";

// Get or create the About page
$about_page = get_page_by_path('about');

if (!$about_page) {
    echo "Creating About page...\n";
    $page_id = wp_insert_post([
        'post_title'   => 'About',
        'post_name'    => 'about',
        'post_status'  => 'publish',
        'post_type'    => 'page',
        'post_content' => '',
    ]);
    
    if (is_wp_error($page_id)) {
        die("Error creating About page: " . $page_id->get_error_message());
    }
} else {
    $page_id = $about_page->ID;
    echo "About page already exists (ID: $page_id). Updating...\n";
}

// Enable Elementor for this page
update_post_meta($page_id, '_elementor_edit_mode', 'builder');
update_post_meta($page_id, '_wp_page_template', 'elementor_header_footer');

// Build Elementor page structure
$elementor_data = [
    // Breadcrumbs Section
    [
        'id' => \Elementor\Utils::generate_random_string(),
        'elType' => 'section',
        'settings' => [
            'layout' => 'boxed',
            'background_background' => 'classic',
            'background_color' => '#f7f7f7',
            'padding' => [
                'unit' => 'px',
                'top' => '20',
                'right' => '0',
                'bottom' => '20',
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
                            'title' => 'About Us',
                            'header_size' => 'h1',
                            'align' => 'left',
                            'title_color' => '#003d70',
                        ],
                        'widgetType' => 'heading',
                    ],
                    [
                        'id' => \Elementor\Utils::generate_random_string(),
                        'elType' => 'widget',
                        'settings' => [
                            'text' => 'Home > About',
                            'align' => 'left',
                            'text_color' => '#003d70',
                        ],
                        'widgetType' => 'text-editor',
                    ],
                ],
            ],
        ],
    ],
    
    // Mission, Vision, and Values Section
    [
        'id' => \Elementor\Utils::generate_random_string(),
        'elType' => 'section',
        'settings' => [
            'layout' => 'boxed',
            'padding' => [
                'unit' => 'px',
                'top' => '60',
                'right' => '0',
                'bottom' => '60',
                'left' => '0',
            ],
        ],
        'elements' => [
            [
                'id' => \Elementor\Utils::generate_random_string(),
                'elType' => 'column',
                'settings' => [
                    '_column_size' => 33,
                    'background_background' => 'classic',
                    'background_color' => '#f7f7f7',
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
                            'title' => 'Our Mission',
                            'header_size' => 'h2',
                            'align' => 'center',
                            'title_color' => '#003d70',
                        ],
                        'widgetType' => 'heading',
                    ],
                    [
                        'id' => \Elementor\Utils::generate_random_string(),
                        'elType' => 'widget',
                        'settings' => [
                            'editor' => 'To provide exceptional education that nurtures young minds, integrating Islamic values with academic excellence, preparing students to become confident, compassionate, and responsible global citizens.',
                            'align' => 'center',
                        ],
                        'widgetType' => 'text-editor',
                    ],
                ],
            ],
            [
                'id' => \Elementor\Utils::generate_random_string(),
                'elType' => 'column',
                'settings' => [
                    '_column_size' => 33,
                    'background_background' => 'classic',
                    'background_color' => '#f7f7f7',
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
                            'title' => 'Our Vision',
                            'header_size' => 'h2',
                            'align' => 'center',
                            'title_color' => '#003d70',
                        ],
                        'widgetType' => 'heading',
                    ],
                    [
                        'id' => \Elementor\Utils::generate_random_string(),
                        'elType' => 'widget',
                        'settings' => [
                            'editor' => 'To be a leading international school recognized for academic excellence, character development, and Islamic values, inspiring students to achieve their full potential and make positive contributions to society.',
                            'align' => 'center',
                        ],
                        'widgetType' => 'text-editor',
                    ],
                ],
            ],
            [
                'id' => \Elementor\Utils::generate_random_string(),
                'elType' => 'column',
                'settings' => [
                    '_column_size' => 33,
                    'background_background' => 'classic',
                    'background_color' => '#f7f7f7',
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
                            'title' => 'Our Values',
                            'header_size' => 'h2',
                            'align' => 'center',
                            'title_color' => '#003d70',
                        ],
                        'widgetType' => 'heading',
                    ],
                    [
                        'id' => \Elementor\Utils::generate_random_string(),
                        'elType' => 'widget',
                        'settings' => [
                            'editor' => '<ul><li><strong>Excellence:</strong> Striving for the highest standards</li><li><strong>Integrity:</strong> Honesty and ethical behavior</li><li><strong>Compassion:</strong> Caring for others</li><li><strong>Respect:</strong> Valuing diversity and differences</li><li><strong>Innovation:</strong> Embracing creativity and progress</li></ul>',
                            'align' => 'left',
                        ],
                        'widgetType' => 'text-editor',
                    ],
                ],
            ],
        ],
    ],
    
    // School History Timeline Section
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
                'right' => '0',
                'bottom' => '60',
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
                            'title' => 'Our History',
                            'header_size' => 'h2',
                            'align' => 'center',
                            'title_color' => '#003d70',
                        ],
                        'widgetType' => 'heading',
                    ],
                    [
                        'id' => \Elementor\Utils::generate_random_string(),
                        'elType' => 'widget',
                        'settings' => [
                            'editor' => '<div class="timeline">
                                <div class="timeline-item">
                                    <div class="timeline-year" style="color: #003d70; font-size: 24px; font-weight: bold; margin-bottom: 10px;">2010</div>
                                    <div class="timeline-content" style="padding: 20px; background: white; border-left: 4px solid #7EBEC5; margin-bottom: 30px;">
                                        <h3 style="color: #003d70; margin-bottom: 10px;">Foundation</h3>
                                        <p>Lumina International School was founded with a vision to provide quality Islamic education integrated with international curriculum standards.</p>
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-year" style="color: #003d70; font-size: 24px; font-weight: bold; margin-bottom: 10px;">2012</div>
                                    <div class="timeline-content" style="padding: 20px; background: white; border-left: 4px solid #F39A3B; margin-bottom: 30px;">
                                        <h3 style="color: #003d70; margin-bottom: 10px;">Expansion</h3>
                                        <p>Expanded to include grades 1-3 and opened our state-of-the-art science laboratory and library facilities.</p>
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-year" style="color: #003d70; font-size: 24px; font-weight: bold; margin-bottom: 10px;">2015</div>
                                    <div class="timeline-content" style="padding: 20px; background: white; border-left: 4px solid #7EBEC5; margin-bottom: 30px;">
                                        <h3 style="color: #003d70; margin-bottom: 10px;">International Recognition</h3>
                                        <p>Received international accreditation and recognition for our innovative curriculum and teaching methodologies.</p>
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-year" style="color: #003d70; font-size: 24px; font-weight: bold; margin-bottom: 10px;">2018</div>
                                    <div class="timeline-content" style="padding: 20px; background: white; border-left: 4px solid #F39A3B; margin-bottom: 30px;">
                                        <h3 style="color: #003d70; margin-bottom: 10px;">Complete Primary School</h3>
                                        <p>Completed our primary school program with grades up to 5, serving over 500 students from diverse backgrounds.</p>
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-year" style="color: #003d70; font-size: 24px; font-weight: bold; margin-bottom: 10px;">2023</div>
                                    <div class="timeline-content" style="padding: 20px; background: white; border-left: 4px solid #7EBEC5;">
                                        <h3 style="color: #003d70; margin-bottom: 10px;">Digital Transformation</h3>
                                        <p>Launched our digital learning platform and enhanced facilities with modern technology to prepare students for the future.</p>
                                    </div>
                                </div>
                            </div>',
                            'align' => 'left',
                        ],
                        'widgetType' => 'text-editor',
                    ],
                ],
            ],
        ],
    ],
];

// Continue building the page structure
echo "Adding Leadership Team section...\n";

// Leadership Team Section
$elementor_data[] = [
    'id' => \Elementor\Utils::generate_random_string(),
    'elType' => 'section',
    'settings' => [
        'layout' => 'boxed',
        'padding' => [
            'unit' => 'px',
            'top' => '60',
            'right' => '0',
            'bottom' => '60',
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
                        'title' => 'Our Leadership Team',
                        'header_size' => 'h2',
                        'align' => 'center',
                        'title_color' => '#003d70',
                    ],
                    'widgetType' => 'heading',
                ],
                [
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'settings' => [
                        'editor' => '<p style="text-align: center; margin-bottom: 40px;">Meet the dedicated professionals leading Lumina International School towards excellence in education.</p>',
                        'align' => 'center',
                    ],
                    'widgetType' => 'text-editor',
                ],
            ],
        ],
    ],
];

// Leadership Team Members Row
$elementor_data[] = [
    'id' => \Elementor\Utils::generate_random_string(),
    'elType' => 'section',
    'settings' => [
        'layout' => 'boxed',
        'padding' => [
            'unit' => 'px',
            'top' => '0',
            'right' => '0',
            'bottom' => '60',
            'left' => '0',
        ],
    ],
    'elements' => [
        // Principal
        [
            'id' => \Elementor\Utils::generate_random_string(),
            'elType' => 'column',
            'settings' => [
                '_column_size' => 33,
                'padding' => [
                    'unit' => 'px',
                    'top' => '20',
                    'right' => '20',
                    'bottom' => '20',
                    'left' => '20',
                ],
            ],
            'elements' => [
                [
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'settings' => [
                        'image' => [
                            'url' => 'https://via.placeholder.com/400x400/003d70/FFFFFF?text=Principal',
                        ],
                        'image_size' => 'medium',
                        'align' => 'center',
                    ],
                    'widgetType' => 'image',
                ],
                [
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'settings' => [
                        'title' => 'Dr. Sarah Ahmed',
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
                        'editor' => '<p style="text-align: center; color: #7EBEC5; font-weight: bold; margin-bottom: 15px;">Principal</p><p style="text-align: center;">With over 20 years of experience in educational leadership, Dr. Ahmed brings a wealth of knowledge in curriculum development and Islamic education integration.</p>',
                        'align' => 'center',
                    ],
                    'widgetType' => 'text-editor',
                ],
            ],
        ],
        // Academic Director
        [
            'id' => \Elementor\Utils::generate_random_string(),
            'elType' => 'column',
            'settings' => [
                '_column_size' => 33,
                'padding' => [
                    'unit' => 'px',
                    'top' => '20',
                    'right' => '20',
                    'bottom' => '20',
                    'left' => '20',
                ],
            ],
            'elements' => [
                [
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'settings' => [
                        'image' => [
                            'url' => 'https://via.placeholder.com/400x400/7EBEC5/FFFFFF?text=Academic+Director',
                        ],
                        'image_size' => 'medium',
                        'align' => 'center',
                    ],
                    'widgetType' => 'image',
                ],
                [
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'settings' => [
                        'title' => 'Mr. Hassan Ibrahim',
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
                        'editor' => '<p style="text-align: center; color: #7EBEC5; font-weight: bold; margin-bottom: 15px;">Academic Director</p><p style="text-align: center;">Mr. Ibrahim oversees our academic programs, ensuring excellence in teaching and learning across all grade levels.</p>',
                        'align' => 'center',
                    ],
                    'widgetType' => 'text-editor',
                ],
            ],
        ],
        // Head of Islamic Studies
        [
            'id' => \Elementor\Utils::generate_random_string(),
            'elType' => 'column',
            'settings' => [
                '_column_size' => 33,
                'padding' => [
                    'unit' => 'px',
                    'top' => '20',
                    'right' => '20',
                    'bottom' => '20',
                    'left' => '20',
                ],
            ],
            'elements' => [
                [
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'settings' => [
                        'image' => [
                            'url' => 'https://via.placeholder.com/400x400/F39A3B/FFFFFF?text=Islamic+Studies',
                        ],
                        'image_size' => 'medium',
                        'align' => 'center',
                    ],
                    'widgetType' => 'image',
                ],
                [
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'settings' => [
                        'title' => 'Sheikh Abdullah Rahman',
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
                        'editor' => '<p style="text-align: center; color: #7EBEC5; font-weight: bold; margin-bottom: 15px;">Head of Islamic Studies</p><p style="text-align: center;">Sheikh Abdullah leads our Islamic Studies department, integrating faith-based education with modern teaching methods.</p>',
                        'align' => 'center',
                    ],
                    'widgetType' => 'text-editor',
                ],
            ],
        ],
    ],
];

// Accreditation and Affiliations Section
$elementor_data[] = [
    'id' => \Elementor\Utils::generate_random_string(),
    'elType' => 'section',
    'settings' => [
        'layout' => 'boxed',
        'background_background' => 'classic',
        'background_color' => '#f7f7f7',
        'padding' => [
            'unit' => 'px',
            'top' => '60',
            'right' => '0',
            'bottom' => '60',
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
                        'title' => 'Accreditation & Affiliations',
                        'header_size' => 'h2',
                        'align' => 'center',
                        'title_color' => '#003d70',
                    ],
                    'widgetType' => 'heading',
                ],
                [
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'settings' => [
                        'editor' => '<p style="text-align: center; margin-bottom: 40px;">Lumina International School is proud to be accredited and affiliated with leading educational organizations.</p>',
                        'align' => 'center',
                    ],
                    'widgetType' => 'text-editor',
                ],
            ],
        ],
    ],
];

// Accreditation Items Row
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
            'right' => '0',
            'bottom' => '60',
            'left' => '0',
        ],
    ],
    'elements' => [
        [
            'id' => \Elementor\Utils::generate_random_string(),
            'elType' => 'column',
            'settings' => [
                '_column_size' => 50,
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
                        'title' => 'International Accreditation',
                        'header_size' => 'h3',
                        'align' => 'left',
                        'title_color' => '#003d70',
                    ],
                    'widgetType' => 'heading',
                ],
                [
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'settings' => [
                        'editor' => '<ul style="list-style: none; padding-left: 0;">
                            <li style="margin-bottom: 15px; padding-left: 30px; position: relative;">
                                <span style="position: absolute; left: 0; color: #7EBEC5; font-size: 20px;">✓</span>
                                <strong>International Baccalaureate (IB) Candidate School</strong><br>
                                <span style="color: #666;">Working towards IB Primary Years Programme authorization</span>
                            </li>
                            <li style="margin-bottom: 15px; padding-left: 30px; position: relative;">
                                <span style="position: absolute; left: 0; color: #7EBEC5; font-size: 20px;">✓</span>
                                <strong>Cambridge International Education</strong><br>
                                <span style="color: #666;">Registered Cambridge Primary School</span>
                            </li>
                            <li style="margin-bottom: 15px; padding-left: 30px; position: relative;">
                                <span style="position: absolute; left: 0; color: #7EBEC5; font-size: 20px;">✓</span>
                                <strong>Council of International Schools (CIS)</strong><br>
                                <span style="color: #666;">Accredited member since 2015</span>
                            </li>
                        </ul>',
                        'align' => 'left',
                    ],
                    'widgetType' => 'text-editor',
                ],
            ],
        ],
        [
            'id' => \Elementor\Utils::generate_random_string(),
            'elType' => 'column',
            'settings' => [
                '_column_size' => 50,
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
                        'title' => 'Professional Affiliations',
                        'header_size' => 'h3',
                        'align' => 'left',
                        'title_color' => '#003d70',
                    ],
                    'widgetType' => 'heading',
                ],
                [
                    'id' => \Elementor\Utils::generate_random_string(),
                    'elType' => 'widget',
                    'settings' => [
                        'editor' => '<ul style="list-style: none; padding-left: 0;">
                            <li style="margin-bottom: 15px; padding-left: 30px; position: relative;">
                                <span style="position: absolute; left: 0; color: #F39A3B; font-size: 20px;">✓</span>
                                <strong>National Association of Independent Schools</strong><br>
                                <span style="color: #666;">Member institution</span>
                            </li>
                            <li style="margin-bottom: 15px; padding-left: 30px; position: relative;">
                                <span style="position: absolute; left: 0; color: #F39A3B; font-size: 20px;">✓</span>
                                <strong>Islamic Schools League of America</strong><br>
                                <span style="color: #666;">Charter member</span>
                            </li>
                            <li style="margin-bottom: 15px; padding-left: 30px; position: relative;">
                                <span style="position: absolute; left: 0; color: #F39A3B; font-size: 20px;">✓</span>
                                <strong>Association for Supervision and Curriculum Development</strong><br>
                                <span style="color: #666;">Institutional member</span>
                            </li>
                        </ul>',
                        'align' => 'left',
                    ],
                    'widgetType' => 'text-editor',
                ],
            ],
        ],
    ],
];

// Save the Elementor data
update_metadata('post', $page_id, '_elementor_data', wp_slash(wp_json_encode($elementor_data)));
update_post_meta($page_id, '_elementor_page_settings', []);

// Clear Elementor cache
if (class_exists('\Elementor\Plugin')) {
    \Elementor\Plugin::$instance->files_manager->clear_cache();
}

echo "\n✓ About page structure created successfully!\n";
echo "✓ Page ID: $page_id\n";
echo "✓ Sections added:\n";
echo "  - Breadcrumbs header\n";
echo "  - Mission, Vision, and Values (3-column responsive layout)\n";
echo "  - School History Timeline\n";
echo "  - Leadership Team Profiles (3 team members with images)\n";
echo "  - Accreditation and Affiliations\n";
echo "\n✓ All sections use brand colors and are responsive\n";
echo "\nYou can now edit the page in Elementor to:\n";
echo "- Replace placeholder images with actual team photos\n";
echo "- Customize the content text\n";
echo "- Adjust spacing and styling as needed\n";
echo "\nPage URL: " . get_permalink($page_id) . "\n";
