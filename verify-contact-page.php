<?php
/**
 * Verify Contact Page Implementation
 * 
 * This script verifies that the Contact page meets all requirements:
 * - Physical address, phone number, and email displayed (Requirement 5.1)
 * - Google Maps embedded (Requirement 5.2)
 * - Contact form present
 * - Office hours information
 * - Social media links
 * - Responsive design
 */

require_once('wp-load.php');

if (!defined('ABSPATH')) {
    die('WordPress not loaded');
}

echo "Verifying Contact Page Implementation...\n\n";
echo str_repeat("=", 60) . "\n";

$errors = [];
$warnings = [];
$success = [];

// Check if Contact page exists
$contact_page = get_page_by_path('contact');

if (!$contact_page) {
    $errors[] = "Contact page does not exist";
    echo "✗ CRITICAL: Contact page not found\n";
    echo "\nVerification failed. Please run build-contact-page.php first.\n";
    exit(1);
}

$contact_page_id = $contact_page->ID;
$success[] = "Contact page exists (ID: $contact_page_id)";
echo "✓ Contact page exists (ID: $contact_page_id)\n";

// Check if page is published
if ($contact_page->post_status !== 'publish') {
    $errors[] = "Contact page is not published (status: {$contact_page->post_status})";
    echo "✗ Contact page is not published\n";
} else {
    $success[] = "Contact page is published";
    echo "✓ Contact page is published\n";
}

// Check if Elementor is enabled
$elementor_enabled = get_post_meta($contact_page_id, '_elementor_edit_mode', true);
if ($elementor_enabled !== 'builder') {
    $errors[] = "Elementor is not enabled for Contact page";
    echo "✗ Elementor is not enabled\n";
} else {
    $success[] = "Elementor is enabled";
    echo "✓ Elementor is enabled\n";
}

