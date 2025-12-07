<?php
/**
 * Enhance Homepage Attractiveness
 * 
 * This script improves:
 * 1. School name styling (bolder, more prominent)
 * 2. Section spacing and layout
 * 3. Footer design with better visual appeal
 * 4. Overall homepage attractiveness
 */

require_once('wp-load.php');

// Create enhanced CSS file for homepage improvements
$enhanced_css = <<<CSS
/**
 * Enhanced Homepage Attractiveness Styles
 * Version: 2.0
 */

/* ============================================
   ENHANCED SCHOOL NAME / LOGO STYLING
   ============================================ */

.site-title {
    margin: 0;
    font-size: 32px !important;
    font-weight: 800 !important;
    line-height: 1.2;
    letter-spacing: -0.5px;
    text-transform: uppercase;
    background: linear-gradient(135deg, #1a2b4a 0%, #3b82f6 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    position: relative;
    padding-bottom: 5px;
}

.site-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 60px;
    height: 3px;
    background: linear-gradient(90deg, #f59e0b 0%, #fbbf24 100%);
    border-radius: 2px;
}

.site-title a {
    color: #1a2b4a !important;
    text-decoration: none;
    font-weight: 800 !important;
    transition: all 0.3s ease;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
}

.site-title a:hover {
    transform: scale(1.02);
    text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.15);
}

.site-description {
    margin: 8px 0 0;
    font-size: 14px;
    color: #666;
    font-weight: 500;
    font-style: italic;
    letter-spacing: 0.5px;
}

/* Mobile responsive school name */
@media (max-width: 768px) {
    .site-title {
        font-size: 24px !important;
    }
}

/* ============================================
   ENHANCED HEADER STYLING
   ============================================ */

.site-header {
    background: linear-gradient(to bottom, #ffffff 0%, #f8fafc 100%);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    position: sticky;
    top: 0;
    z-index: 1000;
    padding: 25px 0;
    border-bottom: 3px solid #f59e0b;
}

/* ============================================
   FIX SECTION SPACING & LAYOUT
   ============================================ */

/* Ensure sections don't extend beyond container */
.elementor-section {
    max-width: 100%;
    overflow: hidden;
}

.elementor-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Fix section padding for better spacing */
.elementor-section-wrap > .elementor-section {
    margin-bottom: 0 !important;
}

.elementor-top-section {
    padding: 60px 0 !important;
}

/* Hero section special treatment */
.elementor-section:first-child {
    padding: 80px 0 !important;
}

/* Alternate section backgrounds for visual interest */
.elementor-section:nth-child(even) {
    background-color: #f8fafc;
}

.elementor-section:nth-child(odd) {
    background-color: #ffffff;
}

/* ============================================
   ENHANCED FOOTER STYLING
   ============================================ */

.site-footer {
    background: linear-gradient(135deg, #1a2b4a 0%, #0f172a 100%);
    color: #FFFFFF;
    padding: 60px 0 20px;
    margin-top: 80px;
    position: relative;
    overflow: hidden;
}

/* Add decorative element to footer */
.site-footer::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #f59e0b 0%, #fbbf24 50%, #f59e0b 100%);
}

/* Add subtle pattern overlay */
.site-footer::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: 
        radial-gradient(circle at 20% 50%, rgba(59, 130, 246, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 80% 80%, rgba(245, 158, 11, 0.1) 0%, transparent 50%);
    pointer-events: none;
}

.footer-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    position: relative;
    z-index: 1;
}

.footer-content {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr;
    gap: 50px;
    margin-bottom: 40px;
}

.footer-column h3 {
    color: #FFFFFF;
    margin-bottom: 20px;
    font-size: 24px;
    font-weight: 700;
    position: relative;
    padding-bottom: 15px;
}

.footer-column h3::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 50px;
    height: 3px;
    background: linear-gradient(90deg, #f59e0b 0%, #fbbf24 100%);
    border-radius: 2px;
}

