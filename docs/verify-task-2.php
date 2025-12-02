<?php
/**
 * Lumina International School - Task 2 Verification Script
 * 
 * This script verifies that all plugins and theme are properly
 * installed and configured according to the requirements.
 * 
 * Requirements: 6.1, 7.2, 7.3, 7.4, 8.2, 8.4
 * 
 * Usage: php docs/verify-task-2.php
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__FILE__) . '/../');
    require_once(ABSPATH . 'wp-load.php');
}

echo "=== Task 2 Verification Report ===\n";
echo "Lumina International School Website\n";
echo "Generated: " . date('Y-m-d H:i:s') . "\n\n";

$verification_results = [
    'theme' => [],
    'plugins' => [],
    'configuration' => [],
    'requirements' => [],
    'warnings' => [],
    'errors' => []
];

$total_checks = 0;
$passed_checks = 0;

/**
 * Helper function to check and report
 */
function check_item($name, $condition, $requirement = null) {
    global $total_checks, $passed_checks, $verification_results;
    $total_checks++;
    
    $status = $condition ? '✓' : '✗';
    $result = $condition ? 'PASS' : 'FAIL';
    
    if ($condition) {
        $passed_checks++;
    } else {
        $verification_results['errors'][] = $name;
    }
    
    $req_text = $requirement ? " (Req: $requirement)" : "";
    echo "  $status $name$req_text\n";
    
    return $condition;
}

/**
 * 1. Theme Verification
 */
echo "1. Theme Verification\n";
echo "-------------------\n";

$current_theme = wp_get_theme();
$theme_slug = $current_theme->get_stylesheet();

check_item(
    "Hello Elementor theme installed",
    $theme_slug === 'hello-elementor' || $theme_slug === 'astra',
    "6.1"
);

check_item(
    "Theme is active",
    $current_theme->exists(),
    "6.1"
);

echo "\n";

/**
 * 2. Plugin Verification
 */
echo "2. Plugin Verification\n";
echo "--------------------\n";

$required_plugins = [
    'elementor/elementor.php' => ['name' => 'Elementor', 'req' => '6.1'],
    'contact-form-7/wp-contact-form-7.php' => ['name' => 'Contact Form 7', 'req' => '6.1'],
    'wordpress-seo/wp-seo.php' => ['name' => 'Yoast SEO', 'req' => '6.1'],
    'wordfence/wordfence.php' => ['name' => 'Wordfence Security', 'req' => '8.4'],
    'updraftplus/updraftplus.php' => ['name' => 'UpdraftPlus', 'req' => '8.2'],
    'w3-total-cache/w3-total-cache.php' => ['name' => 'W3 Total Cache', 'req' => '7.3, 7.4'],
    'wp-smushit/wp-smush.php' => ['name' => 'Smush', 'req' => '7.2'],
    'the-events-calendar/the-events-calendar.php' => ['name' => 'The Events Calendar', 'req' => '6.1']
];

foreach ($required_plugins as $plugin_file => $plugin_info) {
    check_item(
        "{$plugin_info['name']} installed and active",
        is_plugin_active($plugin_file),
        $plugin_info['req']
    );
}

echo "\n";

/**
 * 3. Configuration Verification
 */
echo "3. Configuration Verification\n";
echo "---------------------------\n";

// Permalink structure
$permalink_structure = get_option('permalink_structure');
check_item(
    "SEO-friendly permalinks configured",
    $permalink_structure === '/%postname%/',
    "6.1"
);

// Comments disabled on pages
$comment_status = get_option('default_comment_status');
check_item(
    "Comments disabled on pages by default",
    $comment_status === 'closed',
    "General"
);

// Media organization
$uploads_yearmonth = get_option('uploads_use_yearmonth_folders');
check_item(
    "Media organized by month/year",
    $uploads_yearmonth == 1,
    "General"
);

// File editing disabled
check_item(
    "File editing disabled in WordPress admin",
    defined('DISALLOW_FILE_EDIT') && DISALLOW_FILE_EDIT === true,
    "8.4"
);

echo "\n";

/**
 * 4. Yoast SEO Configuration
 */
echo "4. Yoast SEO Configuration\n";
echo "------------------------\n";

