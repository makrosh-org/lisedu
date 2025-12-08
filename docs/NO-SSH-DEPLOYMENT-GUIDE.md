# WordPress Deployment Without SSH/SFTP Access

Your hosting provider has blocked SSH/SFTP access. This guide shows you how to deploy using cPanel File Manager and FTP - both work perfectly fine.

## Method 1: Zip Upload via cPanel (Recommended - Fastest)

This is the easiest and fastest method when SSH is blocked.

### Step 1: Prepare Your WordPress Files

```bash
# Navigate to your WordPress directory
cd /path/to/your/lumina-wordpress

# Create a clean zip file
zip -r lumina-site.zip . \
  -x "*.git*" \
  -x "*.DS_Store" \
  -x ".DS_Store" \
  -x "node_modules/*" \
  -x "*.log" \
  -x "wp-content/cache/*" \
  -x "wp-content/uploads/cache/*"

# Check the file size
ls -lh lumina-site.zip
```

**Expected size**: Usually 50-200 MB for a WordPress site with theme and plugins.

### Step 2: Export Your Database

```bash
# Export your local database
mysqldump -u root -p wordpress_db > lumina-database.sql

# Or if you have a different username:
mysqldump -u your_username -p your_database_name > lumina-database.sql

# Check the file
ls -lh lumina-database.sql
```

### Step 3: Log into cPanel

1. Go to: **https://lisedu.org:2083** or **https://server313.web-hosting.com:2083**
2. Username: `liseqtmc`
3. Password: Your cPanel password
4. Click "Log in"

### Step 4: Create MySQL Database

1. In cPanel, search for **"MySQL Databases"**
2. Click on it

**Create Database:**
- Database Name: `lumina` (it will become `liseqtmc_lumina`)
- Click "Create Database"
- Note the full name: **liseqtmc_lumina**

**Create Database User:**
- Username: `lumina_admin` (it will become `liseqtmc_lumina_admin`)
- Password: Click "Generate Password" and copy it
- Click "Create User"
- **IMPORTANT**: Save these credentials somewhere safe!

**Add User to Database:**
- User: Select `liseqtmc_lumina_admin`
- Database: Select `liseqtmc_lumina`
- Click "Add"
- Check "ALL PRIVILEGES"
- Click "Make Changes"

**Write down:**
```
Database Name: liseqtmc_lumina
Database User: liseqtmc_lumina_admin
Database Password: [the password you generated]
Database Host: localhost
```

### Step 5: Upload Zip File

1. In cPanel, open **"File Manager"**
2. Navigate to **public_html** folder
3. Check if there are any existing files:
   - If you see WordPress files already, you may want to delete them first
   - Or upload to a subfolder like `public_html/new-site`

4. Click the **"Upload"** button at the top
5. Click **"Select File"** 
6. Choose your `lumina-site.zip` file
7. Wait for upload to complete (progress bar will show)
   - For a 100MB file, this takes 2-5 minutes depending on your internet speed

### Step 6: Extract the Zip File

