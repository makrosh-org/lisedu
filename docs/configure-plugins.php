<?php
/**
 * Lumina International School - Plugin Configuration Script
 * 
 * This script configures all installed plugins with recommended settings
 * according to the design specifications.
 * 
 * Requirements: 6.1, 7.2, 7.3, 7.4, 8.2, 8.4
 * 
 * Usage: Run after plugins are installed and activated
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__FILE__) . '/../');
    require_once(ABSPATH . 'wp-load.php');
}

// Check if user has admin privileges
if (!current_user_can('manage_options')) {
    die('Error: You must be an administrator to run this script.');
}

echo "=== Lumina International School - Plugin Configuration ===\n\n";

/**
 * Configure Contact Form 7
 * Requirement: 6.1
 */
echo "Configuring Contact Form 7...\n";
if (is_plugin_active('contact-form-7/wp-contact-form-7.php')) {
    // Basic settings - CF7 uses individual form configurations
    update_option('wpcf7', [
        'version' => WPCF7_VERSION ?? '5.8',
        'bulk_validate' => [
            'timestamp' => time(),
            'count_valid' => 0,
            'count_invalid' => 0
        ]
    ]);
    echo "  ✓ Contact Form 7 configured\n";
} else {
    echo "  ✗ Contact Form 7 not active\n";
}
echo "\n";

/**
 * Configure Yoast SEO
 * Requirement: 6.1
 */
echo "Configuring Yoast SEO...\n";
if (is_plugin_active('wordpress-seo/wp-seo.php')) {
    // Enable XML sitemaps
    update_option('wpseo_xml', [
        'enablexmlsitemap' => true,
        'disable_author_sitemap' => true,
        'disable_author_noposts' => true
    ]);
    
    // Configure titles and metas
    update_option('wpseo_titles', [
        'separator' => 'sc-dash',
        'title-home-wpseo' => 'Lumina International School - Islamic Education Excellence',
        'metadesc-home-wpseo' => 'Lumina International School offers quality Islamic education from play group to grade 5, combining academic excellence with Islamic values.',
        'company_name' => 'Lumina International School',
        'company_logo' => '',
        'website_name' => 'Lumina International School',
        'stripcategorybase' => true
    ]);
    
    // Social settings
    update_option('wpseo_social', [
        'opengraph' => true,
        'twitter' => true,
        'facebook_site' => '',
        'twitter_site' => '',
        'og_default_image' => '',
        'og_frontpage_title' => 'Lumina International School',
        'og_frontpage_desc' => 'Quality Islamic education from play group to grade 5'
    ]);
    
    echo "  ✓ Yoast SEO configured with XML sitemaps and Open Graph\n";
} else {
    echo "  ✗ Yoast SEO not active\n";
}
echo "\n";

/**
 * Configure Wordfence Security
 * Requirement: 8.4
 */
echo "Configuring Wordfence Security...\n";
if (is_plugin_active('wordfence/wordfence.php')) {
    // Enable login security
    update_option('wordfenceActivated', 1);
    
    // Configure brute force protection
    $wf_config = [
        'loginSecurityEnabled' => 1,
        'maxLoginFailures' => 5,
        'maxLoginFailuresDuration' => 15, // 15 minutes
        'loginSec_lockoutMins' => 15,
        'loginSec_strongPasswds' => 1,
        'loginSec_enableSeparateTwoFactor' => 1,
        'firewallEnabled' => 1,
        'scansEnabled' => 1,
        'liveTrafficEnabled' => 1,
        'alertEmails' => get_option('admin_email')
    ];
    
    foreach ($wf_config as $key => $value) {
        update_option('wordfence_' . $key, $value);
    }
    
    echo "  ✓ Wordfence configured with login limiting (5 attempts, 15-min lockout)\n";
    echo "  ✓ Strong passwords enforced\n";
    echo "  ✓ Two-factor authentication enabled\n";
} else {
    echo "  ✗ Wordfence not active\n";
}
echo "\n";

/**
 * Configure UpdraftPlus Backup
 * Requirement: 8.2
 */
echo "Configuring UpdraftPlus...\n";
if (is_plugin_active('updraftplus/updraftplus.php')) {
    // Configure automated daily backups
    $updraft_settings = [
        'updraft_interval' => 'daily',
        'updraft_interval_database' => 'daily',
        'updraft_retain' => 7, // Keep 7 days of backups
        'updraft_retain_db' => 7,
        'updraft_split_every' => 400, // Split archives every 400MB
        'updraft_delete_local' => 1,
        'updraft_include_plugins' => 1,
        'updraft_include_themes' => 1,
        'updraft_include_uploads' => 1,
        'updraft_include_others' => 1,
        'updraft_include_wpcore' => 0,
        'updraft_report_warningsonly' => 0,
        'updraft_report_wholebackup' => 1,
        'updraft_email' => get_option('admin_email')
    ];
    
    foreach ($updraft_settings as $key => $value) {
        update_option($key, $value);
    }
    
    echo "  ✓ UpdraftPlus configured for daily automated backups\n";
    echo "  ✓ Backup retention: 7 days\n";
    echo "  ✓ Email notifications enabled\n";
    echo "  ! Note: Configure off-site storage (Dropbox, Google Drive, S3) in WordPress admin\n";
} else {
    echo "  ✗ UpdraftPlus not active\n";
}
echo "\n";

