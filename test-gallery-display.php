<?php
/**
 * Test Gallery Display
 */

require_once('wp-load.php');

if (!defined('ABSPATH')) {
    die('WordPress not loaded');
}

echo "\n=== Testing Gallery Display ===\n\n";

// Test the shortcode output
$output = do_shortcode('[lumina_gallery]');

echo "Gallery Shortcode Output:\n";
echo "Length: " . strlen($output) . " characters\n\n";

// Check what's in the output
if (strpos($output, 'no-gallery-message') !== false) {
    echo "Status: No images found (showing empty state message)\n";
    echo "This is expected if no images are uploaded to the media library.\n\n";
} else {
    echo "Status: Gallery content found\n\n";
}

// Show first 500 characters
echo "First 500 characters of output:\n";
echo substr($output, 0, 500) . "...\n\n";

// Check for key elements
$checks = [
    'lumina-gallery-container' => strpos($output, 'lumina-gallery-container') !== false,
    'gallery-filter-tabs' => strpos($output, 'gallery-filter-tabs') !== false,
    'gallery-grid' => strpos($output, 'gallery-grid') !== false,
    'gallery-lightbox' => strpos($output, 'gallery-lightbox') !== false,
    'CSS styles' => strpos($output, '<style>') !== false,
    'JavaScript' => strpos($output, '<script>') !== false,
];

echo "Element Checks:\n";
foreach ($checks as $element => $found) {
    echo "  " . ($found ? "✓" : "✗") . " $element\n";
}

echo "\n";
