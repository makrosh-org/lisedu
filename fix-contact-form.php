<?php
/**
 * Fix Contact Form Content
 * Update the form with proper field definitions
 */

define('WP_USE_THEMES', false);
require './wp-load.php';

echo "=== Fixing Contact Form ===\n\n";

// Get the form
$form_id = 63;
$form = WPCF7_ContactForm::get_instance($form_id);

if (!$form) {
    echo "ERROR: Form not found\n";
    exit(1);
}

// Correct form content with proper Contact Form 7 syntax
$form_content = <<<FORM
<div class="lumina-contact-form">
    <div class="form-row">
        <label for="contact-name">Name *</label>
        [text* your-name id:contact-name class:form-control placeholder "Your Full Name"]
    </div>
    
    <div class="form-row">
        <label for="contact-email">Email *</label>
        [email* your-email id:contact-email class:form-control placeholder "your.email@example.com"]
    </div>
    
    <div class="form-row">
        <label for="contact-phone">Phone</label>
        [tel your-phone id:contact-phone class:form-control placeholder "+1 (555) 123-4567"]
    </div>
    
    <div class="form-row">
        <label for="contact-subject">Subject *</label>
        [select* your-subject id:contact-subject class:form-control "General Inquiry" "Admissions Question" "Program Information" "Facilities Tour Request" "Other"]
    </div>
    
    <div class="form-row">
        <label for="contact-message">Message *</label>
        [textarea* your-message id:contact-message class:form-control placeholder "Please enter your message here..." rows:6]
    </div>
    
    <div class="form-row captcha-row">
        [recaptcha]
    </div>
    
    <div class="form-row submit-row">
        [submit class:btn-primary "Send Message"]
    </div>
</div>
FORM;

// Update the form
$properties = $form->get_properties();
$properties['form'] = $form_content;
$form->set_properties($properties);
$form->save();

echo "✓ Form content updated successfully\n";
echo "\nForm now includes:\n";
echo "  - Name field (required)\n";
echo "  - Email field (required, with validation)\n";
echo "  - Phone field (optional)\n";
echo "  - Subject dropdown (required)\n";
echo "  - Message textarea (required)\n";
echo "  - reCAPTCHA field\n";
echo "  - Submit button\n";

echo "\nVerifying form content...\n";
$updated_form = WPCF7_ContactForm::get_instance($form_id);
$updated_content = $updated_form->prop('form');

if (strpos($updated_content, '[text* your-name') !== false) {
    echo "✓ Name field verified\n";
}
if (strpos($updated_content, '[email* your-email') !== false) {
    echo "✓ Email field verified\n";
}
if (strpos($updated_content, '[tel your-phone') !== false) {
    echo "✓ Phone field verified\n";
}
if (strpos($updated_content, '[select* your-subject') !== false) {
    echo "✓ Subject field verified\n";
}
if (strpos($updated_content, '[textarea* your-message') !== false) {
    echo "✓ Message field verified\n";
}
if (strpos($updated_content, '[recaptcha]') !== false) {
    echo "✓ reCAPTCHA field verified\n";
}

echo "\n✓ Contact form fixed successfully!\n";

?>