if (is_plugin_active('wordpress-seo/wp-seo.php')) {
    $wpseo_xml = get_option('wpseo_xml');
    check_item(
        "XML sitemap enabled",
        isset($wpseo_xml['enablexmlsitemap']) && $wpseo_xml['enablexmlsitemap'] === true,
        "6.1"
    );
    
    $wpseo_social = get_option('wpseo_social');
    check_item(
        "Open Graph tags enabled",
        isset($wpseo_social['opengraph']) && $wpseo_social['opengraph'] === true,
        "6.1"
    );
} else {
    echo "  ⚠ Yoast SEO not active - skipping configuration checks\n";
}

echo "\n";

/**
 * 5. Wordfence Security Configuration
 */
echo "5. Wordfence Security Configuration\n";
echo "---------------------------------\n";

if (is_plugin_active('wordfence/wordfence.php')) {
    $wf_activated = get_option('wordfenceActivated');
    check_item(
        "Wordfence activated",
        $wf_activated == 1,
        "8.4"
    );
    
    $login_security = get_option('wordfence_loginSecurityEnabled');
    check_item(
        "Login security enabled",
        $login_security == 1,
        "8.4"
    );
    
    $max_failures = get_option('wordfence_maxLoginFailures');
    check_item(
        "Login attempt limiting configured (5 attempts)",
        $max_failures == 5,
        "8.4"
    );
    
    $lockout_mins = get_option('wordfence_loginSec_lockoutMins');
    check_item(
        "Lockout duration configured (15 minutes)",
        $lockout_mins == 15,
        "8.4"
    );
} else {
    echo "  ⚠ Wordfence not active - skipping configuration checks\n";
}

echo "\n";

/**
 * 6. UpdraftPlus Backup Configuration
 */
echo "6. UpdraftPlus Backup Configuration\n";
echo "---------------------------------\n";

if (is_plugin_active('updraftplus/updraftplus.php')) {
    $updraft_interval = get_option('updraft_interval');
    check_item(
        "Daily backup schedule configured",
        $updraft_interval === 'daily',
        "8.2"
    );
    
    $updraft_retain = get_option('updraft_retain');
    check_item(
        "Backup retention configured",
        $updraft_retain >= 7,
        "8.2"
    );
    
    $updraft_email = get_option('updraft_email');
    check_item(
        "Email notifications configured",
        !empty($updraft_email),
        "8.2"
    );
    
    // Check for remote storage configuration
    $remote_storage_configured = false;
    $remote_methods = ['updraft_dropbox', 'updraft_googledrive', 'updraft_s3', 'updraft_cloudfiles'];
    foreach ($remote_methods as $method) {
        if (get_option($method)) {
            $remote_storage_configured = true;
            break;
        }
    }
    
    if (!$remote_storage_configured) {
        echo "  ⚠ WARNING: Off-site backup storage not configured (Requirement 8.2)\n";
        $verification_results['warnings'][] = "Configure off-site backup storage in UpdraftPlus";
    } else {
        check_item(
            "Off-site backup storage configured",
            true,
            "8.2"
        );
    }
} else {
    echo "  ⚠ UpdraftPlus not active - skipping configuration checks\n";
}

echo "\n";

/**
 * 7. W3 Total Cache Configuration
 */
echo "7. W3 Total Cache Configuration\n";
echo "-----------------------------\n";

if (is_plugin_active('w3-total-cache/w3-total-cache.php')) {
    $pgcache_enabled = get_option('w3tc_pgcache.enabled');
    check_item(
        "Page caching enabled",
        $pgcache_enabled == true,
        "7.3"
    );
    
    $browsercache_enabled = get_option('w3tc_browsercache.enabled');
    check_item(
        "Browser caching enabled",
        $browsercache_enabled == true,
        "7.3"
    );
    
    $minify_enabled = get_option('w3tc_minify.enabled');
    check_item(
        "Minification enabled",
        $minify_enabled == true,
        "7.4"
    );
    
    $minify_js = get_option('w3tc_minify.js.enable');
    check_item(
        "JavaScript minification enabled",
        $minify_js == true,
        "7.4"
    );
    
    $minify_css = get_option('w3tc_minify.css.enable');
    check_item(
        "CSS minification enabled",
        $minify_css == true,
        "7.4"
    );
} else {
    echo "  ⚠ W3 Total Cache not active - skipping configuration checks\n";
}

echo "\n";

/**
 * 8. Smush Configuration
 */
echo "8. Smush Image Optimization Configuration\n";
echo "---------------------------------------\n";

