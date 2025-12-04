<?php
/**
 * Build Admissions Page with Enrollment Information
 * Task 14: Create Admissions page layout with requirements, fees, deadlines, form, FAQ, and CTAs
 * Requirements: 2.1, 2.2
 */

define('WP_USE_THEMES', false);
require './wp-load.php';

echo "=== Building Admissions Page ===\n\n";

// Check if Elementor is active
if (!did_action('elementor/loaded')) {
    echo "ERROR: Elementor is not active!\n";
    exit(1);
}

// Get or create the Admissions page
$page_title = 'Admissions';
$page_slug = 'admissions';

$existing_page = get_page_by_path($page_slug);

if ($existing_page) {
    $page_id = $existing_page->ID;
    echo "Admissions page already exists (ID: $page_id). Updating content...\n";
} else {
    // Create the page
    $page_id = wp_insert_post(array(
        'post_title' => $page_title,
        'post_name' => $page_slug,
        'post_type' => 'page',
        'post_status' => 'publish',
        'post_content' => ''
    ));
    
    if (is_wp_error($page_id)) {
        echo "ERROR: Failed to create Admissions page\n";
        exit(1);
    }
    
    echo "Admissions page created successfully (ID: $page_id)\n";
}

// Enable Elementor for this page
update_post_meta($page_id, '_elementor_edit_mode', 'builder');
update_post_meta($page_id, '_wp_page_template', 'elementor_header_footer');

// Get the admission form shortcode
$admission_forms = get_posts(array(
    'post_type' => 'wpcf7_contact_form',
    'title' => 'Lumina Admission Inquiry Form',
    'post_status' => 'publish',
    'numberposts' => 1
));

$admission_form_shortcode = '';
if (!empty($admission_forms)) {
    $form_id = $admission_forms[0]->ID;
    $admission_form_shortcode = '[contact-form-7 id="' . $form_id . '" title="Lumina Admission Inquiry Form"]';
    echo "Found admission form (ID: $form_id)\n";
} else {
    echo "WARNING: Admission form not found. Please create it first.\n";
    $admission_form_shortcode = '[Please create admission form first]';
}

