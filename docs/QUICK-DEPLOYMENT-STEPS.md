# ⚡ Quick Deployment Steps - cPanel

## 🎯 Fast Track Guide (30 Minutes)

### 1️⃣ Export Database (Local)
```bash
wp db export lumina-backup.sql
```
Or use phpMyAdmin → Export

### 2️⃣ Create ZIP File
- Zip all WordPress files
- Exclude: `.git`, `node_modules`, `wp-config.php`

### 3️⃣ cPanel - Create Database
1. cPanel → MySQL Databases
2. Create database: `lumina_school`
3. Create user: `lumina_user`
4. Add user to database (ALL PRIVILEGES)
5. **Save credentials!**

### 4️⃣ cPanel - Upload Files
1. File Manager → public_html
2. Upload ZIP file
3. Extract ZIP
4. Delete ZIP

### 5️⃣ Create wp-config.php
1. Copy `wp-config-sample.php` → `wp-config.php`
2. Edit and update:
   - DB_NAME
   - DB_USER
   - DB_PASSWORD
   - DB_HOST (usually 'localhost')
3. Add security keys from: https://api.wordpress.org/secret-key/1.1/salt/

### 6️⃣ Import Database
1. cPanel → phpMyAdmin
2. Select your database
3. Import → Choose `lumina-backup.sql`
4. Click Go

### 7️⃣ Update URLs
In phpMyAdmin → SQL tab:
```sql
UPDATE wp_options 
SET option_value = 'https://yourdomain.com' 
WHERE option_name = 'siteurl' OR option_name = 'home';
```

### 8️⃣ Test Site
1. Visit: `https://yourdomain.com`
2. Login: `https://yourdomain.com/wp-admin`
3. Settings → Permalinks → Save
4. Elementor → Tools → Regenerate CSS

---

## 🔑 Important Credentials to Save

```
Database Name: username_lumina_school
Database User: username_lumina_user
Database Password: [your password]
Database Host: localhost

WordPress Admin: [your username]
WordPress Password: [your password]

cPanel URL: https://yourdomain.com/cpanel
cPanel User: [your username]
cPanel Password: [your password]
```

---

## ⚠️ Common Issues

### Database Connection Error
→ Check wp-config.php credentials

### 404 Errors
→ Settings → Permalinks → Save

### Images Not Loading
→ Update URLs in database

### White Screen
→ Enable WP_DEBUG in wp-config.php

---

## 📞 Quick Help

**Stuck?** Check the full guide: `CPANEL-DEPLOYMENT-GUIDE.md`

**Need support?** Contact your hosting provider

---

**Estimated Time**: 30-60 minutes
**Difficulty**: Beginner-friendly
