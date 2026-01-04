#!/bin/bash

# WPvivid Backup Restoration Script
# This script restores a WPvivid backup to a local WordPress installation

# Configuration
PROJECT_PATH="/Users/zrshishir/Projects/Wppool/cabinet-doors"
BACKUP_PATH="/Users/zrshishir/Downloads"
DB_NAME="cabinet_doors_local"
DB_USER="root"
DB_PASS="root"
DB_HOST="localhost"
LOCAL_URL="http://cabinet-doors.local"
STAGING_URL="https://cabinetdoorsplus.kinsta.cloud"

# Colors for output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

echo -e "${GREEN}=== WPvivid Backup Restoration ===${NC}"
echo ""

# Step 1: Create project directory
echo -e "${YELLOW}Step 1: Creating project directory...${NC}"
mkdir -p "$PROJECT_PATH"
cd "$PROJECT_PATH"

# Step 2: Extract WordPress Core
echo -e "${YELLOW}Step 2: Extracting WordPress Core...${NC}"
if [ -f "$BACKUP_PATH/cabinetdoorsplus-3/cabinetdoorsplus.kinsta.cloud_wpvivid-30c0260a93723_2025-12-10-17-56_backup_core.zip" ]; then
    unzip -q "$BACKUP_PATH/cabinetdoorsplus-3/cabinetdoorsplus.kinsta.cloud_wpvivid-30c0260a93723_2025-12-10-17-56_backup_core.zip" -d "$PROJECT_PATH"
    echo -e "${GREEN}✓ WordPress Core extracted${NC}"
else
    echo -e "${RED}✗ Core backup not found${NC}"
    exit 1
fi

# Step 3: Extract Themes
echo -e "${YELLOW}Step 3: Extracting Themes...${NC}"
if [ -f "$BACKUP_PATH/cabinetdoorsplus/cabinetdoorsplus.kinsta.cloud_wpvivid-30c0260a93723_2025-12-10-17-56_backup_themes.zip" ]; then
    unzip -q "$BACKUP_PATH/cabinetdoorsplus/cabinetdoorsplus.kinsta.cloud_wpvivid-30c0260a93723_2025-12-10-17-56_backup_themes.zip" -d "$PROJECT_PATH/wp-content"
    echo -e "${GREEN}✓ Themes extracted${NC}"
else
    echo -e "${RED}✗ Themes backup not found${NC}"
fi

# Step 4: Extract Plugins
echo -e "${YELLOW}Step 4: Extracting Plugins...${NC}"
if [ -f "$BACKUP_PATH/cabinetdoorsplus/cabinetdoorsplus.kinsta.cloud_wpvivid-30c0260a93723_2025-12-10-17-56_backup_plugin.zip" ]; then
    unzip -q "$BACKUP_PATH/cabinetdoorsplus/cabinetdoorsplus.kinsta.cloud_wpvivid-30c0260a93723_2025-12-10-17-56_backup_plugin.zip" -d "$PROJECT_PATH/wp-content"
    echo -e "${GREEN}✓ Plugins extracted${NC}"
else
    echo -e "${RED}✗ Plugins backup not found${NC}"
fi

# Step 5: Extract Content
echo -e "${YELLOW}Step 5: Extracting Content...${NC}"
if [ -f "$BACKUP_PATH/cabinetdoorsplus-3/cabinetdoorsplus.kinsta.cloud_wpvivid-30c0260a93723_2025-12-10-17-56_backup_content.zip" ]; then
    unzip -q "$BACKUP_PATH/cabinetdoorsplus-3/cabinetdoorsplus.kinsta.cloud_wpvivid-30c0260a93723_2025-12-10-17-56_backup_content.zip" -d "$PROJECT_PATH/wp-content"
    echo -e "${GREEN}✓ Content extracted${NC}"
else
    echo -e "${RED}✗ Content backup not found${NC}"
fi

# Step 6: Extract Uploads (4 parts)
echo -e "${YELLOW}Step 6: Extracting Uploads (4 parts)...${NC}"
mkdir -p "$PROJECT_PATH/wp-content/uploads"

# Part 1
if [ -f "$BACKUP_PATH/cabinetdoorsplus-2/cabinetdoorsplus.kinsta.cloud_wpvivid-30c0260a93723_2025-12-10-17-56_backup_uploads.part001.zip" ]; then
    unzip -q "$BACKUP_PATH/cabinetdoorsplus-2/cabinetdoorsplus.kinsta.cloud_wpvivid-30c0260a93723_2025-12-10-17-56_backup_uploads.part001.zip" -d "$PROJECT_PATH/wp-content/uploads"
    echo -e "${GREEN}✓ Uploads part 1 extracted${NC}"
fi

# Part 2
if [ -f "$BACKUP_PATH/cabinetdoorsplus-4/cabinetdoorsplus.kinsta.cloud_wpvivid-30c0260a93723_2025-12-10-17-56_backup_uploads.part002.zip" ]; then
    unzip -q "$BACKUP_PATH/cabinetdoorsplus-4/cabinetdoorsplus.kinsta.cloud_wpvivid-30c0260a93723_2025-12-10-17-56_backup_uploads.part002.zip" -d "$PROJECT_PATH/wp-content/uploads"
    echo -e "${GREEN}✓ Uploads part 2 extracted${NC}"
fi

