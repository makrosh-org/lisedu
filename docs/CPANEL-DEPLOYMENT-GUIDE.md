# 🚀 cPanel Deployment Guide - Lumina International School Website

## 📋 Prerequisites

Before you start, make sure you have:
- [ ] cPanel hosting account
- [ ] Domain name (e.g., luminaschool.edu.bd)
- [ ] cPanel login credentials
- [ ] FTP/File Manager access
- [ ] MySQL database access

---

## 🎯 Deployment Methods

### Method 1: Using cPanel File Manager (Recommended for Beginners)
### Method 2: Using FTP (FileZilla)
### Method 3: Using SSH/Terminal (Advanced)

---

## 📦 Method 1: cPanel File Manager (Easiest)

### Step 1: Prepare Your Files

1. **Export Database from Local**:
   ```bash
   # On your local machine
   cd /path/to/your/wordpress
   
   # Export database
   wp db export lumina-backup.sql
   
   # Or use phpMyAdmin:
   # Go to http://lisedu.test/phpmyadmin
   # Select your database → Export → Go
   ```

2. **Create a ZIP file** of your WordPress installation:
   ```bash
   # Exclude unnecessary files
   zip -r lumina-website.zip . \
     -x "*.git*" \
     -x "*node_modules*" \
     -x "*.DS_Store" \
     -x "*wp-config.php"
   ```

   **Or manually:**
   - Select all WordPress files EXCEPT:
     - `.git` folder
     - `node_modules` folder
     - `.DS_Store` files
     - `wp-config.php` (we'll create new one)
   - Right-click → Compress → ZIP

### Step 2: Login to cPanel

1. Go to your cPanel URL:
   - Usually: `https://yourdomain.com/cpanel`
   - Or: `https://yourdomain.com:2083`
   - Or provided by your hosting provider

2. Enter your cPanel username and password

### Step 3: Create MySQL Database

1. **Find "MySQL Databases"** in cPanel
2. **Create New Database**:
   - Database Name: `lumina_school` (or your choice)
   - Click "Create Database"
   - Note the full database name (usually: `username_lumina_school`)

3. **Create Database User**:
   - Username: `lumina_user`
   - Password: Generate strong password
   - Click "Create User"
   - **SAVE THESE CREDENTIALS!**

4. **Add User to Database**:
   - Select the user you created
   - Select the database you created
   - Grant "ALL PRIVILEGES"
   - Click "Make Changes"

### Step 4: Upload Files

1. **Open File Manager** in cPanel

2. **Navigate to public_html**:
   - If main domain: `public_html/`
   - If subdomain: `public_html/subdomain/`
   - If addon domain: `public_html/addondomain.com/`

3. **Upload ZIP file**:
   - Click "Upload" button
   - Select your `lumina-website.zip`
   - Wait for upload to complete

4. **Extract ZIP**:
   - Go back to File Manager
   - Right-click on `lumina-website.zip`
   - Click "Extract"
   - Select destination (usually current directory)
   - Click "Extract Files"
   - Delete the ZIP file after extraction

### Step 5: Create wp-config.php

1. **In File Manager**, find `wp-config-sample.php`
2. **Right-click** → Copy → Name it `wp-config.php`
3. **Right-click** `wp-config.php` → Edit
4. **Update these lines**:

```php
// ** MySQL settings ** //
define( 'DB_NAME', 'username_lumina_school' );     // Your database name
define( 'DB_USER', 'username_lumina_user' );       // Your database user
define( 'DB_PASSWORD', 'your_password_here' );     // Your database password
define( 'DB_HOST', 'localhost' );                  // Usually localhost
define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', '' );
```

5. **Add Security Keys**:
   - Visit: https://api.wordpress.org/secret-key/1.1/salt/
   - Copy the generated keys
   - Replace the existing keys in wp-config.php

6. **Add these lines before "That's all, stop editing!"**:

```php
// Update URLs for production
define( 'WP_HOME', 'https://yourdomain.com' );
define( 'WP_SITEURL', 'https://yourdomain.com' );

// Increase memory limit
define( 'WP_MEMORY_LIMIT', '256M' );

// Enable debugging (disable after setup)
define( 'WP_DEBUG', false );
define( 'WP_DEBUG_LOG', false );
define( 'WP_DEBUG_DISPLAY', false );
```

7. **Save Changes**

### Step 6: Import Database

1. **Open phpMyAdmin** in cPanel
2. **Select your database** (username_lumina_school)
3. **Click "Import" tab**
4. **Choose File**: Select your `lumina-backup.sql`
5. **Click "Go"**
6. **Wait for import to complete**

### Step 7: Update URLs in Database

1. **In phpMyAdmin**, click "SQL" tab
2. **Run these queries** (replace with your actual URLs):

```sql
-- Update site URL
UPDATE wp_options 
SET option_value = 'https://yourdomain.com' 
WHERE option_name = 'siteurl' OR option_name = 'home';

-- Update post content URLs
UPDATE wp_posts 
SET post_content = REPLACE(post_content, 'http://lisedu.test', 'https://yourdomain.com');

-- Update post meta URLs
UPDATE wp_postmeta 
SET meta_value = REPLACE(meta_value, 'http://lisedu.test', 'https://yourdomain.com');

-- Update Elementor URLs (if using Elementor)
UPDATE wp_postmeta 
SET meta_value = REPLACE(meta_value, 'http:\\/\\/lisedu.test', 'https:\\/\\/yourdomain.com');
```

3. **Click "Go"**

### Step 8: Set File Permissions

1. **In File Manager**, select these folders:
   - `wp-content/uploads/`
   - `wp-content/themes/`
   - `wp-content/plugins/`

2. **Right-click** → Change Permissions
3. **Set to 755** for folders
4. **Set to 644** for files

### Step 9: Test Your Site

1. **Visit your domain**: `https://yourdomain.com`
2. **Check homepage** loads correctly
3. **Test navigation** menu
4. **Check all pages** work
5. **Test forms** (contact, admission)
6. **Verify images** load

### Step 10: Login to WordPress Admin

1. Go to: `https://yourdomain.com/wp-admin`
2. Login with your credentials
3. **Update Permalinks**:
   - Go to Settings → Permalinks
   - Click "Save Changes" (don't change anything)
   - This regenerates .htaccess

4. **Regenerate Elementor CSS**:
   - Go to Elementor → Tools
   - Click "Regenerate CSS & Data"

5. **Clear Cache** (if using cache plugin)

---

## 📦 Method 2: Using FTP (FileZilla)

### Step 1: Install FileZilla

1. Download from: https://filezilla-project.org/
2. Install on your computer

### Step 2: Connect to Your Server

1. **Open FileZilla**
2. **Enter FTP credentials**:
   - Host: `ftp.yourdomain.com` or your server IP
   - Username: Your cPanel username
   - Password: Your cPanel password
   - Port: 21 (or 22 for SFTP)
3. **Click "Quickconnect"**

### Step 3: Upload Files

1. **Local site** (left): Navigate to your WordPress folder
2. **Remote site** (right): Navigate to `public_html/`
3. **Select all files** in local site
4. **Right-click** → Upload
5. **Wait for upload** (may take 30-60 minutes)

### Step 4: Follow Steps 3-10 from Method 1

- Create database
- Create wp-config.php
- Import database
- Update URLs
- Set permissions
- Test site

---

## 🔧 Method 3: SSH/Terminal (Advanced)

### Step 1: Connect via SSH

```bash
ssh username@yourdomain.com
# Or
ssh username@your-server-ip
```

### Step 2: Navigate to public_html

```bash
cd public_html
```

### Step 3: Upload Files

**Option A: Using SCP from local machine**:
```bash
# On your local machine
scp -r /path/to/wordpress/* username@yourdomain.com:public_html/
```

**Option B: Using rsync**:
```bash
# On your local machine
rsync -avz --exclude '.git' --exclude 'node_modules' \
  /path/to/wordpress/ username@yourdomain.com:public_html/
```

### Step 4: Create Database

```bash
# On server
mysql -u root -p

CREATE DATABASE lumina_school;
CREATE USER 'lumina_user'@'localhost' IDENTIFIED BY 'strong_password';
GRANT ALL PRIVILEGES ON lumina_school.* TO 'lumina_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### Step 5: Import Database

```bash
mysql -u lumina_user -p lumina_school < lumina-backup.sql
```

### Step 6: Update wp-config.php

```bash
nano wp-config.php
# Update database credentials
# Save: Ctrl+O, Exit: Ctrl+X
```

### Step 7: Set Permissions

```bash
find . -type d -exec chmod 755 {} \;
find . -type f -exec chmod 644 {} \;
chmod 600 wp-config.php
```

---

## 🔒 Security Checklist

After deployment:

- [ ] **Change all passwords**
- [ ] **Update wp-config.php** security keys
- [ ] **Install SSL certificate** (Let's Encrypt via cPanel)
- [ ] **Force HTTPS** in wp-config.php
- [ ] **Disable file editing**:
  ```php
  define( 'DISALLOW_FILE_EDIT', true );
  ```
- [ ] **Install security plugin** (Wordfence or Sucuri)
- [ ] **Set up backups** (cPanel backup or plugin)
- [ ] **Update all plugins** and themes
- [ ] **Remove default admin** user
- [ ] **Enable two-factor authentication**

---

## 🌐 SSL Certificate Setup

### Using cPanel AutoSSL (Free):

1. **Go to cPanel** → SSL/TLS Status
2. **Click "Run AutoSSL"**
3. **Wait for certificate** to be issued
4. **Update wp-config.php**:
   ```php
   define( 'FORCE_SSL_ADMIN', true );
   if (strpos($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') !== false)
       $_SERVER['HTTPS']='on';
   ```

### Using Let's Encrypt:

1. **Go to cPanel** → Let's Encrypt SSL
2. **Select your domain**
3. **Click "Issue"**
4. **Wait for installation**

---

## 🔄 Post-Deployment Tasks

### 1. Update Site Settings

- Go to Settings → General
- Verify WordPress Address and Site Address
- Update timezone
- Update date/time format

### 2. Configure Email

- Test contact forms
- Set up SMTP (WP Mail SMTP plugin)
- Configure email notifications

### 3. Set Up Backups

**Option A: cPanel Backups**:
- Go to cPanel → Backup
- Schedule automatic backups

**Option B: WordPress Plugin**:
- Install UpdraftPlus or BackupBuddy
- Configure automatic backups
- Connect to cloud storage (Google Drive, Dropbox)

### 4. Performance Optimization

- Install caching plugin (WP Super Cache or W3 Total Cache)
- Optimize images (Smush or Imagify)
- Enable CDN (Cloudflare - free)
- Minify CSS/JS

### 5. SEO Setup

- Install Yoast SEO or Rank Math
- Submit sitemap to Google Search Console
- Set up Google Analytics
- Configure meta descriptions

---

## 🐛 Troubleshooting

### Issue: White Screen of Death

**Solution**:
```php
// Add to wp-config.php
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
// Check wp-content/debug.log
```

### Issue: Database Connection Error

**Solution**:
- Verify database credentials in wp-config.php
- Check database exists in phpMyAdmin
- Verify user has privileges

### Issue: 404 Errors on Pages

**Solution**:
- Go to Settings → Permalinks
- Click "Save Changes"
- Check .htaccess file exists and is writable

### Issue: Images Not Loading

**Solution**:
- Check file permissions (755 for folders, 644 for files)
- Update URLs in database
- Regenerate thumbnails (plugin)

### Issue: Mixed Content Warnings

**Solution**:
```sql
-- Update all HTTP to HTTPS
UPDATE wp_posts 
SET post_content = REPLACE(post_content, 'http://', 'https://');
```

---

## 📞 Need Help?

### Resources:
- cPanel Documentation: https://docs.cpanel.net/
- WordPress Codex: https://codex.wordpress.org/
- Your hosting provider's support

### Common Hosting Providers:
- **Namecheap**: support.namecheap.com
- **Bluehost**: bluehost.com/help
- **SiteGround**: siteground.com/support
- **HostGator**: hostgator.com/support

---

## ✅ Deployment Checklist

- [ ] Database exported from local
- [ ] Files zipped (excluding .git, node_modules)
- [ ] cPanel login successful
- [ ] MySQL database created
- [ ] Database user created and granted privileges
- [ ] Files uploaded to public_html
- [ ] Files extracted
- [ ] wp-config.php created with correct credentials
- [ ] Database imported
- [ ] URLs updated in database
- [ ] File permissions set correctly
- [ ] Site loads successfully
- [ ] WordPress admin accessible
- [ ] Permalinks regenerated
- [ ] Elementor CSS regenerated
- [ ] SSL certificate installed
- [ ] HTTPS forced
- [ ] All pages tested
- [ ] Forms tested
- [ ] Images loading
- [ ] Social media links working
- [ ] Backups configured
- [ ] Security measures implemented

---

**Created**: December 7, 2025
**Status**: Complete Guide
**Estimated Time**: 1-2 hours for first-time deployment
