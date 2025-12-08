# SFTP Deployment Guide for cPanel

Since SSH shell access is blocked on your hosting, SFTP (SSH File Transfer Protocol) is the best alternative for secure, fast file transfers.

## What is SFTP?

SFTP uses SSH for secure file transfer but doesn't require shell access. It's much faster than FTP and more secure.

## Method 1: Command Line SFTP (Fastest)

### Step 1: Test SFTP Connection

Try different ports to find which one works:

```bash
# Try standard SSH port
sftp liseqtmc@lisedu.org

# If that times out, try port 2222 (common for cPanel)
sftp -P 2222 liseqtmc@lisedu.org

# Try with explicit port 22
sftp -P 22 liseqtmc@lisedu.org
```

### Step 2: Basic SFTP Commands

Once connected, you'll see an `sftp>` prompt:

```bash
# View remote directory
ls

# View current remote directory path
pwd

# Change to public_html
cd public_html

# View local directory (on your Mac)
lls

# View local path
lpwd

# Change local directory
lcd /path/to/your/wordpress

# Upload a single file
put index.php

# Upload entire directory recursively
put -r wp-content

# Download a file
get wp-config.php

# Download a directory
get -r wp-content

# Create remote directory
mkdir test-directory

# Remove remote file
rm test-file.php

# Exit SFTP
exit
```

### Step 3: Upload Your WordPress Site

```bash
# Navigate to your WordPress directory locally
cd /path/to/your/wordpress

# Connect to SFTP
sftp liseqtmc@lisedu.org
# (or sftp -P 2222 liseqtmc@lisedu.org if port 2222 works)

# Once connected:
cd public_html

# Upload WordPress core files
put -r wp-admin
put -r wp-includes
put -r wp-content
put index.php
put wp-*.php
put .htaccess
put license.txt
put readme.html

# Exit
exit
```

### Step 4: Batch Upload Script

Create a script to automate uploads:

```bash
# Create upload script
nano upload-to-cpanel.sh
```

Add this content:

```bash
#!/bin/bash

# Configuration
REMOTE_USER="liseqtmc"
REMOTE_HOST="lisedu.org"
REMOTE_PORT="22"  # Change to 2222 if needed
REMOTE_PATH="/public_html"
LOCAL_PATH="."

echo "Starting WordPress upload via SFTP..."

# Create SFTP batch file
cat > sftp-commands.txt << 'EOF'
cd public_html
put -r wp-admin
put -r wp-includes
put -r wp-content
put index.php
put wp-activate.php
put wp-blog-header.php
put wp-comments-post.php
put wp-config-sample.php
put wp-config.php
put wp-cron.php
put wp-links-opml.php
put wp-load.php
put wp-login.php
put wp-mail.php
put wp-settings.php
put wp-signup.php
put wp-trackback.php
put xmlrpc.php
put .htaccess
put license.txt
put readme.html
bye
EOF

# Execute SFTP with batch commands
sftp -P $REMOTE_PORT -b sftp-commands.txt $REMOTE_USER@$REMOTE_HOST

# Clean up
rm sftp-commands.txt

echo "Upload complete!"
```

Make it executable and run:

```bash
chmod +x upload-to-cpanel.sh
./upload-to-cpanel.sh
```

## Method 2: FileZilla (GUI - Easiest)

### Step 1: Download FileZilla

Download from: https://filezilla-project.org/download.php?type=client

### Step 2: Configure Connection

