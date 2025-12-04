<?php
/**
 * Theme Verification Script
 * 
 * This script verifies that the Lumina child theme is properly configured
 * and all required files are in place.
 * 
 * Run from command line: php verify-theme.php
 */

// Define theme directory
$theme_dir = __DIR__;

echo "=== Lumina Child Theme Verification ===\n\n";

// Check required files
$required_files = [
    'style.css',
    'functions.php',
    'README.md',
    'assets/css/brand-colors.css',
    'assets/js/custom-scripts.js',
    'assets/images/logo.svg'
];

echo "Checking required files...\n";
$all_files_exist = true;
foreach ($required_files as $file) {
    $path = $theme_dir . '/' . $file;
    if (file_exists($path)) {
        echo "✓ $file exists\n";
    } else {
        echo "✗ $file is missing\n";
        $all_files_exist = false;
    }
}

echo "\n";

// Check brand colors in CSS
echo "Checking brand colors...\n";
$brand_colors_file = $theme_dir . '/assets/css/brand-colors.css';
if (file_exists($brand_colors_file)) {
    $css_content = file_get_contents($brand_colors_file);
    
    $required_colors = [
        '--base-darkblue: #003d70',
        '--base-lightgray: #f7f7f7',
        '--base-accent-teal: #7EBEC5',
        '--base-accent-orange: #F39A3B',
        '--base-white: #FFFFFF'
    ];
    
    $all_colors_present = true;
    foreach ($required_colors as $color) {
        if (strpos($css_content, $color) !== false) {
            echo "✓ $color is defined\n";
        } else {
            echo "✗ $color is missing\n";
            $all_colors_present = false;
        }
    }
} else {
    echo "✗ Brand colors file not found\n";
    $all_colors_present = false;
}

echo "\n";

// Check style.css metadata
echo "Checking theme metadata...\n";
$style_file = $theme_dir . '/style.css';
if (file_exists($style_file)) {
    $style_content = file_get_contents($style_file);
    
    $required_metadata = [
        'Theme Name:',
        'Template:',
        'Version:'
    ];
    
    foreach ($required_metadata as $meta) {
        if (strpos($style_content, $meta) !== false) {
            echo "✓ $meta is present\n";
        } else {
            echo "✗ $meta is missing\n";
        }
    }
}

echo "\n";

// Check functions.php for required functions
echo "Checking theme functions...\n";
$functions_file = $theme_dir . '/functions.php';
if (file_exists($functions_file)) {
    $functions_content = file_get_contents($functions_file);
    
    $required_functions = [
        'lumina_child_enqueue_styles',
        'lumina_child_theme_setup',
        'lumina_register_image_sizes'
    ];
    
    foreach ($required_functions as $func) {
        if (strpos($functions_content, $func) !== false) {
            echo "✓ $func is defined\n";
        } else {
            echo "✗ $func is missing\n";
        }
    }
}

echo "\n";

// Final summary
if ($all_files_exist && $all_colors_present) {
    echo "=== ✓ Theme verification PASSED ===\n";
    echo "The Lumina child theme is properly configured!\n";
    exit(0);
} else {
    echo "=== ✗ Theme verification FAILED ===\n";
    echo "Some required files or configurations are missing.\n";
    exit(1);
}