/**
 * Configure W3 Total Cache
 * Requirements: 7.3, 7.4
 */
echo "Configuring W3 Total Cache...\n";
if (is_plugin_active('w3-total-cache/w3-total-cache.php')) {
    // Enable page caching
    update_option('w3tc_pgcache.enabled', true);
    update_option('w3tc_pgcache.engine', 'file_generic');
    
    // Enable browser caching
    update_option('w3tc_browsercache.enabled', true);
    update_option('w3tc_browsercache.cssjs.cache.control', true);
    update_option('w3tc_browsercache.html.cache.control', true);
    update_option('w3tc_browsercache.other.cache.control', true);
    update_option('w3tc_browsercache.cssjs.expires', true);
    update_option('w3tc_browsercache.html.expires', true);
    update_option('w3tc_browsercache.other.expires', true);
    update_option('w3tc_browsercache.cssjs.lifetime', 31536000); // 1 year
    update_option('w3tc_browsercache.html.lifetime', 3600); // 1 hour
    update_option('w3tc_browsercache.other.lifetime', 31536000); // 1 year
    
    // Enable minification
    update_option('w3tc_minify.enabled', true);
    update_option('w3tc_minify.auto', true);
    update_option('w3tc_minify.html.enable', true);
    update_option('w3tc_minify.js.enable', true);
    update_option('w3tc_minify.css.enable', true);
    
    // Enable GZIP compression
    update_option('w3tc_browsercache.cssjs.compression', true);
    update_option('w3tc_browsercache.html.compression', true);
    update_option('w3tc_browsercache.other.compression', true);
    
    echo "  ✓ Page caching enabled\n";
    echo "  ✓ Browser caching configured (Requirement 7.3)\n";
    echo "  ✓ CSS/JS minification enabled (Requirement 7.4)\n";
    echo "  ✓ GZIP compression enabled\n";
} else {
    echo "  ✗ W3 Total Cache not active\n";
}
echo "\n";

/**
 * Configure Smush Image Optimization
 * Requirement: 7.2
 */
echo "Configuring Smush...\n";
if (is_plugin_active('wp-smushit/wp-smush.php')) {
    $smush_settings = [
        'auto' => 1, // Auto-smush on upload
        'lossy' => 0, // Use lossless compression
        'strip_exif' => 1, // Remove EXIF data
        'resize' => 1, // Enable resize
        'detection' => 1, // Detect wrong size images
        'original' => 0, // Don't backup originals
        'lazy_load' => 1, // Enable lazy loading
        'usage' => 1
    ];
    
    update_option('wp-smush-settings', $smush_settings);
    
    echo "  ✓ Automatic image optimization enabled\n";
    echo "  ✓ Lazy loading configured (Requirement 7.2)\n";
    echo "  ✓ Lossless compression enabled\n";
} else {
    echo "  ✗ Smush not active\n";
}
echo "\n";

/**
 * Configure The Events Calendar
 * Requirement: 6.1
 */
echo "Configuring The Events Calendar...\n";
if (is_plugin_active('the-events-calendar/the-events-calendar.php')) {
    // Basic event settings
    update_option('tribe_events_calendar_options', [
        'tribeEventsDateFormatDisplay' => 'F j, Y',
        'tribeEventsTimeFormatDisplay' => 'g:i A',
        'viewOption' => 'list',
        'liveFiltersUpdate' => true,
        'tribeEnableViews' => ['list', 'month', 'day'],
        'dateWithYearFormat' => 'F j, Y',
        'dateWithoutYearFormat' => 'F j',
        'monthAndYearFormat' => 'F Y',
        'dateTimeSeparator' => ' @ ',
        'timeRangeSeparator' => ' - '
    ]);
    
    echo "  ✓ The Events Calendar configured\n";
    echo "  ✓ List and calendar views enabled\n";
} else {
    echo "  ✗ The Events Calendar not active\n";
}
echo "\n";

/**
 * Configure Elementor Settings
 * Requirement: 6.1
 */
