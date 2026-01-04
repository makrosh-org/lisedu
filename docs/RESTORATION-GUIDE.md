# WPvivid Backup Restoration Guide

## Overview
This guide will help you restore your Cabinet Doors Plus staging site backup to your local development environment.

## Backup Information
- **Source**: cabinetdoorsplus.kinsta.cloud
- **Backup Date**: December 10, 2025
- **WordPress Version**: 6.9
- **PHP Version**: 8.2.29
- **MySQL Version**: 11.4.7

## Backup Components
Your backup is split across 5 directories:

1. **cabinetdoorsplus** - Database, Themes, Plugins
2. **cabinetdoorsplus-2** - Uploads Part 1
3. **cabinetdoorsplus-3** - WordPress Core, Content, Uploads Part 4
4. **cabinetdoorsplus-4** - Uploads Part 2
5. **cabinetdoorsplus-5** - Uploads Part 3

## Prerequisites

### 1. Local Development Environment
You need one of these:
- **MAMP/MAMP PRO** (Recommended for Mac)
- **Local by Flywheel**
- **XAMPP**
- **Laravel Valet**
- **Docker (with WordPress)**

### 2. Required Software
- MySQL/MariaDB
- PHP 8.2+
- WP-CLI (optional but recommended)

### 3. Install WP-CLI (Optional)
```bash
curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
chmod +x wp-cli.phar
sudo mv wp-cli.phar /usr/local/bin/wp
```

## Method 1: Automated Restoration (Recommended)

### Step 1: Review Configuration
Edit `restore-wpvivid-backup.sh` and update these variables if needed:

```bash
PROJECT_PATH="/Users/zrshishir/Projects/Wppool/cabinet-doors"
DB_NAME="cabinetd-doors"
DB_USER="root"          # Your MySQL username
DB_PASS=""          # Your MySQL password
DB_HOST="localhost"
LOCAL_URL="http://cabinet-doors.test"
```

### Step 2: Make Script Executable
```bash
chmod +x restore-wpvivid-backup.sh
```

### Step 3: Run Restoration
```bash
./restore-wpvivid-backup.sh
```

### Step 4: Configure Local Server

#### For MAMP:
1. Open MAMP
2. Go to Preferences > Web Server
3. Set Document Root to: `/Users/zrshishir/Projects/Wppool/cabinet-doors`
4. Start servers

#### For Valet:
```bash
cd /Users/zrshishir/Projects/Wppool/cabinet-doors
valet link cabinet-doors
```

#### For Apache/Nginx:
Add virtual host configuration (see below)

### Step 5: Update Hosts File
```bash
sudo nano /etc/hosts
```

Add this line:
```
127.0.0.1 cabinet-doors.local
```

### Step 6: Access Site
Visit: http://cabinet-doors.local

## Method 2: Manual Restoration

### Step 1: Create Project Directory
```bash
mkdir -p /Users/zrshishir/Projects/Wppool/cabinet-doors
cd /Users/zrshishir/Projects/Wppool/cabinet-doors
```

### Step 2: Extract WordPress Core
```bash
unzip /Users/zrshishir/Downloads/cabinetdoorsplus-3/cabinetdoorsplus.kinsta.cloud_wpvivid-30c0260a93723_2025-12-10-17-56_backup_core.zip -d .
```

### Step 3: Extract Themes
```bash
unzip /Users/zrshishir/Downloads/cabinetdoorsplus/cabinetdoorsplus.kinsta.cloud_wpvivid-30c0260a93723_2025-12-10-17-56_backup_themes.zip -d wp-content
```

### Step 4: Extract Plugins
```bash
unzip /Users/zrshishir/Downloads/cabinetdoorsplus/cabinetdoorsplus.kinsta.cloud_wpvivid-30c0260a93723_2025-12-10-17-56_backup_plugin.zip -d wp-content
```

### Step 5: Extract Content
```bash
unzip /Users/zrshishir/Downloads/cabinetdoorsplus-3/cabinetdoorsplus.kinsta.cloud_wpvivid-30c0260a93723_2025-12-10-17-56_backup_content.zip -d wp-content
```

### Step 6: Extract Uploads (All 4 Parts)
```bash
mkdir -p wp-content/uploads

# Part 1
unzip /Users/zrshishir/Downloads/cabinetdoorsplus-2/cabinetdoorsplus.kinsta.cloud_wpvivid-30c0260a93723_2025-12-10-17-56_backup_uploads.part001.zip -d wp-content/uploads

# Part 2
unzip /Users/zrshishir/Downloads/cabinetdoorsplus-4/cabinetdoorsplus.kinsta.cloud_wpvivid-30c0260a93723_2025-12-10-17-56_backup_uploads.part002.zip -d wp-content/uploads

# Part 3
unzip /Users/zrshishir/Downloads/cabinetdoorsplus-5/cabinetdoorsplus.kinsta.cloud_wpvivid-30c0260a93723_2025-12-10-17-56_backup_uploads.part003.zip -d wp-content/uploads

# Part 4
unzip /Users/zrshishir/Downloads/cabinetdoorsplus-3/cabinetdoorsplus.kinsta.cloud_wpvivid-30c0260a93723_2025-12-10-17-56_backup_uploads.part004.zip -d wp-content/uploads
```

