<?php
/**
 * Debug JSON encoding
 */

// Load WordPress
require_once __DIR__ . '/wp-load.php';

$homepage = get_page_by_path('home');
$elementor_data = get_post_meta($homepage->ID, '_elementor_data', true);

// Save to file for inspection
file_put_contents('elementor-data-raw.json', $elementor_data);
echo "Saved raw data to elementor-data-raw.json\n";

// Try to validate JSON
$decoded = json_decode($elementor_data, true);
if ($decoded === null) {
    echo "JSON Error: " . json_last_error_msg() . "\n";
    echo "Error code: " . json_last_error() . "\n";
    
    // Find the error position
    for ($i = 0; $i < strlen($elementor_data); $i++) {
        $test = substr($elementor_data, 0, $i);
        $result = json_decode($test, true);
        if (json_last_error() !== JSON_ERROR_NONE && json_last_error() !== JSON_ERROR_STATE_MISMATCH) {
            echo "Error starts around position $i\n";
            echo "Context: " . substr($elementor_data, max(0, $i-50), 100) . "\n";
            break;
        }
    }
} else {
    echo "JSON is valid!\n";
    echo "Sections: " . count($decoded) . "\n";
}
