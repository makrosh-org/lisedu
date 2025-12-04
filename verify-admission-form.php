<?php
/**
 * Verify Admission Inquiry Form Implementation
 * Task 13: Verify admission form creation and configuration
 * Requirements: 2.3, 2.4, 2.5
 */

define('WP_USE_THEMES', false);
require './wp-load.php';

echo "=== Verifying Admission Inquiry Form ===\n\n";

$all_checks_passed = true;

// Check 1: Contact Form 7 plugin is active
echo "1. Checking Contact Form 7 plugin...\n";
if (is_plugin_active('contact-form-7/wp-contact-form-7.php')) {
    echo "   ✓ Contact Form 7 is active\n";
} else {
    echo "   ✗ Contact Form 7 is NOT active\n";
    $all_checks_passed = false;
}

// Check 2: Admission form exists
echo "\n2. Checking admission inquiry form...\n";
$forms = get_posts(array(
    'post_type' => 'wpcf7_contact_form',
    'title' => 'Lumina Admission Inquiry Form',
    'post_status' => 'publish',
    'numberposts' => 1
));

if (!empty($forms)) {
    $form_id = $forms[0]->ID;
    echo "   ✓ Admission inquiry form exists (ID: $form_id)\n";
    
    // Check 3: Form content has required fields
    echo "\n3. Checking form fields...\n";
    $form_content = $forms[0]->post_content;
    
    $required_fields = array(
        'parent-name' => 'Parent/Guardian Name',
        'parent-email' => 'Parent Email',
        'parent-phone' => 'Parent Phone',
        'student-name' => 'Student Name',
        'student-age' => 'Student Age',
        'grade-level' => 'Grade Level',
        'start-date' => 'Preferred Start Date',
        'comments' => 'Additional Comments',
        'recaptcha' => 'CAPTCHA'
    );
    
    foreach ($required_fields as $field => $label) {
        if (strpos($form_content, $field) !== false) {
            echo "   ✓ $label field present\n";
        } else {
            echo "   ✗ $label field MISSING\n";
            $all_checks_passed = false;
        }
    }
    
    // Check 4: Form configuration
    echo "\n4. Checking form configuration...\n";
    $form = WPCF7_ContactForm::get_instance($form_id);
    
    if ($form) {
        // Check mail settings (to admissions office)
        $mail = $form->prop('mail');
        if (!empty($mail['recipient'])) {
            echo "   ✓ Admin notification email configured: " . $mail['recipient'] . "\n";
        } else {
            echo "   ✗ Admin notification email NOT configured\n";
            $all_checks_passed = false;
        }
        
        // Check mail 2 settings (confirmation to applicant)
        $mail2 = $form->prop('mail_2');
        if (!empty($mail2['active']) && $mail2['active']) {
            echo "   ✓ Applicant confirmation email enabled\n";
            if (strpos($mail2['recipient'], '[parent-email]') !== false) {
                echo "   ✓ Confirmation email recipient set to parent email\n";
            } else {
                echo "   ✗ Confirmation email recipient NOT set correctly\n";
                $all_checks_passed = false;
            }
        } else {
            echo "   ✗ Applicant confirmation email NOT enabled\n";
            $all_checks_passed = false;
        }
        
        // Check messages
        $messages = $form->prop('messages');
        if (!empty($messages['mail_sent_ok'])) {
            echo "   ✓ Success message configured\n";
        } else {
            echo "   ✗ Success message NOT configured\n";
            $all_checks_passed = false;
        }
        
        // Check Flamingo integration
        $additional_settings = $form->prop('additional_settings');
        if (strpos($additional_settings, 'flamingo_email') !== false) {
            echo "   ✓ Flamingo integration configured for database storage\n";
        } else {
            echo "   ⚠ Flamingo integration not configured (submissions may not be stored)\n";
        }
        
    } else {
        echo "   ✗ Could not load form instance\n";
        $all_checks_passed = false;
    }
    
    // Check 5: Flamingo plugin for form storage
    echo "\n5. Checking form submission storage...\n";
    if (is_plugin_active('flamingo/flamingo.php')) {
        echo "   ✓ Flamingo plugin is active (submissions will be stored)\n";
    } else {
        echo "   ⚠ Flamingo plugin is NOT active (submissions will not be stored in database)\n";
        echo "   Note: Email notifications will still work\n";
    }
    
    // Check 6: CSS file exists
    echo "\n6. Checking admission form CSS...\n";
    $css_path = get_stylesheet_directory() . '/assets/css/admission-form.css';
    if (file_exists($css_path)) {
        echo "   ✓ Admission form CSS file exists\n";
        
        // Check if CSS is enqueued
        $functions_file = get_stylesheet_directory() . '/functions.php';
        $functions_content = file_get_contents($functions_file);
        if (strpos($functions_content, 'lumina-admission-form') !== false) {
            echo "   ✓ Admission form CSS is enqueued in functions.php\n";
        } else {
            echo "   ✗ Admission form CSS is NOT enqueued in functions.php\n";
            $all_checks_passed = false;
        }
    } else {
        echo "   ✗ Admission form CSS file does NOT exist\n";
        $all_checks_passed = false;
    }
    
    // Check 7: Form shortcode
    echo "\n7. Form shortcode information:\n";
    echo "   Shortcode: [contact-form-7 id=\"$form_id\" title=\"Lumina Admission Inquiry Form\"]\n";
    echo "   Add this shortcode to the Admissions page to display the form\n";
    
    // Check 8: Validation features
    echo "\n8. Checking validation features...\n";
    $validation_checks = array(
        'required fields' => (preg_match('/\[(?:text|email|tel|number|date|select)\*/', $form_content) > 0),
        'email validation' => (strpos($form_content, '[email*') !== false),
        'phone validation' => (strpos($form_content, '[tel*') !== false),
        'number validation' => (strpos($form_content, '[number*') !== false),
        'date validation' => (strpos($form_content, '[date*') !== false),
        'CAPTCHA protection' => (strpos($form_content, 'recaptcha') !== false)
    );
    
    foreach ($validation_checks as $check => $passed) {
        if ($passed) {
            echo "   ✓ " . ucfirst($check) . " enabled\n";
        } else {
            echo "   ⚠ " . ucfirst($check) . " may not be enabled\n";
            // Don't fail for these checks as they might be configured differently
        }
    }
    
} else {
    echo "   ✗ Admission inquiry form does NOT exist\n";
    $all_checks_passed = false;
}

// Summary
echo "\n" . str_repeat("=", 50) . "\n";
if ($all_checks_passed) {
    echo "✓ ALL CHECKS PASSED\n";
    echo "\nAdmission inquiry form is properly configured!\n";
    echo "\nNext Steps:\n";
    echo "1. Configure reCAPTCHA keys in Contact Form 7 settings (if not already done)\n";
    echo "2. Add the form shortcode to the Admissions page\n";
    echo "3. Test form submission and verify email delivery\n";
    echo "4. Check that submissions are stored in Flamingo (if plugin is active)\n";
} else {
    echo "✗ SOME CHECKS FAILED\n";
    echo "\nPlease review the errors above and run create-admission-form.php if needed.\n";
}
echo str_repeat("=", 50) . "\n";

?>