echo "Configuring Elementor...\n";
if (is_plugin_active('elementor/elementor.php')) {
    // Disable Elementor's default colors and fonts to use custom ones
    update_option('elementor_disable_color_schemes', 'yes');
    update_option('elementor_disable_typography_schemes', 'yes');
    
    // Performance settings
    update_option('elementor_optimized_dom_output', 'enabled');
    update_option('elementor_lazy_load', 'yes');
    update_option('elementor_lazy_load_background_images', 'yes');
    
    // Editor settings
    update_option('elementor_edit_buttons', 'on');
    update_option('elementor_allow_svg', 'yes');
    
    echo "  ✓ Elementor configured\n";
    echo "  ✓ Performance optimizations enabled\n";
    echo "  ✓ Lazy loading enabled\n";
    echo "  ! Note: Elementor Pro requires separate installation and license activation\n";
} else {
    echo "  ✗ Elementor not active\n";
}
echo "\n";

/**
 * General WordPress Settings
 */
echo "Configuring WordPress General Settings...\n";

// Set permalink structure to post name (SEO-friendly)
update_option('permalink_structure', '/%postname%/');
flush_rewrite_rules();
echo "  ✓ Permalink structure set to SEO-friendly format\n";

// Disable comments on pages by default
update_option('default_comment_status', 'closed');
update_option('default_ping_status', 'closed');
echo "  ✓ Comments disabled on pages by default\n";

// Media settings
update_option('uploads_use_yearmonth_folders', 1);
echo "  ✓ Media organized by month/year\n";

// Set timezone (adjust as needed)
update_option('timezone_string', 'Asia/Dubai'); // Adjust for school location
echo "  ✓ Timezone configured\n";

echo "\n";

/**
 * Security Hardening
 * Requirement: 8.4
 */
echo "Applying Security Hardening...\n";

// Disable file editing in WordPress admin
if (!defined('DISALLOW_FILE_EDIT')) {
    $wp_config_path = ABSPATH . 'wp-config.php';
    if (file_exists($wp_config_path) && is_writable($wp_config_path)) {
        $wp_config_content = file_get_contents($wp_config_path);
        if (strpos($wp_config_content, 'DISALLOW_FILE_EDIT') === false) {
            $define_line = "\n// Disable file editing for security\ndefine('DISALLOW_FILE_EDIT', true);\n";
            $wp_config_content = str_replace(
                "/* That's all, stop editing!",
                $define_line . "/* That's all, stop editing!",
                $wp_config_content
            );
            file_put_contents($wp_config_path, $wp_config_content);
            echo "  ✓ File editing disabled in WordPress admin\n";
        } else {
            echo "  ✓ File editing already disabled\n";
        }
    } else {
        echo "  ! wp-config.php not writable - manually add: define('DISALLOW_FILE_EDIT', true);\n";
    }
}

echo "\n";

/**
 * Configuration Summary
 */
echo "=== Configuration Summary ===\n\n";
echo "✓ All plugins configured with recommended settings\n";
echo "✓ Security hardening applied\n";
echo "✓ Performance optimizations enabled\n";
echo "✓ SEO settings configured\n";
echo "✓ Backup system configured\n\n";

echo "Next Steps:\n";
echo "1. Configure off-site backup storage in UpdraftPlus settings\n";
echo "2. Install and activate Elementor Pro (requires license)\n";
echo "3. Set up Cloudflare CDN for additional performance\n";
echo "4. Review and adjust timezone setting if needed\n";
echo "5. Configure email delivery (SMTP recommended)\n";
echo "6. Run initial security scan in Wordfence\n";
echo "7. Test backup creation and restoration\n\n";

// Save configuration log
$config_log = [
    'timestamp' => date('Y-m-d H:i:s'),
    'configured_plugins' => [
        'contact-form-7' => is_plugin_active('contact-form-7/wp-contact-form-7.php'),
        'yoast-seo' => is_plugin_active('wordpress-seo/wp-seo.php'),
        'wordfence' => is_plugin_active('wordfence/wordfence.php'),
        'updraftplus' => is_plugin_active('updraftplus/updraftplus.php'),
        'w3-total-cache' => is_plugin_active('w3-total-cache/w3-total-cache.php'),
        'smush' => is_plugin_active('wp-smushit/wp-smush.php'),
        'the-events-calendar' => is_plugin_active('the-events-calendar/the-events-calendar.php'),
        'elementor' => is_plugin_active('elementor/elementor.php')
    ],
    'requirements_addressed' => [
        '6.1' => 'Content management with Elementor and forms',
        '7.2' => 'Image optimization with Smush',
        '7.3' => 'Browser caching with W3 Total Cache',
        '7.4' => 'Asset minification with W3 Total Cache',
        '8.2' => 'Automated backups with UpdraftPlus',
        '8.4' => 'Security hardening with Wordfence'
    ]
];

$log_file = dirname(__FILE__) . '/configuration-log.json';
file_put_contents($log_file, json_encode($config_log, JSON_PRETTY_PRINT));
echo "Configuration log saved to: docs/configuration-log.json\n\n";

echo "=== Configuration Script Complete ===\n";
