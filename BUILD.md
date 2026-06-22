# Build System Documentation

This module includes multiple build options for creating distributable packages.

## Quick Start

### Linux/macOS/Unix

```bash
# Using the build script
./build.sh

# Or using Make
make build
```

### Windows

```cmd
# Using the batch file
build.bat
```

---

## Build Methods

### Method 1: Bash Script (Recommended for Linux/macOS)

**File:** `build.sh`

**Usage:**
```bash
chmod +x build.sh
./build.sh
```

**Features:**
- Coloured output
- Progress indicators
- Automatic version detection
- File size reporting
- Clean build directory management

**Output:**
- Creates `mod_thoughtoftd_v5.0.0.zip` (version number from XML)

---

### Method 2: Windows Batch File

**File:** `build.bat`

**Usage:**
```cmd
build.bat
```

**Requirements:**
- PowerShell (for ZIP creation)
- Windows 7 or later

**Features:**
- Windows-compatible
- Automatic version detection
- Clean build process
- PowerShell ZIP compression

**Output:**
- Creates `mod_thoughtoftd_v5.0.0.zip`

---

### Method 3: Makefile (Advanced)

**File:** `Makefile`

**Requirements:**
- GNU Make
- Standard Unix tools (zip, find, etc.)

**Available Targets:**

#### Build the package
```bash
make build
# or
make package
```

#### Run validation tests
```bash
make test
```

Validates:
- File structure
- XML syntax (if xmllint installed)
- PHP syntax
- Required files presence

#### Display module information
```bash
make info
```

Shows:
- Module name and version
- File counts
- Available layouts
- Module type

#### Clean build artefacts
```bash
make clean
```

Removes:
- Build directory
- Generated ZIP files

#### Show help
```bash
make help
# or just
make
```

---

## What Gets Included

The build process includes:

### ✅ Included Files

```
mod_thoughtoftd/
├── mod_thoughtoftd.php          # Main module file
├── mod_thoughtoftd.xml          # Manifest
├── Helper/
│   └── ThoughtoftdHelper.php    # Helper class
├── language/
│   ├── en-GB/
│   ├── es-ES/
│   ├── fi-FI/
│   ├── pt-PT/
│   └── ru-RU/
├── media/
│   ├── css/
│   │   └── thoughtoftd.css      # Module styles
│   └── js/
│       └── thoughtoftd.js       # Module JavaScript
└── tmpl/
    ├── default.php              # Default layout
    ├── card.php                 # Card layout
    ├── cardhorizontal.php       # Horizontal card layout
    └── cardoverlay.php          # Overlay card layout
```

### ❌ Excluded Files

- `build.sh` - Build script
- `build.bat` - Windows build script
- `Makefile` - Make configuration
- `BUILD.md` - This file
- `LAYOUTS.md` - Layout documentation
- `tod.zip` - Old package
- `*.md` files in tmpl/ - Template documentation
- `.DS_Store` - macOS system files
- `Thumbs.db` - Windows system files
- `.gitignore` - Git configuration
- `*.swp` - Vim swap files

---

## Build Process Details

### Step-by-Step Process

1. **Clean Previous Build**
   - Removes old `build/` directory
   - Deletes previous ZIP packages

2. **Create Build Structure**
   - Creates `build/mod_thoughtoftd/` directory
   - Mirrors module structure

3. **Copy Files**
   - Copies PHP files
   - Copies Helper directory
   - Copies language files
   - Copies media assets
   - Copies template files

4. **Clean Up**
   - Removes system files (`.DS_Store`, `Thumbs.db`)
   - Removes editor files (`.swp`, etc.)
   - Removes version control files

5. **Create Package**
   - Creates ZIP archive
   - Names with version number
   - Moves to project root

6. **Cleanup**
   - Removes build directory
   - Reports package size and location

---

## Version Management

The version number is automatically extracted from `mod_thoughtoftd.xml`:

```xml
<version>5.0.0</version>
```

This creates: `mod_thoughtoftd_v5.0.0.zip`

To change the version:
1. Edit `mod_thoughtoftd.xml`
2. Update the `<version>` tag
3. Run the build script

---

## Validation

### Using Make

```bash
make test
```

This validates:
- ✓ XML manifest exists
- ✓ Main module file exists
- ✓ Helper class exists
- ✓ Template files exist
- ✓ Card layouts exist
- ✓ Media files exist
- ✓ Language files exist
- ✓ XML syntax (if xmllint available)
- ✓ PHP syntax