### Step 7: Create Database
```bash
mysql -uroot -proot -e "CREATE DATABASE cabinet_doors_local CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### Step 8: Import Database
```bash
# Extract SQL file
unzip /Users/zrshishir/Downloads/cabinetdoorsplus/cabinetdoorsplus.kinsta.cloud_wpvivid-30c0260a93723_2025-12-10-17-56_backup_db.zip -d /tmp

# Import
mysql -uroot -proot cabinet_doors_local < /tmp/cabinetdoorsplus.kinsta.cloud_wpvivid-30c0260a93723_2025-12-10-17-56_backup_db.sql

# Clean up
rm /tmp/cabinetdoorsplus.kinsta.cloud_wpvivid-30c0260a93723_2025-12-10-17-56_backup_db.sql
```

### Step 9: Create wp-config.php
```bash
cp wp-config-sample.php wp-config.php
nano wp-config.php
```

Update these values:
```php
define( 'DB_NAME', 'cabinet_doors_local' );
define( 'DB_USER', 'root' );
define( 'DB_PASSWORD', 'root' );
define( 'DB_HOST', 'localhost' );
```

### Step 10: Update URLs
```bash
wp search-replace 'https://cabinetdoorsplus.kinsta.cloud' 'http://cabinet-doors.local' --all-tables
```

Or use this SQL:
```sql
UPDATE wp_options SET option_value = 'http://cabinet-doors.local' WHERE option_name = 'siteurl';
UPDATE wp_options SET option_value = 'http://cabinet-doors.local' WHERE option_name = 'home';
```

### Step 11: Set Permissions
```bash
chmod -R 755 .
chmod -R 775 wp-content/uploads
```

## Virtual Host Configuration

### Apache (httpd-vhosts.conf)
```apache
<VirtualHost *:80>
    ServerName cabinet-doors.local
    DocumentRoot "/Users/zrshishir/Projects/Wppool/cabinet-doors"
    
    <Directory "/Users/zrshishir/Projects/Wppool/cabinet-doors">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog "/var/log/apache2/cabinet-doors-error.log"
    CustomLog "/var/log/apache2/cabinet-doors-access.log" common
</VirtualHost>
```

### Nginx
```nginx
server {
    listen 80;
    server_name cabinet-doors.local;
    root /Users/zrshishir/Projects/Wppool/cabinet-doors;
    
    index index.php index.html;
    
    location / {
        try_files $uri $uri/ /index.php?$args;
    }
    
    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

## Installed Plugins (from backup)
- Advanced Product Fields for WooCommerce Extended
- Bulk Edit Products Prices & Attributes
- Duplicate Page
- Elementor
- Elementor Pro
- Ajax Search for WooCommerce
- Ultimate Member
- Variation Swatches for WooCommerce
- WooCommerce
- WordPress Importer
- WP File Manager

## Themes (from backup)
- Astra (parent theme)
- Astra Child (active theme)

## Troubleshooting

### Issue: "Error establishing database connection"
**Solution**: Check your wp-config.php database credentials match your local MySQL setup.

### Issue: URLs still pointing to staging
**Solution**: Run the search-replace command again:
```bash
wp search-replace 'https://cabinetdoorsplus.kinsta.cloud' 'http://cabinet-doors.local' --all-tables
```

### Issue: White screen or 500 error
**Solution**: 
1. Check PHP error logs
2. Enable WP_DEBUG in wp-config.php
3. Check file permissions

### Issue: Images not loading
**Solution**: 
1. Verify all 4 upload parts were extracted
2. Check wp-content/uploads permissions
3. Run search-replace to update image URLs

### Issue: Can't login
**Solution**: Reset admin password via MySQL:
```sql
UPDATE wp_users SET user_pass = MD5('newpassword') WHERE user_login = 'admin';
```

## Post-Restoration Checklist

- [ ] Site loads at http://cabinet-doors.local
- [ ] Can login to wp-admin
- [ ] All pages display correctly
- [ ] Images are loading
- [ ] WooCommerce products display
- [ ] Forms are working
- [ ] Elementor editor loads
- [ ] Plugins are active

## Development Tips

1. **Enable Debug Mode**: Already set in the script's wp-config.php
2. **Disable Caching**: Deactivate any caching plugins for development
3. **Use Local SMTP**: Install WP Mail SMTP for testing emails
4. **Version Control**: Initialize git after restoration:
   ```bash
   cd /Users/zrshishir/Projects/Wppool/cabinet-doors
   git init
   git add .
   git commit -m "Initial commit from staging backup"
   ```

## Need Help?

If you encounter issues:
1. Check the error logs in wp-content/debug.log
2. Review your local server error logs
3. Verify all backup files were extracted correctly
4. Ensure database credentials are correct

## Next Steps

After successful restoration:
1. Test all major functionality
2. Update any hardcoded staging URLs in content
3. Configure local development tools (Xdebug, etc.)
4. Set up your development workflow
