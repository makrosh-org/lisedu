<?php
/**
 * Build Resources Page with Elementor
 * 
 * This script creates the Resources page with:
 * - Resources organized by categories
 * - File type and size information
 * - Download links
 * - Search functionality
 * - Support for PDF, DOC, DOCX, XLS formats
 * 
 * Requirements: 12.1, 12.2, 12.3, 12.4
 * Task 20: Build Resources page with downloadable documents
 * 
 * Usage: Run this script once via browser
 */

// Load WordPress
require_once('wp-load.php');

// Check if user is logged in and has admin privileges
if (!is_user_logged_in() || !current_user_can('manage_options')) {
    wp_die('You do not have permission to access this page.');
}

echo "<h1>Building Resources Page</h1>";
echo "<div style='max-width: 800px; margin: 20px auto; padding: 20px; background: #f7f7f7; border-radius: 8px;'>";

// Step 1: Check if Resources page already exists
echo "<h2>Step 1: Checking for Existing Resources Page</h2>";

$existing_page = get_page_by_path('resources');

if ($existing_page) {
    echo "<p style='color: blue;'>ℹ Resources page already exists (ID: {$existing_page->ID})</p>";
    echo "<p>Updating existing page...</p>";
    $page_id = $existing_page->ID;
} else {
    echo "<p style='color: green;'>✓ Creating new Resources page...</p>";
    
    // Create the page
    $page_id = wp_insert_post(array(
        'post_title' => 'Resources',
        'post_name' => 'resources',
        'post_status' => 'publish',
        'post_type' => 'page',
        'post_content' => '',
    ));
    
    if (is_wp_error($page_id)) {
        echo "<p style='color: red;'>✗ Error creating page: " . $page_id->get_error_message() . "</p>";
        exit;
    }
    
    echo "<p style='color: green;'>✓ Resources page created successfully (ID: {$page_id})</p>";
}

// Step 2: Set page template to use Elementor Full Width
echo "<h2>Step 2: Configuring Page Template</h2>";
update_post_meta($page_id, '_wp_page_template', 'elementor_canvas');
update_post_meta($page_id, '_elementor_edit_mode', 'builder');
echo "<p style='color: green;'>✓ Page template set to Elementor Canvas</p>";

// Step 3: Build Elementor content
echo "<h2>Step 3: Building Elementor Content</h2>";