.footer-column h4 {
    color: #FFFFFF;
    margin-bottom: 20px;
    font-size: 18px;
    font-weight: 600;
    position: relative;
    padding-bottom: 12px;
}

.footer-column h4::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 40px;
    height: 2px;
    background: #f59e0b;
    border-radius: 2px;
}

.footer-column p {
    color: rgba(255, 255, 255, 0.9);
    line-height: 1.8;
    margin: 12px 0;
    font-size: 15px;
}

/* Enhanced footer menu styling */
.footer-menu {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-menu li {
    margin: 12px 0;
    position: relative;
    padding-left: 20px;
}

.footer-menu li::before {
    content: '→';
    position: absolute;
    left: 0;
    color: #f59e0b;
    font-weight: bold;
    transition: transform 0.3s ease;
}

.footer-menu li:hover::before {
    transform: translateX(5px);
}

.footer-menu a {
    color: rgba(255, 255, 255, 0.9);
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 15px;
    font-weight: 500;
}

.footer-menu a:hover {
    color: #f59e0b;
    padding-left: 5px;
}

/* Enhanced footer bottom */
.footer-bottom {
    border-top: 1px solid rgba(255, 255, 255, 0.15);
    padding-top: 30px;
    text-align: center;
    margin-top: 20px;
}

.footer-bottom p {
    margin: 0;
    color: rgba(255, 255, 255, 0.8);
    font-size: 14px;
    font-weight: 400;
}

/* Add social media section to footer */
.footer-social {
    margin-top: 25px;
}

.footer-social h4 {
    font-size: 16px;
    margin-bottom: 15px;
}

.social-links {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}

.social-links a {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    color: #FFFFFF;
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 18px;
}

.social-links a:hover {
    background: #f59e0b;
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(245, 158, 11, 0.3);
}

/* Mobile responsive footer */
@media (max-width: 768px) {
    .footer-content {
        grid-template-columns: 1fr;
        gap: 40px;
    }
    
    .site-footer {
        padding: 50px 0 20px;
        margin-top: 60px;
    }
}

/* ============================================
   ENHANCED HOMEPAGE SECTIONS
   ============================================ */

/* Hero section enhancements */
.hero-section {
    background: linear-gradient(135deg, #1a2b4a 0%, #2c5282 100%);
    position: relative;
    overflow: hidden;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: 
        radial-gradient(circle at 20% 50%, rgba(59, 130, 246, 0.2) 0%, transparent 50%),
        radial-gradient(circle at 80% 80%, rgba(245, 158, 11, 0.2) 0%, transparent 50%);
    pointer-events: none;
}

/* Section headings enhancement */
.elementor-heading-title {
    font-weight: 700 !important;
    color: #1a2b4a;
    position: relative;
    padding-bottom: 20px;
    margin-bottom: 30px;
}

.elementor-heading-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: linear-gradient(90deg, #f59e0b 0%, #fbbf24 100%);
    border-radius: 2px;
}

/* Card enhancements */
.elementor-widget-container .card,
.program-card,
.info-card {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    overflow: hidden;
}

.elementor-widget-container .card:hover,
.program-card:hover,
.info-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
}

/* Button enhancements */
.elementor-button,
.wp-block-button__link {
    background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
    border: none;
    padding: 15px 35px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 16px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
    transition: all 0.3s ease;
}

.elementor-button:hover,
.wp-block-button__link:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 25px rgba(245, 158, 11, 0.4);
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
}

