# Fix Shortcode Displaying as Text Issue

## Problem
The shortcode `[contact-form-7 id="XX" title="Lumina Admission Inquiry Form"]` is showing as plain text instead of rendering the actual form.

## Why This Happens
- Shortcode was added in **Text Editor** widget in **Visual mode**
- Or shortcode was added in **HTML** widget incorrectly
- Elementor treats it as regular text, not a shortcode

## Solution

### Method 1: Use Shortcode Widget (Recommended)

#### Step 1: Edit Page in Elementor
1. Go to **Pages** > **All Pages**
2. Find **Admissions** page
3. Click **Edit with Elementor**

#### Step 2: Locate the Problem
1. Find the section showing the shortcode as text
2. Click on it to select the widget
3. You'll see it's probably a **Text Editor** or **HTML** widget

#### Step 3: Delete the Wrong Widget
1. Click on the widget showing the shortcode text
2. Click the **trash icon** (🗑️) or press Delete key
3. Confirm deletion

#### Step 4: Add Shortcode Widget
1. Click the **"+"** button where you want the form
2. In the search box, type: **"Shortcode"**
3. Look for the widget with this icon: 📄
4. Drag **Shortcode** widget to your location

#### Step 5: Configure Shortcode Widget
1. In the left panel, you'll see:
   ```
   ┌─────────────────────────────────┐
   │ SHORTCODE                       │
   │ ─────────────────────────────── │
   │                                 │
   │ Shortcode                       │
   │ ┌─────────────────────────────┐ │
   │ │                             │ │ ← Paste here
   │ └─────────────────────────────┘ │
   └─────────────────────────────────┘
   ```

2. Paste your shortcode:
   ```
   [contact-form-7 id="68" title="Lumina Admission Inquiry Form"]
   ```
   (Replace 68 with your actual form ID)

3. The form should appear immediately in the preview

#### Step 6: Update Page
1. Click the green **"Update"** button (bottom left)
2. Wait for "Page updated" message

#### Step 7: Clear Cache & Test
1. Clear browser cache: Ctrl+Shift+R (Windows) or Cmd+Shift+R (Mac)
2. If using cache plugin, clear it
3. Visit the page in a new incognito/private window
4. Form should now display correctly

---

### Method 2: Fix Text Editor Widget

If you want to keep using Text Editor widget:

#### Step 1: Switch to Text Mode
1. Click on the Text Editor widget
2. In the left panel, click the **"Text"** tab (not Visual)
3. You should see the shortcode

#### Step 2: Verify Shortcode
Make sure it looks like this:
```
[contact-form-7 id="68" title="Lumina Admission Inquiry Form"]
```

#### Step 3: Update and Test
1. Click **Update**
2. Clear cache
3. Test the page

**Note:** This method is less reliable. Use Method 1 (Shortcode widget) instead.

---

### Method 3: Use HTML Widget

#### Step 1: Add HTML Widget
1. Delete the current widget
2. Add **HTML** widget
3. Paste the shortcode in the HTML Code field

#### Step 2: Add Shortcode
```html
[contact-form-7 id="68" title="Lumina Admission Inquiry Form"]
```

#### Step 3: Update
1. Click **Update**
2. Clear cache
3. Test

---

## How to Find Your Form ID

If you don't know your form ID:

### Method 1: From WordPress Admin
1. Go to **Contact** > **Contact Forms**
2. Find **Lumina Admission Inquiry Form**
3. Hover over the title
4. Look at the URL in browser status bar:
   ```
   .../admin.php?page=wpcf7&post=68&action=edit
                                    ^^
                                 This is your ID
   ```

### Method 2: Run Test Script
```bash
php test-admission-form.php
```
It will show the form ID and shortcode.

### Method 3: Check Form Creation Output
If you just ran `create-admission-form-fixed.php`, it showed:
```
Form ID: 68
Shortcode: [contact-form-7 id="68" title="Lumina Admission Inquiry Form"]
```

---

## Common Mistakes to Avoid

### ❌ Mistake 1: Using Text Editor in Visual Mode
```
Text Editor Widget → Visual Tab
[contact-form-7 id="68" ...]  ← Shows as text
```

### ❌ Mistake 2: Adding Extra Spaces
```
[ contact-form-7 id="68" ... ]
  ^                           ^
  Extra spaces break it
```

### ❌ Mistake 3: Wrong Quote Marks
```
[contact-form-7 id="68" title="Form"]  ← Correct (straight quotes)
[contact-form-7 id="68" title="Form"]  ← Wrong (curly quotes)
```

### ❌ Mistake 4: Missing Closing Bracket
```
[contact-form-7 id="68" title="Form"   ← Missing ]
```

### ✅ Correct Format:
```
[contact-form-7 id="68" title="Lumina Admission Inquiry Form"]
```

---

## Troubleshooting

### Issue: Shortcode Still Shows as Text

**Solution 1: Check Contact Form 7 is Active**
1. Go to **Plugins** > **Installed Plugins**
2. Make sure **Contact Form 7** is activated
3. If not, click **Activate**