if (is_plugin_active('wp-smushit/wp-smush.php')) {
    $smush_settings = get_option('wp-smush-settings');
    
    if ($smush_settings) {
        check_item(
            "Automatic optimization enabled",
            isset($smush_settings['auto']) && $smush_settings['auto'] == 1,
            "7.2"
        );
        
        check_item(
            "Lazy loading enabled",
            isset($smush_settings['lazy_load']) && $smush_settings['lazy_load'] == 1,
            "7.2"
        );
    } else {
        echo "  ⚠ Smush settings not found - may need manual configuration\n";
    }
} else {
    echo "  ⚠ Smush not active - skipping configuration checks\n";
}

echo "\n";

/**
 * 9. Elementor Configuration
 */
echo "9. Elementor Configuration\n";
echo "------------------------\n";

if (is_plugin_active('elementor/elementor.php')) {
    $disable_colors = get_option('elementor_disable_color_schemes');
    check_item(
        "Default color schemes disabled",
        $disable_colors === 'yes',
        "6.1"
    );
    
    $disable_typography = get_option('elementor_disable_typography_schemes');
    check_item(
        "Default typography schemes disabled",
        $disable_typography === 'yes',
        "6.1"
    );
    
    $lazy_load = get_option('elementor_lazy_load');
    check_item(
        "Lazy loading enabled",
        $lazy_load === 'yes',
        "6.1"
    );
    
    // Check for Elementor Pro
    $elementor_pro_active = is_plugin_active('elementor-pro/elementor-pro.php');
    if (!$elementor_pro_active) {
        echo "  ⚠ WARNING: Elementor Pro not installed (required for advanced features)\n";
        $verification_results['warnings'][] = "Install Elementor Pro for full functionality";
    } else {
        check_item(
            "Elementor Pro installed",
            true,
            "6.1"
        );
    }
} else {
    echo "  ⚠ Elementor not active - skipping configuration checks\n";
}

echo "\n";

/**
 * 10. Summary Report
 */
echo "=== Verification Summary ===\n\n";
echo "Total Checks: $total_checks\n";
echo "Passed: $passed_checks\n";
echo "Failed: " . ($total_checks - $passed_checks) . "\n";
echo "Success Rate: " . round(($passed_checks / $total_checks) * 100, 1) . "%\n\n";

if (!empty($verification_results['warnings'])) {
    echo "⚠ WARNINGS:\n";
    foreach ($verification_results['warnings'] as $warning) {
        echo "  - $warning\n";
    }
    echo "\n";
}

if (!empty($verification_results['errors'])) {
    echo "✗ FAILED CHECKS:\n";
    foreach ($verification_results['errors'] as $error) {
        echo "  - $error\n";
    }
    echo "\n";
}

/**
 * 11. Requirements Status
 */
echo "=== Requirements Status ===\n\n";

$requirements_status = [
    '6.1' => 'Content management with Elementor and forms',
    '7.2' => 'Image optimization with Smush',
    '7.3' => 'Browser caching with W3 Total Cache',
    '7.4' => 'Asset minification with W3 Total Cache',
    '8.2' => 'Automated backups with UpdraftPlus',
    '8.4' => 'Security hardening with Wordfence'
];

foreach ($requirements_status as $req => $description) {
    echo "Requirement $req: $description\n";
}

echo "\n";

/**
 * 12. Next Steps
 */
echo "=== Next Steps ===\n\n";

if ($passed_checks === $total_checks && empty($verification_results['warnings'])) {
    echo "✓ All checks passed! Task 2 is complete.\n";
    echo "\nProceed to Task 3: Create and configure child theme with brand styling\n";
} else {
    echo "⚠ Some checks failed or warnings present.\n";
    echo "\nRecommended actions:\n";
    
    if (!empty($verification_results['errors'])) {
        echo "1. Review and fix failed checks\n";
        echo "2. Re-run configuration script: php docs/configure-plugins.php\n";
    }
    
    if (!empty($verification_results['warnings'])) {
        echo "3. Address warnings (especially off-site backup storage)\n";
        echo "4. Install Elementor Pro if not already installed\n";
    }
    
    echo "5. Re-run this verification script\n";
}

echo "\n";

// Save verification report
$report_file = dirname(__FILE__) . '/task-2-verification-report.json';
$verification_results['summary'] = [
    'total_checks' => $total_checks,
    'passed_checks' => $passed_checks,
    'failed_checks' => $total_checks - $passed_checks,
    'success_rate' => round(($passed_checks / $total_checks) * 100, 1),
    'timestamp' => date('Y-m-d H:i:s')
];

file_put_contents($report_file, json_encode($verification_results, JSON_PRETTY_PRINT));
echo "Verification report saved to: docs/task-2-verification-report.json\n\n";

echo "=== Verification Complete ===\n";