### Manual Validation

Check the package contents:

```bash
# Linux/macOS
unzip -l mod_thoughtoftd_v5.0.0.zip

# Windows
powershell -command "Expand-Archive -Path mod_thoughtoftd_v5.0.0.zip -DestinationPath test_extract"
```

---

## Troubleshooting

### Build Script Not Executable (Linux/macOS)

**Problem:** `Permission denied` when running `./build.sh`

**Solution:**
```bash
chmod +x build.sh
./build.sh
```

### PowerShell Not Found (Windows)

**Problem:** Build fails with "PowerShell not found"

**Solution:**
- Install PowerShell from Microsoft
- Or manually create ZIP:
  1. Run `build.bat` (it will create the build folder)
  2. Manually ZIP the `build/mod_thoughtoftd` folder
  3. Rename to `mod_thoughtoftd_v5.0.0.zip`

### Make Command Not Found

**Problem:** `make: command not found`

**Solution:**
- **Linux:** `sudo apt-get install build-essential` (Debian/Ubuntu)
- **macOS:** Install Xcode Command Line Tools: `xcode-select --install`
- **Windows:** Use Git Bash or WSL, or use `build.bat` instead

### ZIP Command Not Found

**Problem:** `zip: command not found`

**Solution:**
- **Linux:** `sudo apt-get install zip`
- **macOS:** Should be pre-installed
- **Windows:** Use PowerShell method in `build.bat`

### Version Number Not Detected

**Problem:** Package named `mod_thoughtoftd_v.zip`

**Solution:**
- Ensure `mod_thoughtoftd.xml` has `<version>` tag
- Check XML syntax is valid
- Ensure no extra spaces in version tag

---

## Continuous Integration

### GitHub Actions Example

```yaml
name: Build Module

on:
  push:
    tags:
      - 'v*'

jobs:
  build:
    runs-on: ubuntu-latest
    
    steps:
    - uses: actions/checkout@v2
    
    - name: Validate module
      run: make test
    
    - name: Build package
      run: make build
    
    - name: Upload artifact
      uses: actions/upload-artifact@v2
      with:
        name: module-package
        path: mod_thoughtoftd_v*.zip
```

### GitLab CI Example

```yaml
build:
  stage: build
  script:
    - make test
    - make build
  artifacts:
    paths:
      - mod_thoughtoftd_v*.zip
    expire_in: 1 week
  only:
    - tags
```

---

## Advanced Usage

### Custom Build Directory

Edit the build script to change the build directory:

```bash
# In build.sh
BUILD_DIR="custom_build"
```

### Include Documentation

Uncomment these lines in `build.sh`:

```bash
# Optional: Include documentation in package
cp tmpl/README.md "$BUILD_DIR/$MODULE_NAME/tmpl/" 2>/dev/null || true
cp LAYOUTS.md "$BUILD_DIR/$MODULE_NAME/" 2>/dev/null || true
```

### Custom Package Name

Edit the script to customise the package name:

```bash
# In build.sh
PACKAGE_NAME="${MODULE_NAME}_custom_v${VERSION}.zip"
```

---

## Best Practices

1. **Always validate before building:**
   ```bash
   make test && make build
   ```

2. **Clean before building:**
   ```bash
   make clean build
   ```

3. **Test the package:**
   - Install in a test Joomla instance
   - Verify all layouts work
   - Check media files load correctly

4. **Version control:**
   - Update version in XML before building
   - Tag releases in Git
   - Keep changelog updated

5. **Distribution:**
   - Test package on fresh Joomla installation
   - Verify upgrade path from previous versions
   - Document any breaking changes

---

## Package Distribution

After building, you can:

1. **Install in Joomla:**
   - Go to Extensions → Install
   - Upload the ZIP file
   - Follow installation wizard

2. **Distribute:**
   - Upload to Joomla Extensions Directory
   - Host on your website
   - Share via GitHub releases
   - Distribute via update server

3. **Update Server:**
   - Host the ZIP on your server
   - Update the update server XML
   - Users will receive automatic updates

---

## Support

For build issues:
1. Check this documentation
2. Verify all required files exist
3. Check file permissions
4. Validate XML and PHP syntax
5. Review error messages carefully

For module issues, refer to the main documentation.

