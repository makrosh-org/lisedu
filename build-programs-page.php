<?php
/**
 * Build Programs Page with Elementor
 * 
 * This script creates the Programs page layout with Elementor and populates
 * program posts for each grade level (Play Group to Grade 5).
 * 
 * Task 9: Build Programs page and populate grade levels
 * Requirements: 1.3
 */

require_once 'wp-load.php';

if (!defined('ABSPATH')) {
    die('WordPress not loaded');
}

// Check if Elementor is active
if (!did_action('elementor/loaded')) {
    die('Elementor is not active. Please activate Elementor first.');
}

echo "=== Building Programs Page with Elementor ===\n\n";

// Get the Programs page
$programs_page = get_page_by_path('programs');
if (!$programs_page) {
    die("Error: Programs page not found. Please create it first.\n");
}

$page_id = $programs_page->ID;
echo "Found Programs page (ID: $page_id)\n";

// Enable Elementor for this page
update_post_meta($page_id, '_elementor_edit_mode', 'builder');
update_post_meta($page_id, '_elementor_template_type', 'wp-page');
update_post_meta($page_id, '_elementor_version', '3.18.0');

// Define the Elementor page structure
$elementor_data = [
    // Page Header Section
    [
        'id' => generate_random_string(),
        'elType' => 'section',
        'settings' => [
            'background_background' => 'classic',
            'background_color' => '#003d70',
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
                'id' => generate_random_string(),
                'elType' => 'column',
                'settings' => [
                    '_column_size' => 100,
                ],
                'elements' => [
                    [
                        'id' => generate_random_string(),
                        'elType' => 'widget',
                        'widgetType' => 'heading',
                        'settings' => [
                            'title' => 'Our Programs',
                            'header_size' => 'h1',
                            'align' => 'center',
                            'title_color' => '#FFFFFF',
                        ],
                    ],
                    [
                        'id' => generate_random_string(),
                        'elType' => 'widget',
                        'widgetType' => 'text-editor',
                        'settings' => [
                            'editor' => 'Discover our comprehensive educational programs from Play Group to Grade 5, integrating academic excellence with Islamic values.',
                            'align' => 'center',
                            'text_color' => '#FFFFFF',
                        ],
                    ],
                ],
            ],
        ],
    ],
    
    // Programs Grid Section
    [
        'id' => generate_random_string(),
        'elType' => 'section',
        'settings' => [
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
                'id' => generate_random_string(),
                'elType' => 'column',
                'settings' => [
                    '_column_size' => 100,
                ],
                'elements' => [
                    [
                        'id' => generate_random_string(),
                        'elType' => 'widget',
                        'widgetType' => 'heading',
                        'settings' => [
                            'title' => 'Grade Levels',
                            'header_size' => 'h2',
                            'align' => 'center',
                            'title_color' => '#003d70',
                        ],
                    ],
                    [
                        'id' => generate_random_string(),
                        'elType' => 'widget',
                        'widgetType' => 'shortcode',
                        'settings' => [
                            'shortcode' => '[lumina_programs_grid]',
                        ],
                    ],
                ],
            ],
        ],
    ],
    
    // Islamic Studies Integration Section
    [
        'id' => generate_random_string(),
        'elType' => 'section',
        'settings' => [
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
                'id' => generate_random_string(),
                'elType' => 'column',
                'settings' => [
                    '_column_size' => 100,
                ],
                'elements' => [
                    [
                        'id' => generate_random_string(),
                        'elType' => 'widget',
                        'widgetType' => 'heading',
                        'settings' => [
                            'title' => 'Islamic Studies Integration',
                            'header_size' => 'h2',
                            'align' => 'center',
                            'title_color' => '#003d70',
                        ],
                    ],
                    [
                        'id' => generate_random_string(),
                        'elType' => 'widget',
                        'widgetType' => 'text-editor',
                        'settings' => [
                            'editor' => '<p style="text-align: center; max-width: 800px; margin: 0 auto;">At Lumina International School, Islamic values and teachings are seamlessly integrated into every aspect of our curriculum. Our students learn to embody Islamic principles while excelling in academic subjects, developing both their minds and their character.</p>',
                        ],
                    ],
                ],
            ],
        ],
    ],
    
    // Extracurricular Activities Section
    [
        'id' => generate_random_string(),
        'elType' => 'section',
        'settings' => [
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
                'id' => generate_random_string(),
                'elType' => 'column',
                'settings' => [
                    '_column_size' => 100,
                ],
                'elements' => [
                    [
                        'id' => generate_random_string(),
                        'elType' => 'widget',
                        'widgetType' => 'heading',
                        'settings' => [
                            'title' => 'Extracurricular Activities',
                            'header_size' => 'h2',
                            'align' => 'center',
                            'title_color' => '#003d70',
                        ],
                    ],
                    [
                        'id' => generate_random_string(),
                        'elType' => 'widget',
                        'widgetType' => 'icon-list',
                        'settings' => [
                            'icon_list' => [
                                [
                                    'text' => 'Sports and Physical Education',
                                    'icon' => ['value' => 'fas fa-running', 'library' => 'fa-solid'],
                                ],
                                [
                                    'text' => 'Arts and Crafts',
                                    'icon' => ['value' => 'fas fa-palette', 'library' => 'fa-solid'],
                                ],
                                [
                                    'text' => 'Quran Recitation and Memorization',
                                    'icon' => ['value' => 'fas fa-book-quran', 'library' => 'fa-solid'],
                                ],
                                [
                                    'text' => 'Science Club',
                                    'icon' => ['value' => 'fas fa-flask', 'library' => 'fa-solid'],
                                ],
                                [
                                    'text' => 'Language Development',
                                    'icon' => ['value' => 'fas fa-language', 'library' => 'fa-solid'],
                                ],
                                [
                                    'text' => 'Music and Nasheed',
                                    'icon' => ['value' => 'fas fa-music', 'library' => 'fa-solid'],
                                ],
                            ],
                            'icon_color' => '#7EBEC5',
                            'text_color' => '#003d70',
                        ],
                    ],
                ],
            ],
        ],
    ],
    
    // Call to Action Section
    [
        'id' => generate_random_string(),
        'elType' => 'section',
        'settings' => [
            'background_background' => 'classic',
            'background_color' => '#7EBEC5',
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
                'id' => generate_random_string(),
                'elType' => 'column',
                'settings' => [
                    '_column_size' => 100,
                ],
                'elements' => [
                    [
                        'id' => generate_random_string(),
                        'elType' => 'widget',
                        'widgetType' => 'heading',
                        'settings' => [
                            'title' => 'Ready to Enroll Your Child?',
                            'header_size' => 'h2',
                            'align' => 'center',
                            'title_color' => '#FFFFFF',
                        ],
                    ],
                    [
                        'id' => generate_random_string(),
                        'elType' => 'widget',
                        'widgetType' => 'button',
                        'settings' => [
                            'text' => 'Apply Now',
                            'link' => ['url' => '/admissions'],
                            'align' => 'center',
                            'button_background_color' => '#F39A3B',
                            'button_text_color' => '#FFFFFF',
                        ],
                    ],
                ],
            ],
        ],
    ],
];

