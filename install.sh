#!/bin/bash

# Colors for output
GREEN='\033[0;32m'
RED='\033[0;31m'
NC='\033[0m'

# Check if we're in the correct directory
if [ ! -f "appinfo/info.xml" ]; then
    echo -e "${RED}Error: Must be run from the printorders app directory${NC}"
    exit 1
fi

# Create necessary directories
echo "Creating directories..."
mkdir -p {css,img,js,lib/{Controller,Service,Db,Migration},src/{components,hooks,utils},templates}

# Install PHP dependencies
echo "Installing PHP dependencies..."
if command -v composer &> /dev/null; then
    composer install
else
    echo -e "${RED}Error: Composer not found. Please install Composer first.${NC}"
    exit 1
fi

# Install Node.js dependencies
echo "Installing Node.js dependencies..."
if command -v npm &> /dev/null; then
    npm install
else
    echo -e "${RED}Error: npm not found. Please install Node.js first.${NC}"
    exit 1
fi

# Build frontend assets
echo "Building frontend assets..."
npm run build

# Set permissions
echo "Setting permissions..."
chmod -R 755 .
find . -type f -exec chmod 644 {} \;
chmod +x install.sh

# Create symbolic links
echo "Creating symbolic links..."
NEXTCLOUD_APPS_DIR="../../../apps"
if [ -d "$NEXTCLOUD_APPS_DIR" ]; then
    ln -sf "$(pwd)" "$NEXTCLOUD_APPS_DIR/printorders"
else
    echo -e "${RED}Warning: Nextcloud apps directory not found at $NEXTCLOUD_APPS_DIR${NC}"
fi

echo -e "${GREEN}Installation complete!${NC}"
echo "Please run 'occ app:enable printorders' to enable the app in Nextcloud."