1. Open FileZilla
2. Click "File" > "Site Manager" (or Cmd+S)
3. Click "New Site"
4. Configure:
   - **Protocol**: SFTP - SSH File Transfer Protocol
   - **Host**: lisedu.org
   - **Port**: 22 (try 2222 if 22 doesn't work)
   - **Logon Type**: Key file
   - **User**: liseqtmc
   - **Key file**: Browse to your private key (~/.ssh/id_rsa)

5. Click "Connect"

### Step 3: Upload Files

Once connected:

1. **Left panel**: Your local WordPress files
2. **Right panel**: Remote server (navigate to public_html)
3. **Drag and drop** files/folders from left to right
4. FileZilla shows upload progress

### Tips for FileZilla:
- Right-click > "Create directory" to make folders
- Use "Synchronized browsing" to keep local/remote in sync
- Queue large uploads and let it run in background
- Resume interrupted transfers automatically

## Method 3: Cyberduck (Mac Alternative)

### Step 1: Download Cyberduck

Download from: https://cyberduck.io/download/

### Step 2: Configure Connection

1. Open Cyberduck
2. Click "Open Connection"
3. Select "SFTP (SSH File Transfer Protocol)"
4. Configure:
   - **Server**: lisedu.org
   - **Port**: 22 (or 2222)
   - **Username**: liseqtmc
   - **SSH Private Key**: Choose your ~/.ssh/id_rsa file
5. Click "Connect"

### Step 3: Upload Files

- Navigate to public_html
- Drag files from Finder directly into Cyberduck
- Right-click for more options (permissions, etc.)

## Method 4: Create Zip and Upload via cPanel

If SFTP is also blocked, use this method:

### Step 1: Create Zip Archive Locally

```bash
cd /path/to/your/wordpress

# Create zip excluding unnecessary files
zip -r lumina-wordpress.zip . \
  -x "*.git*" \
  -x "*.DS_Store" \
  -x "node_modules/*" \
  -x "*.log"

# Check the zip file
ls -lh lumina-wordpress.zip
```

### Step 2: Upload via cPanel File Manager

1. Log into cPanel
2. Open "File Manager"
3. Navigate to public_html
4. Click "Upload" button
5. Select your lumina-wordpress.zip file
6. Wait for upload to complete

### Step 3: Extract on Server

1. In File Manager, right-click the zip file
2. Select "Extract"
3. Choose destination (current directory)
4. Click "Extract Files"
5. Delete the zip file after extraction

### Step 4: Set Permissions

```bash
# If you have any SSH access at all, run:
find public_html -type d -exec chmod 755 {} \;
find public_html -type f -exec chmod 644 {} \;
chmod 600 public_html/wp-config.php
```

Or in cPanel File Manager:
- Select all files/folders
- Click "Permissions"
- Set folders to 755
- Set files to 644
- Set wp-config.php to 600

## Troubleshooting SFTP Connection

### Error: "Connection timed out"

Try these solutions:

```bash
# 1. Try port 2222
sftp -P 2222 liseqtmc@lisedu.org

# 2. Try with verbose output to see what's happening
sftp -vvv liseqtmc@lisedu.org

# 3. Check if port is open
nc -zv lisedu.org 22
nc -zv lisedu.org 2222

# 4. Try the server's direct IP address
sftp liseqtmc@YOUR_SERVER_IP
```

### Error: "Permission denied (publickey)"

```bash
# Specify your private key explicitly
sftp -i ~/.ssh/id_rsa liseqtmc@lisedu.org

# Or try password authentication
sftp -o PreferredAuthentications=password liseqtmc@lisedu.org
```

### Error: "No route to host"

- Your hosting provider may have blocked SFTP
- Contact support to enable SFTP access
- Use the zip upload method instead

## Finding Your Server Information

### In cPanel:

1. Look for "SSH Access" section
2. Check for connection details
3. Note any specific hostname or port mentioned

### Common cPanel Hostnames:

- lisedu.org (your domain)
- server123.yourhostingprovider.com
- cpanel.yourhostingprovider.com
- Your server's IP address

### Common Ports:

- 22 (standard SSH/SFTP)
- 2222 (common cPanel alternative)
- 2200, 2201, 2202 (some hosts use these)

## Speed Comparison

| Method | Speed | Ease of Use | Best For |
|--------|-------|-------------|----------|
| SFTP Command Line | ⭐⭐⭐⭐⭐ | ⭐⭐⭐ | Developers, large uploads |
| FileZilla | ⭐⭐⭐⭐ | ⭐⭐⭐⭐⭐ | Everyone, visual interface |
| Cyberduck | ⭐⭐⭐⭐ | ⭐⭐⭐⭐⭐ | Mac users |
| Zip Upload | ⭐⭐ | ⭐⭐⭐⭐ | When SFTP is blocked |
| cPanel File Manager | ⭐ | ⭐⭐⭐ | Small files only |

## Recommended Workflow

### Initial Upload:
1. Create zip of WordPress files
2. Upload zip via cPanel File Manager
3. Extract on server
4. Configure wp-config.php

### Future Updates:
1. Use FileZilla or SFTP command line
2. Only upload changed files
3. Much faster than re-uploading everything

## Next Steps After Upload

1. **Configure Database**:
   - Create database in cPanel > MySQL Databases
   - Update wp-config.php with database credentials

2. **Import Database**:
   - Export from local: `mysqldump -u root -p wordpress_db > database.sql`
   - Upload database.sql via SFTP
   - Import in cPanel > phpMyAdmin

3. **Update URLs**:
   - In phpMyAdmin, run:
   ```sql
   UPDATE wp_options SET option_value = 'https://lisedu.org' WHERE option_name = 'siteurl';
   UPDATE wp_options SET option_value = 'https://lisedu.org' WHERE option_name = 'home';
   ```

4. **Test Site**:
   - Visit https://lisedu.org
   - Login to wp-admin
   - Update permalinks

---

**Need Help?** Let me know which method you'd like to use and I can provide more specific guidance!
