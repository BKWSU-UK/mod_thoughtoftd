# Build System - Quick Reference

## TL;DR

```bash
# Linux/macOS - Quick build
./build.sh

# Or with Make
make build

# Windows
build.bat
```

---

## Common Commands

### Build Package
```bash
./build.sh              # Bash script
make build              # Makefile
build.bat               # Windows
```

### Validate Module
```bash
make test
```

### Clean Build Files
```bash
make clean
```

### Show Module Info
```bash
make info
```

### Show Help
```bash
make help
```

---

## Build Output

**Package Name:** `mod_thoughtoftd_v5.0.0.zip`  
**Package Size:** ~20KB  
**Location:** Project root directory

---

## What's Included

✅ PHP files (module, helper)  
✅ XML manifest  
✅ 4 template layouts  
✅ Language files (5 languages)  
✅ Media files (CSS, JS)  

❌ Documentation files  
❌ Build scripts  
❌ System files  

---

## Troubleshooting

| Problem | Solution |
|---------|----------|
| Permission denied | `chmod +x build.sh` |
| Make not found | Use `./build.sh` instead |
| PowerShell error (Windows) | Install PowerShell |
| Wrong version number | Update `<version>` in XML |

---

## File Structure

```
mod_thoughtoftd_v5.0.0.zip
└── mod_thoughtoftd/
    ├── mod_thoughtoftd.php
    ├── mod_thoughtoftd.xml
    ├── Helper/
    ├── language/
    ├── media/
    └── tmpl/
```

---

## Version Update

1. Edit `mod_thoughtoftd.xml`
2. Change `<version>5.0.0</version>`
3. Run build script
4. New package created with updated version

---

## Quality Checks

Before distributing:
- ✓ Run `make test`
- ✓ Test installation in Joomla
- ✓ Verify all layouts work
- ✓ Check media files load
- ✓ Test on different browsers

---

## Distribution Checklist

- [ ] Update version number
- [ ] Run validation tests
- [ ] Build package
- [ ] Test installation
- [ ] Test all layouts
- [ ] Check responsive design
- [ ] Verify translations
- [ ] Update changelog
- [ ] Tag release in Git
- [ ] Upload to distribution

---

## Quick Links

- **Full Documentation:** `BUILD.md`
- **Layout Guide:** `LAYOUTS.md`
- **Template Docs:** `tmpl/README.md`
- **Comparison:** `tmpl/LAYOUT_COMPARISON.md`

---

## Support

**Build Issues:** Check `BUILD.md`  
**Layout Issues:** Check `LAYOUTS.md`  
**Module Issues:** Check main documentation

---

**Last Updated:** November 2025  
**Module Version:** 5.0.0  
**Joomla Version:** 5.x