$elementor_data = array(
    // Page Header Section
    array(
        'id' => lumina_generate_elementor_id(),
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
                'id' => lumina_generate_elementor_id(),
                'elType' => 'column',
                'settings' => array(
                    '_column_size' => 100,
                ),
                'elements' => array(
                    // Breadcrumbs
                    array(
                        'id' => lumina_generate_elementor_id(),
                        'elType' => 'widget',
                        'settings' => array(
                            'text' => '<div class="lumina-breadcrumbs" style="color: rgba(255,255,255,0.8); margin-bottom: 20px; font-size: 14px;">
                                <a href="' . home_url() . '" style="color: #7EBEC5; text-decoration: none;">Home</a> / 
                                <span style="color: #FFFFFF;">Resources</span>
                            </div>',
                        ),
                        'widgetType' => 'text-editor',
                    ),
                    // Page Title
                    array(
                        'id' => lumina_generate_elementor_id(),
                        'elType' => 'widget',
                        'settings' => array(
                            'title' => 'Resources',
                            'header_size' => 'h1',
                            'title_color' => '#FFFFFF',
                            'typography_typography' => 'custom',
                            'typography_font_size' => array(
                                'unit' => 'px',
                                'size' => 48,
                            ),
                            'typography_font_weight' => '700',
                        ),
                        'widgetType' => 'heading',
                    ),
                    // Page Description
                    array(
                        'id' => lumina_generate_elementor_id(),
                        'elType' => 'widget',
                        'settings' => array(
                            'editor' => '<p style="color: rgba(255,255,255,0.9); font-size: 18px; line-height: 1.6; max-width: 800px; margin: 0 auto;">Access important documents, forms, and information for Lumina International School. Download admission forms, academic policies, parent handbooks, fee information, and more.</p>',
                        ),
                        'widgetType' => 'text-editor',
                    ),
                ),
            ),
        ),
    ),
    
    // Search Section
    array(
        'id' => lumina_generate_elementor_id(),
        'elType' => 'section',
        'settings' => array(
            'background_background' => 'classic',
            'background_color' => '#FFFFFF',
            'padding' => array(
                'unit' => 'px',
                'top' => '40',
                'right' => '20',
                'bottom' => '40',
                'left' => '20',
            ),
        ),
        'elements' => array(
            array(
                'id' => lumina_generate_elementor_id(),
                'elType' => 'column',
                'settings' => array(
                    '_column_size' => 100,
                ),
                'elements' => array(
                    // Search Form
                    array(
                        'id' => lumina_generate_elementor_id(),
                        'elType' => 'widget',
                        'settings' => array(
                            'html' => '<div class="resources-search-container" style="max-width: 800px; margin: 0 auto;">
                                <form role="search" method="get" class="resources-search-form" action="' . get_post_type_archive_link('lis_resource') . '" style="display: flex; gap: 10px; background: #f7f7f7; padding: 10px; border-radius: 50px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                    <input type="hidden" name="post_type" value="lis_resource" />
                                    <input type="search" name="s" placeholder="Search resources by name or description..." style="flex: 1; padding: 15px 25px; border: none; background: transparent; font-size: 16px; outline: none;" />
                                    <button type="submit" style="padding: 15px 35px; background: #F39A3B; color: #FFFFFF; border: none; border-radius: 50px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; font-size: 16px;">
                                        🔍 Search
                                    </button>
                                </form>
                            </div>',
                        ),
                        'widgetType' => 'html',
                    ),
                ),
            ),
        ),
    ),
    
    // Category Filter Section
    array(
        'id' => lumina_generate_elementor_id(),
        'elType' => 'section',
        'settings' => array(
            'background_background' => 'classic',
            'background_color' => '#f7f7f7',
            'padding' => array(
                'unit' => 'px',
                'top' => '40',
                'right' => '20',
                'bottom' => '20',
                'left' => '20',
            ),
        ),
        'elements' => array(
            array(
                'id' => lumina_generate_elementor_id(),
                'elType' => 'column',
                'settings' => array(
                    '_column_size' => 100,
                ),
                'elements' => array(
                    // Section Title
                    array(
                        'id' => lumina_generate_elementor_id(),
                        'elType' => 'widget',
                        'settings' => array(
                            'title' => 'Browse by Category',
                            'header_size' => 'h2',
                            'title_color' => '#003d70',
                            'align' => 'center',
                            'typography_typography' => 'custom',
                            'typography_font_size' => array(
                                'unit' => 'px',
                                'size' => 32,
                            ),
                            'typography_font_weight' => '700',
                        ),
                        'widgetType' => 'heading',
                    ),
                    // Category Buttons
                    array(
                        'id' => lumina_generate_elementor_id(),
                        'elType' => 'widget',
                        'settings' => array(
                            'html' => lumina_get_resource_category_buttons_html(),
                        ),
                        'widgetType' => 'html',
                    ),
                ),
            ),
        ),
    ),
    
    // Resources Grid Section
    array(
        'id' => lumina_generate_elementor_id(),
        'elType' => 'section',
        'settings' => array(
            'background_background' => 'classic',
            'background_color' => '#f7f7f7',
            'padding' => array(
                'unit' => 'px',
                'top' => '40',
                'right' => '20',
                'bottom' => '80',
                'left' => '20',
            ),
        ),
        'elements' => array(
            array(
                'id' => lumina_generate_elementor_id(),
                'elType' => 'column',
                'settings' => array(
                    '_column_size' => 100,
                ),
                'elements' => array(
                    // Resources Archive Shortcode
                    array(
                        'id' => lumina_generate_elementor_id(),
                        'elType' => 'widget',
                        'settings' => array(
                            'shortcode' => '[lumina_resources_grid]',
                        ),
                        'widgetType' => 'shortcode',
                    ),
                ),
            ),
        ),
    ),
    
    // Help Section
    array(
        'id' => lumina_generate_elementor_id(),
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
            ),
        ),
        'elements' => array(
            array(
                'id' => lumina_generate_elementor_id(),
                'elType' => 'column',
                'settings' => array(
                    '_column_size' => 100,
                ),
                'elements' => array(
                    // Help Title
                    array(
                        'id' => lumina_generate_elementor_id(),
                        'elType' => 'widget',
                        'settings' => array(
                            'title' => 'Need Help?',
                            'header_size' => 'h2',
                            'title_color' => '#003d70',
                            'align' => 'center',
                            'typography_typography' => 'custom',
                            'typography_font_size' => array(
                                'unit' => 'px',
                                'size' => 32,
                            ),
                        ),
                        'widgetType' => 'heading',
                    ),
                    // Help Text
                    array(
                        'id' => lumina_generate_elementor_id(),
                        'elType' => 'widget',
                        'settings' => array(
                            'editor' => '<p style="text-align: center; color: #666; font-size: 16px; line-height: 1.6; max-width: 600px; margin: 0 auto 30px;">If you cannot find the resource you\'re looking for or need assistance, please don\'t hesitate to contact our administrative office.</p>',
                        ),
                        'widgetType' => 'text-editor',
                    ),
                    // Contact Button
                    array(
                        'id' => lumina_generate_elementor_id(),
                        'elType' => 'widget',
                        'settings' => array(
                            'text' => 'Contact Us',
                            'link' => array(
                                'url' => home_url('/contact'),
                                'is_external' => '',
                                'nofollow' => '',
                            ),
                            'align' => 'center',
                            'button_type' => 'default',
                            'button_text_color' => '#FFFFFF',
                            'background_color' => '#F39A3B',
                            'button_background_hover_color' => '#003d70',
                            'border_radius' => array(
                                'unit' => 'px',
                                'top' => '8',
                                'right' => '8',
                                'bottom' => '8',
                                'left' => '8',
                            ),
                            'button_padding' => array(
                                'unit' => 'px',
                                'top' => '15',
                                'right' => '40',
                                'bottom' => '15',
                                'left' => '40',
                            ),
                            'typography_typography' => 'custom',
                            'typography_font_size' => array(
                                'unit' => 'px',
                                'size' => 16,
                            ),
                            'typography_font_weight' => '600',
                        ),
                        'widgetType' => 'button',
                    ),
                ),
            ),
        ),
    ),
);

