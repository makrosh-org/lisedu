<?php
/**
 * Configure Elementor Global Settings and Templates
 * 
 * This script initializes Elementor configuration for Lumina International School
 * Run this script once to set up all global settings and templates
 */

// Load WordPress
define('WP_USE_THEMES', false);
require_once(__DIR__ . '/../wp-load.php');

// Check if Elementor is active
if (!is_plugin_active('elementor/elementor.php')) {
    echo "Error: Elementor plugin is not active.\n";
    exit(1);
}

echo "=== Lumina Elementor Configuration ===\n\n";

// Reset configuration flag to force re-run
delete_option('lumina_elementor_configured');
delete_option('lumina_elementor_notice_dismissed');

echo "Step 1: Configuring global color palette...\n";
lumina_configure_elementor_colors();
echo "✓ Brand colors configured\n\n";

echo "Step 2: Configuring typography settings...\n";
lumina_configure_elementor_typography();
echo "✓ Typography configured\n\n";

echo "Step 3: Configuring button styles...\n";
lumina_configure_elementor_buttons();
echo "✓ Button styles configured\n\n";

echo "Step 4: Configuring default spacing...\n";
lumina_configure_elementor_spacing();
echo "✓ Spacing defaults configured\n\n";

echo "Step 5: Creating header template...\n";
$header_id = lumina_create_header_template();
if ($header_id) {
    echo "✓ Header template created (ID: $header_id)\n\n";
} else {
    echo "✗ Failed to create header template\n\n";
}

echo "Step 6: Creating footer template...\n";
$footer_id = lumina_create_footer_template();
if ($footer_id) {
    echo "✓ Footer template created (ID: $footer_id)\n\n";
} else {
    echo "✗ Failed to create footer template\n\n";
}

echo "Step 7: Creating team member card template...\n";
$team_id = lumina_create_team_member_template();
if ($team_id) {
    echo "✓ Team member card template created (ID: $team_id)\n\n";
} else {
    echo "✗ Failed to create team member card template\n\n";
}

echo "Step 8: Creating program card template...\n";
$program_id = lumina_create_program_card_template();
if ($program_id) {
    echo "✓ Program card template created (ID: $program_id)\n\n";
} else {
    echo "✗ Failed to create program card template\n\n";
}

echo "Step 9: Creating event card template...\n";
$event_id = lumina_create_event_card_template();
if ($event_id) {
    echo "✓ Event card template created (ID: $event_id)\n\n";
} else {
    echo "✗ Failed to create event card template\n\n";
}

// Mark configuration as complete
update_option('lumina_elementor_configured', true);

echo "\n=== Configuration Complete ===\n";
echo "All Elementor global settings and templates have been configured.\n";
echo "You can now use these templates in Elementor by inserting them from the template library.\n\n";

echo "Templates created:\n";
echo "- Header Template (ID: $header_id)\n";
echo "- Footer Template (ID: $footer_id)\n";
echo "- Team Member Card (ID: $team_id)\n";
echo "- Program Card (ID: $program_id)\n";
echo "- Event Card (ID: $event_id)\n\n";

echo "Next steps:\n";
echo "1. Log into WordPress admin\n";
echo "2. Go to Elementor > Settings to verify global colors and typography\n";
echo "3. Edit any page with Elementor to see the configured settings\n";
echo "4. Use the templates from the Elementor template library\n";
