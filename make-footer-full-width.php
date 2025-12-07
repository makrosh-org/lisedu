<?php
/**
 * Make Footer Full Width
 * Remove max-width constraint from footer
 */

require_once('wp-load.php');

echo "═══════════════════════════════════════════════════════════\n";
echo "🔧 MAKING FOOTER FULL WIDTH\n";
echo "═══════════════════════════════════════════════════════════\n\n";

// Add full width footer CSS to underline-fixes.css
$footer_full_width_css = <<<CSS

/* ============================================
   FULL WIDTH FOOTER
   ============================================ */

/* Make footer span full width */
.site-footer {
    width: 100% !important;
    max-width: 100% !important;
    margin-left: 0 !important;
    margin-right: 0 !important;
    padding-left: 0 !important;
    padding-right: 0 !important;
}

/* Footer container should also be full width */
.footer-container {
    max-width: 100% !important;
    width: 100% !important;
    padding: 0 40px !important;
}

/* Ensure footer content spans properly */
.footer-content {
    max-width: 1400px;
    margin: 0 auto;
    width: 100%;
}

/* Footer bottom full width */
.footer-bottom {
    max-width: 100% !important;
    width: 100% !important;
}

/* Remove any body or wrapper constraints */
body .site-footer {
    margin-left: auto !important;
    margin-right: auto !important;
}

CSS;

// Append to underline-fixes.css
$fix_css_file = 'wp-content/themes/lumina-child-theme/assets/css/underline-fixes.css';
if (file_exists($fix_css_file)) {
    file_put_contents($fix_css_file, $footer_full_width_css, FILE_APPEND);
    echo "✅ Added full width footer CSS to underline-fixes.css\n";
} else {
    file_put_contents($fix_css_file, $footer_full_width_css);
    echo "✅ Created underline-fixes.css with full width footer CSS\n";
}

// Also update homepage-enhanced.css to ensure footer is full width
$enhanced_css_file = 'wp-content/themes/lumina-child-theme/assets/css/homepage-enhanced.css';
if (file_exists($enhanced_css_file)) {
    $enhanced_css = file_get_contents($enhanced_css_file);
    
    // Replace the footer-container max-width
    $enhanced_css = preg_replace(
        '/\.footer-container\s*\{[^}]*max-width:\s*[^;]+;/s',
        '.footer-container {
    max-width: 100%;',
        $enhanced_css
    );
    
    // Add full width to site-footer if not present
    if (strpos($enhanced_css, 'width: 100%') === false) {
        $enhanced_css = str_replace(
            '.site-footer {',
            '.site-footer {
    width: 100%;
    max-width: 100%;',
            $enhanced_css
        );
    }
    
    file_put_contents($enhanced_css_file, $enhanced_css);
    echo "✅ Updated homepage-enhanced.css for full width footer\n";
}

echo "\n";
echo "═══════════════════════════════════════════════════════════\n";
echo "✅ FOOTER IS NOW FULL WIDTH!\n";
echo "═══════════════════════════════════════════════════════════\n\n";

echo "CHANGES MADE:\n";
echo "✅ Footer width set to 100%\n";
echo "✅ Removed max-width constraint from footer\n";
echo "✅ Footer container set to full width\n";
echo "✅ Content properly centered within full width footer\n";
echo "✅ Padding adjusted for better spacing\n\n";

echo "NEXT STEPS:\n";
echo "1. Clear browser cache (Ctrl+Shift+R or Cmd+Shift+R)\n";
echo "2. Visit your homepage\n";
echo "3. Scroll to footer\n";
echo "4. Verify footer spans full width of screen\n\n";

echo "═══════════════════════════════════════════════════════════\n";
?>
