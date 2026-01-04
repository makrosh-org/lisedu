<?php
/**
 * Admission Form Handler
 * Ensures proper form submission and email delivery
 * 
 * @package Lumina_Child_Theme
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Custom validation for admission form
 */
function lumina_admission_form_validation($result, $tag) {
    $tag = new WPCF7_FormTag($tag);
    
    // Validate phone number format
    if ($tag->name == 'parent-phone') {
        $phone = isset($_POST['parent-phone']) ? trim($_POST['parent-phone']) : '';
        
        // Allow Bangladesh phone format: +880 or 01
        if (!empty($phone) && !preg_match('/^(\+?880|0)?1[3-9]\d{8}$/', str_replace([' ', '-'], '', $phone))) {
            $result->invalidate($tag, 'Please enter a valid Bangladesh phone number (e.g., +880 1XXX-XXXXXX or 01XXX-XXXXXX)');
        }
    }
    
    // Validate student age
    if ($tag->name == 'student-age') {
        $age = isset($_POST['student-age']) ? intval($_POST['student-age']) : 0;
        
        if ($age < 2 || $age > 12) {
            $result->invalidate($tag, 'Student age must be between 2 and 12 years');
        }
    }
    
    // Validate start date (must be future date)
    if ($tag->name == 'start-date') {
        $start_date = isset($_POST['start-date']) ? $_POST['start-date'] : '';
        
        if (!empty($start_date)) {
            $date = strtotime($start_date);
            $today = strtotime('today');
            
            if ($date < $today) {
                $result->invalidate($tag, 'Start date must be in the future');
            }
        }
    }
    
    return $result;
}
add_filter('wpcf7_validate_text*', 'lumina_admission_form_validation', 10, 2);
add_filter('wpcf7_validate_tel*', 'lumina_admission_form_validation', 10, 2);
add_filter('wpcf7_validate_number*', 'lumina_admission_form_validation', 10, 2);
add_filter('wpcf7_validate_date*', 'lumina_admission_form_validation', 10, 2);

/**
 * Log form submissions for debugging
 */
function lumina_log_admission_submission($contact_form) {
    // Only log admission form (check title)
    $title = $contact_form->title();
    if (strpos($title, 'Admission') === false) {
        return;
    }
    
    $submission = WPCF7_Submission::get_instance();
    
    if ($submission) {
        $posted_data = $submission->get_posted_data();
        
        // Log to WordPress debug.log if WP_DEBUG_LOG is enabled
        if (defined('WP_DEBUG_LOG') && WP_DEBUG_LOG) {
            error_log('Admission Form Submission: ' . print_r($posted_data, true));
        }
        
        // Store in custom table or option for backup
        $submissions = get_option('lumina_admission_submissions', array());
        $submissions[] = array(
            'timestamp' => current_time('mysql'),
            'data' => $posted_data,
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
        );
        
        // Keep only last 100 submissions
        if (count($submissions) > 100) {
            $submissions = array_slice($submissions, -100);
        }
        
        update_option('lumina_admission_submissions', $submissions);
    }
}
add_action('wpcf7_before_send_mail', 'lumina_log_admission_submission');

/**
 * Send notification to admin on successful submission
 */
function lumina_admission_notification($contact_form) {
    $title = $contact_form->title();
    if (strpos($title, 'Admission') === false) {
        return;
    }
    
    $submission = WPCF7_Submission::get_instance();
    
    if ($submission) {
        $posted_data = $submission->get_posted_data();
        
        // Additional notification (e.g., SMS, Slack, etc.)
        // You can add custom notification logic here
        
        // Example: Send to multiple email addresses
        $additional_emails = get_option('lumina_admission_notification_emails', array());
        if (!empty($additional_emails)) {
            $student_name = $posted_data['student-name'] ?? 'Unknown';
            $parent_name = $posted_data['parent-name'] ?? 'Unknown';
            $parent_email = $posted_data['parent-email'] ?? '';
            
            $subject = '[Lumina School] New Admission Inquiry - ' . $student_name;
            $message = "New admission inquiry received:\n\n";
            $message .= "Student: $student_name\n";
            $message .= "Parent: $parent_name\n";
            $message .= "Email: $parent_email\n";
            $message .= "\nView full details in WordPress admin.\n";
            
            $headers = array('Content-Type: text/plain; charset=UTF-8');
            
            foreach ($additional_emails as $email) {
                wp_mail($email, $subject, $message, $headers);
            }
        }
    }
}
add_action('wpcf7_mail_sent', 'lumina_admission_notification');

