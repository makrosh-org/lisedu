<?php
/**
 * Fix Yellow Underlines and Update Footer
 * 
 * This script:
 * 1. Removes yellow/orange underlines from headings
 * 2. Updates footer address
 * 3. Ensures sections are full width
 */

require_once('wp-load.php');

echo "═══════════════════════════════════════════════════════════\n";
echo "🔧 FIXING UNDERLINES AND FOOTER\n";
echo "═══════════════════════════════════════════════════════════\n\n";

// Create CSS to remove underlines
$fix_css = <<<CSS
/**
 * Remove Yellow/Orange Underlines
 * Fix awkward underlines from headings
 */

/* Remove school name underline */
.site-title::after {
    display: none !important;
}

/* Remove heading underlines */
.elementor-heading-title::after,
h1::after,
h2::after,
h3::after,
h4::after,
h5::after,
h6::after {
    display: none !important;
}

/* Remove footer heading underlines */
.footer-column h3::after,
.footer-column h4::after {
    display: none !important;
}

/* Remove any yellow/orange underlines */
*::after,
*::before {
    border-bottom-color: transparent !important;
}

/* Ensure full width sections */
.elementor-section.elementor-section-boxed > .elementor-container {
    max-width: 100% !important;
}

.elementor-section-full_width {
    width: 100% !important;
}

/* Override any underline decorations */
.elementor-widget-heading .elementor-heading-title {
    text-decoration: none !important;
    border-bottom: none !important;
}

.elementor-widget-heading .elementor-heading-title::after {
    content: none !important;
    display: none !important;
}

/* Remove decorative elements that might be causing underlines */
.elementor-widget-container::after,
.elementor-widget-container::before {
    display: none !important;
}

CSS;

// Save the fix CSS
$fix_css_file = 'wp-content/themes/lumina-child-theme/assets/css/underline-fixes.css';
file_put_contents($fix_css_file, $fix_css);
echo "✅ Created underline fix CSS: $fix_css_file\n";

// Update functions.php to enqueue the fix CSS
$functions_file = 'wp-content/themes/lumina-child-theme/functions.php';
$functions_content = file_get_contents($functions_file);

if (strpos($functions_content, 'underline-fixes.css') === false) {
    // Find the last wp_enqueue_style in lumina_child_enqueue_styles function
    $pattern = "/(wp_enqueue_style\(\s*'lumina-child-style'[^;]+;)/";
    
    if (preg_match($pattern, $functions_content, $matches)) {
        $new_enqueue = "    // Fix underlines\n    wp_enqueue_style(\n        'lumina-underline-fixes',\n        get_stylesheet_directory_uri() . '/assets/css/underline-fixes.css',\n        array('lumina-homepage-enhanced'),\n        '1.0.0'\n    );\n    \n    " . $matches[1];
        
        $functions_content = str_replace($matches[1], $new_enqueue, $functions_content);
        file_put_contents($functions_file, $functions_content);
        echo "✅ Enqueued underline fix CSS in functions.php\n";
    }
}

// Update footer with correct address
$footer_content = <<<'FOOTER'

<footer class="site-footer">
    <div class="footer-container">
        <div class="footer-content">
            <div class="footer-column">
                <h3>Lumina International School</h3>
                <p>Nurturing Young Minds with Islamic Values and Academic Excellence</p>
                <p><strong>📧 Email:</strong> info@luminaschool.edu<br>
                <strong>📞 Phone:</strong> (123) 456-7890<br>
                <strong>📍 Address:</strong> 26/11 Rajabari, Savar Upazila Complex, Genda, Savar, Dhaka-1340<br>
                Opposite of Dhaka Palli Bidyut Samity-3</p>
                
                <div class="footer-social">
                    <h4>Connect With Us</h4>
                    <div class="social-links">
                        <a href="#" aria-label="Facebook" title="Facebook">📘</a>
                        <a href="#" aria-label="Twitter" title="Twitter">🐦</a>
                        <a href="#" aria-label="Instagram" title="Instagram">📷</a>
                        <a href="#" aria-label="LinkedIn" title="LinkedIn">💼</a>
                        <a href="#" aria-label="YouTube" title="YouTube">📺</a>
                    </div>
                </div>
            </div>
            
            <div class="footer-column">
                <h4>Quick Links</h4>
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'footer',
                    'menu_class'     => 'footer-menu',
                    'container'      => 'nav',
                    'fallback_cb'    => false,
                ) );
                ?>
            </div>
            
            <div class="footer-column">
                <h4>Important Links</h4>
                <nav>
                    <ul class="footer-menu">
                        <li><a href="/admissions">Admissions</a></li>
                        <li><a href="/programs">Programs</a></li>
                        <li><a href="/events">Events</a></li>
                        <li><a href="/contact">Contact Us</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </nav>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> Lumina International School. All rights reserved. | Designed with ❤️ for Education</p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>

</body>
</html>
FOOTER;

file_put_contents('wp-content/themes/lumina-child-theme/footer.php', $footer_content);
echo "✅ Updated footer with correct address\n";

// Update homepage-enhanced.css to remove underline styles
$enhanced_css_file = 'wp-content/themes/lumina-child-theme/assets/css/homepage-enhanced.css';
if (file_exists($enhanced_css_file)) {
    $enhanced_css = file_get_contents($enhanced_css_file);
    
    // Remove the ::after pseudo-elements that create underlines
    $patterns_to_remove = [
        '/\.site-title::after\s*\{[^}]+\}/s',
        '/\.elementor-heading-title::after\s*\{[^}]+\}/s',
        '/\.footer-column h3::after\s*\{[^}]+\}/s',
        '/\.footer-column h4::after\s*\{[^}]+\}/s',
    ];
    
    foreach ($patterns_to_remove as $pattern) {
        $enhanced_css = preg_replace($pattern, '', $enhanced_css);
    }
    
    file_put_contents($enhanced_css_file, $enhanced_css);
    echo "✅ Removed underline styles from homepage-enhanced.css\n";
}

echo "\n";
echo "═══════════════════════════════════════════════════════════\n";
echo "✨ FIXES APPLIED SUCCESSFULLY!\n";
echo "═══════════════════════════════════════════════════════════\n\n";

echo "CHANGES MADE:\n";
echo "✅ Removed yellow/orange underlines from all headings\n";
echo "✅ Removed school name underline\n";
echo "✅ Removed footer heading underlines\n";
echo "✅ Updated footer address to:\n";
echo "   26/11 Rajabari, Savar Upazila Complex\n";
echo "   Genda, Savar, Dhaka-1340\n";
echo "   Opposite of Dhaka Palli Bidyut Samity-3\n";
echo "✅ Ensured sections are full width\n\n";

echo "NEXT STEPS:\n";
echo "1. Clear browser cache (Ctrl+Shift+R or Cmd+Shift+R)\n";
echo "2. Visit your homepage\n";
echo "3. Verify no yellow underlines appear\n";
echo "4. Check footer has correct address\n";
echo "5. Verify sections are full width\n\n";

echo "═══════════════════════════════════════════════════════════\n";
?>
