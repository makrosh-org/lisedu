<?php
/**
 * Create Admission Inquiry Form - Fixed Version
 * Fixes form submission issues and updates currency to Taka
 * 
 * Run: php create-admission-form-fixed.php
 */

// Load WordPress
require_once __DIR__ . '/wp-load.php';

// Check if Contact Form 7 is active
if (!function_exists('wpcf7_contact_form')) {
    die("Error: Contact Form 7 plugin is not active. Please install and activate it first.\n");
}

// Check if Flamingo is active (for storing submissions)
if (!class_exists('Flamingo_Contact')) {
    echo "Warning: Flamingo plugin is not active. Form submissions won't be stored in database.\n";
    echo "Install Flamingo plugin to store form submissions.\n\n";
}

echo "Creating Lumina Admission Inquiry Form...\n\n";

// Delete existing form if it exists
$existing_forms = get_posts(array(
    'post_type' => 'wpcf7_contact_form',
    'title' => 'Lumina Admission Inquiry Form',
    'posts_per_page' => 1
));

if (!empty($existing_forms)) {
    wp_delete_post($existing_forms[0]->ID, true);
    echo "Deleted existing admission form.\n";
}

// Form HTML with all fields
$form_html = <<<'FORM'
<div class="lumina-admission-form">
    <div class="form-section">
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
            [tel* parent-phone id:parent-phone class:form-control placeholder "+880 1XXX-XXXXXX"]
        </div>
    </div>
    
    <div class="form-section">
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
            [select* grade-level id:grade-level class:form-control "Select Grade Level" "Play Group (Ages 2-3)" "Nursery (Ages 3-4)" "Kindergarten (Ages 4-5)" "Grade 1 (Ages 5-6)" "Grade 2 (Ages 6-7)" "Grade 3 (Ages 7-8)" "Grade 4 (Ages 8-9)" "Grade 5 (Ages 9-10)"]
        </div>
        
        <div class="form-row">
            <label for="start-date">Preferred Start Date *</label>
            [date* start-date id:start-date class:form-control]
        </div>
    </div>
    
    <div class="form-section">
        <h3 class="form-section-title">Additional Information</h3>
        
        <div class="form-row">
            <label for="student-photo">Student Photo (Optional)</label>
            [file student-photo id:student-photo class:form-control limit:2mb filetypes:jpg|jpeg|png|pdf]
            <small style="color: #666; font-size: 0.85rem; display: block; margin-top: 5px;">Maximum file size: 2MB. Accepted formats: JPG, PNG, PDF</small>
        </div>
        
        <div class="form-row">
            <label for="comments">Additional Comments or Questions</label>
            [textarea comments id:comments class:form-control placeholder rows:5]
        </div>
    </div>
    
    <div class="captcha-row">
        [recaptcha]
    </div>
    
    <div class="submit-row">
        [submit class:btn-primary "SUBMIT INQUIRY"]
    </div>
</div>
FORM;

// Mail template for admissions office
$mail_body = <<<'MAIL'
New Admission Inquiry Received

PARENT/GUARDIAN INFORMATION:
Name: [parent-name]
Email: [parent-email]
Phone: [parent-phone]

STUDENT INFORMATION:
Student Name: [student-name]
Age: [student-age] years
Grade Level: [grade-level]
Preferred Start Date: [start-date]
Student Photo: [student-photo]

ADDITIONAL COMMENTS:
[comments]

---
Submitted on: [_date] at [_time]
From IP: [_remote_ip]
User Agent: [_user_agent]
MAIL;

// Confirmation email for parents
$mail2_body = <<<'MAIL2'
Dear [parent-name],

Thank you for your interest in Lumina International School!

We have received your admission inquiry for [student-name]. Here's a summary of the information you submitted:

STUDENT DETAILS:
- Name: [student-name]
- Age: [student-age] years
- Grade Level: [grade-level]
- Preferred Start Date: [start-date]