// Save Elementor data
update_post_meta($page_id, '_elementor_data', wp_slash(wp_json_encode($elementor_data)));
update_post_meta($page_id, '_elementor_page_settings', wp_slash(wp_json_encode(array())));

echo "<p style='color: green;'>✓ Elementor content structure created</p>";
echo "<p style='color: green;'>✓ Page sections configured:</p>";
echo "<ul>";
echo "<li>Page header with title and description</li>";
echo "<li>Search functionality for resources</li>";
echo "<li>Category filter buttons</li>";
echo "<li>Resources grid display</li>";
echo "<li>Help section with contact link</li>";
echo "</ul>";

// Step 4: Summary
echo "<h2>Step 4: Setup Summary</h2>";
echo "<div style='background: white; padding: 20px; border-radius: 8px; border-left: 5px solid #7EBEC5;'>";
echo "<h3>Resources Page Created Successfully!</h3>";
echo "<ul>";
echo "<li><strong>Page ID:</strong> {$page_id}</li>";
echo "<li><strong>Page URL:</strong> <a href='" . get_permalink($page_id) . "' target='_blank'>" . get_permalink($page_id) . "</a></li>";
echo "<li><strong>Edit in Elementor:</strong> <a href='" . admin_url('post.php?post=' . $page_id . '&action=elementor') . "' target='_blank'>Open in Elementor</a></li>";
echo "</ul>";

echo "<h4>Features Implemented:</h4>";
echo "<ul>";
echo "<li>✓ Resources organized by categories (Requirement 12.1)</li>";
echo "<li>✓ File type and size information displayed (Requirement 12.3)</li>";
echo "<li>✓ Download links that open PDFs in new tab or initiate download (Requirement 12.2)</li>";
echo "<li>✓ Search functionality for resources</li>";
echo "<li>✓ Support for PDF, DOC, DOCX, XLS formats (Requirement 12.4)</li>";
echo "<li>✓ Category filtering</li>";
echo "<li>✓ Responsive design</li>";
echo "<li>✓ Brand color scheme</li>";
echo "</ul>";

echo "<h4>How It Works:</h4>";
echo "<ol>";
echo "<li><strong>Search:</strong> Users can search for resources by name or description</li>";
echo "<li><strong>Category Filter:</strong> Click category buttons to filter resources by type</li>";
echo "<li><strong>Resource Cards:</strong> Each resource displays file type, size, and download count</li>";
echo "<li><strong>Download:</strong> Click download button to get the file (PDFs open in new tab)</li>";
echo "<li><strong>Access Control:</strong> Restricted resources require login</li>";
echo "</ol>";

