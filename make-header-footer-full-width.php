<?php
/**
 * Make Header and Footer Full Width
 * Remove all width constraints from header and footer
 */

require_once('wp-load.php');

echo "═══════════════════════════════════════════════════════════\n";
echo "🔧 MAKING HEADER AND FOOTER FULL WIDTH\n";
echo "═══════════════════════════════════════════════════════════\n\n";

// Create comprehensive full-width CSS
$full_width_css = <<<CSS

/* ============================================
   FULL WIDTH HEADER AND FOOTER
   ============================================ */

/* Make header span full width */
.site-header {
    width: 100% !important;
    max-width: 100% !important;
    margin-left: 0 !important;
    margin-right: 0 !important;
    padding-left: 0 !important;
    padding-right: 0 !important;
}

/* Header container full width with inner padding */
.header-container {
    max-width: 100% !important;
    width: 100% !important;
    padding: 20px 40px !important;
    margin: 0 !important;
}

/* Make footer span full width */
.site-footer {
    width: 100% !important;
    max-width: 100% !important;
    margin-left: 0 !important;
    margin-right: 0 !important;
    padding-left: 0 !important;
    padding-right: 0 !important;
}

/* Footer container full width with inner padding */
.footer-container {
    max-width: 100% !important;
    width: 100% !important;
    padding: 60px 40px 20px !important;
    margin: 0 !important;
}

/* Ensure body doesn't constrain header/footer */
body {
    margin: 0 !important;
    padding: 0 !important;
}

/* Remove any wrapper constraints */
#page,
#content,
.site,
.site-content {
    max-width: 100% !important;
}

/* Ensure header and footer break out of any container */
body > .site-header,
body > .site-footer,
.site > .site-header,
.site > .site-footer {
    width: 100vw !important;
    max-width: 100vw !important;
    margin-left: calc(-50vw + 50%) !important;
    margin-right: calc(-50vw + 50%) !important;
}

/* Mobile responsive */
@media (max-width: 768px) {
    .header-container,
    .footer-container {
        padding-left: 20px !important;
        padding-right: 20px !important;
    }
}

CSS;

// Update underline-fixes.css
$fix_css_file = 'wp-content/themes/lumina-child-theme/assets/css/underline-fixes.css';
$current_content = file_exists($fix_css_file) ? file_get_contents($fix_css_file) : '';

// Remove old full width footer section if exists
$current_content = preg_replace('/\/\* ={40,}\s+FULL WIDTH FOOTER.*?\*\//s', '', $current_content);

// Append new full width CSS
file_put_contents($fix_css_file, $current_content . "\n" . $full_width_css);
echo "✅ Updated underline-fixes.css with full width header and footer\n";

// Also update header.php inline styles
$header_file = 'wp-content/themes/lumina-child-theme/header.php';
$header_content = file_get_contents($header_file);

// Update header styles in header.php
$header_content = preg_replace(
    '/\.site-header \{[^}]+\}/s',
    '.site-header {
    background: #FFFFFF;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    position: sticky;
    top: 0;
    z-index: 1000;
    padding: 0;
    border-bottom: none;
    width: 100%;
    max-width: 100%;
}',
    $header_content
);

$header_content = preg_replace(
    '/\.header-container \{[^}]+\}/s',
    '.header-container {
    max-width: 100%;
    width: 100%;
    margin: 0;
    padding: 20px 40px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}',
    $header_content
);

file_put_contents($header_file, $header_content);
echo "✅ Updated header.php with full width styles\n";

echo "\n";
echo "═══════════════════════════════════════════════════════════\n";
echo "✅ HEADER AND FOOTER ARE NOW FULL WIDTH!\n";
echo "═══════════════════════════════════════════════════════════\n\n";

echo "CHANGES MADE:\n";
echo "✅ Header width set to 100%\n";
echo "✅ Footer width set to 100%\n";
echo "✅ Removed all max-width constraints\n";
echo "✅ Header and footer break out of any container\n";
echo "✅ Content properly padded within full width\n";
echo "✅ Mobile responsive padding\n\n";

echo "NEXT STEPS:\n";
echo "1. Clear browser cache (Ctrl+Shift+R or Cmd+Shift+R)\n";
echo "2. Visit your homepage\n";
echo "3. Verify header spans full width\n";
echo "4. Scroll to footer and verify it spans full width\n";
echo "5. Check on mobile device\n\n";

echo "═══════════════════════════════════════════════════════════\n";
?>