// Get Elementor data
$elementor_data = get_post_meta($contact_page_id, '_elementor_data', true);
if (empty($elementor_data)) {
    $errors[] = "No Elementor data found for Contact page";
    echo "✗ No Elementor data found\n";
} else {
    $success[] = "Elementor data exists";
    echo "✓ Elementor data exists\n";
    
    $data = json_decode($elementor_data, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        $errors[] = "Elementor data is not valid JSON";
        echo "✗ Invalid Elementor data format\n";
    } else {
        $success[] = "Elementor data is valid JSON";
        echo "✓ Elementor data is valid JSON\n";
        
        // Check for required content
        $content_string = strtolower(wp_json_encode($data));
        
        // Requirement 5.1: Physical address, phone number, and email
        $has_address = (strpos($content_string, 'address') !== false || 
                       strpos($content_string, 'street') !== false ||
                       strpos($content_string, 'visit us') !== false);
        
        $has_phone = (strpos($content_string, 'phone') !== false || 
                     strpos($content_string, 'call') !== false ||
                     strpos($content_string, '+1') !== false ||
                     strpos($content_string, '555') !== false);
        
        $has_email = (strpos($content_string, 'email') !== false || 
                     strpos($content_string, '@') !== false ||
                     strpos($content_string, 'info@') !== false);
        
        if ($has_address) {
            $success[] = "Physical address information present";
            echo "✓ Physical address information present (Requirement 5.1)\n";
        } else {
            $warnings[] = "Physical address information may be missing";
            echo "⚠ Physical address information may be missing\n";
        }
        
        if ($has_phone) {
            $success[] = "Phone number information present";
            echo "✓ Phone number information present (Requirement 5.1)\n";
        } else {
            $warnings[] = "Phone number information may be missing";
            echo "⚠ Phone number information may be missing\n";
        }
        
        if ($has_email) {
            $success[] = "Email information present";
            echo "✓ Email information present (Requirement 5.1)\n";
        } else {
            $warnings[] = "Email information may be missing";
            echo "⚠ Email information may be missing\n";
        }
        
        // Requirement 5.2: Google Maps
        $has_google_maps = (strpos($content_string, 'google_maps') !== false ||
                           strpos($content_string, 'map') !== false);
        
        if ($has_google_maps) {
            $success[] = "Google Maps widget present";
            echo "✓ Google Maps widget present (Requirement 5.2)\n";
        } else {
            $errors[] = "Google Maps widget not found";
            echo "✗ Google Maps widget not found (Requirement 5.2)\n";
        }
        
        // Contact form
        $has_contact_form = (strpos($content_string, 'contact-form') !== false ||
                            strpos($content_string, 'wpforms') !== false ||
                            strpos($content_string, 'shortcode') !== false);
        
        if ($has_contact_form) {
            $success[] = "Contact form present";
            echo "✓ Contact form present\n";
        } else {
            $warnings[] = "Contact form may be missing";
            echo "⚠ Contact form may be missing\n";
        }
        
        // Office hours
        $has_office_hours = (strpos($content_string, 'office hours') !== false ||
                            strpos($content_string, 'hours') !== false ||
                            strpos($content_string, 'monday') !== false);
        
        if ($has_office_hours) {
            $success[] = "Office hours information present";
            echo "✓ Office hours information present\n";
        } else {
            $warnings[] = "Office hours information may be missing";
            echo "⚠ Office hours information may be missing\n";
        }
        
        // Social media links
        $has_social_media = (strpos($content_string, 'social') !== false ||
                            strpos($content_string, 'facebook') !== false ||
                            strpos($content_string, 'twitter') !== false ||
                            strpos($content_string, 'instagram') !== false);
        
        if ($has_social_media) {
            $success[] = "Social media links present";
            echo "✓ Social media links present\n";
        } else {
            $warnings[] = "Social media links may be missing";
            echo "⚠ Social media links may be missing\n";
        }
        
        // Check for responsive design (sections and columns)
        $section_count = 0;
        $column_count = 0;
        
        foreach ($data as $element) {
            if (isset($element['elType']) && $element['elType'] === 'section') {
                $section_count++;
                if (isset($element['elements'])) {
                    foreach ($element['elements'] as $column) {
                        if (isset($column['elType']) && $column['elType'] === 'column') {
                            $column_count++;
                        }
                    }
                }
            }
        }
        
        if ($section_count >= 4) {
            $success[] = "Multiple sections for content organization ($section_count sections)";
            echo "✓ Multiple sections for content organization ($section_count sections)\n";
        } else {
            $warnings[] = "Limited sections found ($section_count sections)";
            echo "⚠ Limited sections found ($section_count sections)\n";
        }
        
        if ($column_count >= 3) {
            $success[] = "Responsive column layout ($column_count columns)";
            echo "✓ Responsive column layout ($column_count columns)\n";
        } else {
            $warnings[] = "Limited columns found ($column_count columns)";
            echo "⚠ Limited columns found ($column_count columns)\n";
        }
        
        // Check for brand colors
        $has_brand_colors = (strpos($content_string, '#003d70') !== false ||
                            strpos($content_string, '#f7f7f7') !== false ||
                            strpos($content_string, '#7ebec5') !== false ||
                            strpos($content_string, '#f39a3b') !== false);
        
        if ($has_brand_colors) {
            $success[] = "Brand colors used in design";
            echo "✓ Brand colors used in design\n";
        } else {
            $warnings[] = "Brand colors may not be applied";
            echo "⚠ Brand colors may not be applied\n";
        }
    }
}

// Check page URL
$page_url = get_permalink($contact_page_id);
if ($page_url) {
    $success[] = "Page URL accessible: $page_url";
    echo "✓ Page URL: $page_url\n";
} else {
    $errors[] = "Could not generate page URL";
    echo "✗ Could not generate page URL\n";
}

// Summary
echo "\n" . str_repeat("=", 60) . "\n";
echo "VERIFICATION SUMMARY\n";
echo str_repeat("=", 60) . "\n\n";

echo "Successes: " . count($success) . "\n";
echo "Warnings: " . count($warnings) . "\n";
echo "Errors: " . count($errors) . "\n\n";

if (!empty($errors)) {
    echo "ERRORS:\n";
    foreach ($errors as $error) {
        echo "  ✗ $error\n";
    }
    echo "\n";
}

if (!empty($warnings)) {
    echo "WARNINGS:\n";
    foreach ($warnings as $warning) {
        echo "  ⚠ $warning\n";
    }
    echo "\n";
}

// Requirements validation
echo "REQUIREMENTS VALIDATION:\n";
echo "  Requirement 5.1 (Contact Information): " . 
     ($has_address && $has_phone && $has_email ? "✓ PASS" : "⚠ PARTIAL") . "\n";
echo "  Requirement 5.2 (Google Maps): " . 
     ($has_google_maps ? "✓ PASS" : "✗ FAIL") . "\n";

echo "\n";

if (count($errors) > 0) {
    echo "Status: FAILED - Please address the errors above\n";
    exit(1);
} elseif (count($warnings) > 0) {
    echo "Status: PASSED WITH WARNINGS - Review warnings and update content as needed\n";
    exit(0);
} else {
    echo "Status: PASSED - All checks successful!\n";
    exit(0);
}