echo "</div>";

// Step 5: Next Steps
echo "<h2>Next Steps</h2>";
echo "<div style='background: #FFF9F0; padding: 20px; border-radius: 8px; border-left: 5px solid #F39A3B;'>";
echo "<h3>To Complete the Resources Page:</h3>";
echo "<ol>";
echo "<li>Add sample resources via <strong>Resources → Add New</strong> in WordPress admin</li>";
echo "<li>Upload files (PDF, DOC, DOCX, XLS) for each resource</li>";
echo "<li>Assign resources to appropriate categories</li>";
echo "<li>Test the search functionality</li>";
echo "<li>Test category filtering</li>";
echo "<li>Test download functionality</li>";
echo "<li>Verify file type and size display correctly</li>";
echo "<li>Test on mobile devices for responsive design</li>";
echo "</ol>";

echo "<h3>Customization Options:</h3>";
echo "<ul>";
echo "<li>Edit page content in Elementor for custom styling</li>";
echo "<li>Modify category descriptions in <strong>Resources → Categories</strong></li>";
echo "<li>Adjust colors and fonts to match brand guidelines</li>";
echo "<li>Add additional help text or instructions</li>";
echo "</ul>";

echo "</div>";

echo "</div>";

echo "<div style='text-align: center; margin: 30px 0;'>";
echo "<a href='" . get_permalink($page_id) . "' style='display: inline-block; padding: 15px 30px; background: #7EBEC5; color: white; text-decoration: none; border-radius: 8px; font-weight: 600; margin-right: 10px;'>View Resources Page</a>";
echo "<a href='" . admin_url('post.php?post=' . $page_id . '&action=elementor') . "' style='display: inline-block; padding: 15px 30px; background: #003d70; color: white; text-decoration: none; border-radius: 8px; font-weight: 600; margin-right: 10px;'>Edit in Elementor</a>";
echo "<a href='" . admin_url('post-new.php?post_type=lis_resource') . "' style='display: inline-block; padding: 15px 30px; background: #F39A3B; color: white; text-decoration: none; border-radius: 8px; font-weight: 600;'>Add Resources</a>";
echo "</div>";

/**
 * Helper function to generate Elementor element ID
 */
function lumina_generate_elementor_id() {
    return dechex(mt_rand(0x10000000, 0x1fffffff));
}

/**
 * Helper function to get resource category buttons HTML
 */
function lumina_get_resource_category_buttons_html() {
    $categories = get_terms(array(
        'taxonomy' => 'resource_category',
        'hide_empty' => false,
    ));
    
    $html = '<div class="resources-category-buttons" style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; max-width: 1000px; margin: 0 auto;">';
    
    // All Resources button
    $html .= '<a href="' . get_post_type_archive_link('lis_resource') . '" class="category-filter-btn" style="padding: 15px 30px; background: #003d70; color: #FFFFFF; text-decoration: none; border-radius: 25px; font-weight: 600; transition: all 0.3s ease; display: inline-block; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        📚 All Resources
    </a>';
    
    if (!empty($categories) && !is_wp_error($categories)) {
        $category_icons = array(
            'admission-forms' => '📝',
            'academic-policies' => '📋',
            'parent-handbook' => '📖',
            'fee-information' => '💰',
            'calendar' => '📅',
        );
        
        foreach ($categories as $category) {
            $icon = isset($category_icons[$category->slug]) ? $category_icons[$category->slug] : '📄';
            $html .= '<a href="' . get_term_link($category) . '" class="category-filter-btn" style="padding: 15px 30px; background: #7EBEC5; color: #FFFFFF; text-decoration: none; border-radius: 25px; font-weight: 600; transition: all 0.3s ease; display: inline-block; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                ' . $icon . ' ' . esc_html($category->name) . ' <span style="opacity: 0.8;">(' . $category->count . ')</span>
            </a>';
        }
    }
    
    $html .= '</div>';
    
    $html .= '<style>
        .category-filter-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2) !important;
            background: #F39A3B !important;
        }
        
        @media (max-width: 768px) {
            .resources-category-buttons {
                flex-direction: column;
            }
            .category-filter-btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>';
    
    return $html;
}
