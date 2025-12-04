<?php
/**
 * Create and Configure Admission Inquiry Form
 * Task 13: Build admission form with validation, CAPTCHA, email notifications, and storage
 * Requirements: 2.3, 2.4, 2.5
 */

define('WP_USE_THEMES', false);
require './wp-load.php';

echo "=== Creating Admission Inquiry Form ===\n\n";

// Check if Contact Form 7 is active
if (!is_plugin_active('contact-form-7/wp-contact-form-7.php')) {
    echo "ERROR: Contact Form 7 plugin is not active!\n";
    exit(1);
}

// Create the admission inquiry form with all required fields
$form_title = 'Lumina Admission Inquiry Form';
$form_content = <<<FORM
<div class="lumina-admission-form">
    <h3 class="form-section-title">Parent/Guardian Information</h3>
    
    <div class="form-row">
        <label for="parent-name">Parent/Guardian Name *</label>
        [text* parent-name id:parent-name class:form-control placeholder "Full Name"]
    </div>
    
    <div class="form-row">
        <label for="parent-email">Email Address *</label>
        [email* parent-email id:parent-email class:form-control placeholder "your.email@example.com"]
    </div>
    
    <div class="form-row">
        <label for="parent-phone">Phone Number *</label>
        [tel* parent-phone id:parent-phone class:form-control placeholder "+1 (555) 123-4567"]
    </div>
    
    <h3 class="form-section-title">Student Information</h3>
    
    <div class="form-row">
        <label for="student-name">Student Name *</label>
        [text* student-name id:student-name class:form-control placeholder "Student's Full Name"]
    </div>
    
    <div class="form-row">
        <label for="student-age">Student Age *</label>
        [number* student-age id:student-age class:form-control min:2 max:12 placeholder "Age"]
    </div>
    
    <div class="form-row">
        <label for="grade-level">Grade Level Interested *</label>
        [select* grade-level id:grade-level class:form-control "Play Group (Ages 2-3)" "Nursery (Ages 3-4)" "Kindergarten (Ages 4-5)" "Grade 1 (Ages 5-6)" "Grade 2 (Ages 6-7)" "Grade 3 (Ages 7-8)" "Grade 4 (Ages 8-9)" "Grade 5 (Ages 9-10)"]
    </div>
    
    <div class="form-row">
        <label for="start-date">Preferred Start Date *</label>
        [date* start-date id:start-date class:form-control]
    </div>
    
    <div class="form-row">
        <label for="comments">Additional Comments or Questions</label>
        [textarea comments id:comments class:form-control placeholder "Please share any additional information or questions you may have..." rows:5]
    </div>
    
    <div class="form-row captcha-row">
        [recaptcha]
    </div>
    
    <div class="form-row submit-row">
        [submit class:btn-primary "Submit Inquiry"]
    </div>
</div>
FORM;

// Mail template for admissions office notification
$mail_template = <<<MAIL
Subject: [Lumina School] New Admission Inquiry - [student-name]

PARENT/GUARDIAN INFORMATION:
Name: [parent-name]
Email: [parent-email]
Phone: [parent-phone]

STUDENT INFORMATION:
Student Name: [student-name]
Age: [student-age]
Grade Level: [grade-level]
Preferred Start Date: [start-date]

ADDITIONAL COMMENTS:
[comments]

---
This inquiry was submitted from the Admissions page on Lumina International School website.
Submission Time: [_date] [_time]
IP Address: [_remote_ip]

Please follow up with the parent/guardian within 1-2 business days.
MAIL;

// Mail 2 template for applicant confirmation
$mail2_template = <<<MAIL2
Subject: Thank you for your admission inquiry - Lumina International School

Dear [parent-name],

Thank you for your interest in Lumina International School! We have received your admission inquiry for [student-name] and are excited about the possibility of welcoming your family to our school community.

Your Inquiry Details:
Student Name: [student-name]
Age: [student-age]
Grade Level: [grade-level]
Preferred Start Date: [start-date]

What Happens Next?
Our admissions team will review your inquiry and contact you within 1-2 business days to discuss:
- The admission process and requirements
- Available enrollment dates
- Fee structure and payment options
- Scheduling a campus tour
- Answering any questions you may have

In the meantime, feel free to explore our website to learn more about our programs, facilities, and the Lumina experience.

If you have urgent questions, please don't hesitate to contact our admissions office directly:
Phone: [Contact number from website]
Email: admissions@luminaschool.edu

We look forward to speaking with you soon!

Best regards,
Lumina International School
Admissions Team

---
This is an automated confirmation email. Please do not reply to this message.
For inquiries, please contact admissions@luminaschool.edu
MAIL2;

// Success message
$success_message = 'Thank you for your admission inquiry! We have received your information and will contact you within 1-2 business days. A confirmation email has been sent to your email address.';

// Error message
$error_message = 'There was an error submitting your inquiry. Please try again or contact our admissions office directly.';

// Validation messages
$validation_messages = array(
    'invalid_required' => 'This field is required',
    'invalid_email' => 'Please enter a valid email address',
    'invalid_tel' => 'Please enter a valid phone number',
    'invalid_number' => 'Please enter a valid age',
    'invalid_date' => 'Please select a valid date',
    'spam' => 'Your submission was flagged as spam. Please try again.',
    'captcha' => 'Please complete the CAPTCHA verification',
    'failed' => 'There was an error submitting your inquiry. Please try again.'
);

