# Quick Deployment Checklist for lisedu.org

Use this checklist to deploy your Lumina School WordPress site to cPanel hosting.

## Pre-Deployment Checklist

- [ ] cPanel login credentials ready
- [ ] Database name, username, and password from cPanel
- [ ] Backup of local WordPress site
- [ ] Backup of local database

## Deployment Steps

### Step 1: Prepare Files Locally

```bash
# Navigate to your WordPress directory
cd /path/to/your/wordpress

# Create deployment package
zip -r lumina-deploy.zip . \
  -x "*.git*" \
  -x "*.DS_Store" \
  -x "node_modules/*" \
  -x "*.log" \
  -x "wp-content/cache/*"

# Verify zip was created
ls -lh lumina-deploy.zip
```

- [ ] Zip file created successfully
- [ ] Zip file size is reasonable (check with `ls -lh`)

### Step 2: Export Database

```bash
# Export your local database
mysqldump -u root -p wordpress_db > lumina-database.sql

# Verify export
ls -lh lumina-database.sql
```

- [ ] Database exported successfully
- [ ] SQL file exists and has content

### Step 3: Create Database in cPanel

1. Log into cPanel at: https://lisedu.org:2083
2. Go to "MySQL Databases"
3. Create new database:
   - Database name: `liseqtmc_lumina` (or similar)
   - Click "Create Database"
4. Create database user:
   - Username: `liseqtmc_admin` (or similar)
   - Password: (generate strong password)
   - Click "Create User"
5. Add user to database:
   - Select user and database
   - Grant "ALL PRIVILEGES"
   - Click "Add"

**Write down these credentials:**
- Database name: ________________
- Database user: ________________
- Database password: ________________
- Database host: localhost

- [ ] Database created
- [ ] Database user created
- [ ] User added to database with all privileges
- [ ] Credentials saved securely

### Step 4: Upload Files

#### Option A: SFTP (Try this first)

```bash
# Try connecting via SFTP
sftp liseqtmc@lisedu.org

# If that times out, try port 2222
sftp -P 2222 liseqtmc@lisedu.org

# Once connected:
cd public_html
put lumina-deploy.zip
bye
```

- [ ] SFTP connection successful
- [ ] Zip file uploaded

#### Option B: cPanel File Manager (If SFTP fails)

1. Log into cPanel
2. Open "File Manager"
3. Navigate to `public_html`
4. Click "Upload"
5. Select `lumina-deploy.zip`
6. Wait for upload to complete (watch progress bar)

- [ ] File Manager opened
- [ ] Navigated to public_html
- [ ] Zip file uploaded successfully

### Step 5: Extract Files on Server

#### If using cPanel File Manager:

1. In File Manager, locate `lumina-deploy.zip`
2. Right-click the file
3. Select "Extract"
4. Confirm extraction to current directory
5. Wait for extraction to complete
6. Delete the zip file (right-click > Delete)

- [ ] Files extracted successfully
- [ ] Zip file deleted
- [ ] WordPress files visible in public_html

#### If using SFTP with shell access:

```bash
ssh liseqtmc@lisedu.org
cd public_html
unzip lumina-deploy.zip
rm lumina-deploy.zip
```

### Step 6: Configure wp-config.php

#### Option A: Edit in cPanel File Manager

1. In File Manager, locate `wp-config.php`
2. Right-click > "Edit"
3. Update these lines with your cPanel database credentials:

```php
define( 'DB_NAME', 'liseqtmc_lumina' );     // Your database name
define( 'DB_USER', 'liseqtmc_admin' );      // Your database user
define( 'DB_PASSWORD', 'your-password' );    // Your database password
define( 'DB_HOST', 'localhost' );            // Usually localhost
```

4. Click "Save Changes"

#### Option B: Edit locally and re-upload

```bash
# Edit wp-config.php on your Mac
nano wp-config.php

# Update database credentials
# Save and exit (Ctrl+O, Enter, Ctrl+X)

# Upload via SFTP
sftp liseqtmc@lisedu.org
cd public_html
put wp-config.php
bye
```

- [ ] wp-config.php updated with correct database credentials
- [ ] File saved successfully

### Step 7: Upload and Import Database

#### Upload database file:

```bash
# Via SFTP
sftp liseqtmc@lisedu.org
put lumina-database.sql
bye
```

Or upload via cPanel File Manager to home directory.

- [ ] Database SQL file uploaded

#### Import via phpMyAdmin:

1. In cPanel, open "phpMyAdmin"
2. Select your database (liseqtmc_lumina) from left sidebar
3. Click "Import" tab
4. Click "Choose File"
5. Select `lumina-database.sql`
6. Scroll down and click "Go"
7. Wait for import to complete (you'll see success message)

- [ ] phpMyAdmin opened
- [ ] Database selected
- [ ] SQL file imported successfully
- [ ] No errors shown

### Step 8: Update Site URLs

In phpMyAdmin:

1. Click "SQL" tab
2. Run these queries (replace with your actual domain):

```sql
UPDATE wp_options 
SET option_value = 'https://lisedu.org' 
WHERE option_name = 'siteurl';

UPDATE wp_options 
SET option_value = 'https://lisedu.org' 
WHERE option_name = 'home';
```

3. Click "Go"

- [ ] Site URL updated
- [ ] Home URL updated
- [ ] Queries executed successfully

### Step 9: Set File Permissions

#### If you have SSH/SFTP access:

```bash
ssh liseqtmc@lisedu.org
cd public_html
find . -type d -exec chmod 755 {} \;
find . -type f -exec chmod 644 {} \;
chmod 600 wp-config.php
```

#### Or in cPanel File Manager:

1. Select all files and folders
2. Click "Permissions" at the top
3. For folders: Set to 755
4. For files: Set to 644
5. For wp-config.php specifically: Set to 600

- [ ] Directory permissions set to 755
- [ ] File permissions set to 644
- [ ] wp-config.php set to 600

### Step 10: Test Your Site

1. Visit: https://lisedu.org
2. Check if homepage loads correctly
3. Test navigation menu
4. Visit: https://lisedu.org/wp-admin
5. Login with your WordPress credentials
6. Check if admin dashboard loads

- [ ] Homepage loads without errors
- [ ] Navigation works
- [ ] Can access wp-admin
- [ ] Can login successfully
- [ ] Dashboard loads properly

### Step 11: Update Permalinks

1. In WordPress admin, go to Settings > Permalinks
2. Don't change anything, just click "Save Changes"
3. This regenerates the .htaccess file

- [ ] Permalinks saved
- [ ] .htaccess regenerated

### Step 12: Enable SSL (HTTPS)

1. In cPanel, search for "SSL/TLS Status"
2. Find your domain (lisedu.org)
3. Click "Run AutoSSL" or install Let's Encrypt certificate
4. Wait for SSL to be issued (usually 1-5 minutes)

- [ ] SSL certificate installed
- [ ] Site accessible via HTTPS

### Step 13: Force HTTPS (Optional but Recommended)

Edit .htaccess in public_html and add at the top:

```apache
# Force HTTPS
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
</IfModule>
```

- [ ] .htaccess updated to force HTTPS
- [ ] HTTP redirects to HTTPS

### Step 14: Final Checks

Test these pages:
- [ ] Homepage: https://lisedu.org
- [ ] About page
- [ ] Programs page
- [ ] Contact page with form
- [ ] Admissions page with form
- [ ] Events page
- [ ] News/Blog page
- [ ] Resources page
- [ ] Gallery page

Test functionality:
- [ ] Contact form submits
- [ ] Admission form submits
- [ ] Gallery filter works
- [ ] Mobile menu works
- [ ] All images load
- [ ] Social media links work

### Step 15: Cleanup

```bash
# Remove database file from server
ssh liseqtmc@lisedu.org
rm ~/lumina-database.sql

# Or delete via File Manager
```

- [ ] Database SQL file deleted from server
- [ ] No sensitive files left in public areas

## Post-Deployment Tasks

- [ ] Update DNS if needed (point domain to hosting)
- [ ] Set up email accounts in cPanel
- [ ] Configure backup schedule in cPanel
- [ ] Install security plugins (Wordfence, etc.)
- [ ] Set up Google Analytics
- [ ] Submit sitemap to Google Search Console
- [ ] Test site on mobile devices
- [ ] Test site in different browsers

## Troubleshooting

### White Screen / 500 Error
- Check wp-config.php database credentials
- Check file permissions
- Enable debug mode in wp-config.php:
  ```php
  define('WP_DEBUG', true);
  define('WP_DEBUG_LOG', true);
  ```
- Check error logs in cPanel

### Database Connection Error
- Verify database name, user, password in wp-config.php
- Verify database user has privileges
- Try 'localhost' or '127.0.0.1' as DB_HOST

### Missing Images/Styles
- Check if wp-content folder uploaded completely
- Update permalinks in WordPress admin
- Check .htaccess file exists

### Can't Login to wp-admin
- Reset password via phpMyAdmin
- Check if wp_users table exists
- Verify site URLs are correct in wp_options

## Support Contacts

- **Hosting Support**: [Your hosting provider's support]
- **cPanel URL**: https://lisedu.org:2083
- **Domain Registrar**: [Your domain registrar]

## Backup Information

- **Local Backup Location**: /path/to/backups/
- **Last Backup Date**: ___________
- **Backup Files**:
  - lumina-deploy.zip
  - lumina-database.sql

---

**Deployment Date**: ___________
**Deployed By**: ___________
**Notes**: ___________________________________________
