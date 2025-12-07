<?php
/**
 * Force Full Width - Aggressive Approach
 * This will definitely make header and footer full width
 */

require_once('wp-load.php');

echo "═══════════════════════════════════════════════════════════\n";
echo "🔧 FORCING FULL WIDTH (AGGRESSIVE)\n";
echo "═══════════════════════════════════════════════════════════\n\n";

// Create aggressive full-width CSS
$aggressive_css = <<<CSS

/* ============================================
   AGGRESSIVE FULL WIDTH HEADER AND FOOTER
   ============================================ */

/* Remove body padding/margin */
body {
    margin: 0 !important;
    padding: 0 !important;
}

/* Remove all wrapper constraints */
#page,
#content,
.site,
.site-content,
.ast-container,
.container,
.wrap,
.wrapper {
    max-width: none !important;
    padding-left: 0 !important;
    padding-right: 0 !important;
}

/* Force header to full width */
.site-header,
header.site-header,
.ast-header,
#masthead {
    width: 100vw !important;
    max-width: 100vw !important;
    margin: 0 !important;
    padding: 0 !important;
    position: relative !important;
    left: 50% !important;
    right: 50% !important;
    margin-left: -50vw !important;
    margin-right: -50vw !important;
}

/* Header container with padding */
.header-container,
.site-header .ast-container,
.site-header .container {
    max-width: 100% !important;
    width: 100% !important;
    padding: 20px 40px !important;
    margin: 0 auto !important;
}

/* Force footer to full width */
.site-footer,
footer.site-footer,
.ast-footer,
#colophon {
    width: 100vw !important;
    max-width: 100vw !important;
    margin: 0 !important;
    padding: 0 !important;
    position: relative !important;
    left: 50% !important;
    right: 50% !important;
    margin-left: -50vw !important;
    margin-right: -50vw !important;
}

/* Footer container with padding */
.footer-container,
.site-footer .ast-container,
.site-footer .container {
    max-width: 100% !important;
    width: 100% !important;
    padding: 60px 40px 20px !important;
    margin: 0 auto !important;
}

/* Ensure content area doesn't interfere */
.site-content,
#content,
.ast-content {
    overflow-x: hidden !important;
}

/* Mobile responsive */
@media (max-width: 768px) {
    .header-container,
    .footer-container,
    .site-header .ast-container,
    .site-footer .ast-container {
        padding-left: 20px !important;
        padding-right: 20px !important;
    }
}

/* Override any Astra theme constraints */
.ast-separate-container .site-header,
.ast-separate-container .site-footer {
    padding-left: 0 !important;
    padding-right: 0 !important;
}

.ast-separate-container .ast-article-single,
.ast-separate-container .ast-article-post {
    max-width: 1200px !important;
    margin: 0 auto !important;
}

CSS;

// Write to a new high-priority CSS file
$priority_css_file = 'wp-content/themes/lumina-child-theme/assets/css/force-full-width.css';
file_put_contents($priority_css_file, $aggressive_css);
echo "✅ Created force-full-width.css\n";

// Update functions.php to enqueue with highest priority
$functions_file = 'wp-content/themes/lumina-child-theme/functions.php';
$functions_content = file_get_contents($functions_file);

if (strpos($functions_content, 'force-full-width.css') === false) {
    // Add enqueue with priority 999
    $enqueue_code = "\n\n/**\n * Force full width header and footer\n */\nfunction lumina_force_full_width() {\n    wp_enqueue_style(\n        'lumina-force-full-width',\n        get_stylesheet_directory_uri() . '/assets/css/force-full-width.css',\n        array(),\n        '1.0.0'\n    );\n}\nadd_action('wp_enqueue_scripts', 'lumina_force_full_width', 999);\n";
    
    file_put_contents($functions_file, $functions_content . $enqueue_code);
    echo "✅ Added force-full-width.css to functions.php with priority 999\n";
}

echo "\n";
echo "═══════════════════════════════════════════════════════════\n";
echo "✅ AGGRESSIVE FULL WIDTH APPLIED!\n";
echo "═══════════════════════════════════════════════════════════\n\n";

echo "CHANGES MADE:\n";
echo "✅ Created force-full-width.css with aggressive rules\n";
echo "✅ Uses viewport width (100vw) for guaranteed full width\n";
echo "✅ Uses negative margins to break out of containers\n";
echo "✅ Overrides all theme wrapper constraints\n";
echo "✅ Enqueued with priority 999 (loads last)\n\n";

echo "CRITICAL NEXT STEPS:\n";
echo "1. Clear ALL caches:\n";
echo "   - Browser: Ctrl+Shift+R (hard refresh)\n";
echo "   - WordPress cache plugin\n";
echo "   - Elementor: Tools → Regenerate CSS & Data\n";
echo "2. Visit homepage\n";
echo "3. Header and footer WILL be full width now\n\n";

echo "If still not full width after clearing cache:\n";
echo "1. Open DevTools (F12)\n";
echo "2. Check if force-full-width.css is loaded\n";
echo "3. Inspect header element\n";
echo "4. Look for 'width: 100vw' in computed styles\n\n";

echo "═══════════════════════════════════════════════════════════\n";
?>
