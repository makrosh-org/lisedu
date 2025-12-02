<?php
/**
 * WordPress Setup Verification Script
 * Lumina International School Website
 * 
 * This script verifies that WordPress is properly configured according to Task 1 requirements.
 * 
 * USAGE:
 * 1. Upload this file to your WordPress root directory
 * 2. Access it via browser: https://yourdomain.com/verify-wordpress-setup.php
 * 3. Review the results
 * 4. DELETE this file after verification for security
 */

// Prevent direct access if WordPress is not loaded
if (!file_exists('./wp-load.php')) {
    die('Error: This script must be placed in the WordPress root directory.');
}

// Load WordPress
require_once('./wp-load.php');

// Security check - only allow logged-in administrators
if (!is_user_logged_in() || !current_user_can('administrator')) {
    die('Error: You must be logged in as an administrator to run this verification script.');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WordPress Setup Verification - Lumina International School</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
            background: #f0f0f1;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        h1 {
            color: #003d70;
            border-bottom: 3px solid #7EBEC5;
            padding-bottom: 10px;
        }
        h2 {
            color: #003d70;
            margin-top: 30px;
        }
        .check-item {
            padding: 15px;
            margin: 10px 0;
            border-left: 4px solid #ddd;
            background: #f9f9f9;
        }
        .check-item.pass {
            border-left-color: #46b450;
            background: #f0f9f0;
        }
        .check-item.fail {
            border-left-color: #dc3232;
            background: #f9f0f0;
        }
        .check-item.warning {
            border-left-color: #F39A3B;
            background: #fff8f0;
        }
        .status {
            font-weight: bold;
            margin-right: 10px;
        }
        .status.pass { color: #46b450; }
        .status.fail { color: #dc3232; }
        .status.warning { color: #F39A3B; }
        .summary {
            background: #003d70;
            color: white;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .summary h3 {
            margin-top: 0;
        }
        .detail {
            font-size: 0.9em;
            color: #666;
            margin-top: 5px;
        }
        .warning-box {
            background: #fff3cd;
            border: 1px solid #F39A3B;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>WordPress Setup Verification</h1>
        <p><strong>Lumina International School Website - Task 1 Verification</strong></p>
        <p>Verification Date: <?php echo date('Y-m-d H:i:s'); ?></p>

        <?php
        $checks = [];
        $passed = 0;
        $failed = 0;
        $warnings = 0;

        // Check 1: WordPress Version
        $wp_version = get_bloginfo('version');
        $version_check = version_compare($wp_version, '6.4', '>=');
        $checks[] = [
            'name' => 'WordPress Version',
            'status' => $version_check ? 'pass' : 'fail',
            'message' => "WordPress version: {$wp_version}",
            'detail' => $version_check ? 'Requirement: 6.4+ ✓' : 'Requirement: 6.4+ (FAILED)'
        ];
        $version_check ? $passed++ : $failed++;

        // Check 2: PHP Version
        $php_version = phpversion();
        $php_check = version_compare($php_version, '8.1', '>=');
        $checks[] = [
            'name' => 'PHP Version',
            'status' => $php_check ? 'pass' : 'fail',
            'message' => "PHP version: {$php_version}",
            'detail' => $php_check ? 'Requirement: 8.1+ ✓' : 'Requirement: 8.1+ (FAILED)'
        ];
        $php_check ? $passed++ : $failed++;

        // Check 3: MySQL Version
        global $wpdb;
        $mysql_version = $wpdb->db_version();
        $mysql_check = version_compare($mysql_version, '8.0', '>=');
        $checks[] = [
            'name' => 'MySQL Version',
            'status' => $mysql_check ? 'pass' : 'warning',
            'message' => "MySQL version: {$mysql_version}",
            'detail' => $mysql_check ? 'Requirement: 8.0+ ✓' : 'Requirement: 8.0+ (Consider upgrading)'
        ];
        $mysql_check ? $passed++ : $warnings++;

        // Check 4: HTTPS Status
        $is_ssl = is_ssl();
        $checks[] = [
            'name' => 'HTTPS/SSL Status',
            'status' => $is_ssl ? 'pass' : 'fail',
            'message' => $is_ssl ? 'Site is using HTTPS' : 'Site is NOT using HTTPS',
            'detail' => $is_ssl ? 'SSL certificate is active ✓' : 'SSL certificate must be installed and configured'
        ];
        $is_ssl ? $passed++ : $failed++;

        // Check 5: Site URL uses HTTPS
        $site_url = get_option('siteurl');
        $home_url = get_option('home');
        $url_check = (strpos($site_url, 'https://') === 0) && (strpos($home_url, 'https://') === 0);
        $checks[] = [
            'name' => 'WordPress URLs Configuration',
            'status' => $url_check ? 'pass' : 'fail',
            'message' => $url_check ? 'WordPress and Site URLs use HTTPS' : 'URLs not configured for HTTPS',
            'detail' => "Site URL: {$site_url}<br>Home URL: {$home_url}"
        ];
        $url_check ? $passed++ : $failed++;

        // Check 6: Permalink Structure
        $permalink_structure = get_option('permalink_structure');
        $permalink_check = ($permalink_structure === '/%postname%/');
        $checks[] = [
            'name' => 'Permalink Structure',
            'status' => $permalink_check ? 'pass' : 'warning',
            'message' => $permalink_check ? 'SEO-friendly permalinks configured' : 'Permalinks not optimized',
            'detail' => "Current structure: " . ($permalink_structure ?: 'Plain (not SEO-friendly)')
        ];
        $permalink_check ? $passed++ : $warnings++;

        // Check 7: Timezone Configuration
        $timezone = get_option('timezone_string');
        $gmt_offset = get_option('gmt_offset');
        $timezone_check = !empty($timezone) || $gmt_offset != 0;
        $checks[] = [
            'name' => 'Timezone Configuration',
            'status' => $timezone_check ? 'pass' : 'warning',
            'message' => $timezone_check ? 'Timezone is configured' : 'Timezone not set',
            'detail' => "Timezone: " . ($timezone ?: "GMT offset: {$gmt_offset}")
        ];
        $timezone_check ? $passed++ : $warnings++;

        // Check 8: Media Organization
        $uploads_use_yearmonth = get_option('uploads_use_yearmonth_folders');
        $checks[] = [
            'name' => 'Media Organization',
            'status' => $uploads_use_yearmonth ? 'pass' : 'warning',
            'message' => $uploads_use_yearmonth ? 'Uploads organized by date' : 'Date-based organization not enabled',
            'detail' => $uploads_use_yearmonth ? 'Files will be organized in year/month folders ✓' : 'Consider enabling for better organization'
        ];
        $uploads_use_yearmonth ? $passed++ : $warnings++;

        // Check 9: Database Connection
        $db_check = $wpdb->check_connection();
        $checks[] = [
            'name' => 'Database Connection',
            'status' => $db_check ? 'pass' : 'fail',
            'message' => $db_check ? 'Database connection successful' : 'Database connection failed',
            'detail' => $db_check ? 'WordPress can communicate with the database ✓' : 'Check database credentials'
        ];
        $db_check ? $passed++ : $failed++;

        // Check 10: File Editing Disabled
        $file_edit_disabled = defined('DISALLOW_FILE_EDIT') && DISALLOW_FILE_EDIT;
        $checks[] = [
            'name' => 'File Editing Security',
            'status' => $file_edit_disabled ? 'pass' : 'warning',
            'message' => $file_edit_disabled ? 'File editing disabled in admin' : 'File editing is enabled',
            'detail' => $file_edit_disabled ? 'Security hardening applied ✓' : 'Add DISALLOW_FILE_EDIT to wp-config.php'
        ];
        $file_edit_disabled ? $passed++ : $warnings++;

        // Check 11: wp-config.php permissions
        $wp_config_path = ABSPATH . 'wp-config.php';
        $wp_config_perms = substr(sprintf('%o', fileperms($wp_config_path)), -3);
        $perms_check = in_array($wp_config_perms, ['600', '640', '644']);
        $checks[] = [
            'name' => 'wp-config.php Permissions',
            'status' => $perms_check ? 'pass' : 'warning',
            'message' => "Current permissions: {$wp_config_perms}",
            'detail' => $perms_check ? 'File permissions are secure ✓' : 'Consider setting to 600 for better security'
        ];
        $perms_check ? $passed++ : $warnings++;

        // Check 12: .htaccess exists
        $htaccess_exists = file_exists(ABSPATH . '.htaccess');
        $checks[] = [
            'name' => '.htaccess File',
            'status' => $htaccess_exists ? 'pass' : 'warning',
            'message' => $htaccess_exists ? '.htaccess file exists' : '.htaccess file not found',
            'detail' => $htaccess_exists ? 'Rewrite rules can be applied ✓' : 'May be needed for permalinks and security'
        ];
        $htaccess_exists ? $passed++ : $warnings++;

        // Check 13: Memory Limit
        $memory_limit = ini_get('memory_limit');
        $memory_value = intval($memory_limit);
        $memory_check = $memory_value >= 256;
        $checks[] = [
            'name' => 'PHP Memory Limit',
            'status' => $memory_check ? 'pass' : 'warning',
            'message' => "Memory limit: {$memory_limit}",
            'detail' => $memory_check ? 'Sufficient memory allocated ✓' : 'Consider increasing to 256M or higher'
        ];
        $memory_check ? $passed++ : $warnings++;

        // Display Summary
        $total = count($checks);
        ?>

        <div class="summary">
            <h3>Verification Summary</h3>
            <p><strong>Total Checks:</strong> <?php echo $total; ?></p>
            <p><strong>Passed:</strong> <?php echo $passed; ?> | <strong>Failed:</strong> <?php echo $failed; ?> | <strong>Warnings:</strong> <?php echo $warnings; ?></p>
            <?php if ($failed === 0): ?>
                <p style="font-size: 1.2em;">✓ All critical requirements met!</p>
            <?php else: ?>
                <p style="font-size: 1.2em;">⚠ Please address failed checks before proceeding.</p>
            <?php endif; ?>
        </div>

        <h2>Detailed Results</h2>

        <?php foreach ($checks as $check): ?>
            <div class="check-item <?php echo $check['status']; ?>">
                <div>
                    <span class="status <?php echo $check['status']; ?>">
                        <?php 
                        echo $check['status'] === 'pass' ? '✓ PASS' : 
                             ($check['status'] === 'fail' ? '✗ FAIL' : '⚠ WARNING'); 
                        ?>
                    </span>
                    <strong><?php echo $check['name']; ?></strong>
                </div>
                <div class="detail">
                    <?php echo $check['message']; ?><br>
                    <?php echo $check['detail']; ?>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="warning-box">
            <strong>⚠ Security Notice:</strong> Please delete this verification script (verify-wordpress-setup.php) after reviewing the results. Leaving it accessible could pose a security risk.
        </div>

        <h2>Next Steps</h2>
        <ol>
            <li>Address any failed checks above</li>
            <li>Review and resolve warnings if possible</li>
            <li><strong>Delete this verification script</strong></li>
            <li>Proceed to Task 2: Install and configure theme and essential plugins</li>
        </ol>

        <p><em>Task 1 Requirements Reference: 8.1 (SSL/HTTPS enforcement)</em></p>
    </div>
</body>
</html>