**Solution 2: Check Form Exists**
1. Go to **Contact** > **Contact Forms**
2. Verify your form is there
3. Check the ID matches your shortcode

**Solution 3: Regenerate Shortcode**
1. Go to **Contact** > **Contact Forms**
2. Click on your form
3. Copy the shortcode shown at the top
4. Use that exact shortcode in Elementor

**Solution 4: Clear All Caches**
```bash
# WordPress cache
wp cache flush

# Elementor cache
Go to: Elementor > Tools > Regenerate CSS
```

**Solution 5: Check for Plugin Conflicts**
1. Deactivate all plugins except:
   - Contact Form 7
   - Elementor
   - Elementor Pro (if you have it)
2. Test if form shows
3. Reactivate plugins one by one to find conflict

---

### Issue: Form Shows But Looks Broken

**Solution 1: Regenerate Elementor CSS**
1. Go to **Elementor** > **Tools**
2. Click **Regenerate CSS**
3. Click **Regenerate Files**

**Solution 2: Check CSS is Loaded**
1. Right-click on page > Inspect
2. Check if `admission-form.css` is loaded
3. If not, check functions.php has the enqueue code

**Solution 3: Clear Browser Cache**
- Chrome: Ctrl+Shift+Delete
- Firefox: Ctrl+Shift+Delete
- Safari: Cmd+Option+E

---

### Issue: Form ID Changed

If you recreated the form, the ID changed:

**Solution:**
1. Find new form ID (see "How to Find Your Form ID" above)
2. Update shortcode with new ID
3. Update page

---

## Widget Comparison

### Shortcode Widget (Best for Forms)
```
✅ Designed for shortcodes
✅ Automatically processes shortcodes
✅ No formatting issues
✅ Recommended by WordPress
```

### Text Editor Widget
```
⚠️ Can work in Text mode
❌ Visual mode shows as text
⚠️ May have formatting issues
❌ Not recommended for shortcodes
```

### HTML Widget
```
✅ Can work for shortcodes
⚠️ Requires exact syntax
⚠️ Less user-friendly
⚠️ Use only if Shortcode widget unavailable
```

---

## Complete Fix Checklist

- [ ] Open Admissions page in Elementor
- [ ] Find section with shortcode text
- [ ] Delete the current widget
- [ ] Add **Shortcode** widget (not Text Editor)
- [ ] Paste shortcode in Shortcode field
- [ ] Verify form appears in preview
- [ ] Click **Update** button
- [ ] Clear browser cache (Ctrl+Shift+R)
- [ ] Clear WordPress cache (if plugin active)
- [ ] Regenerate Elementor CSS
- [ ] Test in incognito/private window
- [ ] Verify form displays correctly
- [ ] Test form submission
- [ ] Check mobile display

---

## Prevention Tips

### For Future Updates:

1. **Always use Shortcode widget** for Contact Form 7 shortcodes
2. **Never paste shortcodes in Text Editor Visual mode**
3. **Copy shortcode from Contact Form 7 admin** (don't type manually)
4. **Test in preview** before updating
5. **Clear cache** after updates

---

## Quick Reference

### Correct Shortcode Format:
```
[contact-form-7 id="68" title="Lumina Admission Inquiry Form"]
```

### Where to Add:
```
Elementor → Shortcode Widget → Shortcode Field
```

### After Adding:
```
1. Update page
2. Clear cache
3. Test
```

---

## Video Tutorial Steps

If you prefer video instructions, search YouTube for:
- "How to add Contact Form 7 shortcode in Elementor"
- "Fix shortcode showing as text in Elementor"

Key points to watch:
1. Using Shortcode widget (not Text Editor)
2. Pasting in the Shortcode field
3. Clearing cache after update

---

## Still Not Working?

### Last Resort Solutions:

**Option 1: Recreate Section**
1. Delete entire section with the shortcode
2. Create new section
3. Add Shortcode widget
4. Paste shortcode
5. Update

**Option 2: Use Different Page Builder**
1. Disable Elementor for this page
2. Use WordPress Block Editor
3. Add Shortcode block
4. Paste shortcode

**Option 3: Contact Support**
- Elementor Support: https://elementor.com/support/
- Contact Form 7 Support: https://wordpress.org/support/plugin/contact-form-7/

---

## Summary

**Problem:** Shortcode showing as text
**Cause:** Wrong widget or wrong mode
**Solution:** Use Shortcode widget, not Text Editor
**Time:** 2 minutes to fix

**Steps:**
1. Delete current widget
2. Add Shortcode widget
3. Paste shortcode
4. Update page
5. Clear cache

**Done! ✅**

---

## Need More Help?

Check these files:
- `ELEMENTOR-SHORTCODE-GUIDE.md` - Detailed Elementor guide
- `ADMISSION-FORM-FIX-GUIDE.md` - Complete form guide
- `test-admission-form.php` - Test form configuration

Or run:
```bash
php test-admission-form.php
```

This will show your form ID and verify everything is configured correctly.