1. Go back to File Manager (close the upload window)
2. You should see `lumina-site.zip` in public_html
3. **Right-click** on `lumina-site.zip`
4. Select **"Extract"**
5. Confirm the extraction path (should be `/public_html`)
6. Click **"Extract File(s)"**
7. Wait for extraction to complete (you'll see a success message)
8. Click "Close"

9. **Delete the zip file** to save space:
   - Right-click `lumina-site.zip`
   - Select "Delete"
   - Confirm deletion

### Step 7: Update wp-config.php

1. In File Manager, locate **wp-config.php** in public_html
2. **Right-click** on it
3. Select **"Edit"**
4. Click "Edit" again in the popup

5. Find these lines and update them:

```php
define( 'DB_NAME', 'liseqtmc_lumina' );
define( 'DB_USER', 'liseqtmc_lumina_admin' );
define( 'DB_PASSWORD', 'your-generated-password-here' );
define( 'DB_HOST', 'localhost' );
```

6. Click **"Save Changes"** at the top right
7. Close the editor

### Step 8: Import Database

1. In cPanel, search for **"phpMyAdmin"**
2. Click to open it
3. In the left sidebar, click on your database: **liseqtmc_lumina**
4. Click the **"Import"** tab at the top
5. Click **"Choose File"**
6. Select your `lumina-database.sql` file
7. Scroll down and click **"Go"**
8. Wait for import to complete (you'll see a success message)

**If you get an error about file size:**
- The file might be too large
- You'll need to split it or compress it
- Or use the "Browse your computer" option and upload in chunks

### Step 9: Update WordPress URLs

Still in phpMyAdmin:

1. Click the **"SQL"** tab at the top
2. Paste this query (replace with your actual domain):

```sql
UPDATE wp_options 
SET option_value = 'https://lisedu.org' 
WHERE option_name = 'siteurl';

UPDATE wp_options 
SET option_value = 'https://lisedu.org' 
WHERE option_name = 'home';
```

3. Click **"Go"**
4. You should see "2 rows affected"

### Step 10: Set File Permissions

1. In File Manager, go to public_html
2. Select **wp-config.php**
3. Click **"Permissions"** at the top
4. Set to **600** (or check: Owner Read + Owner Write only)
5. Click "Change Permissions"

For other files (optional but recommended):
- Select all folders → Permissions → 755
- Select all files → Permissions → 644

### Step 11: Test Your Site

1. Open a new browser tab
2. Go to: **https://lisedu.org**
3. Your site should load!

4. Test admin access:
   - Go to: **https://lisedu.org/wp-admin**
   - Login with your WordPress username and password
   - You should see the dashboard

### Step 12: Update Permalinks

1. In WordPress admin, go to **Settings → Permalinks**
2. Don't change anything
3. Just click **"Save Changes"**
4. This regenerates the .htaccess file

### Step 13: Enable SSL Certificate

1. In cPanel, search for **"SSL/TLS Status"**
2. Find your domain: **lisedu.org**
3. Click **"Run AutoSSL"** or **"Issue"** button
4. Wait 1-5 minutes for certificate to be issued
5. Refresh the page to see if it's active

### Step 14: Force HTTPS (Optional)

1. In File Manager, edit **.htaccess** in public_html
2. Add this at the very top (before the WordPress rules):

```apache
# Force HTTPS
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
</IfModule>
```

3. Save the file

## Method 2: FTP Upload (Alternative)

If you prefer using an FTP client like FileZilla:

### Step 1: Get FTP Credentials

In cPanel:
1. Search for **"FTP Accounts"**
2. Your main FTP account is:
   - **Host**: ftp.lisedu.org or server313.web-hosting.com
   - **Username**: liseqtmc
   - **Password**: Your cPanel password
   - **Port**: 21

### Step 2: Download FileZilla

Download from: https://filezilla-project.org/download.php?type=client

### Step 3: Connect via FTP

1. Open FileZilla
2. Enter at the top:
   - **Host**: ftp.lisedu.org
   - **Username**: liseqtmc
   - **Password**: Your cPanel password
   - **Port**: 21
3. Click "Quickconnect"

### Step 4: Upload Files

1. **Left side**: Navigate to your local WordPress folder
2. **Right side**: Navigate to `/public_html`
3. Select all WordPress files on the left
4. Right-click → **"Upload"**
5. Wait for upload to complete (this can take 30-60 minutes)

**Note**: FTP is much slower than the zip method. Use zip upload if possible.

## Troubleshooting

### Error: "Error establishing database connection"

**Solution:**
1. Check wp-config.php has correct database credentials
2. Verify database name includes the prefix (liseqtmc_)
3. Verify database user has privileges
4. Try changing DB_HOST from 'localhost' to '127.0.0.1'

### Error: "500 Internal Server Error"

**Solution:**
1. Check file permissions (folders: 755, files: 644)
2. Check .htaccess file isn't corrupted
3. Enable debug mode in wp-config.php:
```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
```
4. Check error log in cPanel → Error Log

### Error: "Upload: Failed to write file to disk"

**Solution:**
1. Check disk space in cPanel
2. Check wp-content/uploads folder permissions (755)
3. Contact hosting support if disk quota exceeded

### Can't Upload Large Files

**Solution:**
1. Split your zip into smaller files
2. Or upload folders individually via FTP
3. Or ask hosting to increase upload limits

### Database Import Fails

**Solution:**
1. Check file size (max usually 50-128MB)
2. Compress the SQL file: `gzip lumina-database.sql`
3. Upload the .sql.gz file instead
4. Or use BigDump script for large databases

### Site Looks Broken / Missing Styles

**Solution:**
1. Update permalinks (Settings → Permalinks → Save)
2. Clear browser cache (Cmd+Shift+R)
3. Check if wp-content folder uploaded completely
4. Verify .htaccess file exists

## Quick Command Reference

### Create Zip (Mac/Linux)
```bash
zip -r site.zip . -x "*.git*" -x "*.DS_Store"
```

### Export Database
```bash
mysqldump -u root -p database_name > database.sql
```

### Compress Database
```bash
gzip database.sql
# Creates database.sql.gz
```

### Check File Sizes
```bash
ls -lh *.zip
ls -lh *.sql
```

## Post-Deployment Checklist

- [ ] Site loads at https://lisedu.org
- [ ] Can login to wp-admin
- [ ] All pages load correctly
- [ ] Images display properly
- [ ] Contact form works
- [ ] Admission form works
- [ ] Gallery works
- [ ] Mobile menu works
- [ ] SSL certificate active
- [ ] HTTP redirects to HTTPS

## Performance Tips

After deployment:

1. **Install Caching Plugin**:
   - WP Super Cache or W3 Total Cache
   - Significantly speeds up your site

2. **Optimize Images**:
   - Install Smush or ShortPixel
   - Compress existing images

3. **Enable Gzip Compression**:
   - Usually enabled by default in cPanel
   - Check in cPanel → Optimize Website

4. **Set Up Backups**:
   - Use cPanel → Backup Wizard
   - Schedule automatic backups

## Need Help?

If you encounter issues:

1. Check cPanel → Error Log for specific errors
2. Enable WordPress debug mode to see detailed errors
3. Contact your hosting support (they can see server-side issues)
4. Check WordPress.org support forums

---

**Your Deployment Info:**
- Domain: lisedu.org
- Server: server313.web-hosting.com
- cPanel: https://server313.web-hosting.com:2083
- Username: liseqtmc
- FTP Host: ftp.lisedu.org

**Next Steps**: Follow the steps above starting with creating the zip file!
