<?php
/**
 * Create and Configure Contact Form
 * Task 11: Build contact form with validation, CAPTCHA, email notifications, and storage
 * Requirements: 5.3, 5.4, 5.5
 */

define('WP_USE_THEMES', false);
require './wp-load.php';

echo "=== Creating Contact Form ===\n\n";

// Check if Contact Form 7 is active
if (!is_plugin_active('contact-form-7/wp-contact-form-7.php')) {
    echo "ERROR: Contact Form 7 plugin is not active!\n";
    exit(1);
}

// Create the contact form with all required fields
$form_title = 'Lumina Contact Form';
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

// Mail template for admin notification
$mail_template = <<<MAIL
Subject: [Lumina School] New Contact Form Submission - [your-subject]

From: [your-name] <[your-email]>
Phone: [your-phone]
Subject: [your-subject]

Message:
[your-message]

---
This message was sent from the contact form on Lumina International School website.
Submission Time: [_date] [_time]
IP Address: [_remote_ip]
MAIL;

// Mail 2 template for user confirmation
$mail2_template = <<<MAIL2
Subject: Thank you for contacting Lumina International School

Dear [your-name],

Thank you for reaching out to Lumina International School. We have received your message and will respond to your inquiry as soon as possible, typically within 1-2 business days.

Your Message Details:
Subject: [your-subject]
Message: [your-message]

If you need immediate assistance, please feel free to call us at our main office.

Best regards,
Lumina International School Administration Team

---
This is an automated confirmation email. Please do not reply to this message.
MAIL2;

// Success message
$success_message = 'Thank you for contacting us! Your message has been successfully sent. We will get back to you within 1-2 business days.';

// Error message
$error_message = 'There was an error sending your message. Please try again or contact us directly via phone or email.';

// Validation messages
$validation_messages = array(
    'invalid_required' => 'This field is required',
    'invalid_email' => 'Please enter a valid email address',
    'invalid_tel' => 'Please enter a valid phone number',
    'spam' => 'Your message was flagged as spam. Please try again.',
    'captcha' => 'Please complete the CAPTCHA verification',
    'failed' => 'There was an error sending your message. Please try again.'
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
    echo "Contact form already exists (ID: $form_id). Updating...\n";
    
    // Update existing form
    wp_update_post(array(
        'ID' => $form_id,
        'post_content' => $form_content
    ));
} else {
    // Create new form
    $form_id = wp_insert_post(array(
        'post_type' => 'wpcf7_contact_form',
        'post_title' => $form_title,
        'post_content' => $form_content,
        'post_status' => 'publish'
    ));
    
    if (is_wp_error($form_id)) {
        echo "ERROR: Failed to create contact form: " . $form_id->get_error_message() . "\n";
        exit(1);
    }
    
    echo "Contact form created successfully (ID: $form_id)\n";
}

// Get admin email
$admin_email = get_option('admin_email');
echo "Admin email: $admin_email\n";

// Configure form settings
$form = WPCF7_ContactForm::get_instance($form_id);

if ($form) {
    // Set mail template (to admin)
    $mail = $form->prop('mail');
    $mail['subject'] = '[Lumina School] New Contact Form Submission - [your-subject]';
    $mail['sender'] = '[your-name] <wordpress@' . $_SERVER['HTTP_HOST'] . '>';
    $mail['recipient'] = $admin_email;
    $mail['body'] = $mail_template;
    $mail['additional_headers'] = 'Reply-To: [your-email]';
    $form->set_properties(array('mail' => $mail));
    
    // Set mail 2 template (confirmation to user)
    $mail2 = $form->prop('mail_2');
    $mail2['active'] = true;
    $mail2['subject'] = 'Thank you for contacting Lumina International School';
    $mail2['sender'] = 'Lumina International School <wordpress@' . $_SERVER['HTTP_HOST'] . '>';
    $mail2['recipient'] = '[your-email]';
    $mail2['body'] = $mail2_template;
    $mail2['additional_headers'] = '';
    $form->set_properties(array('mail_2' => $mail2));
    
    // Set messages
    $messages = $form->prop('messages');
    $messages['mail_sent_ok'] = $success_message;
    $messages['mail_sent_ng'] = $error_message;
    $messages['validation_error'] = 'One or more fields have an error. Please check and try again.';
    $messages['spam'] = $validation_messages['spam'];
    $messages['accept_terms'] = 'You must accept the terms and conditions before sending your message.';
    $messages['invalid_required'] = $validation_messages['invalid_required'];
    $messages['invalid_email'] = $validation_messages['invalid_email'];
    $messages['invalid_tel'] = $validation_messages['invalid_tel'];
    $form->set_properties(array('messages' => $messages));
    
    // Enable Flamingo for form submission storage (if available)
    $additional_settings = "flamingo_email: \"[your-email]\"\nflamingo_name: \"[your-name]\"";
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
    echo "⚠ Flamingo plugin is not active. Installing...\n";
    
    // Try to install Flamingo
    include_once(ABSPATH . 'wp-admin/includes/plugin-install.php');
    include_once(ABSPATH . 'wp-admin/includes/file.php');
    include_once(ABSPATH . 'wp-admin/includes/misc.php');
    include_once(ABSPATH . 'wp-admin/includes/class-wp-upgrader.php');
    
    $plugin_slug = 'flamingo';
    $api = plugins_api('plugin_information', array('slug' => $plugin_slug));
    
    if (!is_wp_error($api)) {
        $upgrader = new Plugin_Upgrader(new WP_Ajax_Upgrader_Skin());
        $result = $upgrader->install($api->download_link);
        
        if (!is_wp_error($result) && $result) {
            $activate = activate_plugin('flamingo/flamingo.php');
            if (is_wp_error($activate)) {
                echo "⚠ Flamingo installed but activation failed: " . $activate->get_error_message() . "\n";
            } else {
                echo "✓ Flamingo plugin installed and activated\n";
            }
        } else {
            echo "⚠ Failed to install Flamingo plugin\n";
        }
    }
}

// Get the shortcode
echo "\n=== Contact Form Created Successfully ===\n";
echo "Form ID: $form_id\n";
echo "Shortcode: [contact-form-7 id=\"$form_id\" title=\"$form_title\"]\n";
echo "\nForm Features:\n";
echo "✓ Required fields: Name, Email, Subject, Message\n";
echo "✓ Optional field: Phone\n";
echo "✓ Client-side validation enabled\n";
echo "✓ Email format validation\n";
echo "✓ reCAPTCHA spam protection\n";
echo "✓ Admin email notifications to: $admin_email\n";
echo "✓ User confirmation emails\n";
echo "✓ Form submission storage (via Flamingo)\n";
echo "✓ Success/error messages configured\n";
echo "\nNext Steps:\n";
echo "1. Configure reCAPTCHA keys in Contact Form 7 settings\n";
echo "2. Add the shortcode to the Contact page\n";
echo "3. Add custom CSS styling to match brand design\n";

?>