YOUR CONTACT INFORMATION:
- Email: [parent-email]
- Phone: [parent-phone]

NEXT STEPS:
1. Our admissions team will review your inquiry
2. You will receive a response within 1-2 business days
3. We may contact you to schedule a campus tour
4. You'll receive information about our admission process and requirements

If you have any urgent questions, please contact our admissions office:
- Email: admissions@luminaschool.edu
- Phone: +880 1XXX-XXXXXX

We look forward to welcoming your family to Lumina International School!

Best regards,
Lumina International School Admissions Team

---
This is an automated confirmation email. Please do not reply to this message.
MAIL2;

// Create the contact form
$contact_form = WPCF7_ContactForm::get_template();
$properties = $contact_form->get_properties();

// Set form properties
$properties['title'] = 'Lumina Admission Inquiry Form';
$properties['form'] = $form_html;

// Configure main mail (to admissions office)
$properties['mail']['subject'] = '[Lumina School] New Admission Inquiry - [student-name]';
$properties['mail']['sender'] = '[parent-name] <[parent-email]>';
$properties['mail']['recipient'] = get_option('admin_email');
$properties['mail']['body'] = $mail_body;
$properties['mail']['additional_headers'] = 'Reply-To: [parent-email]';

// Configure confirmation mail (to parent)
$properties['mail_2']['active'] = true;
$properties['mail_2']['subject'] = 'Thank you for your admission inquiry - Lumina International School';
$properties['mail_2']['sender'] = 'Lumina International School <noreply@luminaschool.edu>';
$properties['mail_2']['recipient'] = '[parent-email]';
$properties['mail_2']['body'] = $mail2_body;
$properties['mail_2']['additional_headers'] = '';

// Custom messages
$properties['messages']['mail_sent_ok'] = 'Thank you for your admission inquiry! We have received your information and will contact you within 1-2 business days. A confirmation email has been sent to your email address.';
$properties['messages']['mail_sent_ng'] = 'There was an error submitting your inquiry. Please try again or contact our admissions office directly at admissions@luminaschool.edu';
$properties['messages']['validation_error'] = 'One or more fields have an error. Please check and try again.';
$properties['messages']['spam'] = 'Your submission was flagged as spam. Please try again or contact us directly.';
$properties['messages']['accept_terms'] = 'You must accept the terms and conditions before submitting.';
$properties['messages']['invalid_required'] = 'This field is required.';
$properties['messages']['invalid_too_long'] = 'This field is too long.';
$properties['messages']['invalid_too_short'] = 'This field is too short.';
$properties['messages']['invalid_email'] = 'Please enter a valid email address.';
$properties['messages']['invalid_tel'] = 'Please enter a valid phone number.';
$properties['messages']['invalid_number'] = 'Please enter a valid number.';
$properties['messages']['invalid_date'] = 'Please enter a valid date.';
$properties['messages']['upload_failed'] = 'There was an error uploading the file.';
$properties['messages']['upload_file_type_invalid'] = 'This file type is not allowed.';
$properties['messages']['upload_file_too_large'] = 'The file is too large. Maximum size is 2MB.';
$properties['messages']['upload_failed_php_error'] = 'There was an error uploading the file.';

$contact_form->set_properties($properties);
$contact_form->save();

$form_id = $contact_form->id();

echo "✓ Admission form created successfully!\n";
echo "  Form ID: $form_id\n";
echo "  Form Title: Lumina Admission Inquiry Form\n\n";

echo "SHORTCODE TO USE:\n";
echo "[contact-form-7 id=\"$form_id\" title=\"Lumina Admission Inquiry Form\"]\n\n";

echo "NEXT STEPS:\n";
echo "1. Configure reCAPTCHA in Contact Form 7 > Integration\n";
echo "2. Install Flamingo plugin to store submissions\n";
echo "3. Add the shortcode to your Admissions page\n";
echo "4. Test the form submission\n";
echo "5. Check email delivery\n\n";

echo "Form creation complete!\n";