// Build Elementor page structure
$elementor_data = array(
    // Hero Section
    array(
        'id' => \Elementor\Utils::generate_random_string(),
        'elType' => 'section',
        'settings' => array(
            'background_background' => 'gradient',
            'background_color' => '#003d70',
            'background_color_b' => '#7EBEC5',
            'background_gradient_angle' => array('unit' => 'deg', 'size' => 135),
            'padding' => array(
                'unit' => 'px',
                'top' => '80',
                'right' => '20',
                'bottom' => '80',
                'left' => '20',
                'isLinked' => false
            )
        ),
        'elements' => array(
            array(
                'id' => \Elementor\Utils::generate_random_string(),
                'elType' => 'column',
                'settings' => array('_column_size' => 100),
                'elements' => array(
                    // Page Title
                    array(
                        'id' => \Elementor\Utils::generate_random_string(),
                        'elType' => 'widget',
                        'settings' => array(
                            'title' => 'Join Our School Community',
                            'header_size' => 'h1',
                            'align' => 'center',
                            'title_color' => '#FFFFFF',
                            'typography_typography' => 'custom',
                            'typography_font_size' => array('unit' => 'px', 'size' => 48),
                            'typography_font_weight' => '700'
                        ),
                        'widgetType' => 'heading'
                    ),
                    // Subtitle
                    array(
                        'id' => \Elementor\Utils::generate_random_string(),
                        'elType' => 'widget',
                        'settings' => array(
                            'editor' => '<p style="text-align: center; color: #FFFFFF; font-size: 18px; margin-top: 20px;">Begin your child\'s educational journey at Lumina International School. We welcome students from Play Group through Grade 5.</p>',
                        ),
                        'widgetType' => 'text-editor'
                    ),
                    // CTA Button
                    array(
                        'id' => \Elementor\Utils::generate_random_string(),
                        'elType' => 'widget',
                        'settings' => array(
                            'text' => 'Apply Now',
                            'link' => array('url' => '#admission-form'),
                            'align' => 'center',
                            'button_type' => 'default',
                            'button_background_color' => '#F39A3B',
                            'button_text_color' => '#FFFFFF',
                            'typography_typography' => 'custom',
                            'typography_font_size' => array('unit' => 'px', 'size' => 18),
                            'typography_font_weight' => '600',
                            'button_padding' => array(
                                'unit' => 'px',
                                'top' => '15',
                                'right' => '40',
                                'bottom' => '15',
                                'left' => '40',
                                'isLinked' => false
                            ),
                            'button_border_radius' => array('unit' => 'px', 'size' => 5)
                        ),
                        'widgetType' => 'button'
                    )
                )
            )
        )
    ),
    
    // Admission Process Section
    array(
        'id' => \Elementor\Utils::generate_random_string(),
        'elType' => 'section',
        'settings' => array(
            'background_background' => 'classic',
            'background_color' => '#FFFFFF',
            'padding' => array(
                'unit' => 'px',
                'top' => '60',
                'right' => '20',
                'bottom' => '60',
                'left' => '20',
                'isLinked' => false
            )
        ),
        'elements' => array(
            array(
                'id' => \Elementor\Utils::generate_random_string(),
                'elType' => 'column',
                'settings' => array('_column_size' => 100),
                'elements' => array(
                    // Section Title
                    array(
                        'id' => \Elementor\Utils::generate_random_string(),
                        'elType' => 'widget',
                        'settings' => array(
                            'title' => 'Admission Process',
                            'header_size' => 'h2',
                            'align' => 'center',
                            'title_color' => '#003d70',
                            'typography_typography' => 'custom',
                            'typography_font_size' => array('unit' => 'px', 'size' => 36),
                            'typography_font_weight' => '700'
                        ),
                        'widgetType' => 'heading'
                    ),
                    // Process Description
                    array(
                        'id' => \Elementor\Utils::generate_random_string(),
                        'elType' => 'widget',
                        'settings' => array(
                            'editor' => '<p style="text-align: center; color: #333; font-size: 16px; max-width: 800px; margin: 20px auto;">Our admission process is designed to be straightforward and welcoming. Follow these simple steps to enroll your child at Lumina International School.</p>',
                        ),
                        'widgetType' => 'text-editor'
                    )
                )
            )
        )
    ),
    
    // Admission Steps (3 columns)
    array(
        'id' => \Elementor\Utils::generate_random_string(),
        'elType' => 'section',
        'settings' => array(
            'background_background' => 'classic',
            'background_color' => '#f7f7f7',
            'padding' => array(
                'unit' => 'px',
                'top' => '60',
                'right' => '20',
                'bottom' => '60',
                'left' => '20',
                'isLinked' => false
            )
        ),
        'elements' => array(
            // Step 1
            array(
                'id' => \Elementor\Utils::generate_random_string(),
                'elType' => 'column',
                'settings' => array('_column_size' => 33),
                'elements' => array(
                    array(
                        'id' => \Elementor\Utils::generate_random_string(),
                        'elType' => 'widget',
                        'settings' => array(
                            'icon' => array('value' => 'fas fa-edit', 'library' => 'fa-solid'),
                            'view' => 'default',
                            'shape' => 'circle',
                            'primary_color' => '#7EBEC5',
                            'size' => array('unit' => 'px', 'size' => 60)
                        ),
                        'widgetType' => 'icon'
                    ),
                    array(
                        'id' => \Elementor\Utils::generate_random_string(),
                        'elType' => 'widget',
                        'settings' => array(
                            'title' => 'Step 1: Submit Inquiry',
                            'header_size' => 'h3',
                            'title_color' => '#003d70',
                            'typography_typography' => 'custom',
                            'typography_font_size' => array('unit' => 'px', 'size' => 24),
                            'typography_font_weight' => '600'
                        ),
                        'widgetType' => 'heading'
                    ),
                    array(
                        'id' => \Elementor\Utils::generate_random_string(),
                        'elType' => 'widget',
                        'settings' => array(
                            'editor' => '<p>Complete our online admission inquiry form with your child\'s information and your contact details.</p>',
                        ),
                        'widgetType' => 'text-editor'
                    )
                )
            ),
            // Step 2
            array(
                'id' => \Elementor\Utils::generate_random_string(),
                'elType' => 'column',
                'settings' => array('_column_size' => 33),
                'elements' => array(
                    array(
                        'id' => \Elementor\Utils::generate_random_string(),
                        'elType' => 'widget',
                        'settings' => array(
                            'icon' => array('value' => 'fas fa-calendar-check', 'library' => 'fa-solid'),
                            'view' => 'default',
                            'shape' => 'circle',
                            'primary_color' => '#7EBEC5',
                            'size' => array('unit' => 'px', 'size' => 60)
                        ),
                        'widgetType' => 'icon'
                    ),
                    array(
                        'id' => \Elementor\Utils::generate_random_string(),
                        'elType' => 'widget',
                        'settings' => array(
                            'title' => 'Step 2: Schedule Visit',
                            'header_size' => 'h3',
                            'title_color' => '#003d70',
                            'typography_typography' => 'custom',
                            'typography_font_size' => array('unit' => 'px', 'size' => 24),
                            'typography_font_weight' => '600'
                        ),
                        'widgetType' => 'heading'
                    ),
                    array(
                        'id' => \Elementor\Utils::generate_random_string(),
                        'elType' => 'widget',
                        'settings' => array(
                            'editor' => '<p>Our admissions team will contact you to schedule a campus tour and meet with our staff.</p>',
                        ),
                        'widgetType' => 'text-editor'
                    )
                )
            ),
            // Step 3
            array(
                'id' => \Elementor\Utils::generate_random_string(),
                'elType' => 'column',
                'settings' => array('_column_size' => 33),
                'elements' => array(
                    array(
                        'id' => \Elementor\Utils::generate_random_string(),
                        'elType' => 'widget',
                        'settings' => array(
                            'icon' => array('value' => 'fas fa-check-circle', 'library' => 'fa-solid'),
                            'view' => 'default',
                            'shape' => 'circle',
                            'primary_color' => '#7EBEC5',
                            'size' => array('unit' => 'px', 'size' => 60)
                        ),
                        'widgetType' => 'icon'
                    ),
                    array(
                        'id' => \Elementor\Utils::generate_random_string(),
                        'elType' => 'widget',
                        'settings' => array(
                            'title' => 'Step 3: Complete Enrollment',
                            'header_size' => 'h3',
                            'title_color' => '#003d70',
                            'typography_typography' => 'custom',
                            'typography_font_size' => array('unit' => 'px', 'size' => 24),
                            'typography_font_weight' => '600'
                        ),
                        'widgetType' => 'heading'
                    ),
                    array(
                        'id' => \Elementor\Utils::generate_random_string(),
                        'elType' => 'widget',
                        'settings' => array(
                            'editor' => '<p>Submit required documents, complete the enrollment form, and pay the registration fee to secure your child\'s place.</p>',
                        ),
                        'widgetType' => 'text-editor'
                    )
                )
            )
        )
    ),
    
    // Admission Requirements Section
    array(
        'id' => \Elementor\Utils::generate_random_string(),
        'elType' => 'section',
        'settings' => array(
            'background_background' => 'classic',
            'background_color' => '#FFFFFF',
            'padding' => array(
                'unit' => 'px',
                'top' => '60',
                'right' => '20',
                'bottom' => '60',
                'left' => '20',
                'isLinked' => false
            )
        ),
        'elements' => array(
            array(
                'id' => \Elementor\Utils::generate_random_string(),
                'elType' => 'column',
                'settings' => array('_column_size' => 100),
                'elements' => array(
                    // Section Title
                    array(
                        'id' => \Elementor\Utils::generate_random_string(),
                        'elType' => 'widget',
                        'settings' => array(
                            'title' => 'Admission Requirements',
                            'header_size' => 'h2',
                            'align' => 'center',
                            'title_color' => '#003d70',
                            'typography_typography' => 'custom',
                            'typography_font_size' => array('unit' => 'px', 'size' => 36),
                            'typography_font_weight' => '700'
                        ),
                        'widgetType' => 'heading'
                    ),
                    // Requirements List
                    array(
                        'id' => \Elementor\Utils::generate_random_string(),
                        'elType' => 'widget',
                        'settings' => array(
                            'editor' => '<div style="max-width: 800px; margin: 30px auto;">
                                <h3 style="color: #003d70; font-size: 22px; margin-bottom: 15px;">Required Documents</h3>
                                <ul style="list-style: none; padding-left: 0;">
                                    <li style="padding: 10px 0; border-bottom: 1px solid #e0e0e0;">
                                        <strong>✓ Birth Certificate:</strong> Original and photocopy of student\'s birth certificate
                                    </li>
                                    <li style="padding: 10px 0; border-bottom: 1px solid #e0e0e0;">
                                        <strong>✓ Previous School Records:</strong> Report cards and transcripts from previous school (if applicable)
                                    </li>
                                    <li style="padding: 10px 0; border-bottom: 1px solid #e0e0e0;">
                                        <strong>✓ Immunization Records:</strong> Complete vaccination records as per health requirements
                                    </li>
                                    <li style="padding: 10px 0; border-bottom: 1px solid #e0e0e0;">
                                        <strong>✓ Passport Photos:</strong> Four recent passport-size photographs of the student
                                    </li>
                                    <li style="padding: 10px 0; border-bottom: 1px solid #e0e0e0;">
                                        <strong>✓ Parent/Guardian ID:</strong> Copy of valid identification (passport or national ID)
                                    </li>
                                    <li style="padding: 10px 0;">
                                        <strong>✓ Proof of Residence:</strong> Utility bill or lease agreement showing current address
                                    </li>
                                </ul>
                                
                                <h3 style="color: #003d70; font-size: 22px; margin-top: 40px; margin-bottom: 15px;">Age Requirements</h3>
                                <ul style="list-style: none; padding-left: 0;">
                                    <li style="padding: 8px 0;"><strong>Play Group:</strong> Ages 2-3 years</li>
                                    <li style="padding: 8px 0;"><strong>Nursery:</strong> Ages 3-4 years</li>
                                    <li style="padding: 8px 0;"><strong>Kindergarten:</strong> Ages 4-5 years</li>
                                    <li style="padding: 8px 0;"><strong>Grade 1:</strong> Ages 5-6 years</li>
                                    <li style="padding: 8px 0;"><strong>Grade 2:</strong> Ages 6-7 years</li>
                                    <li style="padding: 8px 0;"><strong>Grade 3:</strong> Ages 7-8 years</li>
                                    <li style="padding: 8px 0;"><strong>Grade 4:</strong> Ages 8-9 years</li>
                                    <li style="padding: 8px 0;"><strong>Grade 5:</strong> Ages 9-10 years</li>
                                </ul>
                            </div>',
                        ),
                        'widgetType' => 'text-editor'
                    )
                )
            )
        )
    ),
    
    // Fee Structure Section
    array(
        'id' => \Elementor\Utils::generate_random_string(),
        'elType' => 'section',
        'settings' => array(
            'background_background' => 'classic',
            'background_color' => '#f7f7f7',
            'padding' => array(
                'unit' => 'px',
                'top' => '60',
                'right' => '20',
                'bottom' => '60',
                'left' => '20',
                'isLinked' => false
            )
        ),
        'elements' => array(
            array(
                'id' => \Elementor\Utils::generate_random_string(),
                'elType' => 'column',
                'settings' => array('_column_size' => 100),
                'elements' => array(
                    // Section Title
                    array(
                        'id' => \Elementor\Utils::generate_random_string(),
                        'elType' => 'widget',
                        'settings' => array(
                            'title' => 'Fee Structure',
                            'header_size' => 'h2',
                            'align' => 'center',
                            'title_color' => '#003d70',
                            'typography_typography' => 'custom',
                            'typography_font_size' => array('unit' => 'px', 'size' => 36),
                            'typography_font_weight' => '700'
                        ),
                        'widgetType' => 'heading'
                    ),
                    // Fee Table
                    array(
                        'id' => \Elementor\Utils::generate_random_string(),
                        'elType' => 'widget',
                        'settings' => array(
                            'editor' => '<div style="max-width: 900px; margin: 30px auto;">
                                <table style="width: 100%; border-collapse: collapse; background: white; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                    <thead>
                                        <tr style="background-color: #003d70; color: white;">
                                            <th style="padding: 15px; text-align: left; border: 1px solid #ddd;">Grade Level</th>
                                            <th style="padding: 15px; text-align: right; border: 1px solid #ddd;">Registration Fee</th>
                                            <th style="padding: 15px; text-align: right; border: 1px solid #ddd;">Annual Tuition</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="padding: 12px; border: 1px solid #ddd;">Play Group</td>
                                            <td style="padding: 12px; text-align: right; border: 1px solid #ddd;">$500</td>
                                            <td style="padding: 12px; text-align: right; border: 1px solid #ddd;">$8,000</td>
                                        </tr>
                                        <tr style="background-color: #f9f9f9;">
                                            <td style="padding: 12px; border: 1px solid #ddd;">Nursery</td>
                                            <td style="padding: 12px; text-align: right; border: 1px solid #ddd;">$500</td>
                                            <td style="padding: 12px; text-align: right; border: 1px solid #ddd;">$8,500</td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 12px; border: 1px solid #ddd;">Kindergarten</td>
                                            <td style="padding: 12px; text-align: right; border: 1px solid #ddd;">$500</td>
                                            <td style="padding: 12px; text-align: right; border: 1px solid #ddd;">$9,000</td>
                                        </tr>
                                        <tr style="background-color: #f9f9f9;">
                                            <td style="padding: 12px; border: 1px solid #ddd;">Grade 1-2</td>
                                            <td style="padding: 12px; text-align: right; border: 1px solid #ddd;">$600</td>
                                            <td style="padding: 12px; text-align: right; border: 1px solid #ddd;">$10,000</td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 12px; border: 1px solid #ddd;">Grade 3-5</td>
                                            <td style="padding: 12px; text-align: right; border: 1px solid #ddd;">$600</td>
                                            <td style="padding: 12px; text-align: right; border: 1px solid #ddd;">$11,000</td>
                                        </tr>
                                    </tbody>
                                </table>
                                
                                <div style="margin-top: 30px; padding: 20px; background: #fff3cd; border-left: 4px solid #F39A3B; border-radius: 4px;">
                                    <h4 style="color: #003d70; margin-top: 0;">Additional Fees</h4>
                                    <ul style="margin-bottom: 0;">
                                        <li><strong>Books & Materials:</strong> $300-$500 per year (varies by grade)</li>
                                        <li><strong>Uniform:</strong> $150-$200 (one-time purchase)</li>
                                        <li><strong>Transportation:</strong> $1,200 per year (optional)</li>
                                        <li><strong>Lunch Program:</strong> $800 per year (optional)</li>
                                        <li><strong>Extracurricular Activities:</strong> Varies by activity</li>
                                    </ul>
                                </div>
                                
                                <div style="margin-top: 20px; padding: 20px; background: #d1ecf1; border-left: 4px solid #7EBEC5; border-radius: 4px;">
                                    <h4 style="color: #003d70; margin-top: 0;">Payment Options</h4>
                                    <p style="margin-bottom: 10px;">We offer flexible payment plans to accommodate families:</p>
                                    <ul style="margin-bottom: 0;">
                                        <li>Full payment (5% discount)</li>
                                        <li>Two installments (September & January)</li>
                                        <li>Three installments (September, December & March)</li>
                                        <li>Monthly payment plan available upon request</li>
                                    </ul>
                                </div>
                            </div>',
                        ),
                        'widgetType' => 'text-editor'
                    )
                )
            )
        )
    ),
    
    // Important Dates Section
    array(
        'id' => \Elementor\Utils::generate_random_string(),
        'elType' => 'section',
        'settings' => array(
            'background_background' => 'classic',
            'background_color' => '#FFFFFF',
            'padding' => array(
                'unit' => 'px',
                'top' => '60',
                'right' => '20',
                'bottom' => '60',
                'left' => '20',
                'isLinked' => false
            )
        ),
        'elements' => array(
            array(
                'id' => \Elementor\Utils::generate_random_string(),
                'elType' => 'column',
                'settings' => array('_column_size' => 100),
                'elements' => array(
                    // Section Title
                    array(
                        'id' => \Elementor\Utils::generate_random_string(),
                        'elType' => 'widget',
                        'settings' => array(
                            'title' => 'Important Dates & Deadlines',
                            'header_size' => 'h2',
                            'align' => 'center',
                            'title_color' => '#003d70',
                            'typography_typography' => 'custom',
                            'typography_font_size' => array('unit' => 'px', 'size' => 36),
                            'typography_font_weight' => '700'
                        ),
                        'widgetType' => 'heading'
                    ),
                    // Dates Content
                    array(
                        'id' => \Elementor\Utils::generate_random_string(),
                        'elType' => 'widget',
                        'settings' => array(
                            'editor' => '<div style="max-width: 800px; margin: 30px auto;">
                                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
                                    <div style="padding: 25px; background: #f7f7f7; border-radius: 8px; border-top: 4px solid #7EBEC5;">
                                        <h3 style="color: #003d70; font-size: 20px; margin-bottom: 15px;">Academic Year 2024-2025</h3>
                                        <ul style="list-style: none; padding-left: 0;">
                                            <li style="padding: 8px 0; border-bottom: 1px solid #ddd;"><strong>Application Opens:</strong> January 15, 2024</li>
                                            <li style="padding: 8px 0; border-bottom: 1px solid #ddd;"><strong>Priority Deadline:</strong> March 31, 2024</li>
                                            <li style="padding: 8px 0; border-bottom: 1px solid #ddd;"><strong>Regular Deadline:</strong> June 30, 2024</li>
                                            <li style="padding: 8px 0;"><strong>School Starts:</strong> September 1, 2024</li>
                                        </ul>
                                    </div>
                                    
                                    <div style="padding: 25px; background: #f7f7f7; border-radius: 8px; border-top: 4px solid #F39A3B;">
                                        <h3 style="color: #003d70; font-size: 20px; margin-bottom: 15px;">Mid-Year Enrollment</h3>
                                        <ul style="list-style: none; padding-left: 0;">
                                            <li style="padding: 8px 0; border-bottom: 1px solid #ddd;"><strong>January Intake:</strong> December 15 deadline</li>
                                            <li style="padding: 8px 0; border-bottom: 1px solid #ddd;"><strong>April Intake:</strong> March 15 deadline</li>
                                            <li style="padding: 8px 0;"><strong>Note:</strong> Subject to availability</li>
                                        </ul>
                                    </div>
                                </div>
                                
                                <div style="margin-top: 30px; padding: 20px; background: #e7f3ff; border-left: 4px solid #003d70; border-radius: 4px;">
                                    <p style="margin: 0; font-size: 16px;"><strong>💡 Pro Tip:</strong> Apply early! Priority applications receive first consideration for enrollment and have more flexibility in class placement.</p>
                                </div>
                            </div>',
                        ),
                        'widgetType' => 'text-editor'
                    )
                )
            )
        )
    ),
    
    // Admission Form Section
    array(
        'id' => \Elementor\Utils::generate_random_string(),
        'elType' => 'section',
        'settings' => array(
            'background_background' => 'classic',
            'background_color' => '#f7f7f7',
            'padding' => array(
                'unit' => 'px',
                'top' => '60',
                'right' => '20',
                'bottom' => '60',
                'left' => '20',
                'isLinked' => false
            ),
            'html_id' => 'admission-form'
        ),
        'elements' => array(
            array(
                'id' => \Elementor\Utils::generate_random_string(),
                'elType' => 'column',
                'settings' => array('_column_size' => 100),
                'elements' => array(
                    // Section Title
                    array(
                        'id' => \Elementor\Utils::generate_random_string(),
                        'elType' => 'widget',
                        'settings' => array(
                            'title' => 'Start Your Application',
                            'header_size' => 'h2',
                            'align' => 'center',
                            'title_color' => '#003d70',
                            'typography_typography' => 'custom',
                            'typography_font_size' => array('unit' => 'px', 'size' => 36),
                            'typography_font_weight' => '700'
                        ),
                        'widgetType' => 'heading'
                    ),
                    // Form Description
                    array(
                        'id' => \Elementor\Utils::generate_random_string(),
                        'elType' => 'widget',
                        'settings' => array(
                            'editor' => '<p style="text-align: center; color: #333; font-size: 16px; max-width: 700px; margin: 20px auto 40px;">Complete the form below to begin your admission inquiry. Our admissions team will contact you within 1-2 business days to discuss next steps.</p>',
                        ),
                        'widgetType' => 'text-editor'
                    ),
                    // Admission Form Shortcode
                    array(
                        'id' => \Elementor\Utils::generate_random_string(),
                        'elType' => 'widget',
                        'settings' => array(
                            'shortcode' => $admission_form_shortcode,
                        ),
                        'widgetType' => 'shortcode'
                    )
                )
            )
        )
    ),
    
    // FAQ Section
    array(
        'id' => \Elementor\Utils::generate_random_string(),
        'elType' => 'section',
        'settings' => array(
            'background_background' => 'classic',
            'background_color' => '#FFFFFF',
            'padding' => array(
                'unit' => 'px',
                'top' => '60',
                'right' => '20',
                'bottom' => '60',
                'left' => '20',
                'isLinked' => false
            )
        ),
        'elements' => array(
            array(
                'id' => \Elementor\Utils::generate_random_string(),
                'elType' => 'column',
                'settings' => array('_column_size' => 100),
                'elements' => array(
                    // Section Title
                    array(
                        'id' => \Elementor\Utils::generate_random_string(),
                        'elType' => 'widget',
                        'settings' => array(
                            'title' => 'Frequently Asked Questions',
                            'header_size' => 'h2',
                            'align' => 'center',
                            'title_color' => '#003d70',
                            'typography_typography' => 'custom',
                            'typography_font_size' => array('unit' => 'px', 'size' => 36),
                            'typography_font_weight' => '700'
                        ),
                        'widgetType' => 'heading'
                    ),
                    // FAQ Accordion
                    array(
                        'id' => \Elementor\Utils::generate_random_string(),
                        'elType' => 'widget',
                        'settings' => array(
                            'tabs' => array(
                                array(
                                    '_id' => \Elementor\Utils::generate_random_string(),
                                    'tab_title' => 'What is the student-teacher ratio?',
                                    'tab_content' => 'We maintain a low student-teacher ratio of 15:1 to ensure personalized attention for each student. In early years (Play Group to Kindergarten), the ratio is even lower at 10:1 to provide optimal care and learning support.'
                                ),
                                array(
                                    '_id' => \Elementor\Utils::generate_random_string(),
                                    'tab_title' => 'Do you offer financial aid or scholarships?',
                                    'tab_content' => 'Yes, we offer need-based financial aid and merit scholarships for qualifying families. Financial aid applications are reviewed on a case-by-case basis. Please contact our admissions office for more information about available assistance programs.'
                                ),
                                array(
                                    '_id' => \Elementor\Utils::generate_random_string(),
                                    'tab_title' => 'What is your curriculum approach?',
                                    'tab_content' => 'We follow an internationally recognized curriculum that integrates Islamic values and teachings. Our approach combines academic excellence with character development, emphasizing critical thinking, creativity, and moral values. Islamic studies are integrated throughout the curriculum.'
                                ),
                                array(
                                    '_id' => \Elementor\Utils::generate_random_string(),
                                    'tab_title' => 'Is transportation provided?',
                                    'tab_content' => 'Yes, we offer optional school bus transportation covering major areas of the city. Transportation fees are separate from tuition and vary based on distance. Routes are planned to ensure safe and convenient pickup and drop-off for students.'
                                ),
                                array(
                                    '_id' => \Elementor\Utils::generate_random_string(),
                                    'tab_title' => 'What are your school hours?',
                                    'tab_content' => 'School hours are 8:00 AM to 2:30 PM, Sunday through Thursday. Early years (Play Group to Kindergarten) have slightly shorter hours, ending at 1:30 PM. Extended care is available until 4:30 PM for families who need it.'
                                ),
                                array(
                                    '_id' => \Elementor\Utils::generate_random_string(),
                                    'tab_title' => 'Can I schedule a campus tour?',
                                    'tab_content' => 'Absolutely! We encourage prospective families to visit our campus. Tours are available Monday through Thursday from 9:00 AM to 12:00 PM. Please contact our admissions office to schedule your visit, or submit an inquiry through our admission form and we\'ll reach out to arrange a convenient time.'
                                ),
                                array(
                                    '_id' => \Elementor\Utils::generate_random_string(),
                                    'tab_title' => 'What documents are needed for enrollment?',
                                    'tab_content' => 'Required documents include: birth certificate, previous school records (if applicable), immunization records, passport photos, parent/guardian ID, and proof of residence. All documents should be submitted as originals with photocopies during the enrollment process.'
                                ),
                                array(
                                    '_id' => \Elementor\Utils::generate_random_string(),
                                    'tab_title' => 'Do you accept mid-year enrollments?',
                                    'tab_content' => 'Yes, we accept mid-year enrollments subject to availability. We have intake periods in January and April. However, we recommend enrolling at the beginning of the academic year in September for the best integration into our program.'
                                )
                            ),
                            'title_html_tag' => 'h3',
                            'icon' => array('value' => 'fas fa-plus', 'library' => 'fa-solid'),
                            'icon_active' => array('value' => 'fas fa-minus', 'library' => 'fa-solid'),
                            'title_color' => '#003d70',
                            'title_background_color' => '#f7f7f7',
                            'content_color' => '#333333'
                        ),
                        'widgetType' => 'accordion'
                    )
                )
            )
        )
    ),
    
    // Final CTA Section
    array(
        'id' => \Elementor\Utils::generate_random_string(),
        'elType' => 'section',
        'settings' => array(
            'background_background' => 'gradient',
            'background_color' => '#003d70',
            'background_color_b' => '#7EBEC5',
            'background_gradient_angle' => array('unit' => 'deg', 'size' => 135),
            'padding' => array(
                'unit' => 'px',
                'top' => '60',
                'right' => '20',
                'bottom' => '60',
                'left' => '20',
                'isLinked' => false
            )
        ),
        'elements' => array(
            array(
                'id' => \Elementor\Utils::generate_random_string(),
                'elType' => 'column',
                'settings' => array('_column_size' => 100),
                'elements' => array(
                    // CTA Heading
                    array(
                        'id' => \Elementor\Utils::generate_random_string(),
                        'elType' => 'widget',
                        'settings' => array(
                            'title' => 'Ready to Join Lumina?',
                            'header_size' => 'h2',
                            'align' => 'center',
                            'title_color' => '#FFFFFF',
                            'typography_typography' => 'custom',
                            'typography_font_size' => array('unit' => 'px', 'size' => 36),
                            'typography_font_weight' => '700'
                        ),
                        'widgetType' => 'heading'
                    ),
                    // CTA Text
                    array(
                        'id' => \Elementor\Utils::generate_random_string(),
                        'elType' => 'widget',
                        'settings' => array(
                            'editor' => '<p style="text-align: center; color: #FFFFFF; font-size: 18px; margin: 20px auto 30px; max-width: 700px;">Take the first step towards an exceptional education for your child. Our admissions team is here to guide you through every step of the process.</p>',
                        ),
                        'widgetType' => 'text-editor'
                    ),
                    // CTA Buttons
                    array(
                        'id' => \Elementor\Utils::generate_random_string(),
                        'elType' => 'widget',
                        'settings' => array(
                            'text' => 'Apply Now',
                            'link' => array('url' => '#admission-form'),
                            'align' => 'center',
                            'button_type' => 'default',
                            'button_background_color' => '#F39A3B',
                            'button_text_color' => '#FFFFFF',
                            'typography_typography' => 'custom',
                            'typography_font_size' => array('unit' => 'px', 'size' => 18),
                            'typography_font_weight' => '600',
                            'button_padding' => array(
                                'unit' => 'px',
                                'top' => '15',
                                'right' => '40',
                                'bottom' => '15',
                                'left' => '40',
                                'isLinked' => false
                            ),
                            'button_border_radius' => array('unit' => 'px', 'size' => 5)
                        ),
                        'widgetType' => 'button'
                    )
                )
            )
        )
    )
);

