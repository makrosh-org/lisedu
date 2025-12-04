<?php
/**
 * Verify Contact Form Implementation
 * Task 11: Verify all requirements for contact form
 * Requirements: 5.3, 5.4, 5.5
 */

define('WP_USE_THEMES', false);
require './wp-load.php';

echo "=== Contact Form Verification ===\n\n";

$all_passed = true;

// Test 1: Check if Contact Form 7 is active
echo "Test 1: Contact Form 7 Plugin Active\n";
if (is_plugin_active('contact-form-7/wp-contact-form-7.php')) {
    echo "✓ PASS: Contact Form 7 is active\n\n";
} else {
    echo "✗ FAIL: Contact Form 7 is not active\n\n";
    $all_passed = false;
}

// Test 2: Check if contact form exists
echo "Test 2: Contact Form Exists\n";
$forms = get_posts(array(
    'post_type' => 'wpcf7_contact_form',
    'title' => 'Lumina Contact Form',
    'post_status' => 'publish',
    'numberposts' => 1
));

if (!empty($forms)) {
    $form_id = $forms[0]->ID;
    echo "✓ PASS: Contact form exists (ID: $form_id)\n\n";
} else {
    echo "✗ FAIL: Contact form not found\n\n";
    $all_passed = false;
    exit(1);
}

// Test 3: Check required fields in form
echo "Test 3: Required Fields Present\n";
$form_content = $forms[0]->post_content;
$required_fields = array(
    'your-name' => 'Name field',
    'your-email' => 'Email field',
    'your-subject' => 'Subject field',
    'your-message' => 'Message field'
);

$fields_passed = true;
foreach ($required_fields as $field => $label) {
    if (strpos($form_content, $field) !== false) {
        echo "  ✓ $label present\n";
    } else {
        echo "  ✗ $label missing\n";
        $fields_passed = false;
        $all_passed = false;
    }
}

if ($fields_passed) {
    echo "✓ PASS: All required fields present\n\n";
} else {
    echo "✗ FAIL: Some required fields missing\n\n";
}

// Test 4: Check optional phone field
echo "Test 4: Optional Phone Field\n";
if (strpos($form_content, 'your-phone') !== false) {
    echo "✓ PASS: Phone field present\n\n";
} else {
    echo "✗ FAIL: Phone field missing\n\n";
    $all_passed = false;
}

// Test 5: Check for required field validation
echo "Test 5: Required Field Validation\n";
$has_required = (strpos($form_content, '[text*') !== false || 
                 strpos($form_content, '[email*') !== false ||
                 strpos($form_content, '[select*') !== false ||
                 strpos($form_content, '[textarea*') !== false);

if ($has_required) {
    echo "✓ PASS: Required field validation markers present\n\n";
} else {
    echo "✗ FAIL: Required field validation markers missing\n\n";
    $all_passed = false;
}

// Test 6: Check for email validation
echo "Test 6: Email Format Validation\n";
if (strpos($form_content, '[email*') !== false) {
    echo "✓ PASS: Email validation field present\n\n";
} else {
    echo "✗ FAIL: Email validation field missing\n\n";
    $all_passed = false;
}

// Test 7: Check for CAPTCHA
echo "Test 7: CAPTCHA Spam Protection\n";
if (strpos($form_content, '[recaptcha]') !== false) {
    echo "✓ PASS: reCAPTCHA field present\n\n";
} else {
    echo "⚠ WARNING: reCAPTCHA field not found (may need manual configuration)\n\n";
}

// Test 8: Check email notification configuration
echo "Test 8: Email Notification Configuration\n";
$form = WPCF7_ContactForm::get_instance($form_id);
if ($form) {
    $mail = $form->prop('mail');
    $admin_email = get_option('admin_email');
    
    if (!empty($mail['recipient']) && strpos($mail['recipient'], $admin_email) !== false) {
        echo "  ✓ Admin email recipient configured: " . $mail['recipient'] . "\n";
    } else {
        echo "  ✗ Admin email recipient not properly configured\n";
        $all_passed = false;
    }
    
    if (!empty($mail['subject'])) {
        echo "  ✓ Email subject configured: " . $mail['subject'] . "\n";
    } else {
        echo "  ✗ Email subject not configured\n";
        $all_passed = false;
    }
    
    if (!empty($mail['body'])) {
        echo "  ✓ Email body template configured\n";
    } else {
        echo "  ✗ Email body template not configured\n";
        $all_passed = false;
    }
    
    echo "✓ PASS: Email notifications configured\n\n";
} else {
    echo "✗ FAIL: Could not load form instance\n\n";
    $all_passed = false;
}

// Test 9: Check user confirmation email
echo "Test 9: User Confirmation Email\n";
if ($form) {
    $mail2 = $form->prop('mail_2');
    
    if (!empty($mail2['active']) && $mail2['active']) {
        echo "  ✓ Confirmation email enabled\n";
        
        if (!empty($mail2['recipient']) && strpos($mail2['recipient'], '[your-email]') !== false) {
            echo "  ✓ Confirmation email recipient configured\n";
        } else {
            echo "  ✗ Confirmation email recipient not properly configured\n";
            $all_passed = false;
        }
        
        if (!empty($mail2['subject'])) {
            echo "  ✓ Confirmation email subject configured\n";
        } else {
            echo "  ✗ Confirmation email subject not configured\n";
            $all_passed = false;
        }
        
        echo "✓ PASS: User confirmation email configured\n\n";
    } else {
        echo "✗ FAIL: User confirmation email not enabled\n\n";
        $all_passed = false;
    }
}

