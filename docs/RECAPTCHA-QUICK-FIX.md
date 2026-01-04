# reCAPTCHA Quick Fix Checklist

## ✅ What's Working:
- Textarea is rendering correctly
- File upload is working
- Form is displaying properly

## ❌ Issue:
- reCAPTCHA checkbox not showing on the form

## 🔧 Quick Fix (Do These in Order):

### 1. Check Google reCAPTCHA Domain (MOST LIKELY ISSUE)

Go to: https://www.google.com/recaptcha/admin

**Check:**
- [ ] Is `lisedu.org` listed in domains?
- [ ] Is `www.lisedu.org` listed in domains?

**If NO:** Add both domains and save. Wait 2 minutes, then test.

---

### 2. Verify Keys Match

**In Google reCAPTCHA Admin:**
- Copy your Site Key (starts with 6L...)
- Copy your Secret Key

**In WordPress (https://lisedu.org/wp-admin):**
- Go to: Contact > Integration
- Click "Setup integration" under reCAPTCHA
- Verify the keys match exactly (no extra spaces)

---

### 3. Check Form Has reCAPTCHA Tag

**In WordPress:**
- Go to: Contact > Contact Forms
- Click on your admission form
- In the "Form" tab, search for: `[recaptcha]`
- If missing, add it before the submit button
- Click Save

---

### 4. Clear Cache

- [ ] Clear browser cache (Ctrl+Shift+R)
- [ ] Test in incognito/private window
- [ ] If using caching plugin, clear WordPress cache
- [ ] If using Cloudflare, purge cache

---

### 5. Test

Visit: https://lisedu.org/admissions/

You should see the reCAPTCHA checkbox above the Submit button.

---

## 🎯 Most Likely Solution:

Based on your setup, the issue is probably **#1** - the domain `lisedu.org` is not registered in your Google reCAPTCHA admin panel.

**Quick Fix:**
1. Go to: https://www.google.com/recaptcha/admin
2. Click on your reCAPTCHA site
3. Click settings (gear icon)
4. Add domains:
   - `lisedu.org`
   - `www.lisedu.org`
5. Save
6. Wait 1-2 minutes
7. Test the form

---

## 📊 Need More Help?

Upload `check-recaptcha-production.php` to your server and run:
```bash
php check-recaptcha-production.php
```

This will show you exactly what's configured and what's missing.

---

## 🆘 If Still Not Working:

Send me:
1. Screenshot of your Google reCAPTCHA admin (domains section)
2. Screenshot of Contact > Integration page (you can hide the secret key)
3. Output from running `check-recaptcha-production.php`

---

## ⚡ Temporary Workaround:

If you need the form working RIGHT NOW while troubleshooting:

1. Edit the admission form
2. Find `[recaptcha]` and comment it out: `<!-- [recaptcha] -->`
3. Save
4. Form will work without spam protection (fix reCAPTCHA later)

**Note:** This removes spam protection, so fix it as soon as possible!
