<?php
define('WP_USE_THEMES', false);
require './wp-load.php';

$forms = get_posts(array(
    'post_type' => 'wpcf7_contact_form',
    'title' => 'Lumina Admission Inquiry Form',
    'post_status' => 'publish',
    'numberposts' => 1
));

if (!empty($forms)) {
    echo "Form Content:\n";
    echo str_repeat("=", 80) . "\n";
    echo $forms[0]->post_content;
    echo "\n" . str_repeat("=", 80) . "\n";
} else {
    echo "Form not found\n";
}
?>
