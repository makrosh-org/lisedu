#!/bin/bash

# Quick WPvivid Restore - Interactive Version
# This script will guide you through the restoration process

set -e

# Colors
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
BLUE='\033[0;34m'
NC='\033[0m'

clear
echo -e "${BLUE}╔════════════════════════════════════════════════════╗${NC}"
echo -e "${BLUE}║   WPvivid Backup Restoration - Cabinet Doors      ║${NC}"
echo -e "${BLUE}╚════════════════════════════════════════════════════╝${NC}"
echo ""

# Default values
DEFAULT_PROJECT_PATH="/Users/zrshishir/Projects/Wppool/cabinet-doors"
DEFAULT_BACKUP_PATH="/Users/zrshishir/Downloads"
DEFAULT_DB_NAME="cabinet_doors_local"
DEFAULT_DB_USER="root"
DEFAULT_DB_PASS=""
DEFAULT_DB_HOST="localhost"
DEFAULT_LOCAL_URL="http://cabinet-doors.test"
STAGING_URL="https://cabinetdoorsplus.kinsta.cloud"

# Ask for configuration
echo -e "${YELLOW}Configuration Setup${NC}"
echo ""

read -p "Project path [$DEFAULT_PROJECT_PATH]: " PROJECT_PATH
PROJECT_PATH=${PROJECT_PATH:-$DEFAULT_PROJECT_PATH}

read -p "Backup files location [$DEFAULT_BACKUP_PATH]: " BACKUP_PATH
BACKUP_PATH=${BACKUP_PATH:-$DEFAULT_BACKUP_PATH}

read -p "Database name [$DEFAULT_DB_NAME]: " DB_NAME
DB_NAME=${DB_NAME:-$DEFAULT_DB_NAME}

read -p "Database user [$DEFAULT_DB_USER]: " DB_USER
DB_USER=${DB_USER:-$DEFAULT_DB_USER}

read -p "Database password [$DEFAULT_DB_PASS]: " DB_PASS
DB_PASS=${DB_PASS:-$DEFAULT_DB_PASS}

read -p "Database host [$DEFAULT_DB_HOST]: " DB_HOST
DB_HOST=${DB_HOST:-$DEFAULT_DB_HOST}

read -p "Local URL [$DEFAULT_LOCAL_URL]: " LOCAL_URL
LOCAL_URL=${LOCAL_URL:-$DEFAULT_LOCAL_URL}

echo ""
echo -e "${BLUE}Configuration Summary:${NC}"
echo "  Project: $PROJECT_PATH"
echo "  Backup: $BACKUP_PATH"
echo "  Database: $DB_NAME"
echo "  Local URL: $LOCAL_URL"
echo ""

read -p "Continue with restoration? (y/n): " CONFIRM
if [ "$CONFIRM" != "y" ]; then
    echo "Restoration cancelled."
    exit 0
fi

echo ""
echo -e "${GREEN}Starting restoration...${NC}"
echo ""

# Create project directory
echo -e "${YELLOW}[1/11] Creating project directory...${NC}"
mkdir -p "$PROJECT_PATH"
cd "$PROJECT_PATH"
echo -e "${GREEN}✓ Done${NC}"

# Extract WordPress Core
echo -e "${YELLOW}[2/11] Extracting WordPress Core...${NC}"
unzip -q "$BACKUP_PATH/cabinetdoorsplus-3/cabinetdoorsplus.kinsta.cloud_wpvivid-30c0260a93723_2025-12-10-17-56_backup_core.zip" -d "$PROJECT_PATH"
echo -e "${GREEN}✓ Done${NC}"

# Extract Themes
echo -e "${YELLOW}[3/11] Extracting Themes...${NC}"
unzip -q "$BACKUP_PATH/cabinetdoorsplus/cabinetdoorsplus.kinsta.cloud_wpvivid-30c0260a93723_2025-12-10-17-56_backup_themes.zip" -d "$PROJECT_PATH/wp-content"
echo -e "${GREEN}✓ Done${NC}"

# Extract Plugins
echo -e "${YELLOW}[4/11] Extracting Plugins...${NC}"
unzip -q "$BACKUP_PATH/cabinetdoorsplus/cabinetdoorsplus.kinsta.cloud_wpvivid-30c0260a93723_2025-12-10-17-56_backup_plugin.zip" -d "$PROJECT_PATH/wp-content"
echo -e "${GREEN}✓ Done${NC}"

# Extract Content
echo -e "${YELLOW}[5/11] Extracting Content...${NC}"
unzip -q "$BACKUP_PATH/cabinetdoorsplus-3/cabinetdoorsplus.kinsta.cloud_wpvivid-30c0260a93723_2025-12-10-17-56_backup_content.zip" -d "$PROJECT_PATH/wp-content"
echo -e "${GREEN}✓ Done${NC}"

# Extract Uploads
echo -e "${YELLOW}[6/11] Extracting Uploads (4 parts)...${NC}"
mkdir -p "$PROJECT_PATH/wp-content/uploads"

