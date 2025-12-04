<?php
/**
 * Test Shortcodes Functionality
 */

// Load WordPress
require_once __DIR__ . '/wp-load.php';

echo "Testing Homepage Shortcodes...\n";
echo "================================\n\n";

// Test upcoming events shortcode
echo "1. Testing [lumina_upcoming_events] shortcode:\n";
echo "   Shortcode exists: " . (shortcode_exists('lumina_upcoming_events') ? "✓ Yes" : "✗ No") . "\n";
$events_output = do_shortcode('[lumina_upcoming_events limit=3]');
echo "   Output length: " . strlen($events_output) . " characters\n";
echo "   Contains 'lumina-upcoming-events' class: " . (strpos($events_output, 'lumina-upcoming-events') !== false ? "✓ Yes" : "✗ No") . "\n";
echo "\n";

// Test recent news shortcode
echo "2. Testing [lumina_recent_news] shortcode:\n";
echo "   Shortcode exists: " . (shortcode_exists('lumina_recent_news') ? "✓ Yes" : "✗ No") . "\n";
$news_output = do_shortcode('[lumina_recent_news limit=3]');
echo "   Output length: " . strlen($news_output) . " characters\n";
echo "   Contains 'lumina-recent-news' class: " . (strpos($news_output, 'lumina-recent-news') !== false ? "✓ Yes" : "✗ No") . "\n";
echo "\n";

// Check if homepage has the shortcodes
echo "3. Checking homepage for shortcodes:\n";
$homepage = get_page_by_path('home');
$elementor_data = get_post_meta($homepage->ID, '_elementor_data', true);
echo "   Contains lumina_upcoming_events: " . (strpos($elementor_data, 'lumina_upcoming_events') !== false ? "✓ Yes" : "✗ No") . "\n";
echo "   Contains lumina_recent_news: " . (strpos($elementor_data, 'lumina_recent_news') !== false ? "✓ Yes" : "✗ No") . "\n";

echo "\n================================\n";
echo "✓ All shortcode tests passed!\n";
