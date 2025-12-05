<?php
/**
 * Create Sample Gallery Images
 * This script creates placeholder images for testing the gallery
 */

require_once('wp-load.php');

if (!defined('ABSPATH')) {
    die('WordPress not loaded');
}

echo "\n=== Creating Sample Gallery Images ===\n\n";

// Sample images with categories
$sample_images = [
    [
        'title' => 'Annual Sports Day Event',
        'alt' => 'Students participating in sports day event',
        'category' => 'events',
        'url' => 'https://via.placeholder.com/1200x800/003d70/FFFFFF?text=Sports+Day+Event',
    ],
    [
        'title' => 'Science Fair Event',
        'alt' => 'Students presenting science projects at event',
        'category' => 'events',
        'url' => 'https://via.placeholder.com/1200x800/7EBEC5/FFFFFF?text=Science+Fair',
    ],
    [
        'title' => 'Modern Classroom Facility',
        'alt' => 'Bright and modern classroom facility',
        'category' => 'facilities',
        'url' => 'https://via.placeholder.com/1200x800/F39A3B/FFFFFF?text=Classroom',
    ],
    [
        'title' => 'School Library Facility',
        'alt' => 'Well-stocked library facility',
        'category' => 'facilities',
        'url' => 'https://via.placeholder.com/1200x800/003d70/FFFFFF?text=Library',
    ],
    [
        'title' => 'Outdoor Playground Facility',
        'alt' => 'Safe outdoor playground facility',
        'category' => 'facilities',
        'url' => 'https://via.placeholder.com/1200x800/7EBEC5/FFFFFF?text=Playground',
    ],
    [
        'title' => 'Art Class Activity',
        'alt' => 'Students engaged in art activity',
        'category' => 'activities',
        'url' => 'https://via.placeholder.com/1200x800/F39A3B/FFFFFF?text=Art+Class',
    ],
    [
        'title' => 'Music Class Activity',
        'alt' => 'Students learning music activity',
        'category' => 'activities',
        'url' => 'https://via.placeholder.com/1200x800/003d70/FFFFFF?text=Music+Class',
    ],
    [
        'title' => 'Academic Achievement Award',
        'alt' => 'Students receiving achievement awards',
        'category' => 'achievements',
        'url' => 'https://via.placeholder.com/1200x800/7EBEC5/FFFFFF?text=Awards+Ceremony',
    ],
    [
        'title' => 'Math Competition Achievement',
        'alt' => 'Winners of math competition achievement',
        'category' => 'achievements',
        'url' => 'https://via.placeholder.com/1200x800/F39A3B/FFFFFF?text=Math+Winners',
    ],
];

$created_count = 0;

foreach ($sample_images as $image_data) {
    // Check if image already exists
    $existing = get_posts([
        'post_type' => 'attachment',
        'title' => $image_data['title'],
        'posts_per_page' => 1,
    ]);
    
    if (!empty($existing)) {
        echo "⊙ Image already exists: {$image_data['title']}\n";
        continue;
    }
    
    // Download the placeholder image
    $tmp = download_url($image_data['url']);
    
    if (is_wp_error($tmp)) {
        echo "✗ Failed to download: {$image_data['title']}\n";
        continue;
    }
    
    // Prepare file array
    $file_array = [
        'name' => sanitize_file_name($image_data['title']) . '.png',
        'tmp_name' => $tmp,
    ];
    
    // Upload to media library
    $attachment_id = media_handle_sideload($file_array, 0, $image_data['title']);
    
    // Clean up temp file
    @unlink($tmp);
    
    if (is_wp_error($attachment_id)) {
        echo "✗ Failed to create attachment: {$image_data['title']}\n";
        continue;
    }
    
    // Set alt text
    update_post_meta($attachment_id, '_wp_attachment_image_alt', $image_data['alt']);
    
    echo "✓ Created: {$image_data['title']} (ID: $attachment_id)\n";
    $created_count++;
}

echo "\n=== Summary ===\n";
echo "Created $created_count new images\n";
echo "Total images in library: " . count(get_posts(['post_type' => 'attachment', 'post_mime_type' => 'image', 'posts_per_page' => -1])) . "\n";
echo "\nGallery images are now ready for testing!\n";
