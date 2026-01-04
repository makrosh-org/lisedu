# Lumina International School Website

WordPress website for Lumina International School (lisedu.org)

## Project Information

- **Production URL:** https://lisedu.org
- **Local Development:** http://lisedu.test
- **WordPress Version:** Latest
- **Theme:** Lumina Child Theme (based on Astra)

## Key Features

- Custom admission inquiry form with file upload
- Student programs and events management
- Resources library
- News and blog
- Photo gallery
- Contact forms with spam protection

## Documentation

All documentation is located in the `/docs` directory:

### Setup & Deployment
- `RESTORATION-GUIDE.md` - Restore from WPvivid backup
- `CPANEL-DEPLOYMENT-GUIDE.md` - Deploy to cPanel hosting
- `SSH-CPANEL-DEPLOYMENT-GUIDE.md` - Deploy via SSH
- `NO-SSH-DEPLOYMENT-GUIDE.md` - Deploy without SSH access
- `SFTP-DEPLOYMENT-GUIDE.md` - Deploy via SFTP

### Forms & Features
- `ADMISSION-FORM-FIX-GUIDE.md` - Admission form setup and troubleshooting
- `LOCAL-SETUP-STEPS.md` - Local development setup
- `FORM-137-READY.md` - Latest form configuration
- `RECAPTCHA-QUICK-FIX.md` - Spam protection setup
- `ADD-FILE-UPLOAD-AND-RECAPTCHA-GUIDE.md` - File upload configuration

### Content Management
- `TASK-13-ADMISSION-FORM.md` - Admission form implementation
- `TASK-15-EVENTS-CPT.md` - Events custom post type
- `TASK-19-RESOURCES-CPT.md` - Resources custom post type
- `TASK-21-GALLERY-PAGE.md` - Gallery implementation

### Reference
- `FILE-STRUCTURE.md` - Project file structure
- `TAKA-CURRENCY-REFERENCE.md` - Bangladesh Taka currency formatting
- `DEPLOYMENT-CHECKLIST.md` - Pre-deployment checklist

## Quick Start

### Local Development

1. Restore from backup:
   ```bash
   cd docs
   ./restore-wpvivid-backup.sh
   ```

2. Access local site: http://lisedu.test/wp-admin

### Production Deployment

See deployment guides in `/docs` directory based on your hosting setup.

## Important Files

- `wp-config.php` - WordPress configuration (not in git)
- `wp-content/themes/lumina-child-theme/` - Custom theme
- `wp-content/plugins/` - Installed plugins
- `.htaccess` - Apache configuration

## Plugins Used

- Contact Form 7 - Form management
- CF7 Apps - Honeypot spam protection
- Flamingo - Form submission storage
- Elementor - Page builder
- Astra - Base theme

## Support

For issues or questions, refer to the documentation in `/docs` or contact the development team.

## License

WordPress core is licensed under GPL v2 or later.
Custom theme and modifications are proprietary.
