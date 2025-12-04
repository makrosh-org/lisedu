<?php
/**
 * Add Contact Form to Contact Page
 * Task 11: Add contact form shortcode to Contact page
 */

define('WP_USE_THEMES', false);
require './wp-load.php';

echo "=== Adding Contact Form to Contact Page ===\n\n";

// Find the Contact page
$contact_page = get_page_by_path('contact');

if (!$contact_page) {
    // Try to find by title
    $pages = get_posts(array(
        'post_type' => 'page',
        'title' => 'Contact',
        'post_status' => 'publish',
        'numberposts' => 1
    ));
    
    if (!empty($pages)) {
        $contact_page = $pages[0];
    }
}

if (!$contact_page) {
    echo "⚠ Contact page not found. Creating it...\n";
    
    // Create Contact page
    $page_id = wp_insert_post(array(
        'post_title' => 'Contact',
        'post_name' => 'contact',
        'post_type' => 'page',
        'post_status' => 'publish',
        'post_content' => '[contact-form-7 id="63" title="Lumina Contact Form"]'
    ));
    
    if (is_wp_error($page_id)) {
        echo "✗ ERROR: Failed to create Contact page\n";
        exit(1);
    }
    
    echo "✓ Contact page created (ID: $page_id)\n";
    $contact_page = get_post($page_id);
} else {
    echo "✓ Contact page found (ID: {$contact_page->ID})\n";
}

// Check if the page already has the contact form shortcode
$content = $contact_page->post_content;

if (strpos($content, '[contact-form-7') !== false) {
    echo "✓ Contact form shortcode already present on page\n";
} else {
    echo "Adding contact form shortcode to page...\n";
    
    // Add the shortcode to the page content
    $new_content = $content . "\n\n" . '[contact-form-7 id="63" title="Lumina Contact Form"]';
    
    wp_update_post(array(
        'ID' => $contact_page->ID,
        'post_content' => $new_content
    ));
    
    echo "✓ Contact form shortcode added to Contact page\n";
}

echo "\n=== Summary ===\n";
echo "Contact Page URL: " . get_permalink($contact_page->ID) . "\n";
echo "Form Shortcode: [contact-form-7 id=\"63\" title=\"Lumina Contact Form\"]\n";
echo "\n✓ Contact form is now available on the Contact page!\n";

?>
