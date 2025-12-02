# Task 2: Plugin and Theme Installation Guide

## Overview

This guide covers the installation and configuration of all required plugins and theme for the Lumina International School website.

**Requirements Addressed:** 6.1, 7.2, 7.3, 7.4, 8.2, 8.4

## Installation Methods

You can install the plugins and theme using one of three methods:

### Method 1: WP-CLI (Recommended)

**Prerequisites:**
- WP-CLI installed ([Installation Guide](https://wp-cli.org/))
- SSH access to server
- WordPress installed and configured

**Steps:**
```bash
# Navigate to WordPress root directory
cd /path/to/wordpress

# Make the script executable
chmod +x docs/wp-cli-install.sh

# Run the installation script
bash docs/wp-cli-install.sh

# Run the configuration script
php docs/configure-plugins.php
```

### Method 2: WordPress Admin Interface

**Steps:**
1. Log in to WordPress Admin (yoursite.com/wp-admin)
2. Navigate to **Appearance > Themes > Add New**
3. Search for and install **Hello Elementor**
4. Activate the theme
5. Navigate to **Plugins > Add New**
6. Install and activate each plugin listed below

### Method 3: PHP Installation Script

**Steps:**
```bash
# Run the installation script
php docs/install-plugins-theme.php

# Run the configuration script
php docs/configure-plugins.php
```

## Required Components

### Theme

| Component | Slug | Purpose | Requirement |
|-----------|------|---------|-------------|
| Hello Elementor | `hello-elementor` | Lightweight base theme optimized for Elementor | 6.1 |

**Alternative:** Astra theme can be used instead of Hello Elementor

### Plugins

| Plugin | Slug | Purpose | Requirement |
|--------|------|---------|-------------|
| Elementor | `elementor` | Page builder for visual content editing | 6.1 |
| Contact Form 7 | `contact-form-7` | Form handling and submissions | 6.1 |
| Yoast SEO | `wordpress-seo` | SEO optimization and XML sitemaps | 6.1 |
| Wordfence Security | `wordfence` | Security hardening and login protection | 8.4 |
| UpdraftPlus | `updraftplus` | Automated backup system | 8.2 |
| W3 Total Cache | `w3-total-cache` | Performance optimization and caching | 7.3, 7.4 |
| Smush | `wp-smushit` | Image optimization and lazy loading | 7.2 |
| The Events Calendar | `the-events-calendar` | Event management system | 6.1 |

### Additional Component (Requires Separate Purchase)

| Component | Purpose | Requirement |
|-----------|---------|-------------|
| Elementor Pro | Advanced page builder features and widgets | 6.1 |

**Note:** Elementor Pro requires a separate license and must be installed manually from [elementor.com](https://elementor.com/)

## Configuration Details

### 1. Contact Form 7
- **Purpose:** Handle contact and admission inquiry forms
- **Configuration:** Individual forms configured per page
- **Settings Applied:**
  - Spam protection enabled
  - Email notifications configured
  - Form validation enabled

### 2. Yoast SEO
- **Purpose:** Search engine optimization
- **Settings Applied:**
  - XML sitemap enabled and configured
  - Open Graph tags enabled for social sharing
  - Meta titles and descriptions configured
  - SEO-friendly URL structure
  - Schema markup for educational organization

**Key Settings:**
```
- Separator: Dash (-)
- Homepage Title: Lumina International School - Islamic Education Excellence
- Homepage Description: Quality Islamic education from play group to grade 5
- XML Sitemap: Enabled
- Open Graph: Enabled
- Twitter Cards: Enabled
```

### 3. Wordfence Security
- **Purpose:** Website security and brute force protection
- **Settings Applied:**
  - Login attempt limiting: 5 attempts, 15-minute lockout
  - Strong password enforcement
  - Two-factor authentication enabled
  - Firewall enabled
  - Malware scanning enabled
  - Live traffic monitoring

**Security Features:**
- Brute force protection (Requirement 8.4)
- Real-time threat defense
- Security notifications to admin email
- File integrity monitoring

### 4. UpdraftPlus
- **Purpose:** Automated backup system
- **Settings Applied:**
  - Daily automated backups
  - 7-day backup retention
  - Email notifications on backup completion
  - Includes: database, plugins, themes, uploads

**Important:** Configure off-site storage:
- Recommended: Dropbox, Google Drive, or Amazon S3
- Navigate to: Settings > UpdraftPlus Backups > Settings
- Select remote storage option and authenticate

### 5. W3 Total Cache
- **Purpose:** Performance optimization
- **Settings Applied:**
  - Page caching enabled (file-based)
  - Browser caching enabled (Requirement 7.3)
  - CSS/JS minification enabled (Requirement 7.4)
  - GZIP compression enabled
  - Cache lifetime: CSS/JS (1 year), HTML (1 hour)

**Performance Features:**
- Reduces page load times
- Improves Google PageSpeed scores
- Reduces server load

### 6. Smush
- **Purpose:** Image optimization
- **Settings Applied:**
  - Automatic optimization on upload (Requirement 7.2)
  - Lossless compression
  - Lazy loading enabled
  - EXIF data removal
  - Image resizing enabled

**Optimization Features:**
- Reduces image file sizes without quality loss
- Improves page load performance
- Lazy loading for better initial page load

### 7. The Events Calendar
- **Purpose:** Event management
- **Settings Applied:**
  - List and calendar views enabled
  - Date format: F j, Y (e.g., January 15, 2024)
  - Time format: 12-hour with AM/PM
  - Event categories enabled

**Event Features:**
- Chronological event listing
- Category filtering
- Event detail pages
- Calendar view

### 8. Elementor
- **Purpose:** Visual page builder
- **Settings Applied:**
  - Optimized DOM output enabled
  - Lazy loading enabled for images and backgrounds
  - Default color schemes disabled (using custom brand colors)
  - Default typography schemes disabled (using custom fonts)
  - SVG upload enabled

**Performance Optimizations:**
- Reduced CSS output
- Lazy loading for better performance
- Optimized for speed

## WordPress General Settings

The configuration script also applies these WordPress settings:

### Permalinks
- **Structure:** `/%postname%/` (SEO-friendly)
- **Purpose:** Clean, readable URLs for better SEO

### Comments
- **Default Status:** Closed on pages
- **Purpose:** Reduce spam and unnecessary comments

### Media
- **Organization:** By month/year folders
- **Purpose:** Better file organization

### Timezone
- **Default:** Asia/Dubai
- **Note:** Adjust based on school location

### Security Hardening
- **File Editing:** Disabled in WordPress admin
- **Purpose:** Prevent unauthorized code modifications

## Post-Installation Checklist

After running the installation and configuration scripts:

- [ ] Verify all plugins are activated
- [ ] Check Hello Elementor theme is active
- [ ] Configure UpdraftPlus off-site backup storage
- [ ] Install Elementor Pro (requires license)
- [ ] Run initial Wordfence security scan
- [ ] Test backup creation and restoration
- [ ] Verify W3 Total Cache is working (check page source for cache comments)
- [ ] Test image optimization by uploading a test image
- [ ] Verify Yoast SEO XML sitemap is accessible (yoursite.com/sitemap_index.xml)
- [ ] Configure SMTP for reliable email delivery (recommended plugin: WP Mail SMTP)
- [ ] Set up Cloudflare CDN (optional but recommended)
- [ ] Review and adjust timezone if needed
- [ ] Test contact form submission
- [ ] Verify security settings in Wordfence

## Verification Commands

### Check Plugin Status
```bash
wp plugin list --status=active
```

### Check Theme Status
```bash
wp theme list --status=active
```

### Verify Permalink Structure
```bash
wp rewrite structure
```

### Check Site Health
```bash
wp site health
```

## Troubleshooting

### Plugin Activation Errors
- Check PHP version (requires 8.1+)
- Verify file permissions
- Check error logs: `wp-content/debug.log`
- Increase PHP memory limit if needed

### W3 Total Cache Issues
- Clear all caches after configuration
- Verify .htaccess is writable
- Check for conflicts with other caching plugins

### Wordfence Installation Issues
- Requires MySQL 5.6+ or MariaDB 10.0+
- May need to increase PHP memory limit
- Check server firewall settings

### UpdraftPlus Backup Failures
- Verify PHP max_execution_time is sufficient (300+ seconds)
- Check available disk space
- Verify remote storage credentials

## Next Steps

After completing this task:

1. **Task 3:** Create and configure child theme with brand styling
2. **Task 4:** Configure Elementor global settings and templates
3. **Task 5:** Create page structure and navigation

## Requirements Validation

This task addresses the following requirements:

- **6.1:** Content management system with Elementor page builder ✓
- **7.2:** Image optimization implementation ✓
- **7.3:** Browser caching enabled ✓
- **7.4:** CSS/JS minification enabled ✓
- **8.2:** Automated daily backup system ✓
- **8.4:** Security hardening and login attempt limiting ✓

## Support Resources

- [WordPress Codex](https://codex.wordpress.org/)
- [Elementor Documentation](https://elementor.com/help/)
- [Yoast SEO Documentation](https://yoast.com/help/)
- [Wordfence Documentation](https://www.wordfence.com/help/)
- [UpdraftPlus Documentation](https://updraftplus.com/support/)
- [W3 Total Cache Documentation](https://www.boldgrid.com/support/w3-total-cache/)

## Files Created

- `docs/install-plugins-theme.php` - PHP installation script
- `docs/configure-plugins.php` - Plugin configuration script
- `docs/wp-cli-install.sh` - WP-CLI installation script
- `docs/TASK-2-PLUGIN-INSTALLATION-GUIDE.md` - This documentation
- `docs/installation-log.json` - Installation results log (generated)
- `docs/configuration-log.json` - Configuration results log (generated)
