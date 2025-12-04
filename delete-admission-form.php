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
    $form_id = $forms[0]->ID;
    wp_delete_post($form_id, true);
    echo "Deleted admission form (ID: $form_id)\n";
} else {
    echo "No admission form found to delete\n";
}
?>
