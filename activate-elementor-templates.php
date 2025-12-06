<?php
/**
 * Activate Elementor Header and Footer Templates
 */

require_once('wp-load.php');

if (!defined('ABSPATH')) {
    die('WordPress not loaded');
}

echo "\n=== Activating Elementor Header/Footer Templates ===\n\n";

// Get the header and footer template IDs
$header_template = get_posts([
    'post_type' => 'elementor_library',
    'title' => 'Site Header',
    'posts_per_page' => 1,
]);

$footer_template = get_posts([
    'post_type' => 'elementor_library',
    'title' => 'Site Footer',
    'posts_per_page' => 1,
]);

$header_id = !empty($header_template) ? $header_template[0]->ID : 0;
$footer_id = !empty($footer_template) ? $footer_template[0]->ID : 0;

echo "Found templates:\n";
echo "  Header ID: $header_id\n";
echo "  Footer ID: $footer_id\n\n";

if ($header_id && $footer_id) {
    // Set display conditions for header
    update_post_meta($header_id, '_elementor_conditions', ['include/general']);
    update_post_meta($header_id, '_elementor_location', 'header');
    
    // Set display conditions for footer
    update_post_meta($footer_id, '_elementor_conditions', ['include/general']);
    update_post_meta($footer_id, '_elementor_location', 'footer');
    
    echo "✓ Display conditions set for header and footer\n";
    echo "✓ Templates activated site-wide\n\n";
    
    echo "To verify, visit your site and you should see:\n";
    echo "  - Header with logo and navigation menu\n";
    echo "  - Footer with links and contact info\n";
} else {
    echo "✗ Could not find header/footer templates\n";
}