echo "  → Part 1/4..."
unzip -q "$BACKUP_PATH/cabinetdoorsplus-2/cabinetdoorsplus.kinsta.cloud_wpvivid-30c0260a93723_2025-12-10-17-56_backup_uploads.part001.zip" -d "$PROJECT_PATH/wp-content/uploads"

echo "  → Part 2/4..."
unzip -q "$BACKUP_PATH/cabinetdoorsplus-4/cabinetdoorsplus.kinsta.cloud_wpvivid-30c0260a93723_2025-12-10-17-56_backup_uploads.part002.zip" -d "$PROJECT_PATH/wp-content/uploads"

echo "  → Part 3/4..."
unzip -q "$BACKUP_PATH/cabinetdoorsplus-5/cabinetdoorsplus.kinsta.cloud_wpvivid-30c0260a93723_2025-12-10-17-56_backup_uploads.part003.zip" -d "$PROJECT_PATH/wp-content/uploads"

echo "  → Part 4/4..."
unzip -q "$BACKUP_PATH/cabinetdoorsplus-3/cabinetdoorsplus.kinsta.cloud_wpvivid-30c0260a93723_2025-12-10-17-56_backup_uploads.part004.zip" -d "$PROJECT_PATH/wp-content/uploads"

echo -e "${GREEN}✓ Done${NC}"

# Create Database
echo -e "${YELLOW}[7/11] Creating Database...${NC}"
mysql -u"$DB_USER" -p"$DB_PASS" -h"$DB_HOST" -e "CREATE DATABASE IF NOT EXISTS $DB_NAME CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" 2>/dev/null || {
    echo -e "${RED}✗ Failed to create database. Please check your MySQL credentials.${NC}"
    exit 1
}
echo -e "${GREEN}✓ Done${NC}"

# Import Database
echo -e "${YELLOW}[8/11] Importing Database (this may take a while)...${NC}"
unzip -q "$BACKUP_PATH/cabinetdoorsplus/cabinetdoorsplus.kinsta.cloud_wpvivid-30c0260a93723_2025-12-10-17-56_backup_db.zip" -d "/tmp"
mysql -u"$DB_USER" -p"$DB_PASS" -h"$DB_HOST" "$DB_NAME" < "/tmp/cabinetdoorsplus.kinsta.cloud_wpvivid-30c0260a93723_2025-12-10-17-56_backup_db.sql"
rm "/tmp/cabinetdoorsplus.kinsta.cloud_wpvivid-30c0260a93723_2025-12-10-17-56_backup_db.sql"
echo -e "${GREEN}✓ Done${NC}"

# Create wp-config.php
echo -e "${YELLOW}[9/11] Creating wp-config.php...${NC}"
cat > "$PROJECT_PATH/wp-config.php" << EOF
<?php
define( 'DB_NAME', '$DB_NAME' );
define( 'DB_USER', '$DB_USER' );
define( 'DB_PASSWORD', '$DB_PASS' );
define( 'DB_HOST', '$DB_HOST' );
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

\$table_prefix = 'wp_';

define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );

if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', __DIR__ . '/' );
}

require_once ABSPATH . 'wp-settings.php';
EOF
echo -e "${GREEN}✓ Done${NC}"

# Update URLs
echo -e "${YELLOW}[10/11] Updating URLs in database...${NC}"
if command -v wp &> /dev/null; then
    cd "$PROJECT_PATH"
    wp search-replace "$STAGING_URL" "$LOCAL_URL" --all-tables --allow-root 2>/dev/null
    echo -e "${GREEN}✓ Done with WP-CLI${NC}"
else
    echo -e "${YELLOW}⚠ WP-CLI not found. URLs need manual update.${NC}"
    echo -e "${YELLOW}  Install WP-CLI or run: wp search-replace '$STAGING_URL' '$LOCAL_URL' --all-tables${NC}"
fi

# Set Permissions
echo -e "${YELLOW}[11/11] Setting permissions...${NC}"
chmod -R 755 "$PROJECT_PATH"
chmod -R 775 "$PROJECT_PATH/wp-content/uploads"
echo -e "${GREEN}✓ Done${NC}"

echo ""
echo -e "${GREEN}╔════════════════════════════════════════════════════╗${NC}"
echo -e "${GREEN}║          Restoration Complete! 🎉                  ║${NC}"
echo -e "${GREEN}╚════════════════════════════════════════════════════╝${NC}"
echo ""
echo -e "${BLUE}Next Steps:${NC}"
echo ""
echo -e "${YELLOW}1. Configure your local server:${NC}"
echo "   - Point document root to: $PROJECT_PATH"
echo ""
echo -e "${YELLOW}2. Update hosts file:${NC}"
echo "   sudo nano /etc/hosts"
echo "   Add: 127.0.0.1 cabinet-doors.local"
echo ""
echo -e "${YELLOW}3. Access your site:${NC}"
echo "   URL: $LOCAL_URL"
echo "   Admin: $LOCAL_URL/wp-admin"
echo ""
echo -e "${YELLOW}4. Database Info:${NC}"
echo "   Name: $DB_NAME"
echo "   User: $DB_USER"
echo "   Host: $DB_HOST"
echo ""
echo -e "${BLUE}For detailed instructions, see: RESTORATION-GUIDE.md${NC}"
echo ""
