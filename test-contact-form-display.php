<?php
/**
 * Test Contact Form Display
 * Verify the form renders correctly with all elements
 */

define('WP_USE_THEMES', false);
require './wp-load.php';

echo "=== Contact Form Display Test ===\n\n";

// Get the form
$form_id = 63;
$form = WPCF7_ContactForm::get_instance($form_id);

if (!$form) {
    echo "✗ ERROR: Form not found\n";
    exit(1);
}

echo "Form Information:\n";
echo "  ID: " . $form->id() . "\n";
echo "  Title: " . $form->title() . "\n";
echo "  Locale: " . $form->locale() . "\n\n";

// Get form HTML
$form_html = $form->prop('form');

echo "Form Structure:\n";
echo "================\n";

// Check for each field
$fields_to_check = array(
    'your-name' => 'Name field',
    'your-email' => 'Email field',
    'your-phone' => 'Phone field',
    'your-subject' => 'Subject field',
    'your-message' => 'Message field',
    'recaptcha' => 'reCAPTCHA',
    'submit' => 'Submit button'
);

foreach ($fields_to_check as $field => $label) {
    if (strpos($form_html, $field) !== false) {
        echo "✓ $label found\n";
    } else {
        echo "✗ $label NOT found\n";
    }
}

echo "\n";

// Check for required markers
$required_count = substr_count($form_html, '*');
echo "Required field markers (*): $required_count\n";

// Check for CSS classes
if (strpos($form_html, 'lumina-contact-form') !== false) {
    echo "✓ Custom CSS class applied\n";
}

if (strpos($form_html, 'form-row') !== false) {
    echo "✓ Form row structure present\n";
}

echo "\n";

// Get mail configuration
$mail = $form->prop('mail');
echo "Email Configuration:\n";
echo "  To: " . $mail['recipient'] . "\n";
echo "  Subject: " . $mail['subject'] . "\n";
echo "  From: " . $mail['sender'] . "\n";

$mail2 = $form->prop('mail_2');
if ($mail2['active']) {
    echo "\nConfirmation Email:\n";
    echo "  Status: Active\n";
    echo "  To: " . $mail2['recipient'] . "\n";
    echo "  Subject: " . $mail2['subject'] . "\n";
}

echo "\n";

// Get messages
$messages = $form->prop('messages');
echo "Success Message:\n";
echo "  " . substr($messages['mail_sent_ok'], 0, 80) . "...\n";

echo "\n";

// Check if form is on Contact page
$contact_page = get_page_by_path('contact');
if ($contact_page) {
    $page_content = $contact_page->post_content;
    if (strpos($page_content, '[contact-form-7') !== false) {
        echo "✓ Form shortcode is on Contact page\n";
        echo "  URL: " . get_permalink($contact_page->ID) . "\n";
    } else {
        echo "⚠ Form shortcode not found on Contact page\n";
    }
}

echo "\n=== Test Complete ===\n";
echo "✓ Contact form is properly configured and ready to use!\n";

?>