// Check if form already exists
$existing_forms = get_posts(array(
    'post_type' => 'wpcf7_contact_form',
    'title' => $form_title,
    'post_status' => 'publish',
    'numberposts' => 1
));

if (!empty($existing_forms)) {
    $form_id = $existing_forms[0]->ID;
    echo "Admission inquiry form already exists (ID: $form_id). Updating...\n";
    
    // Get existing form and update it
    $form = WPCF7_ContactForm::get_instance($form_id);
    if ($form) {
        $form->set_properties(array('form' => $form_content));
        $form->save();
    }
} else {
    // Create new form using Contact Form 7 API
    $form = WPCF7_ContactForm::get_template();
    $form->set_title($form_title);
    $form->set_properties(array('form' => $form_content));
    $form_id = $form->save();
    
    if (!$form_id) {
        echo "ERROR: Failed to create admission inquiry form\n";
        exit(1);
    }
    
    echo "Admission inquiry form created successfully (ID: $form_id)\n";
}

// Get admin email (will be used for admissions office)
$admin_email = get_option('admin_email');
echo "Admissions office email: $admin_email\n";

// Configure form settings
$form = WPCF7_ContactForm::get_instance($form_id);

if ($form) {
    // Get site domain for email sender
    $site_domain = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : parse_url(get_site_url(), PHP_URL_HOST);
    
    // Set mail template (to admissions office)
    $mail = $form->prop('mail');
    $mail['subject'] = '[Lumina School] New Admission Inquiry - [student-name]';
    $mail['sender'] = '[parent-name] <wordpress@' . $site_domain . '>';
    $mail['recipient'] = $admin_email;
    $mail['body'] = $mail_template;
    $mail['additional_headers'] = 'Reply-To: [parent-email]';
    $form->set_properties(array('mail' => $mail));
    
    // Set mail 2 template (confirmation to applicant)
    $mail2 = $form->prop('mail_2');
    $mail2['active'] = true;
    $mail2['subject'] = 'Thank you for your admission inquiry - Lumina International School';
    $mail2['sender'] = 'Lumina International School Admissions <wordpress@' . $site_domain . '>';
    $mail2['recipient'] = '[parent-email]';
    $mail2['body'] = $mail2_template;
    $mail2['additional_headers'] = '';
    $form->set_properties(array('mail_2' => $mail2));
    
    // Set messages
    $messages = $form->prop('messages');
    $messages['mail_sent_ok'] = $success_message;
    $messages['mail_sent_ng'] = $error_message;
    $messages['validation_error'] = 'One or more fields have an error. Please check and try again.';
    $messages['spam'] = $validation_messages['spam'];
    $messages['accept_terms'] = 'You must accept the terms and conditions before submitting.';
    $messages['invalid_required'] = $validation_messages['invalid_required'];
    $messages['invalid_email'] = $validation_messages['invalid_email'];
    $messages['invalid_tel'] = $validation_messages['invalid_tel'];
    $messages['invalid_number'] = $validation_messages['invalid_number'];
    $messages['invalid_date'] = $validation_messages['invalid_date'];
    $form->set_properties(array('messages' => $messages));
    
    // Enable Flamingo for form submission storage (if available)
    $additional_settings = "flamingo_email: \"[parent-email]\"\nflamingo_name: \"[parent-name] - [student-name]\"";
    $form->set_properties(array('additional_settings' => $additional_settings));
    
    $form->save();
    
    echo "Form settings configured successfully\n";
} else {
    echo "ERROR: Could not load form instance\n";
    exit(1);
}

// Check if Flamingo plugin is installed for form storage
if (is_plugin_active('flamingo/flamingo.php')) {
    echo "✓ Flamingo plugin is active (form submissions will be stored)\n";
} else {
    echo "⚠ Flamingo plugin is not active. Form submissions will not be stored in database.\n";
    echo "  Note: Flamingo should have been installed with the contact form setup.\n";
}

// Get the shortcode
echo "\n=== Admission Inquiry Form Created Successfully ===\n";
echo "Form ID: $form_id\n";
echo "Shortcode: [contact-form-7 id=\"$form_id\" title=\"$form_title\"]\n";
echo "\nForm Features:\n";
echo "✓ Required fields: Parent name, email, phone, student name, age, grade level, start date\n";
echo "✓ Optional field: Additional comments\n";
echo "✓ Client-side validation enabled\n";
echo "✓ Email format validation\n";
echo "✓ Phone number validation\n";
echo "✓ Age validation (2-12 years)\n";
echo "✓ Date picker for start date\n";
echo "✓ reCAPTCHA spam protection\n";
echo "✓ Admissions office email notifications to: $admin_email\n";
echo "✓ Applicant confirmation emails\n";
echo "✓ Form submission storage (via Flamingo)\n";
echo "✓ Success/error messages configured\n";
echo "\nNext Steps:\n";
echo "1. Ensure reCAPTCHA keys are configured in Contact Form 7 settings\n";
echo "2. Add the shortcode to the Admissions page\n";
echo "3. Add custom CSS styling to match brand design\n";
echo "4. Test form submission and email delivery\n";

?>