# Part 3
if [ -f "$BACKUP_PATH/cabinetdoorsplus-5/cabinetdoorsplus.kinsta.cloud_wpvivid-30c0260a93723_2025-12-10-17-56_backup_uploads.part003.zip" ]; then
    unzip -q "$BACKUP_PATH/cabinetdoorsplus-5/cabinetdoorsplus.kinsta.cloud_wpvivid-30c0260a93723_2025-12-10-17-56_backup_uploads.part003.zip" -d "$PROJECT_PATH/wp-content/uploads"
    echo -e "${GREEN}✓ Uploads part 3 extracted${NC}"
fi

# Part 4
if [ -f "$BACKUP_PATH/cabinetdoorsplus-3/cabinetdoorsplus.kinsta.cloud_wpvivid-30c0260a93723_2025-12-10-17-56_backup_uploads.part004.zip" ]; then
    unzip -q "$BACKUP_PATH/cabinetdoorsplus-3/cabinetdoorsplus.kinsta.cloud_wpvivid-30c0260a93723_2025-12-10-17-56_backup_uploads.part004.zip" -d "$PROJECT_PATH/wp-content/uploads"
    echo -e "${GREEN}✓ Uploads part 4 extracted${NC}"
fi

# Step 7: Create Database
echo -e "${YELLOW}Step 7: Creating Database...${NC}"
mysql -u"$DB_USER" -p"$DB_PASS" -h"$DB_HOST" -e "CREATE DATABASE IF NOT EXISTS $DB_NAME CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
echo -e "${GREEN}✓ Database created${NC}"

# Step 8: Import Database
echo -e "${YELLOW}Step 8: Importing Database...${NC}"
if [ -f "$BACKUP_PATH/cabinetdoorsplus/cabinetdoorsplus.kinsta.cloud_wpvivid-30c0260a93723_2025-12-10-17-56_backup_db.zip" ]; then
    # Extract SQL file
    unzip -q "$BACKUP_PATH/cabinetdoorsplus/cabinetdoorsplus.kinsta.cloud_wpvivid-30c0260a93723_2025-12-10-17-56_backup_db.zip" -d "/tmp"
    
    # Import SQL
    mysql -u"$DB_USER" -p"$DB_PASS" -h"$DB_HOST" "$DB_NAME" < "/tmp/cabinetdoorsplus.kinsta.cloud_wpvivid-30c0260a93723_2025-12-10-17-56_backup_db.sql"
    
    # Clean up
    rm "/tmp/cabinetdoorsplus.kinsta.cloud_wpvivid-30c0260a93723_2025-12-10-17-56_backup_db.sql"
    
    echo -e "${GREEN}✓ Database imported${NC}"
else
    echo -e "${RED}✗ Database backup not found${NC}"
    exit 1
fi

# Step 9: Create wp-config.php
echo -e "${YELLOW}Step 9: Creating wp-config.php...${NC}"
cat > "$PROJECT_PATH/wp-config.php" << 'EOF'
<?php
define( 'DB_NAME', 'cabinet_doors_local' );
define( 'DB_USER', 'root' );
define( 'DB_PASSWORD', 'root' );
define( 'DB_HOST', 'localhost' );
define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', '' );

define('AUTH_KEY',         'put your unique phrase here');
define('SECURE_AUTH_KEY',  'put your unique phrase here');
define('LOGGED_IN_KEY',    'put your unique phrase here');
define('NONCE_KEY',        'put your unique phrase here');
define('AUTH_SALT',        'put your unique phrase here');
define('SECURE_AUTH_SALT', 'put your unique phrase here');
define('LOGGED_IN_SALT',   'put your unique phrase here');
define('NONCE_SALT',       'put your unique phrase here');

$table_prefix = 'wp_';

define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );

if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', __DIR__ . '/' );
}

require_once ABSPATH . 'wp-settings.php';
EOF

echo -e "${GREEN}✓ wp-config.php created${NC}"

# Step 10: Update URLs in Database
echo -e "${YELLOW}Step 10: Updating URLs in database...${NC}"
cd "$PROJECT_PATH"

# Using WP-CLI if available
if command -v wp &> /dev/null; then
    wp search-replace "$STAGING_URL" "$LOCAL_URL" --all-tables --allow-root
    echo -e "${GREEN}✓ URLs updated with WP-CLI${NC}"
else
    echo -e "${YELLOW}⚠ WP-CLI not found. You'll need to update URLs manually or install WP-CLI${NC}"
    echo -e "${YELLOW}  Run: wp search-replace '$STAGING_URL' '$LOCAL_URL' --all-tables${NC}"
fi

# Step 11: Set Permissions
echo -e "${YELLOW}Step 11: Setting permissions...${NC}"
chmod -R 755 "$PROJECT_PATH"
chmod -R 775 "$PROJECT_PATH/wp-content/uploads"
echo -e "${GREEN}✓ Permissions set${NC}"

echo ""
echo -e "${GREEN}=== Restoration Complete! ===${NC}"
echo ""
echo -e "${YELLOW}Next Steps:${NC}"
echo "1. Configure your local server (Apache/Nginx) to point to: $PROJECT_PATH"
echo "2. Add to /etc/hosts: 127.0.0.1 cabinet-doors.local"
echo "3. Visit: $LOCAL_URL"
echo "4. Login with your staging credentials"
echo ""
echo -e "${YELLOW}Database Info:${NC}"
echo "  Name: $DB_NAME"
echo "  User: $DB_USER"
echo "  Pass: $DB_PASS"
echo "  Host: $DB_HOST"
echo ""