// Save Elementor data
update_post_meta($page_id, '_elementor_data', wp_slash(wp_json_encode($elementor_data)));
update_post_meta($page_id, '_elementor_page_settings', []);

echo "✓ Elementor layout created for Programs page\n\n";

// Helper function to generate random IDs
function generate_random_string($length = 7) {
    return substr(str_shuffle('0123456789abcdef'), 0, $length);
}

// Now populate program posts for each grade level
echo "=== Creating Program Posts ===\n\n";

$programs_data = [
    [
        'title' => 'Play Group',
        'age_range' => '3-4 years',
        'content' => 'Our Play Group program provides a nurturing environment where young learners begin their educational journey. Through play-based learning, children develop foundational skills in a safe, Islamic environment that encourages curiosity and exploration.',
        'curriculum' => [
            'Introduction to basic Islamic concepts and duas',
            'Early literacy and language development',
            'Basic numeracy and shape recognition',
            'Social and emotional learning',
            'Fine and gross motor skill development',
            'Creative arts and sensory activities',
            'Music and movement',
            'Outdoor play and physical activities',
        ],
        'category' => 'Academic Programs',
    ],
    [
        'title' => 'Kindergarten',
        'age_range' => '4-5 years',
        'content' => 'Our Kindergarten program builds upon early learning foundations, preparing children for formal schooling. Students engage in structured learning activities while maintaining the joy and wonder of childhood, all within an Islamic framework.',
        'curriculum' => [
            'Quran introduction and basic Arabic letters',
            'Phonics and early reading skills',
            'Number concepts and basic math operations',
            'Islamic stories and character building',
            'Science exploration and discovery',
            'Social studies and community awareness',
            'Art, music, and creative expression',
            'Physical education and coordination',
        ],
        'category' => 'Academic Programs',
    ],
    [
        'title' => 'Grade 1',
        'age_range' => '5-6 years',
        'content' => 'Grade 1 marks the beginning of formal education at Lumina. Students develop strong literacy and numeracy skills while deepening their understanding of Islamic values and practices. Our curriculum balances academic rigor with age-appropriate learning experiences.',
        'curriculum' => [
            'Quran reading with Tajweed basics',
            'Reading comprehension and writing skills',
            'Addition, subtraction, and place value',
            'Islamic studies and daily prayers',
            'Science concepts and experiments',
            'Social studies and geography basics',
            'English and Arabic language development',
            'Art, music, and physical education',
        ],
        'category' => 'Academic Programs',
    ],
    [
        'title' => 'Grade 2',
        'age_range' => '6-7 years',
        'content' => 'In Grade 2, students continue to build on their foundational skills with increased independence and critical thinking. Our integrated curriculum ensures that Islamic values are woven throughout all subject areas, fostering both academic and spiritual growth.',
        'curriculum' => [
            'Quran memorization and recitation',
            'Advanced reading and creative writing',
            'Multiplication, division, and fractions',
            'Islamic history and Prophet stories',
            'Life science and earth science',
            'World geography and cultures',
            'Bilingual language development',
            'STEM activities and problem-solving',
        ],
        'category' => 'Academic Programs',
    ],
    [
        'title' => 'Grade 3',
        'age_range' => '7-8 years',
        'content' => 'Grade 3 students engage in more complex learning experiences that challenge them to think critically and apply their knowledge. Our curriculum emphasizes both academic excellence and Islamic character development, preparing students for future success.',
        'curriculum' => [
            'Quran with Tajweed and memorization',
            'Literature analysis and essay writing',
            'Advanced math concepts and word problems',
            'Islamic jurisprudence (Fiqh) basics',
            'Physical and chemical science',
            'History and social studies',
            'Technology and computer skills',
            'Arts, sports, and extracurricular activities',
        ],
        'category' => 'Academic Programs',
    ],
    [
        'title' => 'Grade 4',
        'age_range' => '8-9 years',
        'content' => 'Grade 4 students develop advanced academic skills and deeper Islamic understanding. Our curriculum encourages independent learning, research skills, and leadership development, all while maintaining strong Islamic values and ethics.',
        'curriculum' => [
            'Quran memorization and Tafseer introduction',
            'Advanced reading comprehension and research',
            'Decimals, percentages, and geometry',
            'Islamic history and civilization',
            'Biology, chemistry, and physics basics',
            'World history and geography',
            'Advanced technology and coding',
            'Leadership and community service',
        ],
        'category' => 'Academic Programs',
    ],
    [
        'title' => 'Grade 5',
        'age_range' => '9-10 years',
        'content' => 'Our Grade 5 program prepares students for middle school with advanced academic content and strong Islamic foundation. Students develop critical thinking, problem-solving, and leadership skills that will serve them throughout their educational journey.',
        'curriculum' => [
            'Quran memorization and Islamic studies',
            'Literary analysis and persuasive writing',
            'Pre-algebra and advanced mathematics',
            'Islamic ethics and contemporary issues',
            'Advanced science and scientific method',
            'World cultures and current events',
            'Digital literacy and presentation skills',
            'Project-based learning and research',
        ],
        'category' => 'Academic Programs',
    ],
];

