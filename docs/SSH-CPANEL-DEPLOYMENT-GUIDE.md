# SSH Deployment Guide for cPanel

This guide will help you configure SSH access to your cPanel hosting and deploy your WordPress site using command-line tools.

## Prerequisites

- cPanel hosting account with SSH access enabled
- Your cPanel username and password
- Terminal access on your Mac

## Step 1: Enable SSH Access in cPanel

1. Log into your cPanel account
2. Search for "SSH Access" or "Terminal" in the search bar
3. Click on "SSH Access" under the Security section
4. If SSH is disabled, click "Manage SSH Keys" or contact your hosting provider to enable it

## Step 2: Generate SSH Key (Recommended for Security)

Instead of using password authentication every time, generate an SSH key pair:

```bash
# Generate SSH key pair
ssh-keygen -t rsa -b 4096 -C "your_email@example.com"

# When prompted:
# - Save location: Press Enter (default: ~/.ssh/id_rsa)
# - Passphrase: Enter a secure passphrase or press Enter for no passphrase
```

This creates two files:
- `~/.ssh/id_rsa` (private key - keep this secret!)
- `~/.ssh/id_rsa.pub` (public key - this goes on the server)

## Step 3: Add Your Public Key to cPanel

### Option A: Through cPanel Interface

1. Display your public key:
```bash
cat ~/.ssh/id_rsa.pub
```

2. Copy the entire output (starts with `ssh-rsa`)

3. In cPanel:
   - Go to "SSH Access"
   - Click "Manage SSH Keys"
   - Click "Import Key"
   - Paste your public key in the "Public Key" field
   - Give it a name (e.g., "my-macbook")
   - Click "Import"
   - Click "Manage" next to your key
   - Click "Authorize" to enable it

### Option B: Using ssh-copy-id (Easier)

```bash
# Replace with your actual cPanel username and server
ssh-copy-id username@yourdomain.com
# or
ssh-copy-id username@server-ip-address

# Enter your cPanel password when prompted
```

## Step 4: Test SSH Connection

```bash
# Replace with your actual details
ssh username@yourdomain.com
# or
ssh username@server-ip-address

# If successful, you'll see a command prompt on your server
# Type 'exit' to disconnect
```

### Common SSH Connection Issues

**Issue: "Permission denied (publickey)"**
- Your public key isn't authorized on the server
- Try password authentication: `ssh -o PreferredAuthentications=password username@yourdomain.com`

**Issue: "Connection refused"**
- SSH might be disabled by your host
- Contact your hosting provider
- Check if you need to use a specific port: `ssh -p 2222 username@yourdomain.com`

**Issue: "Host key verification failed"**
- Remove old host key: `ssh-keygen -R yourdomain.com`
- Try connecting again

## Step 5: Find Your Document Root

Once connected via SSH:

```bash
# Check your current directory
pwd

# Common cPanel paths:
# - public_html (main domain)
# - public_html/subdomain (for subdomains)
# - ~/public_html

# List directories
ls -la
```

## Step 6: Prepare Your Local WordPress Site

Before uploading, create a clean archive:

```bash
# Navigate to your WordPress directory
cd /path/to/your/wordpress

# Create a compressed archive (excludes unnecessary files)
tar -czf lumina-wordpress.tar.gz \
  --exclude='*.log' \
  --exclude='.DS_Store' \
  --exclude='.git' \
  --exclude='node_modules' \
  --exclude='wp-content/cache/*' \
  --exclude='wp-content/uploads/cache/*' \
  .

# Check the archive size
ls -lh lumina-wordpress.tar.gz
```

## Step 7: Upload Using SCP (Secure Copy)

SCP is the fastest way to transfer files over SSH:

```bash
# Upload the archive to your server
scp lumina-wordpress.tar.gz username@yourdomain.com:~/

# This uploads to your home directory
# Progress will be shown during upload
```

### Alternative: Using rsync (Better for Updates)

Rsync is more efficient for syncing changes:

```bash
# Initial upload (dry run to test)
rsync -avz --dry-run \
  --exclude='*.log' \
  --exclude='.DS_Store' \
  --exclude='.git' \
  --exclude='node_modules' \
  --exclude='wp-content/cache/*' \
  ./ username@yourdomain.com:~/public_html/

# If dry run looks good, remove --dry-run to actually upload
rsync -avz \
  --exclude='*.log' \
  --exclude='.DS_Store' \
  --exclude='.git' \
  --exclude='node_modules' \
  --exclude='wp-content/cache/*' \
  ./ username@yourdomain.com:~/public_html/

# For future updates, rsync only uploads changed files
```

## Step 8: Extract and Setup on Server

Connect to your server via SSH:

```bash
ssh username@yourdomain.com

# Navigate to public_html
cd public_html

# If you uploaded a tar.gz file to home directory:
# Move it to public_html
mv ~/lumina-wordpress.tar.gz .

# Extract the archive
tar -xzf lumina-wordpress.tar.gz

# Remove the archive to save space
rm lumina-wordpress.tar.gz

# Set correct permissions
find . -type d -exec chmod 755 {} \;
find . -type f -exec chmod 644 {} \;
chmod 600 wp-config.php
```

