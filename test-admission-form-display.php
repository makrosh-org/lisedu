<?php
/**
 * Test Admission Form Display
 * Generates HTML preview of the admission form
 */

define('WP_USE_THEMES', false);
require './wp-load.php';

// Get the form
$forms = get_posts(array(
    'post_type' => 'wpcf7_contact_form',
    'title' => 'Lumina Admission Inquiry Form',
    'post_status' => 'publish',
    'numberposts' => 1
));

if (empty($forms)) {
    echo "Error: Admission form not found\n";
    exit(1);
}

$form_id = $forms[0]->ID;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admission Inquiry Form - Lumina International School</title>
    
    <!-- Brand Colors -->
    <style>
        :root {
            --base-darkblue: #003d70;
            --base-lightgray: #f7f7f7;
            --base-accent-teal: #7EBEC5;
            --base-accent-orange: #F39A3B;
            --base-white: #FFFFFF;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: var(--base-lightgray);
            padding: 40px 20px;
            line-height: 1.6;
        }
        
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: var(--base-white);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 61, 112, 0.1);
        }
        
        .page-header {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 30px;
            border-bottom: 3px solid var(--base-accent-teal);
        }
        
        .page-header h1 {
            color: var(--base-darkblue);
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        
        .page-header p {
            color: #666;
            font-size: 1.1rem;
        }
        
        .intro-text {
            background: var(--base-lightgray);
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 40px;
            border-left: 4px solid var(--base-accent-orange);
        }
        
        .intro-text h2 {
            color: var(--base-darkblue);
            font-size: 1.5rem;
            margin-bottom: 15px;
        }
        
        .intro-text p {
            color: #333;
            margin-bottom: 10px;
        }
        
        .intro-text ul {
            margin-left: 20px;
            color: #333;
        }
        
        .intro-text li {
            margin-bottom: 8px;
        }
        
        .form-info {
            background: #e8f5e9;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            border-left: 4px solid #4caf50;
        }
        
        .form-info h3 {
            color: #2e7d32;
            margin-bottom: 10px;
        }
        
        .form-info p {
            color: #1b5e20;
        }
    </style>
    
    <?php wp_head(); ?>
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1>Admission Inquiry</h1>
            <p>Begin Your Journey with Lumina International School</p>
        </div>
        
        <div class="intro-text">
            <h2>Welcome to Our Admissions Process</h2>
            <p>Thank you for your interest in Lumina International School! We're excited to learn more about your family and how we can support your child's educational journey.</p>
            
            <p><strong>What happens after you submit this form?</strong></p>
            <ul>
                <li>Our admissions team will review your inquiry within 1-2 business days</li>
                <li>You'll receive a confirmation email with your inquiry details</li>
                <li>We'll contact you to discuss the admission process and answer your questions</li>
                <li>We can schedule a campus tour at your convenience</li>
            </ul>
        </div>
        
        <div class="form-info">
            <h3>📋 Required Information</h3>
            <p>Please complete all required fields marked with an asterisk (*). This helps us better understand your needs and provide personalized assistance.</p>
        </div>
        
        <!-- Admission Form -->
        <?php echo do_shortcode('[contact-form-7 id="' . $form_id . '" title="Lumina Admission Inquiry Form"]'); ?>
        
        <div style="margin-top: 40px; padding-top: 30px; border-top: 2px solid var(--base-lightgray); text-align: center; color: #666;">
            <p><strong>Questions?</strong> Contact our admissions office:</p>
            <p>📧 Email: admissions@luminaschool.edu | 📞 Phone: [Your Phone Number]</p>
            <p style="margin-top: 20px; font-size: 0.9rem;">
                <em>Your information is secure and will only be used for admission purposes.</em>
            </p>
        </div>
    </div>
    
    <?php wp_footer(); ?>
</body>
</html>