// Get or create the Academic Programs category
$category = get_term_by('name', 'Academic Programs', 'program_category');
if (!$category) {
    $category_result = wp_insert_term('Academic Programs', 'program_category');
    if (!is_wp_error($category_result)) {
        $category_id = $category_result['term_id'];
        echo "✓ Created 'Academic Programs' category\n";
    } else {
        echo "✗ Error creating category: " . $category_result->get_error_message() . "\n";
        $category_id = 0;
    }
} else {
    $category_id = $category->term_id;
    echo "✓ Found existing 'Academic Programs' category\n";
}

echo "\n";

// Create each program post
foreach ($programs_data as $program) {
    // Check if program already exists
    $existing = get_page_by_title($program['title'], OBJECT, 'lis_program');
    
    if ($existing) {
        echo "Program '{$program['title']}' already exists (ID: {$existing->ID}), updating...\n";
        $post_id = $existing->ID;
        
        // Update the post
        wp_update_post([
            'ID' => $post_id,
            'post_content' => $program['content'],
            'post_status' => 'publish',
        ]);
    } else {
        // Create new program post
        $post_id = wp_insert_post([
            'post_title' => $program['title'],
            'post_content' => $program['content'],
            'post_type' => 'lis_program',
            'post_status' => 'publish',
            'menu_order' => array_search($program, $programs_data), // For ordering
        ]);
        
        if (is_wp_error($post_id)) {
            echo "✗ Error creating '{$program['title']}': " . $post_id->get_error_message() . "\n";
            continue;
        }
        
        echo "✓ Created program: {$program['title']} (ID: $post_id)\n";
    }
    
    // Add custom fields
    update_post_meta($post_id, '_program_age_range', $program['age_range']);
    update_post_meta($post_id, '_program_curriculum_highlights', implode("\n", $program['curriculum']));
    
    // Assign category
    if ($category_id > 0) {
        wp_set_object_terms($post_id, $category_id, 'program_category');
    }
}

echo "\n=== Programs Page Build Complete ===\n";
echo "✓ Programs page layout created with Elementor\n";
echo "✓ All grade level programs created (Play Group to Grade 5)\n";
echo "✓ Curriculum highlights added for each program\n";
echo "✓ Islamic studies integration section added\n";
echo "✓ Extracurricular activities section added\n";
echo "✓ Responsive grid layout implemented\n";
echo "\nView the page at: " . get_permalink($page_id) . "\n";
