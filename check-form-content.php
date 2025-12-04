<?php
define('WP_USE_THEMES', false);
require './wp-load.php';

$posts = get_posts(array(
    'post_type' => 'wpcf7_contact_form',
    'p' => 63
));

if (!empty($posts)) {
    echo "Current form content:\n";
    echo "====================\n";
    echo $posts[0]->post_content;
    echo "\n====================\n";
}
?>