## Step 9: Configure wp-config.php

You need to update database credentials on the server:

```bash
# Edit wp-config.php
nano wp-config.php

# Update these values with your cPanel database info:
# DB_NAME - Your database name (from cPanel > MySQL Databases)
# DB_USER - Your database username
# DB_PASSWORD - Your database password
# DB_HOST - Usually 'localhost'

# Save: Ctrl+O, Enter
# Exit: Ctrl+X
```

## Step 10: Import Database

### Export from Local:

```bash
# On your local machine
# Replace with your local database credentials
mysqldump -u root -p wordpress_db > lumina-database.sql

# Or if you have a backup plugin, export from WordPress admin
```

### Import to Server:

```bash
# Upload database file
scp lumina-database.sql username@yourdomain.com:~/

# Connect to server
ssh username@yourdomain.com

# Import database (get credentials from cPanel)
mysql -u cpanel_dbuser -p cpanel_dbname < ~/lumina-database.sql

# Enter database password when prompted

# Clean up
rm ~/lumina-database.sql
```

### Update Site URLs in Database:

```bash
# Connect to MySQL
mysql -u cpanel_dbuser -p cpanel_dbname

# Update URLs (replace with your actual domain)
UPDATE wp_options SET option_value = 'https://yourdomain.com' WHERE option_name = 'siteurl';
UPDATE wp_options SET option_value = 'https://yourdomain.com' WHERE option_name = 'home';

# Exit MySQL
exit;
```

## Step 11: Create SSH Config for Easy Access

Make future connections easier by creating an SSH config:

```bash
# On your local Mac
nano ~/.ssh/config

# Add this configuration:
Host lumina-cpanel
    HostName yourdomain.com
    User your-cpanel-username
    Port 22
    IdentityFile ~/.ssh/id_rsa
    ServerAliveInterval 60

# Save and exit

# Now you can connect simply with:
ssh lumina-cpanel

# And upload with:
scp file.zip lumina-cpanel:~/
```

## Quick Reference Commands

### Connect to Server
```bash
ssh username@yourdomain.com
```

### Upload Single File
```bash
scp local-file.php username@yourdomain.com:~/public_html/
```

### Upload Directory
```bash
scp -r local-directory username@yourdomain.com:~/public_html/
```

### Download from Server
```bash
scp username@yourdomain.com:~/public_html/wp-config.php ./
```

### Sync Changes (rsync)
```bash
# Upload changes
rsync -avz --delete ./ username@yourdomain.com:~/public_html/

# Download changes
rsync -avz username@yourdomain.com:~/public_html/ ./
```

### Check Disk Space
```bash
ssh username@yourdomain.com "df -h"
```

### View Error Logs
```bash
ssh username@yourdomain.com "tail -f ~/public_html/wp-content/debug.log"
```

## Security Best Practices

1. **Use SSH Keys**: Never use password authentication in production
2. **Protect Private Key**: 
   ```bash
   chmod 600 ~/.ssh/id_rsa
   ```
3. **Use Strong Passphrase**: Protect your SSH key with a passphrase
4. **Disable Root Login**: Ask your host to disable root SSH access
5. **Change Default Port**: If possible, use a non-standard SSH port
6. **Keep Backups**: Always backup before major changes

## Troubleshooting

### Can't Connect via SSH
1. Verify SSH is enabled in cPanel
2. Check if your IP is blocked (cPanel > IP Blocker)
3. Try password authentication: `ssh -o PreferredAuthentications=password user@host`
4. Contact hosting support

### Slow Upload Speeds
1. Use compression: `scp -C file.zip user@host:~/`
2. Use rsync instead of scp
3. Upload during off-peak hours
4. Consider using screen/tmux for long uploads

### Permission Denied Errors
```bash
# Fix file permissions
find ~/public_html -type d -exec chmod 755 {} \;
find ~/public_html -type f -exec chmod 644 {} \;
chmod 600 ~/public_html/wp-config.php
```

### Database Connection Errors
1. Verify database credentials in wp-config.php
2. Check if database user has proper privileges
3. Confirm database exists in cPanel > MySQL Databases
4. Try 'localhost' or '127.0.0.1' as DB_HOST

## Next Steps

After successful deployment:

1. Test your website: `https://yourdomain.com`
2. Login to WordPress admin: `https://yourdomain.com/wp-admin`
3. Update permalinks: Settings > Permalinks > Save Changes
4. Clear any caches
5. Test all forms and functionality
6. Enable SSL certificate in cPanel (AutoSSL or Let's Encrypt)
7. Update site to use HTTPS

## Useful cPanel Commands via SSH

```bash
# Check PHP version
php -v

# Check MySQL version
mysql --version

# View running processes
top

# Check memory usage
free -m

# Find large files
find ~/public_html -type f -size +10M -exec ls -lh {} \;

# Clear WordPress cache
rm -rf ~/public_html/wp-content/cache/*

# Create database backup
mysqldump -u dbuser -p dbname > backup-$(date +%Y%m%d).sql
```

---

**Need Help?** If you encounter any issues during SSH setup or deployment, let me know the specific error message and I'll help you troubleshoot.
