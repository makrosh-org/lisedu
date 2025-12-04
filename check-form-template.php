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
    $form = WPCF7_ContactForm::get_instance($form_id);
    
    if ($form) {
        echo "Form Template (HTML):\n";
        echo str_repeat("=", 80) . "\n";
        
        // Get the form property which contains the actual form template
        $properties = $form->get_properties();
        if (isset($properties['form'])) {
            echo $properties['form'];
        } else {
            echo "Form template not found in properties\n";
            echo "Available properties: " . implode(', ', array_keys($properties)) . "\n";
        }
        
        echo "\n" . str_repeat("=", 80) . "\n";
    } else {
        echo "Could not load form instance\n";
    }
} else {
    echo "Form not found\n";
}
?>
