#!/bin/bash

##
# Build script for Thought of the Day Joomla 5 Module
# Creates a distributable ZIP package
##

set -e

# Colours for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Colour

# Script directory
SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
cd "$SCRIPT_DIR"

# Module information
MODULE_NAME="mod_thoughtoftd"
VERSION=$(grep -oP '(?<=<version>)[^<]+' mod_thoughtoftd.xml)
BUILD_DIR="build"
PACKAGE_NAME="${MODULE_NAME}_v${VERSION}.zip"

echo -e "${BLUE}╔════════════════════════════════════════════════╗${NC}"
echo -e "${BLUE}║   Thought of the Day - Build Script           ║${NC}"
echo -e "${BLUE}║   Version: ${VERSION}                               ║${NC}"
echo -e "${BLUE}╚════════════════════════════════════════════════╝${NC}"
echo ""

# Clean previous build
echo -e "${YELLOW}→${NC} Cleaning previous build..."
rm -rf "$BUILD_DIR"
mkdir -p "$BUILD_DIR/$MODULE_NAME"

# Files and folders to include
echo -e "${YELLOW}→${NC} Copying module files..."

# Copy PHP files
cp mod_thoughtoftd.php "$BUILD_DIR/$MODULE_NAME/"
cp mod_thoughtoftd.xml "$BUILD_DIR/$MODULE_NAME/"

# Copy Helper directory
echo -e "  ${GREEN}✓${NC} Helper/"
cp -r Helper "$BUILD_DIR/$MODULE_NAME/"

# Copy language directory
echo -e "  ${GREEN}✓${NC} language/"
cp -r language "$BUILD_DIR/$MODULE_NAME/"

# Copy media directory
echo -e "  ${GREEN}✓${NC} media/"
cp -r media "$BUILD_DIR/$MODULE_NAME/"

# Copy template directory
echo -e "  ${GREEN}✓${NC} tmpl/"
mkdir -p "$BUILD_DIR/$MODULE_NAME/tmpl"
cp tmpl/*.php "$BUILD_DIR/$MODULE_NAME/tmpl/"

# Optional: Include documentation in package (comment out if not wanted)
# cp tmpl/README.md "$BUILD_DIR/$MODULE_NAME/tmpl/" 2>/dev/null || true
# cp LAYOUTS.md "$BUILD_DIR/$MODULE_NAME/" 2>/dev/null || true

# Remove any hidden files and system files
echo -e "${YELLOW}→${NC} Cleaning up..."
find "$BUILD_DIR" -name ".DS_Store" -delete 2>/dev/null || true
find "$BUILD_DIR" -name "Thumbs.db" -delete 2>/dev/null || true
find "$BUILD_DIR" -name ".gitignore" -delete 2>/dev/null || true
find "$BUILD_DIR" -name "*.swp" -delete 2>/dev/null || true

# Create ZIP package
echo -e "${YELLOW}→${NC} Creating package..."
cd "$BUILD_DIR"
zip -r "$PACKAGE_NAME" "$MODULE_NAME" -q

# Move to root and clean up
mv "$PACKAGE_NAME" ..
cd ..
rm -rf "$BUILD_DIR"

# Get file size
FILE_SIZE=$(du -h "$PACKAGE_NAME" | cut -f1)

# Success message
echo ""
echo -e "${GREEN}╔════════════════════════════════════════════════╗${NC}"
echo -e "${GREEN}║   Build completed successfully!                ║${NC}"
echo -e "${GREEN}╚════════════════════════════════════════════════╝${NC}"
echo ""
echo -e "${BLUE}Package:${NC} $PACKAGE_NAME"
echo -e "${BLUE}Size:${NC}    $FILE_SIZE"
echo -e "${BLUE}Version:${NC} $VERSION"
echo ""
echo -e "${YELLOW}Ready for installation in Joomla!${NC}"
echo ""