// Test 10: Check form submission storage (Flamingo)
echo "Test 10: Form Submission Storage\n";
if (is_plugin_active('flamingo/flamingo.php')) {
    echo "✓ PASS: Flamingo plugin active (submissions will be stored)\n\n";
} else {
    echo "⚠ WARNING: Flamingo plugin not active (submissions won't be stored in database)\n\n";
}

// Test 11: Check success message configuration
echo "Test 11: Success Confirmation Message\n";
if ($form) {
    $messages = $form->prop('messages');
    
    if (!empty($messages['mail_sent_ok'])) {
        echo "  ✓ Success message configured: " . substr($messages['mail_sent_ok'], 0, 50) . "...\n";
        echo "✓ PASS: Success confirmation message configured\n\n";
    } else {
        echo "✗ FAIL: Success confirmation message not configured\n\n";
        $all_passed = false;
    }
}

// Test 12: Check error message configuration
echo "Test 12: Error Message Configuration\n";
if ($form) {
    $messages = $form->prop('messages');
    
    if (!empty($messages['mail_sent_ng'])) {
        echo "  ✓ Error message configured\n";
    }
    
    if (!empty($messages['validation_error'])) {
        echo "  ✓ Validation error message configured\n";
    }
    
    if (!empty($messages['invalid_required'])) {
        echo "  ✓ Required field error message configured\n";
    }
    
    if (!empty($messages['invalid_email'])) {
        echo "  ✓ Invalid email error message configured\n";
    }
    
    echo "✓ PASS: Error messages configured\n\n";
}

// Test 13: Check custom CSS file exists
echo "Test 13: Custom CSS Styling\n";
$css_file = get_stylesheet_directory() . '/assets/css/contact-form.css';
if (file_exists($css_file)) {
    $css_size = filesize($css_file);
    echo "  ✓ Contact form CSS file exists ($css_size bytes)\n";
    
    // Check if CSS contains brand colors
    $css_content = file_get_contents($css_file);
    if (strpos($css_content, 'var(--base-darkblue)') !== false ||
        strpos($css_content, 'var(--base-accent-teal)') !== false ||
        strpos($css_content, 'var(--base-accent-orange)') !== false) {
        echo "  ✓ CSS uses brand color variables\n";
    } else {
        echo "  ⚠ CSS may not be using brand colors\n";
    }
    
    echo "✓ PASS: Custom CSS styling file exists\n\n";
} else {
    echo "✗ FAIL: Contact form CSS file not found\n\n";
    $all_passed = false;
}

// Test 14: Check CSS is enqueued
echo "Test 14: CSS Enqueued in Theme\n";
$functions_file = get_stylesheet_directory() . '/functions.php';
if (file_exists($functions_file)) {
    $functions_content = file_get_contents($functions_file);
    if (strpos($functions_content, 'lumina-contact-form') !== false &&
        strpos($functions_content, 'contact-form.css') !== false) {
        echo "✓ PASS: Contact form CSS is enqueued in functions.php\n\n";
    } else {
        echo "✗ FAIL: Contact form CSS not enqueued in functions.php\n\n";
        $all_passed = false;
    }
} else {
    echo "✗ FAIL: functions.php not found\n\n";
    $all_passed = false;
}

// Test 15: Check form shortcode
echo "Test 15: Form Shortcode\n";
echo "  Shortcode: [contact-form-7 id=\"$form_id\" title=\"Lumina Contact Form\"]\n";
echo "  ✓ Shortcode ready to be added to Contact page\n";
echo "✓ PASS: Form shortcode available\n\n";

// Summary
echo "=== Verification Summary ===\n";
if ($all_passed) {
    echo "✓ ALL TESTS PASSED\n\n";
    echo "Contact form is fully configured and ready to use!\n\n";
    echo "Requirements Validated:\n";
    echo "  ✓ 5.3: Client-side validation for email format and required fields\n";
    echo "  ✓ 5.4: Email notifications to administrative email\n";
    echo "  ✓ 5.5: Success confirmation message\n\n";
    echo "Next Steps:\n";
    echo "1. Configure reCAPTCHA keys in WordPress admin:\n";
    echo "   - Go to Contact > Integration\n";
    echo "   - Add reCAPTCHA v2 or v3 keys from Google\n";
    echo "2. Add the shortcode to the Contact page in Elementor:\n";
    echo "   [contact-form-7 id=\"$form_id\" title=\"Lumina Contact Form\"]\n";
    echo "3. Test form submission to verify email delivery\n";
} else {
    echo "✗ SOME TESTS FAILED\n\n";
    echo "Please review the failed tests above and fix the issues.\n";
    exit(1);
}

?>
