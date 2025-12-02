#!/bin/bash

###############################################################################
# Lumina International School - WP-CLI Installation Script
# 
# This script uses WP-CLI to install and activate all required plugins
# and theme for the Lumina International School website.
# 
# Requirements: 6.1, 7.2, 7.3, 7.4, 8.2, 8.4
# 
# Prerequisites:
# - WP-CLI must be installed (https://wp-cli.org/)
# - Run from WordPress root directory
# - WordPress must be installed and configured
#
# Usage: bash docs/wp-cli-install.sh
###############################################################################

echo "=== Lumina International School - WP-CLI Installation ==="
echo ""

# Check if WP-CLI is installed
if ! command -v wp &> /dev/null; then
    echo "Error: WP-CLI is not installed."
    echo "Please install WP-CLI from https://wp-cli.org/"
    exit 1
fi

# Check if WordPress is installed
if ! wp core is-installed 2>/dev/null; then
    echo "Error: WordPress is not installed or wp-config.php is not configured."
    exit 1
fi

echo "✓ WP-CLI found"
echo "✓ WordPress installation detected"
echo ""

###############################################################################
# Install and Activate Theme
###############################################################################

echo "Installing Theme..."
echo ""

# Install Hello Elementor theme
echo "Installing Hello Elementor theme..."
wp theme install hello-elementor --activate
if [ $? -eq 0 ]; then
    echo "  ✓ Hello Elementor theme installed and activated"
else
    echo "  ✗ Failed to install Hello Elementor theme"
fi
echo ""

###############################################################################
# Install and Activate Plugins
###############################################################################

echo "Installing Plugins..."
echo ""

# Elementor (Free version)
echo "Installing Elementor..."
wp plugin install elementor --activate
if [ $? -eq 0 ]; then
    echo "  ✓ Elementor installed and activated (Requirement 6.1)"
else
    echo "  ✗ Failed to install Elementor"
fi
echo ""

# Contact Form 7
echo "Installing Contact Form 7..."
wp plugin install contact-form-7 --activate
if [ $? -eq 0 ]; then
    echo "  ✓ Contact Form 7 installed and activated (Requirement 6.1)"
else
    echo "  ✗ Failed to install Contact Form 7"
fi
echo ""

# Yoast SEO
echo "Installing Yoast SEO..."
wp plugin install wordpress-seo --activate
if [ $? -eq 0 ]; then
    echo "  ✓ Yoast SEO installed and activated (Requirement 6.1)"
else
    echo "  ✗ Failed to install Yoast SEO"
fi
echo ""

# Wordfence Security
echo "Installing Wordfence Security..."
wp plugin install wordfence --activate
if [ $? -eq 0 ]; then
    echo "  ✓ Wordfence Security installed and activated (Requirement 8.4)"
else
    echo "  ✗ Failed to install Wordfence"
fi
echo ""

# UpdraftPlus Backup
echo "Installing UpdraftPlus..."
wp plugin install updraftplus --activate
if [ $? -eq 0 ]; then
    echo "  ✓ UpdraftPlus installed and activated (Requirement 8.2)"
else
    echo "  ✗ Failed to install UpdraftPlus"
fi
echo ""

# W3 Total Cache
echo "Installing W3 Total Cache..."
wp plugin install w3-total-cache --activate
if [ $? -eq 0 ]; then
    echo "  ✓ W3 Total Cache installed and activated (Requirements 7.3, 7.4)"
else
    echo "  ✗ Failed to install W3 Total Cache"
fi
echo ""

# Smush Image Optimization
echo "Installing Smush..."
wp plugin install wp-smushit --activate
if [ $? -eq 0 ]; then
    echo "  ✓ Smush installed and activated (Requirement 7.2)"
else
    echo "  ✗ Failed to install Smush"
fi
echo ""

# The Events Calendar
echo "Installing The Events Calendar..."
wp plugin install the-events-calendar --activate
if [ $? -eq 0 ]; then
    echo "  ✓ The Events Calendar installed and activated (Requirement 6.1)"
else
    echo "  ✗ Failed to install The Events Calendar"
fi
echo ""

###############################################################################
# Display Installation Summary
###############################################################################

echo "=== Installation Summary ==="
echo ""

# List installed plugins
echo "Installed Plugins:"
wp plugin list --status=active --format=table

echo ""
echo "Active Theme:"
wp theme list --status=active --format=table

echo ""
echo "=== Installation Complete ==="
echo ""
echo "Next Steps:"
echo "1. Run configuration script: php docs/configure-plugins.php"
echo "2. Install Elementor Pro (requires separate license)"
echo "3. Configure off-site backup storage in UpdraftPlus"
echo "4. Set up Cloudflare CDN"
echo "5. Configure SMTP for email delivery"
echo "6. Run initial Wordfence security scan"
echo ""
