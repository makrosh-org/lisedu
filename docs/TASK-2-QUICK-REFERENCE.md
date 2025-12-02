# Task 2 Quick Reference Card

## 🚀 Quick Start

```bash
# Install everything (WP-CLI)
bash docs/wp-cli-install.sh

# Configure all plugins
php docs/configure-plugins.php

# Verify installation
php docs/verify-task-2.php
```

## 📦 What Gets Installed

**Theme:** Hello Elementor  
**Plugins:** 8 essential plugins

## ✅ Requirements Addressed

- **6.1** - Content management (Elementor)
- **7.2** - Image optimization (Smush)
- **7.3** - Browser caching (W3 Total Cache)
- **7.4** - Minification (W3 Total Cache)
- **8.2** - Backups (UpdraftPlus)
- **8.4** - Security (Wordfence)

## ⚠️ Post-Installation (Critical)

1. Configure off-site backup in UpdraftPlus
2. Install Elementor Pro (requires license)
3. Run Wordfence security scan
4. Test backup creation

## 📚 Documentation

- **Full Guide:** `TASK-2-PLUGIN-INSTALLATION-GUIDE.md`
- **Checklist:** `TASK-2-CHECKLIST.md`
- **README:** `TASK-2-README.md`
- **Summary:** `TASK-2-IMPLEMENTATION-SUMMARY.md`

## 🔧 Troubleshooting

**Plugin won't activate?**
- Check PHP 8.1+
- Increase memory limit

**Cache issues?**
- Clear all caches
- Check .htaccess writable

**Backup fails?**
- Increase max_execution_time
- Check disk space

## ➡️ Next Task

**Task 3:** Create and configure child theme with brand styling

---

**Status:** ✓ Complete | **Files:** 8 created | **Time:** ~30 minutes to execute
