# Fix reCAPTCHA on Production (lisedu.org)

## Current Status:
- ✅ Textarea is working
- ✅ File upload is working  
- ❌ reCAPTCHA not showing on form

## Possible Causes:

### 1. Domain Not Registered in Google reCAPTCHA
The most common issue is that your production domain isn't registered.

**Fix:**
1. Go to: https://www.google.com/recaptcha/admin
2. Find your reCAPTCHA site
3. Click the settings (gear icon)
4. Under "Domains", make sure you have:
   - `lisedu.org`
   - `www.lisedu.org`
5. Save changes
6. Wait 1-2 minutes for changes to propagate
7. Test the form again

### 2. reCAPTCHA Tag Missing from Form

**Check:**
1. Go to: https://lisedu.org/wp-admin
2. Navigate to: **Contact > Contact Forms**
3. Click on your admission form
4. In the **Form** tab, search for `[recaptcha]`
5. If it's missing, add it before the submit button:
   ```
   <div class="captcha-row">
       [recaptcha]
   </div>
   ```
6. Click **Save**

### 3. Wrong reCAPTCHA Keys

You might be using test keys instead of production keys.

**Fix:**
1. Go to: **Contact > Integration**
2. Click **Setup integration** under reCAPTCHA
3. Make sure you're using the keys for your production domain (lisedu.org)
4. If unsure, create new keys:
   - Go to: https://www.google.com/recaptcha/admin/create
   - Label: Lumina School Production
   - Type: reCAPTCHA v2 "I'm not a robot"
   - Domains: `lisedu.org` and `www.lisedu.org`
   - Copy the new Site Key and Secret Key
   - Paste them in WordPress: Contact > Integration > reCAPTCHA
   - Save

### 4. Cache Issues

**Fix:**
1. Clear WordPress cache (if using a caching plugin)
2. Clear browser cache (Ctrl+Shift+R or Cmd+Shift+R)
3. Test in incognito/private window
4. If using Cloudflare or CDN, purge cache there too

## Quick Diagnostic:

Upload `check-recaptcha-production.php` to your production server and run:

```bash
php check-recaptcha-production.php
```

This will tell you:
- ✓ If reCAPTCHA keys are configured
- ✓ If [recaptcha] tag is in the form
- ✓ Which form ID to use

## Most Likely Solution:

Based on your screenshot showing "reCAPTCHA is active on this site", the keys are configured. The issue is probably:

**Option A: Domain not registered**
- Add `lisedu.org` and `www.lisedu.org` to your Google reCAPTCHA admin

**Option B: Using wrong keys**
- You might be using keys registered for a different domain (like `lisedu.test` or `localhost`)
- Create new keys specifically for `lisedu.org`

## Step-by-Step Fix:

### Step 1: Verify Domain Registration
1. Go to: https://www.google.com/recaptcha/admin
2. Find your reCAPTCHA site (the one with the keys you're using)
3. Check if `lisedu.org` is in the domains list
4. If not, add it and save

### Step 2: Verify Keys in WordPress
1. Go to: https://lisedu.org/wp-admin
2. Navigate to: **Contact > Integration**
3. Under reCAPTCHA, verify:
   - ✓ Keys are entered
   - ✓ No extra spaces
   - ✓ Keys match the ones in Google admin

### Step 3: Verify Form Has reCAPTCHA Tag
1. Go to: **Contact > Contact Forms**
2. Click on your admission form
3. In the **Form** tab, search for `[recaptcha]`
4. If missing, add it
5. Save

### Step 4: Clear All Caches
1. Clear WordPress cache
2. Clear browser cache
3. Test in incognito window

### Step 5: Test
1. Visit: https://lisedu.org/admissions/
2. Scroll to form
3. You should see the reCAPTCHA checkbox
4. If still not showing, check browser console for errors (F12)

## If Still Not Working:

Send me:
1. Screenshot of Google reCAPTCHA admin showing your domains
2. Screenshot of Contact > Integration page (hide the secret key)
3. The form ID you're using
4. Any error messages in browser console (F12 > Console tab)

## Alternative: Temporarily Disable reCAPTCHA

If you need the form working immediately while troubleshooting:

1. Go to: **Contact > Contact Forms**
2. Edit your admission form
3. Find and remove (or comment out) the `[recaptcha]` tag:
   ```
   <!-- [recaptcha] -->
   ```
4. Save
5. Form will work without spam protection (not recommended long-term)

---

**Need Help?**
Run the diagnostic script and send me the output, or send screenshots of:
- Google reCAPTCHA admin (domains section)
- Contact > Integration page
- The form editor showing the [recaptcha] tag
