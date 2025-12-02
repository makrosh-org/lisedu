# Task 1 Completion Checklist
## Set up WordPress environment and base configuration

Use this checklist to verify Task 1 is complete before proceeding to Task 2.

## Installation Requirements

- [ ] WordPress 6.4+ installed on hosting server
- [ ] PHP 8.1+ confirmed (check via Site Health or phpinfo)
- [ ] MySQL 8.0+ confirmed (check via Site Health)
- [ ] Can successfully log into WordPress admin panel

## SSL/HTTPS Configuration (Requirement 8.1)

- [ ] SSL certificate installed on server
- [ ] HTTPS is enforced (http:// URLs redirect to https://)
- [ ] WordPress Address (URL) uses https:// (Settings > General)
- [ ] Site Address (URL) uses https:// (Settings > General)
- [ ] Green padlock appears in browser address bar
- [ ] .htaccess includes HTTPS redirect rules

## Basic WordPress Settings

### Timezone Configuration
- [ ] Timezone set to school's local timezone (Settings > General)
- [ ] Date format configured (Settings > General)
- [ ] Time format configured (Settings > General)

### Permalink Configuration
- [ ] Permalink structure set to "Post name" (Settings > Permalinks)
- [ ] Custom structure shows: `/%postname%/`
- [ ] Test: Create a page and verify URL is SEO-friendly

### Media Organization
- [ ] "Organize uploads into month- and year-based folders" is checked (Settings > Media)
- [ ] Image sizes configured:
  - Thumbnail: 400 x 300
  - Medium: 800 x 600
  - Large: 1200 x 800

## Database Connection

- [ ] Database connection verified (Site Health shows green)
- [ ] Can create and save pages/posts
- [ ] Can upload media to library
- [ ] No database errors in Site Health

## Security Hardening (Initial)

- [ ] Admin username is NOT "admin"
- [ ] Strong password set for admin account
- [ ] Security keys updated in wp-config.php (from https://api.wordpress.org/secret-key/1.1/salt/)
- [ ] File editing disabled (DISALLOW_FILE_EDIT = true in wp-config.php)
- [ ] wp-config.php permissions set to 600 or 640

## File Permissions

- [ ] Directories: 755
- [ ] Files: 644
- [ ] wp-config.php: 600 (recommended)

## Verification

- [ ] Run verify-wordpress-setup.php script
- [ ] All critical checks pass
- [ ] Address any warnings if possible
- [ ] Delete verify-wordpress-setup.php after verification

## Functionality Tests

- [ ] Can log into WordPress admin
- [ ] Can create a test page
- [ ] Can publish the test page
- [ ] Can view the page on frontend
- [ ] Can upload an image to media library
- [ ] Site Health shows no critical issues

## Documentation

- [ ] Database credentials documented securely
- [ ] Admin login credentials stored securely
- [ ] Hosting account details documented
- [ ] SSL certificate details noted (expiration date, provider)

## Files Created/Configured

- [ ] wp-config.php (with proper database credentials and security keys)
- [ ] .htaccess (with HTTPS redirect and WordPress rules)
- [ ] WordPress core files installed

## Ready for Next Task?

If all items above are checked, you are ready to proceed to:
**Task 2: Install and configure theme and essential plugins**

---

## Troubleshooting Resources

If you encounter issues:

1. **Cannot access admin panel**: Check database credentials in wp-config.php
2. **SSL not working**: Verify certificate installation with hosting provider
3. **Permalinks showing 404**: Re-save permalink settings, check .htaccess
4. **Permission errors**: Contact hosting provider to verify file ownership
5. **Site Health issues**: Review recommendations in Tools > Site Health

## Support

- WordPress Codex: https://codex.wordpress.org/
- WordPress Support Forums: https://wordpress.org/support/
- Hosting Provider Support: Contact your hosting provider's support team

---

**Task Reference**: .kiro/specs/lumina-school-website/tasks.md - Task 1
**Requirements**: 8.1 (SSL/HTTPS enforcement)
