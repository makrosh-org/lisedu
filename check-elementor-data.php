<?php
/**
 * Check Elementor Data Structure
 */

// Load WordPress
require_once __DIR__ . '/wp-load.php';

$homepage = get_page_by_path('home');
if (!$homepage) {
    die("Home page not found\n");
}

echo "Homepage ID: {$homepage->ID}\n\n";

$elementor_data = get_post_meta($homepage->ID, '_elementor_data', true);
echo "Elementor data type: " . gettype($elementor_data) . "\n";
echo "Elementor data length: " . strlen($elementor_data) . "\n";
echo "First 500 characters:\n";
echo substr($elementor_data, 0, 500) . "\n\n";

// Try to decode
$decoded = json_decode($elementor_data, true);
if ($decoded === null) {
    echo "JSON decode error: " . json_last_error_msg() . "\n";
} else {
    echo "Successfully decoded!\n";
    echo "Array count: " . count($decoded) . "\n";
}
