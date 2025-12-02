# Task 1 Implementation: WordPress Environment Setup

## Overview

This directory contains all the resources needed to complete **Task 1: Set up WordPress environment and base configuration** for the Lumina International School website.

## What's Included

### 1. **wordpress-setup-guide.md**
Comprehensive step-by-step guide for installing and configuring WordPress. This includes:
- WordPress installation instructions (cPanel and manual methods)
- Database setup and configuration
- SSL certificate installation and HTTPS enforcement
- Basic WordPress settings configuration
- Security hardening steps
- Verification procedures
- Troubleshooting tips

**Start here** if you're setting up WordPress for the first time.

### 2. **wp-config-template.php**
Pre-configured WordPress configuration file template with:
- Recommended security settings
- Performance optimizations
- Proper database configuration structure
- Security keys placeholders
- File upload settings
- Memory limits

**Usage**: Copy to your WordPress root, rename to `wp-config.php`, and fill in your database credentials.

### 3. **.htaccess-template**
Apache configuration file with:
- HTTPS enforcement rules
- WordPress permalink rules
- Browser caching configuration
- GZIP compression
- Security headers
- File upload security

**Usage**: Copy to your WordPress root and rename to `.htaccess`.

### 4. **verify-wordpress-setup.php**
Automated verification script that checks:
- WordPress version (6.4+)
- PHP version (8.1+)
- MySQL version (8.0+)
- HTTPS/SSL status
- Permalink configuration
- Timezone settings
- Database connection
- Security settings
- File permissions

**Usage**: Upload to WordPress root, access via browser, then **delete after verification**.

### 5. **TASK-1-CHECKLIST.md**
Interactive checklist to ensure all Task 1 requirements are met before proceeding to Task 2.

## Implementation Steps

### Step 1: Review the Setup Guide
Read `wordpress-setup-guide.md` thoroughly to understand the complete process.

### Step 2: Install WordPress
Follow the installation instructions in the setup guide using either:
- cPanel/Softaculous (recommended for beginners)
- Manual installation via SSH (for advanced users)

### Step 3: Configure Database
- Create MySQL database
- Create database user with strong password
- Grant all privileges to the user
- Note credentials for wp-config.php

### Step 4: Configure wp-config.php
1. Copy `wp-config-template.php` to your WordPress root
2. Rename to `wp-config.php`
3. Fill in database credentials
4. Generate and add security keys from https://api.wordpress.org/secret-key/1.1/salt/
5. Adjust settings as needed

### Step 5: Set Up SSL and HTTPS
1. Install SSL certificate (Let's Encrypt recommended)
2. Copy `.htaccess-template` to WordPress root
3. Rename to `.htaccess`
4. Update WordPress URLs to use https://

### Step 6: Configure WordPress Settings
Log into WordPress admin and configure:
- **General Settings**: Timezone, date/time formats, site URLs
- **Permalink Settings**: Set to "Post name" structure
- **Media Settings**: Enable date-based folder organization

### Step 7: Verify Setup
1. Upload `verify-wordpress-setup.php` to WordPress root
2. Log in as administrator
3. Access the script via browser: `https://yourdomain.com/verify-wordpress-setup.php`
4. Review all checks
5. Address any failures or warnings
6. **Delete the verification script**

### Step 8: Complete Checklist
Go through `TASK-1-CHECKLIST.md` and ensure all items are checked.

## Requirements Validation

This task satisfies **Requirement 8.1** from the requirements document:
> "THE Website System SHALL implement SSL certificate for HTTPS encryption"

All configuration files and scripts ensure:
- ✓ WordPress 6.4+ installation
- ✓ PHP 8.1+ environment
- ✓ MySQL 8.0+ database
- ✓ SSL/HTTPS enforcement
- ✓ Proper WordPress configuration
- ✓ Database connectivity
- ✓ Security hardening

## Important Security Notes

1. **Never commit wp-config.php** with real credentials to version control
2. **Delete verify-wordpress-setup.php** after use
3. **Use strong passwords** for all accounts
4. **Keep credentials secure** - use a password manager
5. **Regular backups** will be configured in later tasks

## Next Steps

Once Task 1 is complete and verified:
1. Mark Task 1 as complete in tasks.md
2. Proceed to **Task 2: Install and configure theme and essential plugins**

## Support

If you encounter issues during setup:
- Consult the troubleshooting section in `wordpress-setup-guide.md`
- Check WordPress Codex: https://codex.wordpress.org/
- Contact your hosting provider's support team
- Review WordPress Support Forums: https://wordpress.org/support/

## Files Summary

| File | Purpose | Action Required |
|------|---------|-----------------|
| wordpress-setup-guide.md | Complete setup instructions | Read and follow |
| wp-config-template.php | WordPress configuration | Copy, rename, configure |
| .htaccess-template | Server configuration | Copy, rename |
| verify-wordpress-setup.php | Automated verification | Upload, run, delete |
| TASK-1-CHECKLIST.md | Completion verification | Check all items |
| README-TASK-1.md | This file | Reference guide |

---

**Project**: Lumina International School Website  
**Task**: 1. Set up WordPress environment and base configuration  
**Status**: Ready for implementation  
**Requirements**: 8.1