/**
 * Add custom CSS classes to form
 */
function lumina_admission_form_class($class) {
    $class .= ' lumina-admission-form-wrapper';
    return $class;
}
add_filter('wpcf7_form_class_attr', 'lumina_admission_form_class');

/**
 * Customize success message with redirect option
 */
function lumina_admission_success_redirect($contact_form) {
    $title = $contact_form->title();
    if (strpos($title, 'Admission') === false) {
        return;
    }
    
    // Optional: Redirect to thank you page after submission
    // Uncomment the following lines if you want to redirect
    /*
    $thank_you_url = home_url('/thank-you-admission/');
    echo '<script type="text/javascript">
        document.addEventListener("wpcf7mailsent", function(event) {
            location = "' . $thank_you_url . '";
        }, false);
    </script>';
    */
}
add_action('wpcf7_submit', 'lumina_admission_success_redirect');

/**
 * Ensure emails are sent properly
 */
function lumina_fix_email_delivery() {
    // Set proper from email
    add_filter('wp_mail_from', function($email) {
        $sitename = strtolower($_SERVER['SERVER_NAME']);
        if (substr($sitename, 0, 4) == 'www.') {
            $sitename = substr($sitename, 4);
        }
        return 'noreply@' . $sitename;
    });
    
    // Set proper from name
    add_filter('wp_mail_from_name', function($name) {
        return get_bloginfo('name');
    });
}
add_action('init', 'lumina_fix_email_delivery');

/**
 * Add admin menu for viewing submissions
 */
function lumina_admission_submissions_menu() {
    add_submenu_page(
        'wpcf7',
        'Admission Submissions',
        'Admission Submissions',
        'manage_options',
        'lumina-admission-submissions',
        'lumina_display_admission_submissions'
    );
}
add_action('admin_menu', 'lumina_admission_submissions_menu');

/**
 * Display admission submissions in admin
 */
function lumina_display_admission_submissions() {
    if (!current_user_can('manage_options')) {
        return;
    }
    
    $submissions = get_option('lumina_admission_submissions', array());
    $submissions = array_reverse($submissions); // Show newest first
    
    echo '<div class="wrap">';
    echo '<h1>Admission Form Submissions</h1>';
    
    if (empty($submissions)) {
        echo '<p>No submissions yet.</p>';
    } else {
        echo '<p>Total submissions: ' . count($submissions) . '</p>';
        echo '<table class="wp-list-table widefat fixed striped">';
        echo '<thead><tr>';
        echo '<th>Date/Time</th>';
        echo '<th>Student Name</th>';
        echo '<th>Parent Name</th>';
        echo '<th>Email</th>';
        echo '<th>Phone</th>';
        echo '<th>Grade Level</th>';
        echo '<th>IP Address</th>';
        echo '</tr></thead>';
        echo '<tbody>';
        
        foreach ($submissions as $submission) {
            $data = $submission['data'];
            echo '<tr>';
            echo '<td>' . esc_html($submission['timestamp']) . '</td>';
            echo '<td>' . esc_html($data['student-name'] ?? '-') . '</td>';
            echo '<td>' . esc_html($data['parent-name'] ?? '-') . '</td>';
            echo '<td>' . esc_html($data['parent-email'] ?? '-') . '</td>';
            echo '<td>' . esc_html($data['parent-phone'] ?? '-') . '</td>';
            echo '<td>' . esc_html($data['grade-level'] ?? '-') . '</td>';
            echo '<td>' . esc_html($submission['ip']) . '</td>';
            echo '</tr>';
        }
        
        echo '</tbody></table>';
    }
    
    echo '</div>';
}
