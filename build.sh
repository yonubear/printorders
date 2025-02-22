#!/bin/bash

# Colors for output
GREEN='\033[0;32m'
RED='\033[0;31m'
NC='\033[0m'

# Clean previous build
echo "Cleaning previous build..."
rm -rf js/*

# Install dependencies
echo "Installing dependencies..."
npm install

# Run build
echo "Building application..."
if [ "$1" == "--analyze" ]; then
    ANALYZE=1 npm run build
else
    npm run build
fi

# Copy assets
echo "Copying assets..."
mkdir -p js/assets
cp -r src/assets/* js/assets/

# Set permissions
echo "Setting permissions..."
chmod -R 755 js

echo -e "${GREEN}Build complete!${NC}"