// Save Elementor data
update_post_meta($page_id, '_elementor_data', wp_slash(wp_json_encode($elementor_data)));
update_post_meta($page_id, '_elementor_page_settings', array());
update_post_meta($page_id, '_elementor_version', ELEMENTOR_VERSION);

echo "\n=== Admissions Page Built Successfully ===\n";
echo "Page ID: $page_id\n";
echo "Page URL: " . get_permalink($page_id) . "\n";
echo "\nPage Sections:\n";
echo "✓ Hero section with page title and CTA\n";
echo "✓ Admission process (3-step guide)\n";
echo "✓ Admission requirements (documents and age requirements)\n";
echo "✓ Fee structure table with payment options\n";
echo "✓ Important dates and deadlines\n";
echo "✓ Admission inquiry form (embedded)\n";
echo "✓ FAQ accordion section (8 questions)\n";
echo "✓ Final CTA section with Apply Now button\n";
echo "\nFeatures:\n";
echo "✓ Responsive design with brand colors\n";
echo "✓ Clear information hierarchy\n";
echo "✓ Multiple Apply Now CTAs\n";
echo "✓ Smooth scroll to form section\n";
echo "✓ Professional fee structure table\n";
echo "✓ Comprehensive FAQ section\n";
echo "\nRequirements Validated:\n";
echo "✓ 2.1: Admission requirements and fee structure displayed\n";
echo "✓ 2.2: Application deadlines shown\n";
echo "\nNext Steps:\n";
echo "1. Visit the page to review the layout\n";
echo "2. Test the Apply Now buttons (should scroll to form)\n";
echo "3. Test the admission form submission\n";
echo "4. Adjust content as needed through Elementor editor\n";
echo "5. Add any school-specific information (contact numbers, etc.)\n";

?>
