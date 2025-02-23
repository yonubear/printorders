#!/bin/bash

# Colors for output
GREEN='\033[0;32m'
RED='\033[0;31m'
NC='\033[0m'

echo "Setting up Print Orders app build environment..."

# Check if npm is installed
if ! command -v npm &> /dev/null; then
    echo -e "${RED}Error: npm is not installed${NC}"
    exit 1
fi

# Install dependencies
echo "Installing dependencies..."
npm install

# Create necessary directories
echo "Creating directories..."
mkdir -p \
    dist \
    src/components \
    src/store \
    src/router \
    src/services \
    css

# Copy initial assets
echo "Copying assets..."
if [ ! -d "src/assets" ]; then
    mkdir -p src/assets
fi

# Set correct permissions
echo "Setting permissions..."
chmod +x webpack.config.js
chmod -R 755 src

echo -e "${GREEN}Setup complete!${NC}"
echo "You can now run 'npm run dev' to start development server"