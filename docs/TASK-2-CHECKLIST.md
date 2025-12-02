# Task 2: Installation and Configuration Checklist

## Quick Reference Checklist

### Installation Phase

#### Theme Installation
- [ ] Install Hello Elementor theme
- [ ] Activate Hello Elementor theme
- [ ] Verify theme is active

#### Plugin Installation
- [ ] Install Elementor (free version)
- [ ] Install Contact Form 7
- [ ] Install Yoast SEO
- [ ] Install Wordfence Security
- [ ] Install UpdraftPlus
- [ ] Install W3 Total Cache
- [ ] Install Smush
- [ ] Install The Events Calendar
- [ ] Activate all plugins

#### Elementor Pro (Separate)
- [ ] Purchase Elementor Pro license
- [ ] Download Elementor Pro from elementor.com
- [ ] Install Elementor Pro via WordPress admin
- [ ] Activate Elementor Pro license

### Configuration Phase

#### Contact Form 7
- [ ] Verify plugin is active
- [ ] Basic settings configured

#### Yoast SEO (Requirement 6.1)
- [ ] XML sitemap enabled
- [ ] Homepage title and description set
- [ ] Open Graph tags enabled
- [ ] Twitter cards enabled
- [ ] Schema markup configured
- [ ] Verify sitemap accessible at /sitemap_index.xml

#### Wordfence Security (Requirement 8.4)
- [ ] Login attempt limiting configured (5 attempts, 15-min lockout)
- [ ] Strong password enforcement enabled
- [ ] Two-factor authentication enabled
- [ ] Firewall enabled
- [ ] Malware scanning enabled
- [ ] Email alerts configured
- [ ] Run initial security scan

#### UpdraftPlus (Requirement 8.2)
- [ ] Daily backup schedule configured
- [ ] Database backup enabled
- [ ] Files backup enabled (plugins, themes, uploads)
- [ ] 7-day retention configured
- [ ] Email notifications enabled
- [ ] **CRITICAL:** Configure off-site storage (Dropbox/Google Drive/S3)
- [ ] Test backup creation
- [ ] Test backup restoration

#### W3 Total Cache (Requirements 7.3, 7.4)
- [ ] Page caching enabled
- [ ] Browser caching enabled (Requirement 7.3)
- [ ] CSS minification enabled (Requirement 7.4)
- [ ] JavaScript minification enabled (Requirement 7.4)
- [ ] HTML minification enabled
- [ ] GZIP compression enabled
- [ ] Cache lifetimes configured
- [ ] Clear all caches after configuration

#### Smush (Requirement 7.2)
- [ ] Automatic optimization on upload enabled
- [ ] Lossless compression configured
- [ ] Lazy loading enabled
- [ ] EXIF data removal enabled
- [ ] Image resizing enabled
- [ ] Test by uploading an image

#### The Events Calendar (Requirement 6.1)
- [ ] Date format configured
- [ ] Time format configured
- [ ] List view enabled
- [ ] Calendar view enabled
- [ ] Event categories enabled

#### Elementor
- [ ] Default color schemes disabled
- [ ] Default typography schemes disabled
- [ ] Optimized DOM output enabled
- [ ] Lazy loading enabled
- [ ] SVG upload enabled

### WordPress General Settings

- [ ] Permalink structure set to `/%postname%/`
- [ ] Rewrite rules flushed
- [ ] Comments disabled on pages by default
- [ ] Media organized by month/year
- [ ] Timezone configured correctly
- [ ] Admin email verified

### Security Hardening

- [ ] File editing disabled in wp-config.php
- [ ] Default admin username changed (if applicable)
- [ ] Strong passwords enforced
- [ ] HTTPS/SSL certificate installed
- [ ] Security headers configured

### Verification Tests

#### Functionality Tests
- [ ] All plugins show as active in WordPress admin
- [ ] Theme displays correctly on frontend
- [ ] No PHP errors in error log
- [ ] WordPress admin accessible
- [ ] Elementor editor loads correctly

#### Performance Tests
- [ ] Page caching working (check page source for cache comments)
- [ ] Browser caching headers present (check with browser dev tools)
- [ ] CSS/JS files are minified (check file sizes)
- [ ] Images are being optimized (check media library)
- [ ] Lazy loading working (check network tab while scrolling)

#### Security Tests
- [ ] HTTPS enforced on all pages
- [ ] Login attempt limiting working (test with wrong password)
- [ ] File editing disabled in admin
- [ ] Wordfence firewall active
- [ ] Security scan completed without critical issues

#### SEO Tests
- [ ] XML sitemap accessible
- [ ] Meta tags present on pages (view page source)
- [ ] Open Graph tags present (test with Facebook debugger)
- [ ] Clean URLs working (no ?p= parameters)

#### Backup Tests
- [ ] Manual backup completes successfully
- [ ] Backup files created in configured location
- [ ] Off-site backup uploaded successfully
- [ ] Backup restoration works (test on staging if possible)
- [ ] Email notification received

### Post-Installation Tasks

- [ ] Review installation log: `docs/installation-log.json`
- [ ] Review configuration log: `docs/configuration-log.json`
- [ ] Document any custom settings or deviations
- [ ] Set up monitoring for backup completion
- [ ] Schedule regular security scans
- [ ] Configure SMTP for email delivery (recommended)
- [ ] Set up Cloudflare CDN (optional)

### Requirements Validation

- [ ] **Requirement 6.1:** Elementor page builder installed and configured ✓
- [ ] **Requirement 7.2:** Image optimization with Smush configured ✓
- [ ] **Requirement 7.3:** Browser caching enabled via W3 Total Cache ✓
- [ ] **Requirement 7.4:** CSS/JS minification enabled via W3 Total Cache ✓
- [ ] **Requirement 8.2:** Automated daily backups configured with UpdraftPlus ✓
- [ ] **Requirement 8.4:** Security hardening with Wordfence and login limiting ✓

### Known Limitations

- Elementor Pro requires separate purchase and manual installation
- Off-site backup storage requires manual configuration in UpdraftPlus
- SMTP configuration recommended for reliable email delivery
- CDN setup (Cloudflare) is optional but recommended for performance

### Next Task

Once all items are checked:
- [ ] Mark Task 2 as complete
- [ ] Proceed to Task 3: Create and configure child theme with brand styling

## Quick Commands

### Installation (WP-CLI)
```bash
bash docs/wp-cli-install.sh
```

### Configuration
```bash
php docs/configure-plugins.php
```

### Verify Installation
```bash
wp plugin list --status=active
wp theme list --status=active
```

### Test Backup
```bash
# Via WordPress admin: Settings > UpdraftPlus Backups > Backup Now
```

### Clear Caches
```bash
# Via WordPress admin: Performance > W3 Total Cache > Empty All Caches
```

## Troubleshooting Quick Reference

| Issue | Solution |
|-------|----------|
| Plugin won't activate | Check PHP version (8.1+), increase memory limit |
| W3 Total Cache errors | Verify .htaccess writable, clear all caches |
| Backup fails | Increase max_execution_time, check disk space |
| Wordfence won't install | Check MySQL version (5.6+), increase memory |
| Images not optimizing | Verify Smush is active, check file permissions |
| Minification breaks site | Disable minification, add exclusions for problematic files |

## Support Contacts

- WordPress Support: https://wordpress.org/support/
- Elementor Support: https://elementor.com/help/
- Plugin-specific support: Check individual plugin documentation

---

**Task Status:** In Progress
**Last Updated:** [Current Date]
**Completed By:** [Your Name]
