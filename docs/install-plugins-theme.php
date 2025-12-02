<?php
/**
 * Lumina International School - Plugin and Theme Installation Script
 * 
 * This script installs and configures all required plugins and theme
 * for the Lumina International School website.
 * 
 * Requirements: 6.1, 7.2, 7.3, 7.4, 8.2, 8.4
 * 
 * Usage: Run via WP-CLI or include in WordPress admin
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__FILE__) . '/../');
    require_once(ABSPATH . 'wp-load.php');
}

// Check if user has admin privileges
if (!current_user_can('install_plugins') || !current_user_can('install_themes')) {
    die('Error: You must be an administrator to run this script.');
}

/**
 * Plugin and Theme Installation Configuration
 */
$installation_config = [
    'theme' => [
        'slug' => 'hello-elementor',
        'name' => 'Hello Elementor',
        'activate' => true
    ],
    'plugins' => [
        // Page Builder
        [
            'slug' => 'elementor',
            'name' => 'Elementor',
            'activate' => true,
            'requirement' => '6.1'
        ],
        // Form Plugin
        [
            'slug' => 'contact-form-7',
            'name' => 'Contact Form 7',
            'activate' => true,
            'requirement' => '6.1'
        ],
        // SEO Plugin
        [
            'slug' => 'wordpress-seo',
            'name' => 'Yoast SEO',
            'activate' => true,
            'requirement' => '6.1'
        ],
        // Security Plugin
        [
            'slug' => 'wordfence',
            'name' => 'Wordfence Security',
            'activate' => true,
            'requirement' => '8.4'
        ],
        // Backup Plugin
        [
            'slug' => 'updraftplus',
            'name' => 'UpdraftPlus',
            'activate' => true,
            'requirement' => '8.2'
        ],
        // Performance Optimization
        [
            'slug' => 'w3-total-cache',
            'name' => 'W3 Total Cache',
            'activate' => true,
            'requirement' => '7.3, 7.4'
        ],
        // Image Optimization
        [
            'slug' => 'wp-smushit',
            'name' => 'Smush',
            'activate' => true,
            'requirement' => '7.2'
        ],
        // Events Calendar
        [
            'slug' => 'the-events-calendar',
            'name' => 'The Events Calendar',
            'activate' => true,
            'requirement' => '6.1'
        ]
    ]
];

/**
 * Installation Results Tracker
 */
$results = [
    'theme' => [],
    'plugins' => [],
    'errors' => []
];

echo "=== Lumina International School - Installation Script ===\n\n";

/**
 * Install and Activate Theme
 */
echo "Installing Theme: {$installation_config['theme']['name']}...\n";

$theme_slug = $installation_config['theme']['slug'];
$theme = wp_get_theme($theme_slug);

if (!$theme->exists()) {
    echo "  - Theme not found locally. Installation required via WordPress admin or WP-CLI.\n";
    $results['theme']['status'] = 'manual_install_required';
    $results['theme']['message'] = "Please install {$installation_config['theme']['name']} theme manually";
} else {
    if ($installation_config['theme']['activate']) {
        switch_theme($theme_slug);
        echo "  ✓ Theme activated successfully\n";
        $results['theme']['status'] = 'activated';
    }
}

echo "\n";

/**
 * Install and Activate Plugins
 */
echo "Installing Plugins...\n\n";

foreach ($installation_config['plugins'] as $plugin_config) {
    echo "Processing: {$plugin_config['name']}...\n";
    
    // Check if plugin is already installed
    $plugin_file = $plugin_config['slug'] . '/' . $plugin_config['slug'] . '.php';
    
    // Handle special cases for plugin file names
    $special_cases = [
        'wordpress-seo' => 'wordpress-seo/wp-seo.php',
        'wp-smushit' => 'wp-smushit/wp-smush.php',
        'contact-form-7' => 'contact-form-7/wp-contact-form-7.php'
    ];
    
    if (isset($special_cases[$plugin_config['slug']])) {
        $plugin_file = $special_cases[$plugin_config['slug']];
    }
    
    $plugin_path = WP_PLUGIN_DIR . '/' . $plugin_file;
    
    if (!file_exists($plugin_path)) {
        echo "  - Plugin not found locally. Installation required via WordPress admin or WP-CLI.\n";
        $results['plugins'][$plugin_config['slug']] = [
            'status' => 'manual_install_required',
            'message' => "Please install {$plugin_config['name']} manually",
            'requirement' => $plugin_config['requirement']
        ];
    } else {
        // Plugin exists, activate it
        if ($plugin_config['activate']) {
            if (!is_plugin_active($plugin_file)) {
                $activate_result = activate_plugin($plugin_file);
                if (is_wp_error($activate_result)) {
                    echo "  ✗ Error activating plugin: " . $activate_result->get_error_message() . "\n";
                    $results['plugins'][$plugin_config['slug']] = [
                        'status' => 'error',
                        'message' => $activate_result->get_error_message()
                    ];
                } else {
                    echo "  ✓ Plugin activated successfully\n";
                    $results['plugins'][$plugin_config['slug']] = [
                        'status' => 'activated',
                        'requirement' => $plugin_config['requirement']
                    ];
                }
            } else {
                echo "  ✓ Plugin already active\n";
                $results['plugins'][$plugin_config['slug']] = [
                    'status' => 'already_active',
                    'requirement' => $plugin_config['requirement']
                ];
            }
        }
    }
    
    echo "\n";
}

/**
 * Display Summary
 */
echo "\n=== Installation Summary ===\n\n";
echo "Theme Status: " . ($results['theme']['status'] ?? 'unknown') . "\n";
echo "Plugins Processed: " . count($installation_config['plugins']) . "\n\n";

echo "Next Steps:\n";
echo "1. If any plugins require manual installation, install them via:\n";
echo "   - WordPress Admin > Plugins > Add New\n";
echo "   - Or use WP-CLI: wp plugin install <plugin-slug> --activate\n\n";
echo "2. Run the configuration script: php docs/configure-plugins.php\n\n";
echo "3. Configure Elementor Pro (requires separate license)\n\n";

// Save results to log file
$log_file = dirname(__FILE__) . '/installation-log.json';
file_put_contents($log_file, json_encode($results, JSON_PRETTY_PRINT));
echo "Installation log saved to: docs/installation-log.json\n\n";

echo "=== Installation Script Complete ===\n";