/* Statistics section enhancement */
.stats-section {
    background: linear-gradient(135deg, #1a2b4a 0%, #2c5282 100%);
    color: #ffffff;
    padding: 80px 0 !important;
}

.stat-item {
    text-align: center;
    padding: 30px;
}

.stat-number {
    font-size: 48px;
    font-weight: 800;
    color: #f59e0b;
    margin-bottom: 10px;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
}

.stat-label {
    font-size: 18px;
    color: rgba(255, 255, 255, 0.9);
    font-weight: 500;
}

/* ============================================
   ANIMATIONS & INTERACTIONS
   ============================================ */

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.elementor-widget-container {
    animation: fadeInUp 0.6s ease-out;
}

/* Smooth scroll behavior */
html {
    scroll-behavior: smooth;
}

/* ============================================
   RESPONSIVE IMPROVEMENTS
   ============================================ */

@media (max-width: 1024px) {
    .elementor-top-section {
        padding: 50px 0 !important;
    }
}

@media (max-width: 768px) {
    .elementor-top-section {
        padding: 40px 0 !important;
    }
    
    .elementor-heading-title {
        font-size: 28px !important;
    }
    
    .stat-number {
        font-size: 36px;
    }
}

CSS;

// Save the enhanced CSS file
$css_file = 'wp-content/themes/lumina-child-theme/assets/css/homepage-enhanced.css';
file_put_contents($css_file, $enhanced_css);

echo "✅ Enhanced CSS file created: $css_file\n\n";

// Update functions.php to enqueue the new CSS
$functions_file = 'wp-content/themes/lumina-child-theme/functions.php';
$functions_content = file_get_contents($functions_file);

// Check if already enqueued
if (strpos($functions_content, 'homepage-enhanced.css') === false) {
    // Find the enqueue styles function
    $enqueue_pattern = "/(function lumina_child_enqueue_styles\(\) \{.*?wp_enqueue_style\([^;]+;)/s";
    
    if (preg_match($enqueue_pattern, $functions_content, $matches)) {
        $new_enqueue = $matches[1] . "\n    \n    // Enhanced homepage styles\n    wp_enqueue_style(\n        'lumina-homepage-enhanced',\n        get_stylesheet_directory_uri() . '/assets/css/homepage-enhanced.css',\n        array('lumina-brand-colors'),\n        '2.0'\n    );";
        
        $functions_content = str_replace($matches[1], $new_enqueue, $functions_content);
        file_put_contents($functions_file, $functions_content);
        echo "✅ Enhanced CSS enqueued in functions.php\n\n";
    }
}

// Update footer.php with enhanced structure
$footer_enhanced = <<<'FOOTER'

<footer class="site-footer">
    <div class="footer-container">
        <div class="footer-content">
            <div class="footer-column">
                <h3>Lumina International School</h3>
                <p>Nurturing Young Minds with Islamic Values and Academic Excellence</p>
                <p><strong>📧 Email:</strong> info@luminaschool.edu<br>
                <strong>📞 Phone:</strong> (123) 456-7890<br>
                <strong>📍 Address:</strong> 123 Education Street, City</p>
                
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

file_put_contents('wp-content/themes/lumina-child-theme/footer.php', $footer_enhanced);
echo "✅ Enhanced footer.php updated\n\n";

echo "═══════════════════════════════════════════════════════════\n";
echo "✨ HOMEPAGE ENHANCEMENT COMPLETE!\n";
echo "═══════════════════════════════════════════════════════════\n\n";

echo "IMPROVEMENTS MADE:\n";
echo "✅ School name is now BOLD, larger, and has gradient effect\n";
echo "✅ School name has decorative underline accent\n";
echo "✅ Fixed section spacing - no more extended sections\n";
echo "✅ Enhanced footer with better layout and social links\n";
echo "✅ Added gradient backgrounds and modern styling\n";
echo "✅ Improved button designs with hover effects\n";
echo "✅ Better typography and spacing throughout\n";
echo "✅ Mobile responsive improvements\n\n";

echo "NEXT STEPS:\n";
echo "1. Visit your homepage to see the improvements\n";
echo "2. Clear browser cache (Ctrl+Shift+R or Cmd+Shift+R)\n";
echo "3. Check mobile view for responsiveness\n\n";

echo "═══════════════════════════════════════════════════════════\n";
?>
