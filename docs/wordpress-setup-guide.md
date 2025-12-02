# WordPress Environment Setup Guide - Lumina International School

## Prerequisites

Before beginning, ensure you have:
- Web hosting account with cPanel or similar control panel
- PHP 8.1+ support
- MySQL 8.0+ database support
- SSH access (recommended)
- Domain name configured

## Step 1: Install WordPress 6.4+

### Option A: Using cPanel (Recommended for beginners)

1. Log into your hosting cPanel
2. Navigate to "WordPress" or "Softaculous Apps Installer"
3. Click "Install Now"
4. Configure installation:
   - Choose Protocol: `https://` (SSL will be configured in Step 3)
   - Choose Domain: Your school domain
   - Directory: Leave empty for root installation
   - Database Name: `lumina_wp_db` (or auto-generate)
   - Admin Username: Choose a secure username (NOT "admin")
   - Admin Password: Use a strong password
   - Admin Email: Your administrative email
5. Click "Install"
6. Save the installation details provided

### Option B: Manual Installation via SSH

```bash
# Download WordPress
cd /path/to/public_html
wget https://wordpress.org/latest.tar.gz
tar -xzf latest.tar.gz
mv wordpress/* .
rm -rf wordpress latest.tar.gz

# Set proper permissions
find . -type d -exec chmod 755 {} \;
find . -type f -exec chmod 644 {} \;
```

## Step 2: Configure Database Connection

### Create MySQL Database

1. In cPanel, go to "MySQL Databases"
2. Create new database: `lumina_wp_db`
3. Create new user: `lumina_wp_user`
4. Set strong password
5. Add user to database with ALL PRIVILEGES
6. Note down:
   - Database name
   - Database username
   - Database password
   - Database host (usually `localhost`)

### Configure wp-config.php

If not auto-configured, edit `wp-config.php`:

```php
define( 'DB_NAME', 'lumina_wp_db' );
define( 'DB_USER', 'lumina_wp_user' );
define( 'DB_PASSWORD', 'your_secure_password' );
define( 'DB_HOST', 'localhost' );
define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', '' );
```

## Step 3: Set Up SSL Certificate and Enforce HTTPS

### Install SSL Certificate

#### Option A: Let's Encrypt (Free, Recommended)

1. In cPanel, go to "SSL/TLS Status"
2. Select your domain
3. Click "Run AutoSSL"
4. Wait for certificate installation

#### Option B: Manual SSL Installation

1. Purchase SSL certificate from provider
2. In cPanel, go to "SSL/TLS"
3. Upload certificate files
4. Install certificate for your domain

### Enforce HTTPS

Add to `.htaccess` in WordPress root:

```apache
# Force HTTPS
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
</IfModule>
```

Update WordPress URLs:
1. Log into WordPress admin
2. Go to Settings > General
3. Update both:
   - WordPress Address (URL): `https://yourdomain.com`
   - Site Address (URL): `https://yourdomain.com`
4. Save changes

## Step 4: Configure Basic WordPress Settings

### Timezone Configuration

1. Log into WordPress admin (`https://yourdomain.com/wp-admin`)
2. Navigate to Settings > General
3. Set Timezone: Choose your school's timezone
4. Set Date Format: Select preferred format
5. Set Time Format: Select preferred format
6. Save Changes

### Permalink Configuration

1. Navigate to Settings > Permalinks
2. Select "Post name" structure (SEO-friendly)
3. Custom Structure will show: `/%postname%/`
4. Save Changes

### Media Organization

1. Navigate to Settings > Media
2. Check "Organize my uploads into month- and year-based folders"
3. Set image sizes:
   - Thumbnail: 400 x 300 (cropped)
   - Medium: 800 x 600
   - Large: 1200 x 800
4. Save Changes

### Reading Settings

1. Navigate to Settings > Reading
2. Set "Your homepage displays": A static page (will configure later)
3. Blog pages show at most: 10 posts
4. Save Changes

### Discussion Settings

1. Navigate to Settings > Discussion
2. Uncheck "Allow people to submit comments on new posts"
3. Save Changes (comments not needed for school pages)

## Step 5: Verify Database Connection and Functionality

### Test Database Connection

1. Log into WordPress admin successfully
2. Navigate to Tools > Site Health
3. Check "Database" section - should show green status
4. Verify:
   - Database server version: MySQL 8.0+
   - PHP version: 8.1+
   - HTTPS status: Active

### Test Basic Functionality

1. Create a test page:
   - Pages > Add New
   - Title: "Test Page"
   - Content: "This is a test"
   - Publish
2. View the page on frontend
3. Delete the test page

### Verify File Permissions

Ensure proper permissions:
- Directories: 755
- Files: 644
- wp-config.php: 600 (more secure)

```bash
# Via SSH
chmod 600 wp-config.php
```

## Step 6: Security Hardening (Initial)

### Update wp-config.php Security Keys

1. Visit: https://api.wordpress.org/secret-key/1.1/salt/
2. Copy the generated keys
3. Replace the placeholder keys in wp-config.php

### Disable File Editing

Add to wp-config.php (before "That's all, stop editing!"):

```php
// Disable file editing in admin
define( 'DISALLOW_FILE_EDIT', true );
```

### Change Database Table Prefix (if not done during install)

Default is `wp_` - consider changing to something unique like `lum_` for security.

## Verification Checklist

- [ ] WordPress 6.4+ installed successfully
- [ ] Can log into WordPress admin
- [ ] PHP version is 8.1 or higher
- [ ] MySQL version is 8.0 or higher
- [ ] SSL certificate installed and active
- [ ] HTTPS enforced (http:// redirects to https://)
- [ ] Timezone configured correctly
- [ ] Permalinks set to "Post name"
- [ ] Media organization enabled
- [ ] Database connection verified in Site Health
- [ ] Can create and publish pages
- [ ] Security keys updated in wp-config.php
- [ ] File editing disabled in admin

## Next Steps

Once this setup is complete, proceed to Task 2: Install and configure theme and essential plugins.

## Troubleshooting

### Cannot connect to database
- Verify database credentials in wp-config.php
- Check if database user has proper privileges
- Confirm database host is correct (usually localhost)

### SSL not working
- Clear browser cache
- Check .htaccess rules
- Verify SSL certificate is installed correctly
- Check with hosting provider

### Permalinks not working (404 errors)
- Check if mod_rewrite is enabled
- Verify .htaccess file exists and is writable
- Re-save permalink settings

### Permission denied errors
- Check file and directory permissions
- Ensure web server user owns WordPress files
- Contact hosting provider if issues persist

## Support Resources

- WordPress Codex: https://codex.wordpress.org/
- WordPress Support: https://wordpress.org/support/
- Hosting Provider Documentation
